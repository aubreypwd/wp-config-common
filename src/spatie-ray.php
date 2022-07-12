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

	if ( ! isset( $error['type'] ) ) {
		return;
	}

	// Comment these out to ignore errors.
	if ( ( ! defined( 'SPATIE_RAY_NO_WARNINGS' ) || false === SPATIE_RAY_NO_WARNINGS ) && in_array( $error['type'], [

		E_WARNING,
		E_NOTICE,
		E_CORE_WARNING,
		E_COMPILE_WARNING,
		E_USER_WARNING,
		E_USER_NOTICE,
		E_STRICT,
		E_RECOVERABLE_ERROR,
		E_DEPRECATED,
		E_USER_DEPRECATED,

	] , true ) ) {

		// Warnings, etc in orange.
		\ray( $error )->orange();
	}

	// If we hit any of theses ERROR's, we'll show the app so you know.
	if ( ( ! defined( 'SPATIE_RAY_NO_ERRORS' ) || false === SPATIE_RAY_NO_ERRORS ) && in_array( $error['type'], [

		/* Errors */

		E_ERROR,
		E_PARSE,
		E_CORE_ERROR,
		E_COMPILE_ERROR,
		E_USER_ERROR,

	], true ) ) {

		// Errors in red.
		\ray( $error )->red();
	}
}
register_shutdown_function( '____error_to_spatie_ray' );