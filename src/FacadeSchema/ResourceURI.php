<?php
class ResourceURI {

    private $resourceType = ResourceType::HTML;
    private $isAbsolute;
    private $uri;

    function __construct(bool $isAbsolute, string $uri, ResourceType $resourceType) {
        $this->isAbsolute = $isAbsolute;
        $this->uri = $uri;
        $this->resourceType = $resourceType;
    }

    function is_absolute(): bool {
        return $this->isAbsolute;
    }

    function get_uri(): string {
        return $this->uri;
    }

    function get_resource_type(): ResourceType {
        return $this->resourceType;
    }
}
?>