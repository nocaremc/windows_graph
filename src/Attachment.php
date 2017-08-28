<?php namespace nocare\windows_graph;

/**
*  Attachment
*
*  Represents an Email attachment.
*  Contains attachment data which can be saved.
*
*  @author Joshua Rodarte
*/
class Attachment {

    /**  @var string $id ID of this attachment */
    public $id;

    /**  @var string $name Name of attachment */
    public $name;

    /**  @var string $contentBytes Base64 byte/binary data of attachment */
    public $contentBytes;

    /**
    * saveLocal
    *
    * Saves its attachment data to timestamped file in the same directory
    *
    * @return string $file_uri Server Path to the file that was just generated
    */
    public function saveLocal($file_path) {

        $now = new \DateTime();
        $now = $now->format('m-d-Y');

        $file_uri = $file_path . "/{$now}-{$this->name}";

        file_put_contents($file_uri, base64_decode($this->contentBytes));
        return $file_uri;
    }
}