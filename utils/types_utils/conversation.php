<?php

    /**
     * Conversation manager, works within a directory.
     */
    abstract class ConversationManager {
        /**
         * Directory path.
         *
         * @var string
         */
        private static $path = '';

        /**
         * Outputs directory path.
         *
         * @return string
         */
        public static function getFolderPath() {
            return self::$path;
        }

        /**
         * Sets directory path.
         *
         * @param string $path Directory path
         */
        public static function setFolderPath(string $path) {
            if (is_dir($path)) {
                self::$path = $path;
            } else {
                throw new Exception('Wrong directory', 1);
            }
        }
    }

    /**
     * Conversation, related to one specific file from the parent class directory.
     */
    class Conversation extends ConversationManager {
        /**
         * Predefined types of conversation.
         */
        public const DM = 'dm';

        public const TICKET = 'ticket';

        /**
         * ID of the conversation.
         *
         * @var string
         */
        protected $id = '';

        /**
         * Members of the conversation.
         *
         * @var array
         */
        protected $people = array();

        /**
         * Type of conversation.
         *
         * @var string
         */
        protected $type = '';

        /**
         * Last message
         *
         * @var string
         */
        protected $message = array();

        /**
         * Conversation title
         *
         * @var string
         */
        protected $title = null;

        /**
         * Creates a new conversation.
         *
         * @param array $data Array with conversation properties
         */
        public function __construct(array $data) {
            if (isset($data['people']) && sizeof($data['people']) > 1) {
                foreach ($data['people'] as $id) {
                    if (13 !== strlen($id)) {
                        throw new Exception("Bad id format : {$id}", 1);
                    }
                    array_push($this->people, $id);
                }

                $this->id = $data['id'] ?? uniqid();
                $this->people = $data['people'];
                $this->type = (isset($data['type']) && (self::TICKET === $data['type'])) ? self::TICKET : self::DM;
                $this->message = $data['message'] ?? array();
                $this->title = htmlspecialchars(substr($data['title'], 0, 50)) ?? null;

                if (is_dir(parent::getFolderPath()) && !file_exists($this->getPath())) {
                    touch($this->getPath());
                }
            } else {
                throw new Exception('Wrong conversation array.', 1);
            }
        }

        /**
         * Returns properties of conversation.
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'title' => $this->title,
                'people' => $this->people,
                'type' => $this->type,
                'message' => $this->message
            );
        }

        /**
         * Returns id
         *
         * @return string
         */
        public function getID() {
            return $this->id;
        }

        /**
         * Returns title
         *
         * @return void
         */
        public function getTitle() {
            return $this->title;
        }

        public function setTitle(?string $title) {
            $this->title = htmlspecialchars($title) ?? null;
        }

        /**
         * Returns people
         *
         * @return array
         */
        public function getPeople() {
            return $this->people;
        }

        /**
         * Add person to conversation
         *
         * @param string $id user id
         * @return void
         */
        public function addPeople(string $id) {
            if (strlen($id) == 13) {
                array_push($this->people, $id);
            } else {
                throw new Exception("Bad id format", 1);  
            }
        }

        /**
         * Remove person from conversation
         *
         * @param string $id user id
         * @return void
         */
        public function removePeople(string $id) {
            if (in_array($id, $this->people)) {
                unset($this->people[array_search($id, $this->conversations)]);
            } else {
                throw new Exception("id not in conversation", 1);   
            }
        }

        /**
         * Sets the last message to a message
         *
         * @param Message $msg
         * @return void
         */
        public function setLastMessage(Message $msg) {
            $this->message = $msg->getAll();
        }

        /**
         * Returns conversation file path.
         */
        public function getPath() {
            return parent::getFolderPath() . $this->id . '.json';
        }
    }

    /**
     * Represents one message.
     */
    class Message extends Conversation {
        /**
         * ID of the message.
         *
         * @var string
         */
        protected $id = '';

        /**
         * Sender's ID.
         *
         * @var string
         */
        protected $sender = '';

        /**
         * Message text content.
         *
         * @var string
         */
        protected $content = '';

        /**
         * Paths array of attached files.
         *
         * @var array
         */
        protected $files = array();

        /**
         * Timestamp of when the message was sent.
         *
         * @var string
         */
        protected $timestamp = '';

        /**
         * Creates a new message, gives an unique ID.
         */
        public function __construct(array $data) {
            if (isset($data['sender'], $data['content']) && $data['content'] !== "") {
                
                $this->id = $data['id'] ?? uniqid();
                $this->sender = $data['sender'];
                $this->content = htmlspecialchars(substr($data['content'], 0, 1000));
                $this->files = $data['files'] ?? array();
                $this->timestamp = $data['timestamp'] ?? time();
            } else {
                throw new Exception('Invalid message format', 1);
            }
        }

        /**
         * Returns message properties.
         *
         * @return array
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'sender' => $this->sender,
                'content' => $this->content,
                'files' => $this->files,
                'timestamp' => $this->timestamp,
            );
        }
    }

?>
