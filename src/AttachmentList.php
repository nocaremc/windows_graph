<?php namespace windows_graph;

use Attachment;
use JsonMapper;

/**
*  AttachmentList
*
*  List of Attachments.
*
*  @author Joshua Rodarte
*/
class AttachmentList {

    /**  @var $value Array of nocare\windows_graph\Attachments OR \StdClass */
    public $value;

    /**
    * init
    *
    * When this class is instantiated, $value is full of StdClass objects.
    * We remap these to Attachment objects
    *
    * @return void
    */
    public function init() {

        foreach($this->value as &$attachment) {

            $mapper = new JsonMapper();
            $attachment = $mapper->map($attachment, new Attachment());
            //$attachment->saveLocal();
        }
    }
}