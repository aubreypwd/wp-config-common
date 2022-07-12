<?php
/**
 * Multisite
 *
 * Common multisite settings, you MUST control DOMAIN_CURRENT_SITE and
 * SUBDOMAIN_INSTALL on your own.
 *
 * @since Monday, July 11, 2022
 */

if ( ! defined( 'DOMAIN_CURRENT_SITE' ) ) {
	die( 'You must define DOMAIN_CURRENT_SITE somewhere before you load ' . __FILE__ );
}

if ( ! defined( 'SUBDOMAIN_INSTALL' ) ) {
	die( 'You must define SUBDOMAIN_INSTALL somewhere before you load ' . __FILE__ );
}

define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
