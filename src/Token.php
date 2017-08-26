<?php namespace nocare\windows_graph;

/**
*  Token
*
*  Holds token data
*
*  @author Joshua Rodarte
*/
class Token {

    /**  @var string $token_type The type of token, such as "bearer" */
    public $token_type;

    /**  @var string $expires_in Time until this token expires */
    public $expires_in;

    /**  @var string $ext_expires_in Another experation? */
    public $ext_expires_in;

    /**  @var string $access_token The token string */
    public $access_token;

    /**
    * __toString
    *
    * @return string Formatted for use in an Authorization header.
    */
    public function __toString() {

        return "{$this->token_type} {$this->access_token}";
    }
}