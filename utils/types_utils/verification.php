<?php

    /**
     * Documents verification class
     */
    class Verification {

        /**
         * ID of verification
         *
         * @var string
         */
        protected $id = '';

        /**
         * ID of assuré that initiated verification
         *
         * @var string
         */
        protected $owner = '';

        /**
         * ID of assuré's assurance
         *
         * @var string
         */
        protected $assurance = '';

        /**
         * Verification status
         *
         * @var integer
         */
        protected $status = 0;

        /**
         * Verification content (see parseContent)
         *
         * @var array
         */
        protected $content = array();

        /**
         * Gestionnaire's comment
         *
         * @var string
         */
        protected $comment = null;

        /**
         * Gestionnaire's ID
         *
         * @var string
         */
        protected $mod = null;

        /**
         * Verification status constants
         */
        public const PENDING = 0;
        public const ACCEPTED = 1;
        public const REJECTED = -1;

        /**
         * Creates new verification
         *
         * @param array $data verification data
         */
        public function __construct(array $data) {
            $this->id = $data["id"] ?? uniqid();
            $this->owner = $data["owner"];
            $this->assurance = $data["assurance"];
            $this->content = $this->parseContent($data["content"]);
            $this->comment = $data["comment"] ?? null;
            $this->status = (in_array($data["status"], array(
                self::PENDING,
                self::ACCEPTED,
                self::REJECTED
            ))) ? $data["status"] : self::PENDING;
            $this->mod = $data["mod"] ?? null;
        }

        /**
         * Parses content (reason and proofs)
         *
         * @param array $content justification and files
         * @return array content
         */
        public function parseContent(array $content) {
            return array(
                'justification' => (strlen($content['justification']) > 0) ? $content['justification'] : "Non précisé",
                'files' => (sizeof($content["files"]) > 0) ? $content["files"] : array()
            );
        }

        /**
         * Accept verification
         *
         * @param string $id Gestionnaire's id
         * @return void
         */
        public function accept(string $id) {
            $this->status = self::ACCEPTED;
            $this->mod = $id;
        }

        /**
         * Rejects verification
         *
         * @param string $id Gestionnaire's id
         * @param string|null $comment Comment on why
         * @return void
         */
        public function reject(string $id, ?string $comment) {
            $this->status = self::REJECTED;
            $this->mod = $id;
            $this->comment = (isset($comment) && (strlen($comment) > 0)) ? $comment : null;
        }
        
    }
?>