<?php

require __DIR__ . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

/**
*  MSClient
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author Joshua Rodarte
*/
class MSClientTest extends TestCase {
	
    /**
    * Just check if the YourClass has no syntax error 
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function testIsThereAnySyntaxError() {

        $var = new nocare\windows_graph\MSClient('', '', '', '');
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
    * Just check if the YourClass has no syntax error 
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    /*
    public function testMethod1(){

        $var = new Buonzz\Template\YourClass;
        $this->assertTrue($var->method1("hey") == 'Hello World');
        unset($var);
    }
    */
}