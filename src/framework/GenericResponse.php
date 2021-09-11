<?php declare(strict_types = 1);
namespace framework;

use JsonSerializable;

class GenericResponse implements JsonSerializable{
    private $isValid;
    private $content;
    private $error;
    function __construct(bool $isValid,string $content, string $error)
    {
        $this->isValid = $isValid;
        $this->content = $content;
        $this->error = $error;
    }

    function is_valid() {
        return $this->isValid;
    }

    function get_content() {
        return $this->content;
    }

    function get_error() {
        return $this->error;
    }
    
    public function jsonSerialize() {
		return get_object_vars($this);
	}
}

?>