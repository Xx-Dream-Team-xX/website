function toggleModal() {
    let m = document.getElementById("modal");
    if (m.classList.contains("show")) {
        m.classList.remove("show");
        m.setAttribute("style", "display: none;");
    } else {
        m.classList.add("show");
        m.setAttribute("style", "display: block;");
    }
}

function toggleFiles() {
    document.getElementById("files").hidden ^= true;
    document.getElementById("content").hidden ^= true;
    document.getElementById("button-send").hidden ^= true;
}

function onLoad(){
    if (isID('/messages/')) {
        CACHE["selected"] = getTarget('/messages/');
    }
    updateMe(() => {
        requestMessagesList(),
        setInterval(() =>
            {
                requestMessagesList()
            }, 5000
        );
    });
    getRecipients();
    document.getElementById("content").addEventListener("keyup", function(event) {
        if (event.key === "Enter" && !event.shiftKey) {
          event.preventDefault();
          prepareMessage();
        }
      });
}

function fill(input, data, filter="") {

    data = data.sort((a, b) => {
        if (a.featured) {
            return ((b.featured)*1 - (a.featured)*(1));
        }
        return (a < b)
    })
    data = data.filter(a => (a.name.toLowerCase().includes(filter.toLocaleLowerCase())));
    input.innerHTML = "";
    data.forEach(user => {
        el = document.createElement("option");
        el.textContent = `${user.name} (${types[user.type]})`;
        el.value = user.id;
        input.appendChild(el);
    });
}

function searchRecipients() {
    fill(document.getElementById("selectUser"), CACHE["recipients"], document.getElementById('filterSelect').value);
}

const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];

const CACHE = {
    "messages": [],
    "actual": [],
    "selected": null,
    "recipients": [],
    "users": [],
    "unreadmessages": []
};

function getRecipients() {
    let req = new XMLHttpRequest();

    req.open("GET", "/conversation/recipients");
    req.send();
    req.onreadystatechange = function() {

        if (this.status === 200 && this.readyState === 4) {

            CACHE["recipients"] = JSON.parse(this.responseText) ?? [];
            CACHE["recipients"].forEach(u => {
                getNameFromId(CACHE["users"], u.id);
            });
            searchRecipients();
        }
    }
}

function clearMessages() {
    document.getElementById("messages").innerHTML = "";
}

function clearConversations() {
    document.getElementById("recent").innerHTML = "";
}

function requestMessagesList() {
    let req = new XMLHttpRequest();
    req.open("GET", "/conversation/list");
    req.send();
    req.onreadystatechange = function() {

        if (this.status === 200 && this.readyState === 4) {

            clearConversations();
            CACHE["messages"] = JSON.parse(this.responseText).sort((a, b) => {
                return b["message"].timestamp - a["message"].timestamp
            }) ?? [];
            if (CACHE['actual'].length === 0) requestMessages(CACHE["selected"] ?? CACHE["messages"][0]["id"]);
            showRecentMessages(CACHE["messages"]);
            
        }
    }
}

function highlight() {
    
    els = document.querySelectorAll('.bg-success');
    els.forEach(e => {
        e.classList.remove('bg-success');
    });

    CACHE["selected"] ? document.getElementById(CACHE["selected"]).classList.add("bg-success") : document.getElementById("recent").children[0].classList.add("bg-success");
}

function requestMessages(id) {
    let req = new XMLHttpRequest();
    let d = new FormData();

    d.append("id", id);
    req.open("POST", "/conversation/get");
    req.send(d);
    req.onreadystatechange = function() {
        clearMessages();
        if (this.status === 200 && this.readyState === 4) {
            CACHE["actual"] = JSON.parse(this.responseText) ?? [];
            CACHE["selected"] = id;
            showMessages(CACHE["actual"]);
            setFakeURL("Conversation", '/messages/' + id);
        }
    }
    
}

function showRecentMessages(DATA){
    for (let i = 0; i < DATA.length; i++) {
        getData(DATA[i]);
    }
    highlight();
}

function showMessages(DATA) { 

    for (let i = 0; i < DATA.length; i++) {
        getMessage(DATA[i]);
    }

    m = document.getElementById("messages");
    m.scrollTop = m.scrollHeight;
    highlight()
}

function getMessage(DATA) {

    let mess_id = DATA["id"];
    let mess_sender = DATA["sender"];
    let mess_content = DATA["content"];
    let mess_files = DATA["files"];
    let mess_time = DATA["timestamp"];
    let timestamp = getDate(mess_time  * 1000);

    // check if sender if me
    if (me["id"] === mess_sender) { 
        addReveiverMessage(mess_id, mess_sender, mess_content, mess_files, timestamp)
    } else {
        addSenderMessage(mess_id, mess_sender, mess_content, mess_files, timestamp)
    }
}

function getData(DATA){
    let conv_id = DATA["id"];
    let conv_type = DATA["type"];
    let conv_participents = DATA["people"];
    let conv_last_message_content = DATA["message"]["content"];
    let conv_last_message_files = DATA["message"]["files"];
    let conv_last_message_time = DATA["message"]["timestamp"];
    let conv_last_message_id = DATA["message"]["id"];
    let unread = DATA["unread"];
    let sender = (DATA["people"]).filter((u) => {return u !== me['id']})[0];

    let timestamp = getDate(conv_last_message_time * 1000);

    addConvtoRecent(conv_id, conv_type, conv_participents, conv_last_message_content, sender, conv_last_message_files, timestamp, unread, conv_last_message_id);
}

function getFormatDate(d) {
    let a = d.toJSON();
    return a.split('T')[0];
}

function getDate(timestamp) {
    let t = new Date();
    let today = getFormatDate(t);
    let d = new Date(timestamp);

    if (getFormatDate(d) === today){
        let m = d.getMinutes();
        if (m < 10){
            m = "0" + m;
        }
        return d.getHours() + ":" + m;
    } else {
        let day = d.getDate();
        if (day < 10){
            day = "0"+day;
        }
        if (t.getFullYear === d.getFullYear) {
            return day + " " + monthNames[d.getMonth()];
        } else {
            return day + " " + monthNames[d.getMonth()] + " " + d.getFullYear();
        }
    }
}

function addConvtoRecent(id, type, people, content, sender, files, timestamp, unread, message_id){
    let message_box = document.getElementById("recent");

    let a1 = document.createElement('a');
    a1.classList.add("list-group-item", "list-group-item-action", "list-group-item-light", "rounded-0")
    if (unread) {
        a1.classList.add("bg-info");
        if (!CACHE["unreadmessages"].includes(message_id)) {
            CACHE["unreadmessages"].push(message_id);
            let audio = new Audio('/static/sound/notification.mp3');
            audio.play();
        }
        
    };
    if (id === CACHE["selected"] && unread) {
        requestMessages(id);
    }

    a1.setAttribute("id", id);
    a1.setAttribute("onclick", "requestMessages(this.id, this)");
    a1.classList.add("mouse-cursor");
    
    let d2 = document.createElement('div');
    d2.classList.add("media");

    let d4 = document.createElement('div');
    d4.classList.add("media-body", "ml-4", "chat-message");
    
    let d5 = document.createElement('div');
    d5.classList.add("d-flex", "align-items-center", "justify-content-between", "mb-1", "text-dark");

    let h6 = document.createElement('h6');
    h6.classList.add("mb-0");

    getNameFromId(CACHE["users"], sender, (c) => {
        h6.innerText = (c && c['name']) ? c["name"] : "Utilisateur supprim??";
    });
    
    let s7 = document.createElement('small');
    s7.classList.add("small", "font-weight-bold");
    s7.innerText = timestamp; 

    let p8 = document.createElement('p');
    p8.classList.add("font-italic", "mb-0", "text-small", "text-dark");
    p8.innerHTML = content.split("\n")[0];
    p8.innerHTML += (content.split("\n").length > 2) ? "..." : "";
    if (files.length > 0) p8.innerHTML += `<br>${files.length} Attachment${(files.length > 1)?"s":""}`;

    d5.appendChild(h6);
    d5.appendChild(s7);
    d4.appendChild(d5);
    d4.appendChild(p8);
    d2.appendChild(d4);
    a1.appendChild(d2);
    message_box.appendChild(a1);
}

function addSenderMessage(id, sender, content, files, timestamp) {
    let message_box = document.getElementById("messages");

    let d1 = document.createElement('div');
    d1.classList.add("media", "mb-3");

    let d3 = document.createElement('div');
    d3.classList.add("media-body", "ml-3",  "message-box-box");

    let d4 = document.createElement('div');
    d4.classList.add("bg-light", "rounded", "py-2", "px-3", "mb-2", "message-message");
    
    let p5 = document.createElement('p');
    p5.classList.add("text-small-s", "mb-0", "text-muted");
    p5.innerHTML = content;

    let p6 = document.createElement('p');
    p6.classList.add("small", "text-muted");
    p6.innerText = timestamp;

    d4.appendChild(p5);
    d3.appendChild(d4);
    d3.appendChild(p6);
    d1.appendChild(d3);

    if (files) {
        d7 = document.createElement('ul');
        d7.classList.add("mb-0")
        files.forEach((f) => {
            d7.innerHTML += `<li><a class="text-dark small" target="_blank" href="/useruploadedcontent/${f}">${f}</a></li>\n`;
        });
        d4.appendChild(d7);
    }

    message_box.appendChild(d1);
}

function addReveiverMessage(id, sender, content, files, timestamp) {
    let message_box = document.getElementById("messages");

    let d1 = document.createElement('div');
    d1.classList.add("media", "mr-3", "mb-3", "ml-auto", "d-flex", "justify-content-end");

    let d3 = document.createElement('div');
    d3.classList.add("media-body", "message-box-box");

    let d4 = document.createElement('div');
    d4.classList.add("bg-primary", "rounded", "py-2", "px-3", "mb-2", "message-message");
    
    let p5 = document.createElement('p');
    p5.classList.add("text-small-s", "mb-0", "text-white");
    p5.innerHTML = content;

    let p6 = document.createElement('p');
    p6.classList.add("small", "text-muted", "d-flex", "justify-content-end");
    p6.innerText = timestamp;

    d4.appendChild(p5);
    d3.appendChild(d4);
    d3.appendChild(p6);
    d1.appendChild(d3);

    if (files) {
        d7 = document.createElement('ul');
        d7.classList.add("mb-0")
        files.forEach((f) => {
            d7.innerHTML += `<li><a class="text-white small" target="_blank" href="/useruploadedcontent/${f}">${f}</a></li>\n`;
        });
        d4.appendChild(d7);
    }

    message_box.appendChild(d1);
}

function prepareMessage() {
    let id = CACHE["selected"];
    let content = document.getElementById("content").value;
    let files = document.getElementById("files");

    sendMessage(id, content, files)
}

function sendMessage(id, content, files) {
    let r = new XMLHttpRequest();
    let d = new FormData();

    d.append("id", id);
    d.append("content", content);
    for (let i = 0; i < files.files.length; i++) {
        d.append("file" + i, files.files[i], files.files[i].name);
        
    }

    r.open("POST", '/conversation/send');
    r.send(d);
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            if (JSON.parse(this.responseText)["id"]) {
                requestMessagesList();
                requestMessages(id);
                document.getElementById("content").value = "";
                document.getElementById("files").value = null;
            }
        }
    }
}

function prepareConversation() {
    let id = document.getElementById("selectUser").value;
    let content = document.getElementById("new_message").value;
    if (!id || !content) return alert("Veuillez remplir les d??tails"); 
    toggleModal();
    newConversation(id, content)
}

function newConversation(id, content, files) {
    let r = new XMLHttpRequest();
    let d = new FormData();

    d.append("recipient", id);
    d.append("content", content);

    r.open("POST", '/conversation/new');
    r.send(d);
    r.onreadystatechange = function() {
        if (this.status === 200 && this.readyState === 4) {
            if (id = JSON.parse(this.responseText)["id"]) {

                requestMessagesList();
                requestMessages(id);
                document.getElementById("new_message").value = "";
            }
        }
    }
}

