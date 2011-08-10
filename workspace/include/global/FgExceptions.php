<?php
class FgException extends Exception
{
	public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

	public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}



class Exception_Event_NotFound extends FgException{}
class Exception_Login extends FgException{}
