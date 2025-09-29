# Public Folder Installer

Automatically creates a `public` folder in your project root and copies essential files (`index.php` and `.htaccess`) during Composer installation.

## Installation

```bash
composer require quellabs/canvas-apache
```

## What It Does

When installed, this package automatically:

1. Creates a `public/` directory in your project root
2. Copies `index.php` - a front controller that loads your application
3. Copies `.htaccess` - Apache configuration with URL rewriting and security settings

## Files Created

### `public/index.php`
Basic front controller that loads Composer's autoloader and serves as your application entry point.

### `public/.htaccess`
Apache configuration including:
- URL rewriting to index.php
- Directory browsing protection
- Hidden file access denial
- UTF-8 charset setting

## Behavior

- Files are only copied if they don't already exist
- Existing files are never overwritten
- The installer runs automatically on `composer install` and `composer update`

## Requirements

- PHP >= 8.2
- Apache web server (for .htaccess functionality)

## License

MIT