<?php
namespace MsfTheDev\TestSeoPlugin;

include_once(TEST_SEO_PLUGIN_ROOT . 'database/database_manager.php');
use MsfTheDev\TestSeoPlugin\Database\DatabaseManager;

class Factory {
    private static $dbManagerInstance;

    private function __construct() {
        // Private constructor to prevent direct instantiation
    }

    public static function createDatabaseManager() {
        if (!isset(self::$dbManagerInstance)) {
            self::$dbManagerInstance = new DatabaseManager();
        }
        return self::$dbManagerInstance;
    }
}

