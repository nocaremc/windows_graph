<?php namespace nocare\windows_graph;

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

    /** @var \DateTime $receivedDateTime DateTime email was recieved */
    public $receivedDateTime;

    /** @var string $subject Subject of this email */
    public $subject;
}