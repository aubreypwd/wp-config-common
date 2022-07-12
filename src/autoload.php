<?php
/**
 * Autoloader
 *
 * @since Monday, July 11, 2022
 */

if ( defined( 'WP_CONFIG_COMMON' ) && is_string( WP_CONFIG_COMMON ) ) {

	$configs = array_map( function( $config ) {
		return trim( $config );
	}, explode( ',', WP_CONFIG_COMMON ) );

	/**
	 * Set max execution time.
	 *
	 * This usually helps with Xdebug, etc.
	 * Default to an hour.
	 *
	 * @since Monday, July 11, 2022
	 */
	if ( in_array( 'max-execution-3600', $configs, true ) ) {

		set_time_limit( defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );
		ini_set( 'max_execution_time', defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );
		ini_set( 'max_input_time', defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );
	}

	/**
	 * Multisite
	 *
	 * Common multisite settings, you MUST control DOMAIN_CURRENT_SITE and
	 * SUBDOMAIN_INSTALL on your own.
	 *
	 * @since Monday, July 11, 2022
	 */
	if ( in_array( 'multisite', $configs, true ) ) {

		if ( ! defined( 'DOMAIN_CURRENT_SITE' ) ) {
			die( 'You must define DOMAIN_CURRENT_SITE.' );
		}

		if ( ! defined( 'SUBDOMAIN_INSTALL' ) ) {
			die( 'You must define SUBDOMAIN_INSTALL' );
		}

		define( 'WP_ALLOW_MULTISITE', true );
		define( 'MULTISITE', true );
		define( 'PATH_CURRENT_SITE', '/' );
		define( 'SITE_ID_CURRENT_SITE', 1 );
		define( 'BLOG_ID_CURRENT_SITE', 1 );
	}

	/**
	 * Support for tunneling using ngrok or localtunnel.
	 *
	 * Note, does not work well with multisite!
	 *
	 * @since Monday, July 11, 2022
	 */
	if ( in_array( 'tunnel', $configs, true ) ) {

		// Proxies (lt or ngrok).
		if ( isset( $_SERVER['HTTP_X_FORWARDED_HOST'] ) || isset( $_SERVER['HTTP_X_ORIGINAL_HOST' ] ) ) {

			// Tell WP, no matter what, HTTPS is on (you can override).
			$_SERVER['HTTPS'] = defined( 'HTTPS' ) ? HTTPS : 'on';

			// Mock the host.
			$_SERVER['HTTP_HOST'] = isset( $_SERVER['HTTP_X_ORIGINAL_HOST' ] )
				? $_SERVER['HTTP_X_ORIGINAL_HOST' ]
				: $_SERVER['HTTP_X_FORWARDED_HOST']; // Make sure we mock the proxy.
		}

		// Set WP_HOME;
		define( 'WP_HOME', 'on' === $_SERVER['HTTPS'] ? "https://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}" );
		define( 'WP_SITEURL', WP_HOME );
	}

	// Spatie Ray(tm)
	if ( in_array( 'spatie-ray', $configs, true ) ) {
		require_once __DIR__ . '/spatie-ray.php';
	}

	unset( $configs );
}