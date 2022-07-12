<?php
/**
 * Set max execution time.
 *
 * This usually helps with Xdebug, etc.
 * Default to an hour.
 *
 * @since Monday, July 11, 2022
 */

set_time_limit( defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );
ini_set( 'max_execution_time', defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );
ini_set( 'max_input_time', defined( 'MAX_EXECUTION_TIME' ) ? MAX_EXECUTION_TIME : 3600 );