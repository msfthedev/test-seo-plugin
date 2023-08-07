<?php
namespace MsfTheDev\TestSeoPlugin\Crawl;

require_once TEST_SEO_PLUGIN_ROOT . 'vendor/autoload.php';

use Goutte\Client;
use MsfTheDev\TestSeoPlugin\Factory;

class Crawler {
    public function __construct() {
		//
    }

    public function crawlWebsite($url) {
		$dbManager = Factory::createDatabaseManager();
        // Delete previous crawl results
        $dbManager->deleteCrawlingResults();

        // Start crawling from the root URL
        $internalLinks = $this->extractInternalLinks($url);

        // Store results in the database
        $this->storeCrawlingResults($internalLinks);

        // Save home page as .html
        $this->saveHomePageHtml($url);

        // Create sitemap.html
        $this->createSitemapHtml($internalLinks);

        return $internalLinks;
    }

    private function extractInternalLinks($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        
        $internalLinks = [];
        
        // Extract internal links from anchor tags
        $crawler->filter('a')->each(function ($node) use (&$internalLinks) {
            $link = $node->link()->getUri();
            
            if ($this->isInternalLink($link)) {
                $internalLinks[] = $link;
            }
        });

        return $internalLinks;
    }

    private function isInternalLink($link) {
		$baseUrl = site_url();
        $parsedLink = parse_url($link);
        $parsedBaseUrl = parse_url($baseUrl);

        if ($parsedLink['host'] === $parsedBaseUrl['host']) {
            return true;
        }

        return false;
    }
	
    private function storeCrawlingResults($links) {
		$dbManager = Factory::createDatabaseManager();
        $dbManager->storeCrawlingResults($links);
    }

    private function saveHomePageHtml($url) {
        // Fetch the home page content
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $content = $crawler->html();

        // Save as .html file
        file_put_contents(TEST_SEO_PLUGIN_ROOT . 'output/homepage.html', $content);
    }

    private function createSitemapHtml($links) {
        // Generate sitemap structure
        $sitemapContent = '<ul>';
        foreach ($links as $link) {
            $sitemapContent .= '<li>' . $link . '</li>';
        }
        $sitemapContent .= '</ul>';

        // Save as sitemap.html
        file_put_contents(TEST_SEO_PLUGIN_ROOT . 'output/sitemap.html', $sitemapContent);
    }
}
