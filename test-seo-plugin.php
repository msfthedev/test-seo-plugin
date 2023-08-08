<?php
/**
 * Plugin Name: Test SEO Plugin
 * Description: A plugin to improve SEO by crawling internal links.
 * Version: 1.0.1
 * Author: Muhammad Saeed
 */
namespace MsfTheDev\TestSeoPlugin;

define('TEST_SEO_PLUGIN_ROOT', plugin_dir_path(__FILE__));

use MsfTheDev\TestSeoPlugin\Admin\AdminPage;
use MsfTheDev\TestSeoPlugin\Crawl\Crawler;

require_once(plugin_dir_path(__FILE__) . 'factory.php');
use MsfTheDev\TestSeoPlugin\Factory;

class Plugin {
	public $factory;
	
    public function __construct() {
        // Activation and Deactivation Hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Hook to add admin menu
        add_action('admin_menu', array($this, 'add_admin_page'));

        // Schedule the crawlWebsite event to run hourly
        if (!wp_next_scheduled('crawl_website_event')) {
            wp_schedule_event(time(), 'hour', 'crawl_website_event');
        }
        add_action('crawl_website_event', array($this, 'crawl_website_callback'));		
    }

    // Callback function to be executed when the event is triggered
    public function crawl_website_callback() {
        include_once( TEST_SEO_PLUGIN_ROOT . 'crawler/crawler.php');
        $crawler = new Crawler();
		
        $home_page_url = get_home_url();
        $crawl_results = $crawler->crawlWebsite($home_page_url);
    }
	
    // Activation Hook
    public function activate() {
        // Perform activation tasks if needed
    }

    // Deactivation Hook
    public function deactivate() {
        // Perform deactivation tasks if needed
    }

    // Method to add admin page
    public function add_admin_page() {
        add_menu_page(
            'Test SEO Plugin',
            'Test SEO',
            'manage_options',
            'test-seo-plugin',
            array($this, 'render_admin_page')
        );
    }

    // Method to render admin page content
    public function render_admin_page() {
        // Include the admin page file
        include_once(plugin_dir_path(__FILE__) . '/admin/admin-page.php');
        $adminPage = new AdminPage();
        $adminPage->showAdminPage();
    }
}

// Initialize the plugin
$test_seo_plugin = new Plugin();
