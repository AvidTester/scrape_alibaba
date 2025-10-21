# Alibaba Product Media Extractor (PHP)

This simple PHP script uses `curl` to fetch an Alibaba product detail page and attempts to extract media items such as images.

---

## How It Works

1. Sends a request to the Alibaba product page using `curl`.
2. Searches the HTML for any embedded `mediaItems` JSON structure.
3. If not found, falls back to extracting image URLs from `<img>` tags.
4. Outputs the result as JSON.

---

## How to Use

### 1. Set up your PHP environment

You need a PHP-enabled server or local environment like XAMPP, MAMP, or a terminal with PHP installed.

### 2. Replace the Product URL

In the script (`alibaba_media_scraper.php`), locate this line:

```php
$url = 'https://www.alibaba.com/product-detail/Comfortable-Rolling-Office-Chair-Swivel-Wheels_1600204355800.html?...';
