<?php
/**
 * SystemInfo class file.
 *
 * @package cyr-to-lat
 */

namespace CyrToLat\Settings;

use CyrToLat\ConversionTables;
use CyrToLat\Settings\Abstracts\SettingsBase;

/**
 * Class SystemInfo
 *
 * Settings page "SystemInfo".
 */
class SystemInfo extends PluginSettingsBase {

	/**
	 * Admin script handle.
	 */
	public const HANDLE = 'cyr-to-lat-system-info';

	/**
	 * Script localization object.
	 */
	public const OBJECT = 'Cyr2LatSystemInfoObject';

	/**
	 * Data key length.
	 */
	public const DATA_KEY_LENGTH = 36;

	/**
	 * Get page title.
	 *
	 * @return string
	 */
	protected function page_title(): string {
		return __( 'System Info', 'cyr2lat' );
	}

	/**
	 * Get section title.
	 *
	 * @return string
	 */
	protected function section_title(): string {
		return 'system-info';
	}

	/**
	 * Enqueue class scripts.
	 */
	public function admin_enqueue_scripts(): void {
		wp_enqueue_script(
			self::HANDLE,
			constant( 'CYR_TO_LAT_URL' ) . "/assets/js/system-info$this->min_prefix.js",
			[],
			constant( 'CYR_TO_LAT_VERSION' ),
			true
		);

		wp_localize_script(
			self::HANDLE,
			self::OBJECT,
			[
				'copiedMsg' => __( 'System info copied to clipboard.', 'cyr2lat' ),
			]
		);

		wp_enqueue_style(
			self::HANDLE,
			constant( 'CYR_TO_LAT_URL' ) . "/assets/css/system-info$this->min_prefix.css",
			[ SettingsBase::HANDLE ],
			constant( 'CYR_TO_LAT_VERSION' )
		);
	}

	/**
	 * Section callback.
	 *
	 * @param array $arguments Section arguments.
	 */
	public function section_callback( array $arguments ): void {
		?>
		<h2>
			<?php echo esc_html__( 'System Information', 'cyr2lat' ); ?>
		</h2>
		<div id="ctl-system-info-wrap">
			<span class="helper">
				<span class="helper-content"><?php esc_html_e( 'Copy system info to clipboard', 'cyr2lat' ); ?></span>
			</span>
			<div class="dashicons-before dashicons-media-text" aria-hidden="true"></div>
			<label>
			<textarea
					id="ctl-system-info"
					readonly><?php echo esc_textarea( $this->get_system_info() ); ?></textarea>
			</label>
		</div>
		<?php
	}

	/**
	 * Get system information.
	 *
	 * Based on a function from WPForms.
	 *
	 * @return string
	 */
	public function get_system_info(): string {
		$data = $this->header( '### Begin System Info ###' );

		$data .= $this->cyr_to_lat_info();
		$data .= $this->site_info();
		$data .= $this->wp_info();
		$data .= $this->uploads_info();
		$data .= $this->plugins_info();
		$data .= $this->server_info();

		$data .= $this->header( '### End System Info ###' );

		return $data;
	}

	/**
	 * Get Cyr To Lat info.
	 *
	 * @return string
	 */
	private function cyr_to_lat_info(): string {
		global $cyr_to_lat_plugin;

		$data = $this->header( '-- Cyr To Lat Info --' );

		$settings = $cyr_to_lat_plugin->settings();
		$tabs     = $settings->get_tabs();

		/**
		 * Tables instance.
		 *
		 * @var Tables $tables
		 */
		$tables         = array_filter(
			$tabs,
			static function ( $tab ) {
				return is_a( $tab, Tables::class );
			}
		)[0];
		$locales        = $tables->get_locales();
		$current_locale = $tables->get_current_locale();

		$data .= $this->data( 'Version', CYR_TO_LAT_VERSION );
		$data .= $this->data( 'Site locale', get_locale() );
		$data .= $this->data( 'User locale', get_user_locale() );
		$data .= $this->data( 'Current table', $current_locale );

		foreach ( $locales as $key => $locale ) {
			$default_table = ConversionTables::get( $key );
			$table         = $settings->get( $key );
			$diff          = array_diff( $table, $default_table );

			if ( ! $diff ) {
				continue;
			}

			$table_name = $key;

			$data .= $this->header( "--- $table_name table customization ---" );

			foreach ( $diff as $symbol => $transliteration ) {
				$data .= $this->data( $symbol, $transliteration );
			}
		}

		$data .= $this->header( '--- Post Types and Statuses ---' );

		$post_types    = (array) $settings->get( 'background_post_types', [] );
		$post_statuses = (array) $settings->get( 'background_post_statuses', [] );

		$data .= $this->data( 'Post types', implode( ', ', $post_types ) );
		$data .= $this->data( 'Post statuses', implode( ', ', $post_statuses ) );

		return $data;
	}

	/**
	 * Get Site info.
	 *
	 * @return string
	 */
	private function site_info(): string {
		$data = $this->header( '-- Site Info --' );

		$data .= $this->data( 'Site URL', site_url() );
		$data .= $this->data( 'Home URL', home_url() );
		$data .= $this->data( 'Multisite', is_multisite() ? 'Yes' : 'No' );

		return $data;
	}

	/**
	 * Get WordPress Configuration info.
	 *
	 * @return string
	 * @noinspection NestedTernaryOperatorInspection
	 */
	private function wp_info(): string {
		global $wpdb;

		$theme_data = wp_get_theme();
		$theme      = $theme_data->get( 'Name' ) . ' ' . $theme_data->get( 'Version' );

		$data = $this->header( '-- WordPress Configuration --' );

		$data .= $this->data( 'Version', get_bloginfo( 'version' ) );
		$data .= $this->data( 'Language', get_locale() );
		$data .= $this->data( 'User Language', get_user_locale() );
		$data .= $this->data( 'Permalink Structure', get_option( 'permalink_structure' ) ?: 'Default' );
		$data .= $this->data( 'Active Theme', $theme );
		$data .= $this->data( 'Show On Front', get_option( 'show_on_front' ) );

		// Only show page specs if front page is set to 'page'.
		if ( get_option( 'show_on_front' ) === 'page' ) {
			$front_page_id = get_option( 'page_on_front' );
			$blog_page_id  = get_option( 'page_for_posts' );
			$front_page    = $front_page_id ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset';
			$blog_page     = $blog_page_id ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset';

			$data .= $this->data( 'Page On Front', $front_page );
			$data .= $this->data( 'Page For Posts', $blog_page );
		}

		$data .= $this->data( 'ABSPATH', ABSPATH );
		$data .= $this->data( 'Table Prefix', 'Length: ' . strlen( $wpdb->prefix ) . '   Status: ' . ( strlen( $wpdb->prefix ) > 16 ? 'ERROR: Too long' : 'Acceptable' ) );
		$data .= $this->data( 'WP_DEBUG', defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set' );
		$data .= $this->data( 'Memory Limit', WP_MEMORY_LIMIT );
		$data .= $this->data( 'Registered Post Stati', implode( ', ', get_post_stati() ) );
		$data .= $this->data( 'Revisions', WP_POST_REVISIONS ? WP_POST_REVISIONS > 1 ? 'Limited to ' . WP_POST_REVISIONS : 'Enabled' : 'Disabled' );

		return $data;
	}

	/**
	 * Get Uploads/Constants info.
	 *
	 * @return string
	 * @noinspection NestedTernaryOperatorInspection
	 */
	private function uploads_info(): string {
		$data = $this->header( '-- WordPress Uploads/Constants --' );

		$data .= $this->data( 'WP_CONTENT_DIR', defined( 'WP_CONTENT_DIR' ) ? WP_CONTENT_DIR ?: 'Disabled' : 'Not set' );
		$data .= $this->data( 'WP_CONTENT_URL', defined( 'WP_CONTENT_URL' ) ? WP_CONTENT_URL ?: 'Disabled' : 'Not set' );
		$data .= $this->data( 'UPLOADS', defined( 'UPLOADS' ) ? UPLOADS ?: 'Disabled' : 'Not set' );

		$uploads_dir = wp_upload_dir();

		$data .= $this->data( 'wp_uploads_dir() path', $uploads_dir['path'] );
		$data .= $this->data( 'wp_uploads_dir() url', $uploads_dir['url'] );
		$data .= $this->data( 'wp_uploads_dir() basedir', $uploads_dir['basedir'] );
		$data .= $this->data( 'wp_uploads_dir() baseurl', $uploads_dir['baseurl'] );

		return $data;
	}

	/**
	 * Get Plugins info.
	 *
	 * @return string
	 */
	private function plugins_info(): string {
		// Get plugins that have an update.
		$data = $this->mu_plugins();

		$data .= $this->installed_plugins();
		$data .= $this->multisite_plugins();

		return $data;
	}

	/**
	 * Get MU Plugins info.
	 *
	 * @return string
	 */
	private function mu_plugins(): string {
		$data = '';

		// Must-use plugins.
		// Note: MU plugins can't show updates!
		$mu_plugins = get_mu_plugins();

		if ( ! empty( $mu_plugins ) && count( $mu_plugins ) > 0 ) {
			$data = $this->header( '-- Must-Use Plugins --' );

			$key_length = $this->get_max_key_length( $mu_plugins, 'Name' );

			foreach ( $mu_plugins as $plugin_data ) {
				$data .= $this->data( $plugin_data['Name'], $plugin_data['Version'], $key_length );
			}
		}

		return $data;
	}

	/**
	 * Get Installed Plugins info.
	 *
	 * @return string
	 */
	private function installed_plugins(): string {
		$updates = get_plugin_updates();

		// WordPress active plugins.
		$data = $this->header( '-- WordPress Active Plugins --' );

		$plugins        = get_plugins();
		$active_plugins = get_option( 'active_plugins', [] );

		$key_length = $this->get_max_key_length( $plugins, 'Name' );

		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( ! in_array( $plugin_path, $active_plugins, true ) ) {
				continue;
			}

			$update = array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[ $plugin_path ]->update->new_version . ')' : '';

			$data .= $this->data( $plugin['Name'], $plugin['Version'] . $update, $key_length );
		}

		// WordPress inactive plugins.
		$data .= $this->header( '-- WordPress Inactive Plugins --' );

		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( in_array( $plugin_path, $active_plugins, true ) ) {
				continue;
			}

			$update = array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[ $plugin_path ]->update->new_version . ')' : '';

			$data .= $this->data( $plugin['Name'], $plugin['Version'] . $update, $key_length );
		}

		return $data;
	}

	/**
	 * Get Multisite Plugins info.
	 *
	 * @return string
	 */
	private function multisite_plugins(): string {
		$data = '';

		if ( ! is_multisite() ) {
			return $data;
		}

		$updates = get_plugin_updates();

		// WordPress Multisite active plugins.
		$data = $this->header( '-- Network Active Plugins --' );

		$plugins        = wp_get_active_network_plugins();
		$active_plugins = get_site_option( 'active_sitewide_plugins', [] );

		foreach ( $plugins as $plugin_path ) {
			$plugin_base = plugin_basename( $plugin_path );

			if ( ! array_key_exists( $plugin_base, $active_plugins ) ) {
				continue;
			}

			$update = array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[ $plugin_path ]->update->new_version . ')' : '';
			$plugin = get_plugin_data( $plugin_path );

			$data .= $plugin['Name'] . ': ' . $plugin['Version'] . $update;
		}

		return $data;
	}

	/**
	 * Get Server info.
	 *
	 * @return string
	 */
	private function server_info(): string {
		global $wpdb;

		// Server configuration (really just versions).
		$data = $this->header( '-- Webserver Configuration --' );

		$data .= $this->data( 'PHP Version', PHP_VERSION );
		$data .= $this->data( 'MySQL Version', $wpdb->db_version() );
		$data .= $this->data( 'Webserver Info', isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '' );

		// PHP configs... now we're getting to the important stuff.
		$data .= $this->header( '-- PHP Configuration --' );
		$data .= $this->data( 'Memory Limit', ini_get( 'memory_limit' ) );
		$data .= $this->data( 'Upload Max Size', ini_get( 'upload_max_filesize' ) );
		$data .= $this->data( 'Post Max Size', ini_get( 'post_max_size' ) );
		$data .= $this->data( 'Upload Max Filesize', ini_get( 'upload_max_filesize' ) );
		$data .= $this->data( 'Time Limit', ini_get( 'max_execution_time' ) );
		$data .= $this->data( 'Max Input Vars', ini_get( 'max_input_vars' ) );
		$data .= $this->data( 'Display Errors', ( ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A' ) );

		// PHP extensions and such.
		$data .= $this->header( '-- PHP Extensions --' );
		$data .= $this->data( 'cURL', ( function_exists( 'curl_init' ) ? 'Supported' : 'Not Supported' ) );
		$data .= $this->data( 'fsockopen', ( function_exists( 'fsockopen' ) ? 'Supported' : 'Not Supported' ) );
		$data .= $this->data( 'SOAP Client', ( class_exists( 'SoapClient', false ) ? 'Installed' : 'Not Installed' ) );
		$data .= $this->data( 'Suhosin', ( extension_loaded( 'suhosin' ) ? 'Installed' : 'Not Installed' ) );

		// Session stuff.
		$data .= $this->header( '-- Session Configuration --' );
		$data .= $this->data( 'Session', isset( $_SESSION ) ? 'Enabled' : 'Disabled' );

		// The rest of this is only relevant if session is enabled.
		if ( isset( $_SESSION ) ) {
			$data .= $this->data( 'Session Name', esc_html( ini_get( 'session.name' ) ) );
			$data .= $this->data( 'Cookie Path', esc_html( ini_get( 'session.cookie_path' ) ) );
			$data .= $this->data( 'Save Path', esc_html( ini_get( 'session.save_path' ) ) );
			$data .= $this->data( 'Use Cookies', ( ini_get( 'session.use_cookies' ) ? 'On' : 'Off' ) );
			$data .= $this->data( 'Use Only Cookies', ( ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off' ) );
		}

		return $data;
	}

	/**
	 * Get header.
	 *
	 * @param string $header Header.
	 *
	 * @return string
	 */
	private function header( string $header ): string {
		return "\n" . $header . "\n\n";
	}

	/**
	 * Get data string.
	 *
	 * @param string $key            Data key.
	 * @param string $value          Data value.
	 * @param int    $max_key_length Max key length.
	 *
	 * @return string
	 */
	private function data( string $key, string $value, int $max_key_length = 0 ): string {
		$length = $max_key_length ? max( $max_key_length, self::DATA_KEY_LENGTH ) : self::DATA_KEY_LENGTH;

		$length += 2;

		return $this->mb_str_pad( $key . ': ', $length ) . $value . "\n";
	}

	/**
	 * Get max key length.
	 *
	 * @param array  $arr Array.
	 * @param string $key Key.
	 *
	 * @return int
	 * @noinspection PhpSameParameterValueInspection
	 */
	private function get_max_key_length( array $arr, string $key ): int {
		return array_reduce(
			$arr,
			static function ( $carry, $item ) use ( $key ) {
				$length = isset( $item[ $key ] ) ? mb_strlen( $item[ $key ] ) : 0;

				return max( $carry, $length );
			},
			0
		);
	}

	/**
	 * Multibyte str_pad.
	 *
	 * @param string $str        A string.
	 * @param int    $length     Desired length.
	 * @param string $pad_string Padding character.
	 *
	 * @return string
	 * @noinspection PhpSameParameterValueInspection
	 */
	private function mb_str_pad( string $str, int $length, string $pad_string = ' ' ): string {
		$pad_string = mb_substr( $pad_string, 0, 1 );
		$times      = max( 0, $length - mb_strlen( $str ) );

		return $str . str_repeat( $pad_string, $times );
	}
}
