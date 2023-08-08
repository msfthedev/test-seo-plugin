<?php
namespace MsfTheDev\TestSeoPlugin\Database;

class DatabaseManager {
    private $crawl_table = '';

    public function __construct() {
        global $wpdb;

        // Table name
        $this->crawl_table = $wpdb->prefix . 'crawling_results';
        
        // SQL query to create the table if it doesn't exist
        $create_table_sql = "
            CREATE TABLE IF NOT EXISTS $this->crawl_table (
                id INT AUTO_INCREMENT PRIMARY KEY,
                link VARCHAR(255) NOT NULL
            )
        ";
        
        // Create or update the table
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($create_table_sql);        
    }

	public function getStoredLinks() {
		global $wpdb;

		$query = "SELECT link FROM $this->crawl_table";
		$links = $wpdb->get_col($query);

		return $links;
	}

    public function deleteCrawlingResults() {
        global $wpdb;
        
        $result = $wpdb->query("DELETE FROM $this->crawl_table");
        if ($result !== false) {
            echo 'Crawling results deleted successfully.<br>';
        } else {
            $wpdb->print_error();
        }
    }
    
    public function storeCrawlingResults($links) {
        global $wpdb;
        
        foreach ($links as $link) {
            $result = $wpdb->insert($this->crawl_table, array('link' => $link));
            if ($result === false) {
                $wpdb->print_error();
                break; // Stop if an error occurs
            }            
        }
        echo 'Crawling results stored successfully.<br>';
    }
    

}
