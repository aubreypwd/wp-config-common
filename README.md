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
define( 'WP_CONFIG_COMMON', 'max-execution-3600, multisite, spatie-ray, tunnel' );
```