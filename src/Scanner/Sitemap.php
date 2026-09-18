<?php
declare(strict_types=1);

namespace scanner;

use framework\Bootstrap;

require_once __DIR__ . "/../framework/Bootstrap.php";

class Sitemap
{
    private function getApplicationBaseUrl(): string
    {
        $scheme = "http";
        if (!empty($_SERVER["HTTP_X_FORWARDED_PROTO"])) {
            $scheme = trim(explode(",", $_SERVER["HTTP_X_FORWARDED_PROTO"])[0]);
        } elseif (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") {
            $scheme = "https";
        }

        $host = $_SERVER["HTTP_HOST"] ?? "localhost";
        return $scheme . "://" . $host;
    }

    private function buildSitemapUrls(): array
    {
        $routingInfo = Bootstrap::Instance()->get_routing_info();
        $baseUrl = $this->getApplicationBaseUrl();
        $urls = [];

        foreach (array_keys($routingInfo) as $path) {
            if (!is_string($path) || $path === "") {
                continue;
            }

            $urls[] = $baseUrl . $path;
        }

        $urls = array_values(array_unique($urls));
        sort($urls, SORT_STRING);

        return $urls;
    }

    function sitemap()
    {
        $urls = $this->buildSitemapUrls();
        header("Content-type: application/xml; charset=UTF-8");

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        foreach ($urls as $url) {
            $escapedUrl = htmlspecialchars($url, ENT_QUOTES | ENT_XML1, "UTF-8");
            echo "  <url><loc>" . $escapedUrl . "</loc></url>\n";
        }
        echo "</urlset>";
    }
}
