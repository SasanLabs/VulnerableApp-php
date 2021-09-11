<?php
namespace facadeSchema;

use JsonSerializable;

class ResourceInformation implements JsonSerializable
{
    private $htmlResource;
    private $staticResources = [];

    function get_html_resource(): string
    {
        return $this->htmlResource;
    }

    function set_html_resource(ResourceURI $htmlResource)
    {
        $this->htmlResource = $htmlResource;
    }

    function get_static_resources(): array
    {
        return $this->staticResources;
    }

    function add_static_resources(ResourceURI $staticResources)
    {
        array_push($this->staticResources, $staticResources);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
