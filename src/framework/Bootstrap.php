<?php
namespace framework;
use fileupload\FileUpload;
use ReflectionClass;
use framework\Mapper;
require __DIR__ . "/../fileUploadVulnerability/FileUpload.php";
require __DIR__ . "/Mapper.php";
class Bootstrap
{
    private $routing_url_to_mapper = [];
    private $vulnerability_definition_providers = [];
    public static function Instance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new Bootstrap();
        }
        return $instance;
    }

    function get_routing_info(): array
    {
        return $this->routing_url_to_mapper;
    }

    function get_vulnerability_definitions(): array
    {
        $vulnerability_definitions = [];
        foreach ($this->vulnerability_definition_providers as $provider) {
            array_push(
                $vulnerability_definitions,
                $provider
                    ->getMethod("getVulnerabilityDefinition")
                    ->invoke($provider->newInstance())
            );
        }
        return $vulnerability_definitions;
    }

    function __construct()
    {
        array_push(
            $this->vulnerability_definition_providers,
            new ReflectionClass(FileUpload::class)
        );
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_1"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level1");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_2"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level2");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_3"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level3");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_4"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level4");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_5"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level5");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_6"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level6");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_7"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level7");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_8"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level8");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_9"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level9");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_10"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level10");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_11"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level11");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_12"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level12");
        $this->routing_url_to_mapper[
            "/VulnerableApp-php/FileUpload/LEVEL_13"
        ] = new Mapper(new ReflectionClass(FileUpload::class), "level13");
    }
}
?>
