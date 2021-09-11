<?php
namespace framework;
use fileupload\FileUpload;
use ReflectionClass;
use framework\Mapper;
require __DIR__."/../fileUploadVulnerability/FileUpload.php";
require __DIR__."/Mapper.php";
class Bootstrap{
    private $routing_url_to_mapper = array();
    private $vulnerability_definition_providers = array();
    public static function Instance(){
        static $instance = null;
        if ($instance === null) {
            $instance = new Bootstrap();
        }
        return $instance;
    }
    
    function get_routing_info(): array {
        return $this->routing_url_to_mapper;
    }

    function get_vulnerability_definitions() : array {
        $vulnerability_definitions = array();
        foreach($this->vulnerability_definition_providers as $provider){
            array_push($vulnerability_definitions,$provider->getMethod("getVulnerabilityDefinition")->invoke($provider->newInstance()));
        }
        return $vulnerability_definitions;
    }

    function __construct() {
        array_push($this->vulnerability_definition_providers, new ReflectionClass(FileUpload::class));
        $this->routing_url_to_mapper["/VulnerableApp-php/FileUpload/Level_1"] = new Mapper(new ReflectionClass(FileUpload::class), "level1");
        $this->routing_url_to_mapper["/VulnerableApp-php/FileUpload/Level_2"] = new Mapper(new ReflectionClass(FileUpload::class), "level2");
    }
}
?>