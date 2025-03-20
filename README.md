
# Quotes API Package

A Laravel package that provides an API to manage and fetch quotes.

## Installation

### Install from GitHub

Since this package is not available in Packagist, you can install it directly from the GitHub repository using Composer.

1. Open your `composer.json` file located in the root of your Laravel project.

2. Add the package's repository in the `repositories` section:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/stevensgsp/quotes-api.git"
    }
],
```

3. Add the package in the require section of your composer.json:

```json
"require": {
    "stevensgsp/quotes-api": "dev-master"
}
```

4. Run the following command to install the package:
```bash
composer update stevensgsp/quotes-api --with-dependencies
```

This will add the package to your Laravel project.

## Configuration

Once the package is installed, you can publish the configuration file to customize settings.

Run the following command:

```bash
php artisan vendor:publish --provider="Stevensgsp\QuotesApi\Providers\QuotesApiServiceProvider" --tag="config"
```

This will create a `config/quotes.php` file where you can configure settings such as the default quote source, etc.

## API Usage

The package provides the following API endpoints:

- GET `/api/quotes`: Fetches all quotes.
- GET `/api/quotes/random`: Fetches a random quote.
- GET `/api/quotes/{id}`: Fetches a specific quote by ID.

## Publishing and Modifying the UI

If the package includes a UI component (e.g., a blade view), you can publish it using the following command:

```bash
php artisan vendor:publish --provider="Vendor\Package\PackageServiceProvider" --tag="views"
```

Once published, you can modify the views as needed in the `resources/views/vendor/package-name` directory.

## Running Tests

To run the tests for this package, use the following command:

```bash
./vendor/bin/pest .
```

This will run all the tests using Pest. Make sure you have Pest installed via Composer, as it's used for testing in this package.