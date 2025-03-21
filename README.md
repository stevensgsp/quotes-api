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

3. Run the following command to install the package:

	```bash
	composer require stevensgsp/quotes-api:dev-master --with-dependencies
	```

This will add the package to your Laravel project.

## Configuration

Once the package is installed, you can publish the configuration file to customize settings.

Run the following command:

```bash
php artisan vendor:publish --tag=quotes-api-config
```

This will create a `config/quotes.php` file where you can configure settings such as the default quote source, rate limiting, caching, and other API settings.

### Cache Configuration

To ensure the proper functioning of the quotes API, it's important that your Laravel application has caching configured. This is necessary for the package to store quotes and improve performance by reducing unnecessary API calls.

The package supports two types of cache drivers:

-   **Database Cache**: Suitable for environments where persistent storage for cache is required.
-   **File Cache**: Stores cache in the filesystem, which is suitable for most applications.

You can configure the cache driver in your Laravel application by modifying the `.env` file.

#### Setting Cache Driver

1.  Open your `.env` file located at the root of your Laravel application.
2.  Set the `CACHE_STORE` to either `database` or `file`, depending on your preference.

For **Database Cache**, ensure that you have run the cache table migration:

```php
php artisan cache:table
php artisan migrate
```

For **File Cache**, you don't need additional setup beyond ensuring the `CACHE_STORE=file` in your `.env`.

Once the cache is configured, the package will use it to store quotes for faster retrieval.

### Publishing the Routes

By default, the package registers routes automatically. However, if you want to modify the routes, you can publish them using:

```bash
php artisan vendor:publish --tag=quotes-api-routes
```

This will copy the routes file to `routes/quotes.php`, where you can modify them as needed.

### Configure Rate Limiting

The package supports rate limiting to prevent abuse of the quotes API. You can customize the rate limit settings by modifying the `config/quotes.php` file.

For example, you can change the rate limit and window time:

```php
'rate_limit' => 10,  // Requests per minute
'window_time' => 60, // In seconds
```

### Configure Caching

By default, the package caches the quotes to improve performance and reduce unnecessary API calls. You can configure caching settings in the `config/quotes.php` file.

```php
'cache_time' => 3600, // Cache time in seconds
```

## API Usage

The package provides the following API endpoints:

- GET `/api/quotes`: Fetches all quotes.
- GET `/api/quotes/random`: Fetches a random quote.
- GET `/api/quotes/{id}`: Fetches a specific quote by ID.

Example Request

```php
use Illuminate\Support\Facades\Http;

$response = Http::get(url('/api/quotes'));

if ($response->successful()) {
    $quotes = $response->json();
    dd($quotes);
} else {
    dd('Error:', $response->status());
}
```

Example Response

```json
{
    "quotes": [
        {
            "id": 1,
            "quote": "Life is what happens when you're busy making other plans.",
            "author": "John Lennon"
        },
        {},
        {},
        {},
        "total":1454,
        "skip":0,
        "limit":30
    ]
}
```

## Vue.js UI Integration

This package includes a pre-built Vue.js UI that can be used to display quotes in your frontend.

### Publishing the UI

To access the Vue.js UI, you need to publish the frontend assets using the following command:

```bash
php artisan vendor:publish --tag=quotes-api-ui
```

This will publish the UI assets in the `public/vendor/quotes-api/assets` directory.

### Publishing the Views

If you want to customize the Laravel Blade views, you can publish them using:

```bash
php artisan vendor:publish --tag=quotes-api-views
```

The views will be published to `resources/views/vendor/quotes-api`, where you can modify them as needed.

### Access the UI

After publishing the assets, you can access the Vue.js UI by navigating to the `/quotes-ui` route in your browser:

```
http://your-laravel-app.com/quotes-ui
```

### Customizing the UI

If you want to customize the frontend, you can modify the published files:

-   **Blade Views**: Located in `resources/views/vendor`.
-   **UI Assets**: Located in `public/vendor/quotes-api/assets`.

## Running Tests

To run the tests for this package, use the following command:

```bash
./vendor/bin/phpunit
```

This will execute all tests using PHPUnit. Make sure you have PHPUnit installed via Composer, as it is the testing framework used in this package.

## Additional Notes

### Caching and Rate Limiting

If you have configured rate limiting and caching, ensure that the frontend requests are properly debounced or throttled to avoid hitting rate limits. You can adjust the rate limit settings as needed to suit your requirements.

## Troubleshooting


f you encounter any issues with the API or Vue.js UI, here are some steps you can take to resolve common problems:

1.  **Check Laravel Logs**: Look at the Laravel log files (`storage/logs/laravel.log`) for any errors related to the package.
2.  **Clear Cache**: If you're experiencing issues with outdated quotes or cache, you can clear the cache using:

    ```bash
    php artisan cache:clear
    ```

3.  **Rebuild Vue.js Assets**: If the frontend UI is not displaying correctly, try rebuilding the assets

    ```bash
    npm run dev
    ```
