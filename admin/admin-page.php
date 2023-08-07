<?php
namespace MsfTheDev\TestSeoPlugin\Admin;

use MsfTheDev\TestSeoPlugin\Factory;
use MsfTheDev\TestSeoPlugin\Crawl\Crawler;

class AdminPage{
    public function __construct() {
        //        
    }

	public function showStoredLinks() {
		$dbManager = Factory::createDatabaseManager();
        $storedLinks = $dbManager->getStoredLinks();

        if (!empty($storedLinks)) {
            echo '<h2>Crawled Links</h2>';
            echo '<ul>';
            foreach ($storedLinks as $link) {
                echo '<li>' . esc_html($link) . '</li>';
            }
            echo '</ul>';
        }
    }
	
    function showAdminPage(){
        include_once( TEST_SEO_PLUGIN_ROOT . 'crawler/crawler.php');
        $crawler = new Crawler();
    ?>
    <div class="wrap">
        <h1>SEO Crawl Admin Page</h1>
        <p>Welcome to the SEO Crawl admin page. Click the button below to trigger a crawl.</p>
        
        <form method="post" action="">
            <?php wp_nonce_field('seo_crawl', 'seo_crawl_nonce'); ?>
            <input type="submit" class="button button-primary" name="crawl_button" value="Trigger Crawl">
			<input type="submit" class="button" name="show_links_button" value="Show Last Crawled Links">
        </form>

        <?php
        if (isset($_POST['crawl_button'])) {
            if (!isset($_POST['seo_crawl_nonce']) || !wp_verify_nonce($_POST['seo_crawl_nonce'], 'seo_crawl')) {
                wp_die('Unauthorized request');
            }

            // Perform crawl on the home page
            $home_page_url = get_home_url();
            $crawl_results = $crawler->crawlWebsite($home_page_url);
			
			$this->showStoredLinks();
			
        }elseif (isset($_POST['show_links_button'])) {
            $this->showStoredLinks();
        }
        ?>
    </div>
    <?php
    }
}