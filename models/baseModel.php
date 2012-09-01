<?php
    class BaseModel {
        protected $con;
        public function __construct() {
            require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.inc");
            $this->con = init();
        }
    }