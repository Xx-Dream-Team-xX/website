<?php
    /**
     * Assurance class
     */
    class Assurance {

        /**
         * id of assurance company
         *
         * @var string
         */
        protected $id = '';

        /**
         * name of company
         *
         * @var string
         */
        protected $name = '';

        /**
         * public phone number
         *
         * @var string
         */
        protected $phone = '';

        /**
         * Logo, hold my beer
         *
         * @var string
         */
        protected $logoPath = '';

        /**
         * builds an assurance
         *
         * @param array $rawAssur
         */
        public function __construct(array $rawAssur) {
            if (isset($rawAssur['name'],$rawAssur['phone'])) {
                if (isset($rawAssur['id'])) {
                    $this->id = $rawAssur['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->phone = $rawAssur['phone'];
                $this->name = $rawAssur['name'];
                $this->logoPath = $rawAssur['logoPath'];
            } else {
                throw new Exception("Array passed doesn't represent an Assurance", 1);
            }
        }

        /**
         * returns assurance name
         *
         * @return void
         */
        public function getName() {
            return $this->name;
        }

        /**
         * returns assurance phone number
         *
         * @return void
         */
        public function getPhone() {
            return $this->phone;
        }

        /**
         * returns assurance id
         *
         * @return void
         */
        public function getID() {
            return $this->id;
        }

        /**
         * returns assurance logo?
         *
         * @return void
         */
        public function getLogo() {
            return $this->logoPath;
        }

        /**
         * returns assurance array
         *
         * @return array data
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'logoPath' => $this->logoPath
            );
        }
    }

?>
