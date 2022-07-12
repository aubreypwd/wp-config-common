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
define( 'WP_CONFIG_COMMON', 'max-execution-3600, multisite, spatie-ray, tunnel, noemail' );
```

### `max-execution-3600` ([source](src/autoload.php))

Simply tries to set `max_execution_time` to one hour (for debugging, etc).

### `multisite` ([source](src/autoload.php))

Configures multisite to be _on_.

### `spatie-ray` ([source](src/spatie-ray.php))

Pushes all Warnings and Errors from PHP to Spatie Ray(tm).

Set `define( 'SPATIE_RAY_NO_WARNINGS', true )'` to stop warnings. 
Set `define( 'SPATIE_RAY_NO_ERRORS', true )'` to stop errors. 

### `tunnel` ([source](src/autoload.php))

Tries to automatically trick WordPress into thinking the website (single-site only, the the way) is the proxy. Works with `localtunnel` and `ngrock`.

### `no-email` ([source](src/autoload.php))

Stops `wp_mail` from working by overriding the function. You can define `WP_MAIL_RETURN` with the overridden function's return value, which is `false` by default.