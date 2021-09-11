<?php
namespace router;
use framework\Bootstrap;
require __DIR__."/../framework/Bootstrap.php";

$uri = $_SERVER['REQUEST_URI'];
echo $uri."\n";
$routing_url_to_class_mapper = Bootstrap::Instance()->get_routing_info();
var_dump($routing_url_to_class_mapper);
if(array_key_exists($uri,$routing_url_to_class_mapper)) {
    echo $routing_url_to_class_mapper[$uri]->invoke();
} else {
    echo $uri. " is not available";
}
?>