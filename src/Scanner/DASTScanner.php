<?php
declare(strict_types=1);

namespace scanner;

use facadeSchema\VulnerabilityDefinition;
use facadeSchema\VulnerabilityLevelDefinition;
use framework\Bootstrap;

require_once __DIR__ . "/../framework/Bootstrap.php";

class DASTScanner
{
    private function getApplicationUrl(): string
    {
        $scheme = "http";
        if (!empty($_SERVER["HTTP_X_FORWARDED_PROTO"])) {
            $scheme = trim(explode(",", $_SERVER["HTTP_X_FORWARDED_PROTO"])[0]);
        } elseif (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") {
            $scheme = "https";
        }

        $host = $_SERVER["HTTP_HOST"] ?? "localhost";
        return $scheme . "://" . $host . "/VulnerableApp-php/";
    }

    private function getVulnerabilityTypeNames(
        VulnerabilityDefinition $definition,
        VulnerabilityLevelDefinition $level
    ): array {
        $names = [];
        $hints = $level->get_hints();
        foreach ($hints as $hint) {
            foreach ($hint->get_vulnerability_types() as $vulnerabilityType) {
                $value = $vulnerabilityType->get_value();
                if (!in_array($value, $names, true)) {
                    $names[] = $value;
                }
            }
        }

        if (empty($names)) {
            foreach ($definition->get_vulnerability_types() as $vulnerabilityType) {
                $value = $vulnerabilityType->get_value();
                if (!in_array($value, $names, true)) {
                    $names[] = $value;
                }
            }
        }

        return $names;
    }

    private function buildScannerRows(): array
    {
        $definitions = Bootstrap::Instance()->get_vulnerability_definitions();
        $rows = [];
        $applicationUrl = $this->getApplicationUrl();

        foreach ($definitions as $definition) {
            $vulnerabilityId = $definition->get_id();
            foreach ($definition->get_level_definitions() as $levelDefinition) {
                $rows[] = [
                    "url" =>
                        $applicationUrl .
                        $vulnerabilityId .
                        "/" .
                        $levelDefinition->get_level(),
                    "variant" => $levelDefinition->get_variant(),
                    "method" => "POST",
                    "vulnerabilityTypes" => $this->getVulnerabilityTypeNames(
                        $definition,
                        $levelDefinition
                    ),
                ];
            }
        }

        return $rows;
    }

    function dast()
    {
        header("Content-type: application/json");
        echo json_encode($this->buildScannerRows(), JSON_UNESCAPED_SLASHES);
    }
}
