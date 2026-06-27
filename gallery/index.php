<?php
$page_title = "HOSTILE NOISE — Gallery";
$og_title = "HOSTILE NOISE — Gallery";
$og_desc = "Visual archive of HOSTILE NOISE by Shotiko Tsikurishvili.";
$is_home = false;
include '../header.php';

// ─── Fetch all gallery photos server-side with 1-hour file cache ───────────────
$_hn_cache     = sys_get_temp_dir() . '/hn_gallery_cache.json';
$_hn_ttl       = 3600;
$galleryPhotos = [];
$hashes        = [];

if (file_exists($_hn_cache) && (time() - filemtime($_hn_cache) < $_hn_ttl)) {
    $galleryPhotos = json_decode(file_get_contents($_hn_cache), true) ?: [];
} else {
    $_hn_page = 1;
    while ($_hn_page <= 60) {
        $_hn_ch = curl_init(
            'https://www.shotikotsikura.com/client/loadphotos/'
            . '?cuk=hostilenoise&cid=113028891&page=' . $_hn_page . '&gs=highlights'
        );
        curl_setopt_array($_hn_ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; GalleryProxy/1.0)',
            CURLOPT_HTTPHEADER     => [
                'X-Requested-With: XMLHttpRequest',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Referer: https://www.shotikotsikura.com/hostilenoise/',
            ],
        ]);
        $_hn_resp = curl_exec($_hn_ch);
        $_hn_code = curl_getinfo($_hn_ch, CURLINFO_HTTP_CODE);
        curl_close($_hn_ch);

        if ($_hn_code !== 200 || empty($_hn_resp)) break;

        $_hn_data = json_decode($_hn_resp, true);
        if (empty($_hn_data) || ($_hn_data['status'] ?? '') !== 'success') break;

        foreach (json_decode($_hn_data['content'] ?? '[]', true) ?: [] as $_hn_photo) {
            $_hn_raw = $_hn_photo['pathLarge'] ?? '';
            if (empty($_hn_raw)) continue;
            $_hn_src = (substr($_hn_raw, 0, 2) === '//') ? 'https:' . $_hn_raw : $_hn_raw;
            if (preg_match('/\/([a-f0-9]{32})-/i', $_hn_src, $_hn_m)) {
                $galleryPhotos[] = ['hash' => $_hn_m[1], 'src' => $_hn_src];
            }
        }

        if (!empty($_hn_data['isLastPage'])) break;
        $_hn_page++;
    }
    if (!empty($galleryPhotos)) {
        @file_put_contents($_hn_cache, json_encode($galleryPhotos));
    }
}

foreach ($galleryPhotos as $_hn_p) {
    $hashes[] = $_hn_p['hash'];
}
unset($_hn_cache, $_hn_ttl, $_hn_page, $_hn_ch, $_hn_resp, $_hn_code,
      $_hn_data, $_hn_photo, $_hn_raw, $_hn_src, $_hn_m, $_hn_p);
?>
<a id="top"></a>
<style>
  .gallery-page {
    padding: 4rem 3rem 6rem;
    border-bottom: 1px solid var(--gray);
  }

  .gallery-intro {
    display: grid;
    grid-template-columns: 1.2fr auto;
    gap: 2rem;
    align-items: end;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding-bottom: 1.5rem;
    margin-bottom: 2rem;
  }

  .gallery-kicker {
    font-family: 'Space Mono', monospace;
    font-size: 0.58rem;
    letter-spacing: 0.28em;
    color: var(--red);
    text-transform: uppercase;
  }

  .gallery-title {
    margin-top: 0.5rem;
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    letter-spacing: 0.08em;
    color: var(--white);
  }

  .gallery-author {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--light);
    line-height: 1.6;
    margin-top: 2rem;
  }

  .gallery-author span {
    display: block;
    color: var(--white);
    font-size: 1rem;
    margin-top: 0.5rem;
    letter-spacing: 0.05em;
  }

  .gallery-hero-link {
    display: inline-block;
    margin-top: 1.2rem;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem;
    letter-spacing: 0.24em;
    color: var(--black);
    background: var(--red);
    padding: 0.9rem 1.8rem;
    text-decoration: none;
    border: 1px solid rgba(241, 238, 117, 0.9);
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
    transition: transform 0.2s ease, box-shadow 0.25s ease;
    box-shadow: 0 0 0 rgba(241, 238, 117, 0.35);
  }

  .gallery-hero-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 16px rgba(241, 238, 117, 0.4);
  }

  /* ─── VIDEO SECTION ─── */
  .gallery-video {
    margin-top: 2.25rem;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.08);
    background: rgba(18, 18, 18, 0.6);
  }

  .gallery-video-frame {
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #0f0f0f;
    border: 1px solid rgba(255, 255, 255, 0.08);
    overflow: hidden;
    box-shadow: 0 0 0 rgba(241, 238, 117, 0.0);
  }

  .gallery-video-frame iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
  }

  .gallery-video-caption {
    margin-top: 0.9rem;
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--mid);
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .gallery-video-caption a {
    color: var(--red);
    text-decoration: none;
    opacity: 0.95;
    transition: opacity 0.2s ease;
  }

  .gallery-video-caption a:hover {
    opacity: 0.8;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
  }

  .gallery-item {
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.08);
    overflow: hidden;
    background: #121212;
    aspect-ratio: 3 / 4;
  }

  .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    filter: grayscale(10%) contrast(1.05);
    transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), filter 0.4s ease;
  }

  .gallery-item:hover img {
    transform: scale(1.02);
    filter: grayscale(0%) contrast(1.1);
  }

  .gallery-item::after {
    content: "Photo by Shotiko Tsikurishvili";
    position: absolute;
    left: 1rem;
    bottom: 1rem;
    font-family: 'Space Mono', monospace;
    font-size: 0.5rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--white);
    background: rgba(0, 0, 0, 0.6);
    padding: 0.4rem 0.8rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    z-index: 2;
  }

  .gallery-item:hover::after {
    opacity: 1;
  }

  .back-to-top-wrap {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
  }

  .back-to-top-btn {
    display: inline-block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem;
    letter-spacing: 0.24em;
    color: var(--black);
    background: var(--red);
    padding: 0.9rem 1.8rem;
    text-decoration: none;
    border: 1px solid rgba(241, 238, 117, 0.9);
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
    transition: transform 0.2s ease, box-shadow 0.25s ease;
    box-shadow: 0 0 0 rgba(241, 238, 117, 0.35);
  }

  .back-to-top-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 16px rgba(241, 238, 117, 0.4);
  }

  @media (max-width: 768px) {
    .gallery-page {
      padding: 3rem 1.5rem 5rem;
    }

    .gallery-intro {
      grid-template-columns: 1fr;
      align-items: start;
    }

    .gallery-author {
      text-align: left;
    }

    .gallery-grid {
      grid-template-columns: 1fr;
    }

    .video-reels-grid {
      grid-template-columns: 1fr;
    }
  }

  /* FOOTER STYLES */
  footer {
    padding: 3rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--gray);
  }

  .footer-logo-text {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.5rem;
    letter-spacing: 0.2em;
    color: var(--white);
  }

  .footer-orgs {
    display: flex;
    align-items: center;
    gap: 2rem;
  }


  .footer-credit {
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    color: var(--mid);
    letter-spacing: 0.15em;
    text-align: right;
    line-height: 2;
  }

  .footer-contact {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    letter-spacing: 0.1em;
    color: var(--light);
    margin-top: 1rem;
  }

  .footer-contact a {
    color: var(--red);
    text-decoration: none;
    transition: opacity 0.2s ease;
  }

  .footer-contact a:hover {
    opacity: 0.8;
  }

  @media (max-width: 768px) {
    footer {
      flex-direction: column;
      gap: 2rem;
      text-align: center;
    }

    .footer-credit {
      text-align: center;
    }
  }
</style>

<section class="gallery-page">
  <div class="gallery-intro">
    <div>
      <div class="gallery-kicker">Gallery</div>
      <h1 class="gallery-title">Hostile Noise Visual Archive</h1>
    </div>
    <div class="gallery-author">Author <span><a href="https://www.instagram.com/shotikotsikura/" target="_blank" style="color: inherit; text-decoration: none;">Shotiko Tsikurishvili</a></span></div>
  </div>

  <section class="gallery-video" aria-label="Hostile Noise video">
    <div class="gallery-video-frame">
      <iframe
        src="https://www.youtube-nocookie.com/embed/5jWM4jZyG8E?rel=0&modestbranding=1&playsinline=1"
        title="HOSTILE NOISE video"
        loading="lazy"
        referrerpolicy="strict-origin-when-cross-origin"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen>
      </iframe>
    </div>
    <div class="gallery-video-caption">
      <span>// Video documentation</span>
      <a href="https://youtu.be/5jWM4jZyG8E?si=MvqZHzXlSRQYCg1L" target="_blank" rel="noopener noreferrer">Open on YouTube ↗</a>
    </div>
  </section>

  <div class="gallery-grid">
    <?php if (empty($galleryPhotos)): ?>
      <div class="gallery-item">
        <img src="https://logos.pixieset.com/workspace-4391331/22a15a9d1c43336e3880eeff0cd4ea8c-medium.jpg" alt="Hostile Noise photography by Shotiko Tsikurishvili" loading="lazy">
      </div>
      <div style="color:var(--light);font-family:'Space Mono',monospace;font-size:0.75rem;padding:2rem 0;grid-column:1/-1;">
        Live photo feed is temporarily unavailable on this server. You can still access the full gallery via
        <a href="https://www.shotikotsikura.com/hostilenoise/" target="_blank" rel="noopener noreferrer" style="color:var(--red);text-decoration:none;">this direct gallery link</a>.
      </div>
    <?php else: foreach ($galleryPhotos as $_gp): ?>
    <div class="gallery-item" onclick="openLightbox('<?php echo $_gp['hash']; ?>')"><img src="<?php echo htmlspecialchars($_gp['src']); ?>" alt="Hostile Noise" loading="lazy"></div>
    <?php endforeach; endif; ?>
  </div>

  <div class="back-to-top-wrap">
    <a href="#top" class="back-to-top-btn" aria-label="Back to top">BACK TO TOP</a>
  </div>
</section>

  <style>
    /* ─── LIGHTBOX ─── */
    .lightbox {
      display: none;
      position: fixed;
      z-index: 100000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(10, 10, 10, 0.95);
      backdrop-filter: blur(4px);
      align-items: center;
      justify-content: center;
    }
    .lightbox-content {
      max-width: 90%;
      max-height: 90vh;
      object-fit: contain;
      box-shadow: 0 0 20px rgba(241, 238, 117, 0.05);
    }
    .lightbox-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      color: var(--mid);
      border: none;
      font-size: 2rem;
      padding: 1rem;
      cursor: crosshair;
      z-index: 100001;
      transition: color 0.2s, transform 0.2s;
    }
    .lightbox-btn:hover { color: var(--white); transform: translateY(-50%) scale(1.1); }
    .lightbox-prev { left: 2rem; }
    .lightbox-next { right: 2rem; }
    .lightbox-close {
      position: absolute;
      top: 2rem;
      right: 2rem;
      background: none;
      border: none;
      color: var(--red);
      font-family: 'Space Mono', monospace;
      font-size: 1rem;
      cursor: crosshair;
      transition: color 0.2s ease, transform 0.2s ease;
      letter-spacing: 0.1em;
      z-index: 100001;
    }
    .lightbox-close:hover { color: var(--white); transform: scale(1.1); }
    .gallery-item { cursor: crosshair; }
  </style>

  <!-- LIGHTBOX HTML -->
  <div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">[CLOSE]</button>
    <button class="lightbox-btn lightbox-prev" onclick="changeImage(-1)">&#10094;</button>
    <img class="lightbox-content" id="lightbox-img" src="" alt="">
    <button class="lightbox-btn lightbox-next" onclick="changeImage(1)">&#10095;</button>
  </div>

  <script>
    let currentHashIndex = 0;
    const hashes = <?php echo json_encode($hashes); ?>;

    function openLightbox(hash) {
      currentHashIndex = hashes.indexOf(hash);
      document.getElementById('lightbox-img').src = 'https://images.pixieset.com/198820311/' + hash + '-xlarge.jpg';
      document.getElementById('lightbox').style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      document.getElementById('lightbox').style.display = 'none';
      document.getElementById('lightbox-img').src = '';
      document.body.style.overflow = 'auto';
    }

    function changeImage(direction) {
      currentHashIndex += direction;
      if (currentHashIndex >= hashes.length) currentHashIndex = 0;
      if (currentHashIndex < 0) currentHashIndex = hashes.length - 1;
      document.getElementById('lightbox-img').src = 'https://images.pixieset.com/198820311/' + hashes[currentHashIndex] + '-xlarge.jpg';
    }

    document.addEventListener('keydown', function(e) {
      if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeImage(-1);
        if (e.key === 'ArrowRight') changeImage(1);
      }
    });

    document.getElementById('lightbox').addEventListener('click', function(e) {
      if (e.target.id === 'lightbox') {
        closeLightbox();
      }
    });
  </script>

<?php include '../footer.php'; ?>
