# Takt for Laravel

Laravel integration for [Takt](https://github.com/vskstudio) analytics. Drop a single `@takt`
Blade directive in your layout for privacy-friendly client-side tracking, and use the `Takt`
facade to send server-side events straight from your application code.

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12

## Installation

```bash
composer require vskstudio/takt-laravel
```

The service provider and the `Takt` facade are registered automatically through Laravel package
auto-discovery. There is nothing else to wire up.

## Configuration

The package ships with sane defaults and reads everything from your environment. To customise the
published config file:

```bash
php artisan vendor:publish --tag=takt-config
```

This writes `config/takt.php`. All values are environment-driven:

| Env variable             | Default                     | Description                                                              |
| ------------------------ | --------------------------- | ------------------------------------------------------------------------ |
| `TAKT_DOMAIN`            | `''`                        | The site/domain registered in Takt that data is attributed to.           |
| `TAKT_ENDPOINT`          | `https://takt.example.com`  | Base URL of your Takt ingest endpoint.                                    |
| `TAKT_API_KEY`           | `null`                      | Ingest-scoped API key used for server-side events (see below).           |
| `TAKT_MODE`              | `inline`                    | Snippet delivery mode: `inline`, `cdn`, or `asset`.                      |
| `TAKT_OUTBOUND`          | `false`                     | Track clicks on outbound links.                                          |
| `TAKT_FILES`            | `false`                     | Track file download clicks.                                              |
| `TAKT_EXCLUDE_LOCALHOST` | `true`                      | Skip tracking when running on localhost.                                 |

Example `.env`:

```dotenv
TAKT_DOMAIN=example.com
TAKT_ENDPOINT=https://ingest.takt.io
TAKT_API_KEY=ingest_xxxxxxxxxxxxxxxx
TAKT_MODE=inline
```

## Client-side tracking

Add the `@takt` directive to the `<head>` of your layout:

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @takt
</head>
<body>
    @yield('content')
</body>
</html>
```

### Delivery modes

`TAKT_MODE` controls how the tracking script is delivered:

- **`inline`** (default) — the script is embedded directly in the rendered HTML. Zero extra
  network requests, nothing to host.
- **`cdn`** — references the script from the Takt CDN.
- **`asset`** — references a self-hosted copy of the script served from your own application.

## Server-side events

Use the `Takt` facade to record events from controllers, jobs, or anywhere in your application:

```php
use Vskstudio\Takt\Laravel\Facades\Takt;
use Vskstudio\Takt\Revenue;

// A custom event with properties and revenue
Takt::event('Signup', ['plan' => 'pro'], new Revenue('29.00', 'EUR'));

// A simple pageview
Takt::pageview();
```

Server-side events automatically attribute to the current request's IP address and User-Agent, so
they are correlated with the visitor that triggered them. You can optionally pass an explicit URL
as the last argument to either method.

> **API key scope:** `TAKT_API_KEY` must be an **ingest-scoped** key bound to the configured
> `TAKT_DOMAIN`. Keep it server-side only — it is never exposed to the browser.

## License

MIT. See [LICENSE](LICENSE).
