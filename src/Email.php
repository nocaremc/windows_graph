<?php namespace windows_graph;

use \DateTime;

/**
*  Email
*
*  Represents an email
*
*  @author Joshua Rodarte
*/
class Email {

    /**  @var string $id ID of this email */
    public $id;

    /** @var DateTime|StdClass $receivedDateTime DateTime email was recieved */
    public $receivedDateTime;

    /** @var string $subject Subject of this email */
    public $subject;

    /**
    * init
    *
    * Converts its StdClass DateTime object to an actual DateTime object
    *
    * @return void
    */
    public function init() {

        $this->receivedDateTime = new DateTime($this->receivedDateTime);
    }
}