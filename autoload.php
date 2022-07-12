<?php
/**
 * Require autoload.php
 *
 * Note, does not do so with PHP 5.6, because it's very unlikely
 * that it will work.
 *
 * @since Monday, July 11, 2022
 */

if ( ! isset( $_SERVER['DOCUMENT_ROOT'] ) ) {
	return;
}

if ( ! stristr( phpversion(), '5.6' ) ) {

	if ( file_exists(  $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php' ) ) {

		// Load aubreypwd/php-s-wp
		require_once  $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
	}
}