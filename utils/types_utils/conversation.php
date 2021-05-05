<?php
    /**
     * Conversation manager, works within a directory
     */
    abstract class ConversationManager {

        /**
         * Directory path
         *
         * @var string
         */
        static private $path = '';

        /**
         * Outputs directory path
         *
         * @return string
         */
        public function getPath() {
            return self::$path;
        }

        /**
         * Sets directory path
         *
         * @param string $path Directory path
         * @return void
         */
        public function setPath(string $path) {
            if (is_dir($path)) {
                self::$path = $path;
            } else {
                throw new Exception("Wrong directory", 1);
            }
        }
    }

    /**
     * Conversation, related to one specific file from the parent class directory
     */
    class Conversation extends ConversationManager{

        /**
         * Predefined types of conversation
         */
        public const DM = "dm";
        public const TICKET = "ticket";

        /**
         * ID of the conversation
         *
         * @var string
         */
        protected $id = "";

        /**
         * Members of the conversation
         *
         * @var array
         */
        protected $people = array();

        /**
         * Type of conversation
         *
         * @var string
         */
        protected $type = "";

        /**
         * Messages to be saved
         *
         * @var array
         */
        protected $messages_buffer = array();

        /**
         * Returns properties of conversation
         *
         * @return void
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'people' => $this->people,
                'type' => $this->type,
                'path' => $this->getPath()
            );
        }

        /**
         * Returns conversation file path
         *
         * @return void
         */
        public function getPath() {
            return ConversationManager::getPath() . $this->id . '.json';
        }

        /**
         * Returns message buffer (messages to be saved)
         *
         * @return void
         */
        public function getMessageBuffer() {
            return $this->messages_buffer;
        }

        /**
         * Adds a message to the buffer
         *
         * @param Message $message Message to be added
         * @return void
         */
        public function send(Message $message) {
            if (in_array($message->getAll()["sender"], $this->people)) {
                
                array_push($messages_buffer, $message);

            } else {
                throw new Exception("Sender not in conversation", 1);
                
            }
        }

        /**
         * Creates a new conversation
         *
         * @param array $data Array with conversation properties
         */
        public function __construct(array $data) {
            if (isset($data["people"]) && sizeof($data["people"]) > 1) {
                foreach ($data["people"] as $id) {
                    if (strlen($id) !== 13) {
                        throw new Exception("Bad id format : $id", 1);
                    } else {
                        array_push($this->people, $id);
                    }
                }

                $this->id = $data["id"] ?? uniqid();
                $this->people = $data["people"];
                $this->type = (isset($data["type"]) && ($data["type"] === self::TICKET)) ? self::TICKET : self::DM;

            } else {
                throw new Exception("Wrong conversation array.", 1);
            }
        }
    }

    /**
     * Represents one message
     */
    class Message extends Conversation {

        /**
         * ID of the message
         *
         * @var string
         */
        protected $id = '';

        /**
         * Sender's ID
         *
         * @var string
         */
        protected $sender = '';

        /**
         * Message text content
         *
         * @var string
         */
        protected $content = '';

        /**
         * Paths array of attached files
         *
         * @var array
         */
        protected $files = array();

        /**
         * Timestamp of when the message was sent
         *
         * @var string
         */
        protected $timestamp = '';

        /**
         * Returns message properties
         *
         * @return array
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'sender' => $this->sender,
                'content' => $this->content,
                'files' => $this->files,
                'timestamp' => $this->timestamp
            );
        }

        /**
         * Creates a new message, gives an unique ID
         *
         * @param array $data
         */
        public function __construct(array $data){
            if (isset($data["sender"], $data["content"])) {
                $this->id = $data["id"] ?? uniqid();
                $this->sender = $data["sender"];
                $this->content = htmlspecialchars($data["content"]);
                $this->files = $data["files"] ?? array();
                $this->timestamp = $data["timestamp"] ?? date_timestamp_get();
            } else {
                throw new Exception("Invalid message format", 1);
            }
        }
    }

?>