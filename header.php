<?php
/**
 * header.php
 * Common header for HOSTILE NOISE website.
 *
 * Variables:
 * $page_title - The page title
 * $og_title - Title for social sharing
 * $og_desc - Description for social sharing
 * $og_image - Image for social sharing
 * $is_home - Boolean to toggle home-specific nav elements
 */

$title = isset($page_title) ? $page_title : "HOSTILE NOISE — Friction in Design, Art and Technology";
$og_t = isset($og_title) ? $og_title : $title;
$og_d = isset($og_desc) ? $og_desc : "An exploration of friction in Design, Art and Technology. 18 April 2026, Rooms, Tbilisi.";
$og_i = isset($og_image) ? $og_image : "og-image.png";
$home = isset($is_home) ? $is_home : false;

/**
 * Compute the site root (base URL path where this project is mounted).
 *
 * Deterministic rules for hosted deployment:
 * 1) Prefer explicit override ($site_root_override) when provided by a page.
 * 2) Otherwise derive from the request URL:
 *    - Use SCRIPT_NAME directory (stable across subdirectories like /gallery/, /programme/)
 *    - If SCRIPT_NAME is empty/unreliable, fall back to REQUEST_URI directory
 *
 * Examples:
 * - SCRIPT_NAME: /hostile-noise/index.php           => site root: /hostile-noise
 * - SCRIPT_NAME: /hostile-noise/gallery/index.php   => site root: /hostile-noise/gallery (we then normalize to its directory)
 */
$site_root = null;

// 1) Explicit override (recommended for tricky hosting setups)
if (isset($site_root_override)) {
  $site_root = rtrim((string)$site_root_override, '/');
  if ($site_root === '' || $site_root === '/' || $site_root === '.' || $site_root === '\\') {
    $site_root = '';
  }
}

// 2) Derive from request path (no filesystem checks)
if ($site_root === null) {
  $script_name = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', (string)$_SERVER['SCRIPT_NAME']) : '';
  $base = '';

  if ($script_name !== '') {
    // e.g. /hostile-noise/gallery/index.php -> /hostile-noise/gallery
    $base = rtrim(dirname($script_name), '/');
  } else {
    // Fallback: REQUEST_URI without query string
    $request_uri = isset($_SERVER['REQUEST_URI']) ? str_replace('\\', '/', (string)$_SERVER['REQUEST_URI']) : '';
    $request_uri = explode('?', $request_uri, 2)[0];
    $base = rtrim(dirname($request_uri), '/');
  }

  if ($base === '' || $base === '.' || $base === '\\' || $base === '/') {
    $base = '';
  }

  /**
   * If this project is deployed in a subfolder, and SCRIPT_NAME points to a subpage
   * (e.g. /hostile-noise/gallery), we need the project root, not the current directory.
   *
   * Heuristic: if we are inside a known subdir, step up one level.
   * Add more subdirs here if needed.
   */
  $known_subdirs = ['/gallery', '/programme'];
  foreach ($known_subdirs as $subdir) {
    if ($base !== '' && substr($base, -strlen($subdir)) === $subdir) {
      $base = rtrim(substr($base, 0, -strlen($subdir)), '/');
      break;
    }
  }

  $site_root = $base;
}

// Final normalization: no trailing slash, except empty root.
if ($site_root === null || $site_root === '' || $site_root === '/') {
  $site_root = '';
} else {
  $site_root = rtrim($site_root, '/');
}

if (!function_exists('page_url')) {
  function page_url($path = '') {
    global $site_root;
    $normalized = ltrim($path, '/');
    if ($normalized === '') {
      return $site_root === '' ? '/' : $site_root . '/';
    }
    return ($site_root === '' ? '' : $site_root) . '/' . $normalized;
  }
}

if (!function_exists('asset_url')) {
  function asset_url($path = '') {
    global $site_root;
    $normalized = ltrim($path, '/');
    if ($normalized === '') {
      return $site_root === '' ? '/' : $site_root . '/';
    }
    $segments = array_map('rawurlencode', explode('/', $normalized));
    return ($site_root === '' ? '' : $site_root) . '/' . implode('/', $segments);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="icon" type="image/png" href="<?php echo asset_url('favicon.png'); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Barlow+Condensed:wght@300;400;600&display=swap"
    rel="stylesheet">

  <!-- Social Sharing Meta Tags -->
  <meta property="og:title" content="<?php echo $og_t; ?>">
  <meta property="og:description" content="<?php echo $og_d; ?>">
  <meta property="og:image" content="https://hostile-noise.geolab.edu.ge/<?php echo str_replace(' ', '%20', $og_i); ?>">
  <meta property="og:type" content="<?php echo $home ? 'website' : 'article'; ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo $og_t; ?>">
  <meta name="twitter:description" content="<?php echo $og_d; ?>">
  <meta name="twitter:image" content="https://hostile-noise.geolab.edu.ge/<?php echo str_replace(' ', '%20', $og_i); ?>">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Ensure header nav and its links are always clickable above page overlays */
    .nav {
      position: relative;
      z-index: 20000;
      pointer-events: auto;
    }
    .nav * {
      pointer-events: auto;
    }
    .back-link {
      position: relative;
      z-index: 20001;
      pointer-events: auto;
      cursor: pointer;

      /* Match programme page styling */
      font-family: 'Space Mono', monospace;
      font-size: 0.65rem;
      letter-spacing: 0.2em;
      color: var(--mid);
      text-decoration: none;
      text-transform: uppercase;
      transition: color 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .back-link:hover { color: var(--red); }
    .back-link::before { content: '←'; }

    :root {
      --black: #0a0a0a;
      --white: #f0ede8;
      --red: #f1ee75;
      --gray: #2a2a2a;
      --mid: #5a5a5a;
      --light: #b0aa9f;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      background: var(--black);
      color: var(--white);
      font-family: 'Space Mono', monospace;
      overflow-x: hidden;
      cursor: crosshair;
      min-height: 100vh;
    }

    /* NOISE OVERLAY */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
      opacity: 0.04;
      pointer-events: none;
      z-index: 9999;
    }

    /* SCANLINES */
    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background: repeating-linear-gradient(0deg,
          transparent,
          transparent 2px,
          rgba(0, 0, 0, 0.03) 2px,
          rgba(0, 0, 0, 0.03) 4px);
      pointer-events: none;
      z-index: 9998;
    }

    .nav {
      position: relative;
      z-index: 10;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 2rem 3rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .nav-logos {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .logo-adjara {
      height: 54px;
      width: auto;
      filter: invert(1) brightness(0.7);
      opacity: 0.85;
      transition: opacity 0.2s ease;
    }

    .logo-adjara:hover {
      opacity: 1;
    }

    .logo-geolab {
      height: 54px;
      width: auto;
      filter: brightness(0.7);
      opacity: 0.85;
      transition: opacity 0.2s ease;
    }

    .logo-geolab:hover {
      opacity: 1;
    }

    .logo-art {
      height: 38px;
      width: auto;
      filter: brightness(0.7);
      opacity: 0.85;
      transition: opacity 0.2s ease;
    }

    .logo-art:hover {
      opacity: 1;
    }

    .footer-logo-adjara {
      height: 60px;
      width: auto;
      filter: invert(1) brightness(0.5);
      opacity: 0.6;
      transition: opacity 0.2s ease;
    }

    .footer-logo-adjara:hover {
      opacity: 0.9;
    }

    .footer-logo-geolab {
      height: 60px;
      width: auto;
      filter: brightness(0.5);
      opacity: 0.6;
      transition: opacity 0.2s ease;
    }

    .footer-logo-geolab:hover {
      opacity: 0.9;
    }

    .footer-logo-art {
      height: 44px;
      width: auto;
      filter: brightness(0.5);
      opacity: 0.6;
      transition: opacity 0.2s ease;
    }

    .footer-logo-art:hover {
      opacity: 0.9;
    }

    /* ─── POPUP ─── */
    .thank-you-popup-overlay {
      position: fixed;
      inset: 0;
      background: rgba(10, 10, 10, 0.9);
      z-index: 100000;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      backdrop-filter: blur(4px);
    }

    .thank-you-popup {
      background: var(--black);
      border: 1px solid var(--red);
      padding: 3rem;
      max-width: 600px;
      position: relative;
      box-shadow: 0 0 20px rgba(241, 238, 117, 0.1);
      animation: popupFade 0.5s ease-out;
    }

    @keyframes popupFade {
      from { opacity: 0; transform: translateY(20px) scale(0.95); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .thank-you-close {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      background: none;
      border: none;
      color: var(--red);
      font-family: 'Space Mono', monospace;
      font-size: 1rem;
      cursor: crosshair;
      transition: color 0.2s ease, transform 0.2s ease;
      letter-spacing: 0.1em;
    }

    .thank-you-close:hover {
      color: var(--white);
      transform: scale(1.1);
    }

    .thank-you-title {
      font-family: 'Space Mono', monospace;
      font-size: 0.85rem;
      letter-spacing: 0.4em;
      color: var(--red);
      margin-bottom: 1.5rem;
      text-transform: uppercase;
    }

    .thank-you-content {
      font-family: 'Barlow Condensed', sans-serif;
      font-size: 1.3rem;
      color: var(--light);
      line-height: 1.7;
    }

    .thank-you-content p {
      margin-bottom: 1.2rem;
    }

    .thank-you-content p:last-child {
      margin-bottom: 0;
    }

    .thank-you-content strong {
      color: var(--white);
      font-weight: 600;
      letter-spacing: 0.05em;
    }
  </style>
</head>

<body>
  <?php if ($home): ?>
  <!-- THANK YOU POPUP -->
  <div class="thank-you-popup-overlay" id="thankYouPopup">
    <div class="thank-you-popup">
      <button class="thank-you-close" onclick="closeThankYouPopup()">[CLOSE]</button>
      <div class="thank-you-title">// Message Logs</div>
      <div class="thank-you-content">
        <p><strong>We appreciate your presence!</strong></p>
        <p>A huge thank you to everyone who joined us. To our guests, our international participants who traveled from across the globe, and the supporters who fueled this journey. Your energy made <strong>HOSTILE NOISE</strong> real.</p>
        <p>See you at the next intersection of art, design and technology!</p>
      </div>
    </div>
  </div>

  <script>
    function closeThankYouPopup() {
      document.getElementById('thankYouPopup').style.display = 'none';
    }
  </script>

  <nav class="nav">
    <div class="nav-logos">
      <a href="https://roomshotels.com/" target="_blank"><img src="<?php echo asset_url('Rooms_Hotels_Logo-01.png'); ?>" alt="Rooms Hotels" class="logo-adjara"></a>
      <a href="https://www.facebook.com/GeoLabEdu" target="_blank"><img src="<?php echo asset_url('GeoLab.logo.png'); ?>" alt="GeoLab" class="logo-geolab"></a>
      <a href="https://art.edu.ge/" target="_blank"><img src="<?php echo asset_url('art.png'); ?>" alt="Art" class="logo-art"></a>
    </div>
    <div class="nav-date">
      <span>18 April 2026</span>
      Rooms, 14 Merab Kostava St.<br>
      Full-Day Programme
    </div>
  </nav>
  <?php else: ?>
  <nav class="nav">
    <div class="nav-logos">
      <a href="https://roomshotels.com/" target="_blank"><img src="<?php echo asset_url('Rooms_Hotels_Logo-01.png'); ?>" alt="Rooms Hotels" class="logo-adjara"></a>
      <a href="https://www.facebook.com/GeoLabEdu" target="_blank"><img src="<?php echo asset_url('GeoLab.logo.png'); ?>" alt="GeoLab" class="logo-geolab"></a>
      <a href="https://art.edu.ge/" target="_blank"><img src="<?php echo asset_url('art.png'); ?>" alt="Art" class="logo-art"></a>
    </div>

    <a href="<?php echo page_url(''); ?>" class="back-link">Back to Hostile Noise</a>

  </nav>
  <?php endif; ?>
