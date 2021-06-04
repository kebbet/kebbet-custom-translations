<?php
/**
 * Plugin Name: Kebbet plugins - Custom Translations
 * Plugin URI:  https://github.com/kebbet/wp-custom-translations
 * Description: Merges translations under ”custom-languages” on top of those installed.
 * Version:     20210604.01
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 *
 * @package kebbet-custom-translations
 * @author Erik Betshammar
 * @source https://wordpress.stackexchange.com/a/302390
 */

namespace kebbet\muplugin\customtranslations;

/**
 * Modify translations directories.
 *
 * @param string $domain The text domain.
 * @param string $mo_file The mo-file and its path.
 */
function load_custom_translations( $domain = '', $mo_file = '' ){
	$wp_language_dir     = trailingslashit( WP_LANG_DIR );
	$language_dir_length = strlen( $wp_language_dir );
	$mo_file_dir         = substr( $mo_file, 0, $language_dir_length );

	// Only run this if file being loaded is under WP_LANG_DIR.
	if ( $wp_language_dir === $mo_file_dir ) {

		$language_folder_length = strlen( 'languages/' ); // Languages are stored in this folder.
		$language_parent_dir    = substr( $wp_language_dir, 0, - $language_folder_length );
		$custom_language_dir    = $language_parent_dir . 'custom-languages/'; // The custom folder.
		$mo_file_name           = substr( $mo_file, $language_dir_length ); // File file name and its folder (plugin/ or themes/).
		$custom_file_path       = $custom_language_dir . $mo_file_name;

		/**
		 * Our custom directory is parallel to languages directory.
		 * Load translations only if a custom file exists.
		 */ 
		if ( $mo_file = realpath( $custom_file_path ) ) {
			load_textdomain( $domain, $mo_file );
		}
	}
}
add_action( 'load_textdomain', __NAMESPACE__ . '\load_custom_translations', 10, 2 );
