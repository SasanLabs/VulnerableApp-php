<?php
class ResourceInformation {
    
    private $htmlResource;
    private $staticResources;

    function get_html_resource() {
        return $this->htmlResource;
    }

    function set_html_resource( $htmlResource ) {
        $this->htmlResource = $htmlResource;
    }

    function get_static_resources() {
        return $this->staticResources;
    }

    function set_static_resources( $staticResources ) {
        $this->staticResources = $staticResources;
    }
}
