<?php
namespace facadeSchema;
class ResourceInformation {
    
    private $htmlResource;
    private $staticResources;

    function get_html_resource(): string {
        return $this->htmlResource;
    }

    function set_html_resource(string $htmlResource ) {
        $this->htmlResource = $htmlResource;
    }

    function get_static_resources(): string{
        return $this->staticResources;
    }

    function set_static_resources(string $staticResources ) {
        $this->staticResources = $staticResources;
    }
}
