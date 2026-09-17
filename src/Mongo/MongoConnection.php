<?php
declare(strict_types=1);
namespace mongo;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class MongoConnection
{
    private const DEFAULT_URI = "mongodb://mongodb:27017";
    private const DEFAULT_DATABASE = "vulnerableapp_php";

    private static $instance = null;

    private $manager;
    private $database;

    private function __construct()
    {
        $this->manager = new Manager(getenv("MONGODB_URI") ?: self::DEFAULT_URI);
        $this->database = getenv("MONGODB_DATABASE") ?: self::DEFAULT_DATABASE;
    }

    public static function instance(): MongoConnection
    {
        if (self::$instance === null) {
            self::$instance = new MongoConnection();
        }
        return self::$instance;
    }

    public function findOne(string $collection, array $filter): ?array
    {
        $query = new Query($filter, ["limit" => 1]);
        $cursor = $this->manager->executeQuery($this->namespace($collection), $query);
        $documents = $cursor->toArray();
        if (count($documents) === 0) {
            return null;
        }
        return json_decode(json_encode($documents[0]), true);
    }

    public function manager(): Manager
    {
        return $this->manager;
    }

    public function database(): string
    {
        return $this->database;
    }

    public function namespace(string $collection): string
    {
        return $this->database . "." . $collection;
    }
}
?>
