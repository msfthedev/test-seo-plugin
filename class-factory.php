<?php
/**
 * Factory class file.
 *
 * This file defines the Factory class, responsible for creating and managing objects.
 *
 * @package MsfTheDev\TestSeoPlugin
 * @since   1.0.0
 */

namespace MsfTheDev\TestSeoPlugin;

require_once MSFTHEDEV_TEST_SEO_PLUGIN_ROOT . 'database/class-databasemanager.php';
use MsfTheDev\TestSeoPlugin\Database\DatabaseManager;

/**
 * Factory class.
 *
 * This class provides methods for creating and managing objects.
 *
 * @package MsfTheDev\TestSeoPlugin
 * @since   1.0.0
 */
class Factory {
	/**
	 * Database manager instance.
	 *
	 * @var DatabaseManager $db_manager_instance An instance of the database manager.
	 * @since 1.0.0
	 */
	private static $db_manager_instance;
	/**
	 * Private constructor to prevent direct instantiation.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Private constructor to prevent direct instantiation.
	}

	/**
	 * Create a database manager instance.
	 *
	 * If an instance does not exist, it will be created and returned.
	 *
	 * @return DatabaseManager The database manager instance.
	 * @since 1.0.0
	 */
	public static function create_database_manager() {
		if ( ! isset( self::$db_manager_instance ) ) {
			self::$db_manager_instance = new DatabaseManager();
		}
		return self::$db_manager_instance;
	}
}
