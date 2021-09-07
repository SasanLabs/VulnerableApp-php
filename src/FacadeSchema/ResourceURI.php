<?php
class ResourceURI {

    private $resourceType = ResourceType::HTML;
    private $isAbsolute;
    private $uri;

    function __construct($isAbsolute, $uri, $resourceType) {
        $this->isAbsolute = $isAbsolute;
        $this->uri = $uri;
        $this->resourceType = $resourceType;
    }

    function is_absolute() {
        return $this->isAbsolute;
    }

    function get_uri() {
        return $this->uri;
    }

    function get_resource_type() {
        return $this->resourceType;
    }
}
?>