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
	 * Allow multisite
	 *
	 * Use to install multisite, then enable multisite.
	 *
	 * @since Wednesday, July 20, 2022
	 */
	if ( in_array( 'install-multisite', $configs, true ) ) {
		define( 'WP_ALLOW_MULTISITE', true );
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

		if ( ! defined( 'DOMAIN_CURRENT_SITE' ) && isset( $_SERVER['HTTP_HOST'] ) ) {

			// Assume the current host.
			define( 'DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST'] );
		} elseif ( ! defined( 'DOMAIN_CURRENT_SITE' ) ) {

			// We can't assume the current host, so you have to tell us what's in the DB.
			die( 'Please define DOMAIN_CURRENT_SITE since we cannot assume $_SERVER[HTTP_HOST]' );
		}

		if ( ! defined( 'SUBDOMAIN_INSTALL' ) ) {
			define( 'SUBDOMAIN_INSTALL', false );
		}

		if ( ! defined( 'SUBDOMAIN_INSTALL' ) ) {
			die( 'You must define SUBDOMAIN_INSTALL' );
		}

		define( 'MULTISITE', true );
		define( 'PATH_CURRENT_SITE', '/' );
		define( 'SITE_ID_CURRENT_SITE', 1 );
		define( 'BLOG_ID_CURRENT_SITE', 1 );
	}

	/**
	 * Disable email.
	 *
	 * @since Tuesday, July 12, 2022
	 */
	if ( in_array( 'no-email', $configs, true ) ) {

		function wp_mail() {
			return defined( 'WP_MAIL_RETURN' ) ? WP_MAIL_RETURN : false;
		}
	}

	/**
	 * Send email directly to Mailhog
	 *
	 * @since Tuesday, July 12, 2022
	 */
	if ( in_array( 'mailhog', $configs, true ) ) {

		function wp_mail ( $to, $subject, $message, $headers = '', $attachments = array() ) {

			$mail = new PHPMailer;

			$mail->isSMTP();

			// Mailhog
			$mail->Host = defined( 'MAILHOG_HOST' ) ? MAILHOG_HOST : 'localhost';
			$mail->SMTPAuth = defined( 'MAILHOG_AUTH' ) ? MAILHOG_AUTH : false;
			$mail->Port = defined( 'MAILHOG_PORT' ) ? MAILHOG_PORT : 1025;

			$mail->setFrom(
				defined( 'MAILHOG_FROM_EMAIL' ) ? MAILHOG_FROM_EMAIL : "noreply@{$_SERVER['HTTP_HOST']}",
				defined( 'MAILHOG_FROM_NAME' ) ? MAILHOG_FROM_NAME : $_SERVER['HTTP_HOST']
			);

			$mail->addAddress( $to, $to );

			foreach ( $attachments as $attachment ) {
				$mail->addAttachment( $attachment );
			}

			$mail->isHTML( true );

			$mail->Subject = $subject;
			$mail->Body    = $message;

			return $mail->send();
		}
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

		// Because WP_CLI doesn't define this.
		if ( isset( $_SERVER['HTTP_HOST'] ) ) {

			// Set WP_HOME;
			define( 'WP_HOME', 'on' === $_SERVER['HTTPS'] ? "https://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}" );
			define( 'WP_SITEURL', WP_HOME );
		}
	}

	// Spatie Ray(tm)
	if ( in_array( 'spatie-ray', $configs, true ) ) {
		require_once __DIR__ . '/spatie-ray.php';
	}

	unset( $configs );
}