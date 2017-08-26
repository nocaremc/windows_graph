<?php namespace windows_graph;

use JsonMapper;
use Email;

/**
*  EmailList
*
*  A list of nocare\windows_graph\Emails.
*
*  @author Joshua Rodarte
*/
class EmailList {

    /** @var Array<StdObject|Email> $value Array of Emails */
    public $value;

    /** @var string $search_subject Email subject to match in getLatestEmail */
    public $search_subject;

    public function __contruct($search_subject) {

        $this->search_subject = $search_subject;
    }

    /**
    * init
    *
    * Maps $value to an array of Email objects
    *
    * @return void
    */
    public function init() {

        foreach($this->value as &$email) {
            
            $mapper = new JsonMapper();
            $email = $mapper->map($email, new Email());
            $email->init();
        }
    }

    /**
    * getLatestEmail
    *
    * Sorts list of emails by date (desc) and return first
    *
    * @return nocare\windows_graph\Email Latest email
    */
    public function getLatestEmail() {

        usort($this->value, function($a, $b) {

            // We'll immediately downsort if this isn't the right email
            if($a->subject !== $this->search_subject) {

                return 1;
            }

            if($b->subject !== $this->search_subject) {

                return -1;
            }

            $a = $a->receivedDateTime;
            $b = $b->receivedDateTime;

            if($a == $b) {
                return 0;
            }

            return $a > $b ? -1 : 1;
        });
        
        return $this->value[0];
    }
}