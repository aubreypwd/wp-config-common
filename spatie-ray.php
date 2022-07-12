<?php
/**
 * Spatie Ray(tm)
 *
 * If you install spatie/ray in the WordPress root (where wp-config.php usually is)
 * you can require this file and get errors and warnings pushed to Ray.
 *
 * Defining SPATIE_RAY_NO_WARNINGS stops warnings from being pushed to Ray.
 * Defining SPATIE_RAY_NO_ERRORS stops any errors from being pushed to Ray.
 *
 * @since Monday, July 11, 2022
 */

if ( ! isset( $_SERVER['DOCUMENT_ROOT'] ) ) {
	return;
}

// Load Spatie Ray through the composer autoload.php file.
if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php' ) ) {

	// We have to load autoload.php.
	require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

	// You have to install it.
	if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/vendor/spatie' ) ) {

		/**
		 * Report errors to Spatie Ray.
		 *
		 * Add to your `wp-config.php` in WordPress.
		 * Make sure you `composer require spatie/ray`
		 * Make sure you ran `composer install`
		 *
		 * @author Aubrey Portwood <aubrey@webdevstudios.com>
		 * @since  Monday, December 27, 2021
		 * @return void
		 */
		function ____error_to_spatie_ray() {

			$error = error_get_last();

			if ( $error === NULL ) {
				return;
			}

			// Comment these out to ignore errors.
			if ( in_array( true, defined( 'SPATIE_RAY_NO_WARNINGS' ) ? [] : [

				/* Ignore Notices, Warnings, and Deprecations */

					$error['type'] === E_WARNING,
					$error['type'] === E_NOTICE,
					$error['type'] === E_CORE_WARNING,
					$error['type'] === E_COMPILE_WARNING,
					$error['type'] === E_USER_WARNING,
					$error['type'] === E_USER_NOTICE,
					$error['type'] === E_STRICT,
					$error['type'] === E_RECOVERABLE_ERROR,
					$error['type'] === E_DEPRECATED,
					$error['type'] === E_USER_DEPRECATED,

				/* Ignore Errors */

					$error['type'] === E_ERROR,
					$error['type'] === E_PARSE,
					$error['type'] === E_CORE_ERROR,
					$error['type'] === E_COMPILE_ERROR,
					$error['type'] === E_USER_ERROR,

			] , true ) ) {

				// Don't show anything in Ray about these.
				return;
			}

			// If we hit any of theses ERROR's, we'll show the app so you know.
			if ( in_array( true, defined( 'SPATIE_RAY_NO_ERRORS' ) ? [] : [

				/* Errors */

				$error['type'] === E_ERROR,
				$error['type'] === E_PARSE,
				$error['type'] === E_CORE_ERROR,
				$error['type'] === E_COMPILE_ERROR,
				$error['type'] === E_USER_ERROR,

			], true ) ) {

				// Log the error (in red) and show Ray.
				\ray( $error )->red();

				return;
			}

			\ray( $error ); // Just log the error to Ray (in red).
		}
		register_shutdown_function( '____error_to_spatie_ray' );

	} else {

		die( 'You must use Composer to require spatie/ray and install it into ./vendor first before you load ' . __FILE__ );
	}
}
