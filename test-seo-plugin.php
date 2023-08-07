<?php
/**
 * Plugin Name: Test SEO Plugin
 * Description: A plugin to improve SEO by crawling internal links.
 * Version: 1.0
 * Author: Your Name
 */
namespace MsfTheDev\TestSeoPlugin;

define('TEST_SEO_PLUGIN_ROOT', plugin_dir_path(__FILE__));

use MsfTheDev\TestSeoPlugin\Admin\AdminPage;

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
