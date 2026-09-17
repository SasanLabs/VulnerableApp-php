<?php
declare(strict_types=1);

namespace scanner;

use fileupload\FileUpload;
use magichash\MagicHash;
use nosqlinjection\NoSQLInjection;
use ReflectionMethod;

class SASTScanner
{
    private const CATALOG = [
        [
            "class" => FileUpload::class,
            "filePath" => "src/FileUploadVulnerability/FileUpload.php",
            "methods" => [
                "level1",
                "level2",
                "level3",
                "level4",
                "level5",
                "level6",
                "level7",
                "level8",
                "level9",
                "level10",
                "level11",
            ],
            "cwe" => "CWE-434",
            "type" => "Unrestricted File Upload",
        ],
        [
            "class" => MagicHash::class,
            "filePath" => "src/MagicHashVulnerability/MagicHash.php",
            "methods" => ["level1", "level2"],
            "cwe" => "CWE-704",
            "type" => "Magic Hash Exploitation",
        ],
        [
            "class" => NoSQLInjection::class,
            "filePath" => "src/NoSQLInjectionVulnerability/NoSQLInjection.php",
            "methods" => ["level1", "level2", "level3"],
            "cwe" => "CWE-943",
            "type" => "MongoDB NoSQL Injection",
        ],
        [
            "class" => NoSQLInjection::class,
            "filePath" => "src/NoSQLInjectionVulnerability/NoSQLInjection.php",
            "methods" => ["level4"],
            "cwe" => "CWE-256",
            "type" => "Insecure Credential Storage",
        ],
    ];

    private function buildScannerRows(): array
    {
        $rows = [];

        foreach (self::CATALOG as $entry) {
            foreach ($entry["methods"] as $methodName) {
                $method = new ReflectionMethod($entry["class"], $methodName);
                $rows[] = [
                    "cwe" => $entry["cwe"],
                    "filePath" => $entry["filePath"],
                    "line" => (int) $method->getStartLine(),
                    "numberOfSources" => 1,
                    "type" => $entry["type"],
                ];
            }
        }

        return $rows;
    }

    function sast(): void
    {
        header("Content-type: application/json");
        echo json_encode($this->buildScannerRows(), JSON_UNESCAPED_SLASHES);
    }
}
