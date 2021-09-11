<?php
namespace framework;
use ReflectionClass;
class Mapper{
    private $reflectionClass;
    private $methodname;
    private $instance;
    function __construct(ReflectionClass $reflectionClass, string $methodname)
    {
        $this->reflectionClass = $reflectionClass;
        $this->methodname = $methodname;
        $this->instance = $this->reflectionClass->newInstance();
    }
    
    function invoke() {
        return $this->reflectionClass->getMethod($this->methodname)->invoke($this->instance);
    }
}
?>