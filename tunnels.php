<?php
/**
 * Support for tunneling using ngrok or localtunnel.
 *
 * Note, does not work well with multisite!
 *
 * @since Monday, July 11, 2022
 */

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