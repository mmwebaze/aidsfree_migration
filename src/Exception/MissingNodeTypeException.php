<?php

namespace Drupal\aidsfree_migration\Exception;

class MissingNodeTypeException extends \Exception {
  public function __construct($message, $code = 0, \Exception $previous = null) {
    parent::__construct($message, $code, $previous);
  }
  public function __toString() {

    return "The content type '".$this->message. "' needs to be created first.";
  }
  /*public function message(){
    return 'The content type '.$this->message. ' needs to be created first.';
  }*/
}