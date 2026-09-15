<?php
declare(strict_types=1);
namespace mongo;

use MongoDB\BSON\ObjectId;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\Exception as MongoException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class MongoConnection
{
    private const DEFAULT_URI = "mongodb://mongodb:27017";
    private const DEFAULT_DATABASE = "vulnerableapp_php";

    private static $instance = null;

    private $manager;
    private $database;
    private $seeded = false;

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
        $this->seedIfRequired();
        $query = new Query($filter, ["limit" => 1]);
        $cursor = $this->manager->executeQuery($this->namespace($collection), $query);
        $documents = $cursor->toArray();
        if (count($documents) === 0) {
            return null;
        }
        return json_decode(json_encode($documents[0]), true);
    }

    public function seedIfRequired(): void
    {
        if ($this->seeded) {
            return;
        }

        try {
            $query = new Query(["seedMarker" => "nosql_injection_users"], ["limit" => 1]);
            $cursor = $this->manager->executeQuery($this->namespace("seed_metadata"), $query);
            if (count($cursor->toArray()) > 0) {
                $this->seeded = true;
                return;
            }

            $users = $this->buildSeedUsers();
            $bulkWrite = new BulkWrite();
            foreach ($users as $user) {
                $bulkWrite->insert($user);
            }
            $this->manager->executeBulkWrite($this->namespace("users"), $bulkWrite);

            $metadata = new BulkWrite();
            $metadata->insert([
                "_id" => new ObjectId(),
                "seedMarker" => "nosql_injection_users",
                "createdAt" => time(),
            ]);
            $this->manager->executeBulkWrite($this->namespace("seed_metadata"), $metadata);
            $this->seeded = true;
        } catch (MongoException $exception) {
            throw new \RuntimeException("MongoDB seed failed: " . $exception->getMessage(), 0, $exception);
        }
    }

    private function namespace(string $collection): string
    {
        return $this->database . "." . $collection;
    }

    private function buildSeedUsers(): array
    {
        $users = [];
        for ($level = 1; $level <= 5; $level++) {
            $password = "level" . $level . "_password";
            $users[] = [
                "_id" => new ObjectId(),
                "level" => "LEVEL_" . $level,
                "username" => "level" . $level . "_user",
                "password" => $password,
                "passwordHash" => password_hash($password, PASSWORD_DEFAULT),
                "role" => "user",
            ];
            $adminPassword = "level" . $level . "_admin_secret";
            $users[] = [
                "_id" => new ObjectId(),
                "level" => "LEVEL_" . $level,
                "username" => "level" . $level . "_admin",
                "password" => $adminPassword,
                "passwordHash" => password_hash($adminPassword, PASSWORD_DEFAULT),
                "role" => "admin",
            ];
        }
        return $users;
    }
}
?>
