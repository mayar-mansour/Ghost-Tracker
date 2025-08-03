# 👻 GhostTrack

**GhostTrack** is a lightweight Laravel package to silently track user actions (like `viewed_product`, `clicked_checkout`, or `submitted_form`) **without bloating your logs or slowing down your app**.

Built by [@MayarMansour](https://github.com/mayar-mansour)

---

## 🚀 Features

- 🧩 Plug-and-play Laravel integration
- 📝 Logs user actions like clicks, views, and behavior
- 🗄️ Stores logs in **database**, **file**, or **cache**
- 🧵 Queue support for non-blocking performance
- ✅ Supports anonymous users, IP, URL, and User-Agent
- 🔧 Configurable & extendable

---

## 📦 Installation

### Option A: Install via GitHub

Add the GitHub repo to your `composer.json`:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/YOUR_USERNAME/ghosttrack"
  }
]
```

Then run:

```bash
composer require mayar/ghosttrack:dev-main
```

> Replace `YOUR_USERNAME` with your GitHub username.

---

### Option B: Install as local package (for dev)

Move this package to: `packages/Mayar/GhostTrack`, then add to your Laravel root:

```json
"repositories": [
  {
    "type": "path",
    "url": "packages/Mayar/GhostTrack"
  }
]
```

Install it:

```bash
composer require mayar/ghosttrack:* --prefer-source
```

---

## ⚙️ Setup

1. **Publish the config file:**

```bash
php artisan vendor:publish --tag=ghosttrack-config
```

2. **Run the migration (if using DB driver):**

```bash
php artisan migrate
```

---

## 🔧 Configuration

The config file `config/ghosttrack.php` includes:

```php
return [
    'enabled' => true,
    'driver' => 'database', // Options: database, log, cache
    'queue' => true,         // Use Laravel queues for DB writing
];
```

---

## 🧪 Usage

Use the global helper function:

```php
ghost_log('viewed_product', [
    'product_id' => 123,
    'ref' => 'facebook_ad'
]);
```

### Example Logs:

```php
ghost_log('clicked_checkout');
ghost_log('submitted_form', ['form_id' => 88]);
ghost_log('page_visit', ['url' => request()->fullUrl()]);
```

---

## 📊 Storage Drivers

You can choose how to store logs:

| Driver   | Description                        | Use case                  |
|----------|------------------------------------|---------------------------|
| `database` | Stores logs in `ghost_logs` table   | Best for dashboards        |
| `log`    | Sends logs to Laravel log files    | Simple debug logging       |
| `cache`  | Temporary in-memory log storage    | Dev/test, performance-first|

---

## ⚡ Queued Logging (recommended)

If `queue = true`, GhostTrack will log actions using Laravel’s queued jobs to avoid performance hits.

Ensure you run your queue worker:

```bash
php artisan queue:work
```

---

## 📂 Database Table

If you use the database driver, logs will be stored with:

- `user_id` (nullable)
- `action` (string)
- `meta` (json)
- `ip_address`
- `url`
- `user_agent`
- `created_at`, `updated_at`

---

## ✅ Example Use Cases

- Log when users:
  - View a product
  - Submit a form
  - Enter checkout
  - Visit a campaign landing page
- Detect bot patterns
- Store frontend events (via simple AJAX calls)

---

## 💡 Example: Log from JavaScript (via route)

You can define a backend route and call `ghost_log()` using a POST request from your frontend.

```js
// Example using fetch
fetch('/api/track', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: JSON.stringify({
    action: 'clicked_button',
    meta: { label: 'Subscribe' }
  })
});
```

---

## 🧑‍💻 Contributing

Pull requests welcome! Please PR on the `main` branch with clear commits.

---

## 📄 License

MIT © [Mayar Mansour](https://github.com/mayarmansour)

---
