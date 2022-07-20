# Use

```bash
composer require aubreypwd/wp-config-common
```

Then, add to your `wp-config.php`:

```php
if ( file_exists(  __DIR__ . '/vendor/autoload.php' ) ) {
	require_once  __DIR__ . '/vendor/autoload.php';
}
```

## Enabling Configs

You must define this _before_ you require `autoload.php` above!

```php
define( 'WP_CONFIG_COMMON', 'max-execution-3600, multisite, spatie-ray, tunnel, noemail, mailhog' );
```

### `max-execution-3600`

Simply tries to set `max_execution_time` to one hour (for debugging, etc).

### `install-multisite`

Use this before `multisite` if you have not installed multisite into the database yet. After turning this on, head to `/wp-admin/network.php` and install multisite. When done, you can use `multisite` to turn multisite on and off again easily.

- If you don't specify `SUBDOMAIN_INSTALL` we assume `false` for you.
- If you don't specify `DOMAIN_CURRENT_SITE`, we assume `$_SERVER['HTTP_HOST']`


### `multisite`

Configures multisite (note use `install-multisite` first.

### `spatie-ray`

Pushes all Warnings and Errors from PHP to Spatie Ray(tm).

Set `define( 'SPATIE_RAY_NO_WARNINGS', true )'` to stop warnings. 
Set `define( 'SPATIE_RAY_NO_ERRORS', true )'` to stop errors. 

### `tunnel`

Tries to automatically trick WordPress into thinking the website (single-site only, the the way) is the proxy. Works with `localtunnel` and `ngrock`.

### `no-email`

Stops `wp_mail` from working by overriding the function. You can define `WP_MAIL_RETURN` with the overridden function's return value, which is `false` by default.

### `mailhog`

Forwards all email to Mailhog at `localhost` (change with `MAILHOG_HOST`) on Port `1025` (change with `MAILHOG_PORT`).

You can also use `MAILHOG_FROM_EMAIL`, `MAILHOG_FROM_NAME`, and `MAILHOG_AUTH`, to further configure.

_Note, will override `no-email`._ Works by overriding `wp_mail()`.