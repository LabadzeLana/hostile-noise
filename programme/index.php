<?php
$page_title = 'Programme — HOSTILE NOISE';
$og_title = 'Programme — HOSTILE NOISE';
$og_desc = 'Full programme for HOSTILE NOISE — Friction in Design, Art and Technology. 18 April 2026, Rooms, Tbilisi.';
$og_image = 'og-image.png';
include '../header.php';
?>

<style>

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --black: #0a0a0a;
    --white: #f0ede8;
    --red: #f1ee75;
    --gray: #2a2a2a;
    --mid: #5a5a5a;
    --light: #b0aa9f;
  }

  html { scroll-behavior: smooth; }

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
    background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,0.03) 2px, rgba(0,0,0,0.03) 4px);
    pointer-events: none;
    z-index: 9998;
  }

  /* ─── NAV ─── */
  .nav {
    position: relative;
    z-index: 10;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem 3rem;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }

  .nav-logos { display: flex; align-items: center; gap: 1.5rem; }

  .logo-adjara {
    height: 54px; width: auto;
    filter: invert(1) brightness(0.7);
    opacity: 0.85; transition: all 0.2s ease;
  }
  .logo-adjara:hover { opacity: 1; filter: invert(1) brightness(1); }

  .logo-geolab {
    height: 54px; width: auto;
    filter: brightness(0.7);
    opacity: 0.85; transition: all 0.2s ease;
  }
  .logo-geolab:hover { opacity: 1; filter: brightness(1); }

  .logo-art {
    height: 38px; width: auto;
    filter: brightness(0.7);
    opacity: 0.85; transition: all 0.2s ease;
  }
  .logo-art:hover { opacity: 1; filter: brightness(1); }

  .back-link {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    color: var(--mid);
    text-decoration: none;
    text-transform: uppercase;
    transition: color 0.2s;
    display: flex; align-items: center; gap: 0.5rem;
  }
  .back-link:hover { color: var(--red); }
  .back-link::before { content: '←'; }

  /* ─── HERO ─── */
  .prog-hero {
    min-height: 62vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 5rem 3rem 4rem;
    border-bottom: 1px solid var(--gray);
    position: relative;
    overflow: hidden;
  }

  /* Animated interference bg */
  .prog-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
    overflow: hidden;
  }

  .prog-hero-bg svg {
    position: absolute;
    width: 100%; height: 100%;
    opacity: 0.08;
  }

  .prog-hero-bg line {
    stroke: var(--white);
    stroke-width: 0.5;
    animation: drift 14s ease-in-out infinite alternate;
  }

  .prog-hero-bg line:nth-child(even) {
    animation-duration: 10s;
    animation-delay: -4s;
  }

  @keyframes drift {
    from { transform: translateX(-15px) rotate(0deg); }
    to   { transform: translateX(15px) rotate(1.5deg); }
  }

  /* Big background text */
  .prog-hero-bg-text {
    position: absolute;
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(8rem, 22vw, 22rem);
    color: rgba(255,255,255,0.025);
    letter-spacing: -0.04em;
    line-height: 1;
    bottom: -1rem;
    left: -0.5rem;
    pointer-events: none;
    user-select: none;
    white-space: nowrap;
    z-index: 0;
  }

  .prog-hero-content {
    position: relative;
    z-index: 2;
  }

  .prog-label {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    letter-spacing: 0.5em;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    opacity: 0;
    animation: fadeUp 0.7s ease forwards 0.1s;
  }

  .prog-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(5rem, 16vw, 14rem);
    line-height: 0.88;
    letter-spacing: -0.02em;
    color: var(--white);
    opacity: 0;
    animation: fadeUp 0.7s ease forwards 0.25s;
    position: relative;
    display: inline-block;
  }

  /* Glitch effect on title */
  .prog-title .glitch {
    position: relative;
    display: inline-block;
  }

  .prog-title .glitch::before,
  .prog-title .glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0; left: 0; width: 100%;
  }

  .prog-title .glitch::before {
    color: var(--red);
    clip-path: polygon(0 25%, 100% 25%, 100% 45%, 0 45%);
    transform: translateX(-3px);
    animation: glitch1 5s infinite;
  }

  .prog-title .glitch::after {
    color: rgba(100, 200, 255, 0.3);
    clip-path: polygon(0 65%, 100% 65%, 100% 80%, 0 80%);
    transform: translateX(3px);
    animation: glitch2 5s infinite 0.6s;
  }

  @keyframes glitch1 {
    0%, 88%, 100% { opacity:0; transform: translateX(-3px); }
    89%  { opacity:1; transform: translateX(-8px); }
    91%  { opacity:0; }
    94%  { opacity:1; transform: translateX(5px); }
    96%  { opacity:0; }
  }

  @keyframes glitch2 {
    0%, 86%, 100% { opacity:0; }
    87%  { opacity:1; transform: translateX(7px); }
    89%  { opacity:0; }
    93%  { opacity:1; transform: translateX(-5px); }
    95%  { opacity:0; }
  }

  .prog-subtitle {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(1rem, 2vw, 1.3rem);
    font-weight: 300;
    letter-spacing: 0.25em;
    color: var(--light);
    margin-top: 1.5rem;
    text-transform: uppercase;
    opacity: 0;
    animation: fadeUp 0.7s ease forwards 0.4s;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ─── STAT STRIP ─── */
  .stat-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    background: var(--gray);
    border-bottom: 1px solid #333;
  }

  .stat-block {
    padding: 3rem 2.5rem;
    border-right: 1px solid #333;
    position: relative;
    overflow: hidden;
    cursor: default;
  }
  .stat-block:last-child { border-right: none; }

  .stat-block::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 2px;
    background: var(--red);
    transition: width 0.4s ease;
  }
  .stat-block:hover::after { width: 100%; }

  .stat-label {
    font-family: 'Space Mono', monospace;
    font-size: 0.55rem;
    letter-spacing: 0.4em;
    color: var(--mid);
    text-transform: uppercase;
    margin-bottom: 0.8rem;
  }

  .stat-value {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    color: var(--white);
    letter-spacing: 0.04em;
    line-height: 1.05;
  }

  .stat-value span {
    color: var(--red);
  }

  .stat-sub {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 0.8rem;
    color: var(--mid);
    margin-top: 0.4rem;
    letter-spacing: 0.1em;
  }

  /* ─── SCHEDULE WRAPPER ─── */
  .schedule-wrap {
    padding: 7rem 3rem;
    max-width: 1300px;
    margin: 0 auto;
  }

  .schedule-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray);
  }

  .schedule-header-left {
    display: flex;
    align-items: baseline;
    gap: 2rem;
  }

  .section-tag {
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.4em;
    color: var(--red);
    text-transform: uppercase;
  }

  .section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    letter-spacing: 0.05em;
    color: var(--white);
  }

  .schedule-date-tag {
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.2em;
    color: var(--mid);
  }

  /* ─── TIMELINE ITEMS ─── */
  .schedule-item {
    display: grid;
    grid-template-columns: 180px 40px 1fr;
    gap: 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    position: relative;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease, background 0.25s ease;
  }

  .schedule-item.visible {
    opacity: 1;
    transform: translateY(0);
  }

  .schedule-item:hover {
    background: rgba(241, 238, 117, 0.03);
  }

  /* animated left accent bar */
  .schedule-item::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 2px;
    background: var(--red);
    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.35s ease;
  }

  .schedule-item:hover::before {
    transform: scaleY(1);
  }

  /* TIME COLUMN */
  .sched-time {
    padding: 2.5rem 1.5rem 2.5rem 1.5rem;
    border-right: 1px solid rgba(255,255,255,0.05);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: 0.4rem;
  }

  .time-from {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.4rem;
    color: var(--white);
    letter-spacing: 0.05em;
    line-height: 1;
  }

  .time-to {
    font-family: 'Space Mono', monospace;
    font-size: 0.5rem;
    color: var(--mid);
    letter-spacing: 0.15em;
  }

  /* DOT COLUMN */
  .sched-dot {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 2.9rem;
    position: relative;
  }

  .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--gray);
    border: 1px solid var(--mid);
    flex-shrink: 0;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .schedule-item:hover .dot {
    background: var(--red);
    border-color: var(--red);
    box-shadow: 0 0 12px rgba(241, 238, 117, 0.5);
  }

  .dot-line {
    width: 1px;
    flex: 1;
    background: rgba(255,255,255,0.07);
    margin-top: 4px;
  }

  .schedule-item:last-child .dot-line { display: none; }

  /* BODY COLUMN */
  .sched-body {
    padding: 2.5rem 2rem 2.5rem 2rem;
  }

  .sched-type {
    font-family: 'Space Mono', monospace;
    font-size: 0.5rem;
    letter-spacing: 0.45em;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 0.6rem;
    opacity: 0.8;
  }

  .sched-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(1.3rem, 2.5vw, 1.8rem);
    color: var(--white);
    letter-spacing: 0.03em;
    line-height: 1.1;
    margin-bottom: 0.6rem;
    transition: color 0.25s ease;
  }

  .schedule-item:hover .sched-name {
    color: var(--red);
  }

  .sched-desc {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(0.9rem, 1.5vw, 1.1rem);
    font-weight: 300;
    color: var(--light);
    line-height: 1.75;
    letter-spacing: 0.03em;
  }

  .sched-desc strong {
    color: var(--white);
    font-weight: 600;
  }

  .sched-desc em {
    font-style: italic;
    color: var(--light);
  }

  .sched-venue {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    font-family: 'Space Mono', monospace;
    font-size: 0.5rem;
    letter-spacing: 0.3em;
    color: var(--mid);
    text-transform: uppercase;
    transition: color 0.25s ease;
  }

  .schedule-item:hover .sched-venue {
    color: var(--light);
  }

  .sched-venue::before {
    content: '◆';
    font-size: 0.35rem;
    color: var(--red);
  }

  /* BREAK ROWS */
  .schedule-item.is-break {
    opacity: 0;
    transform: translateY(30px);
  }
  .schedule-item.is-break.visible {
    opacity: 1;
    transform: translateY(0);
  }

  .schedule-item.is-break .sched-name {
    font-family: 'Space Mono', monospace;
    font-size: 0.7rem;
    font-weight: normal;
    letter-spacing: 0.25em;
    color: var(--mid);
    text-transform: uppercase;
  }

  /* HIGHLIGHT ROW (afterparty) */
  .schedule-item.is-highlight {
    background: rgba(241, 238, 117, 0.04);
  }

  .schedule-item.is-highlight .sched-name {
    color: var(--red);
  }

  .schedule-item.is-highlight:hover .sched-name {
    color: var(--white);
  }

  .schedule-item.is-highlight .dot {
    background: var(--red);
    border-color: var(--red);
    box-shadow: 0 0 16px rgba(241,238,117,0.4);
  }

  /* ─── TICKER ─── */
  .ticker-wrap {
    overflow: hidden;
    border-top: 1px solid rgba(255,255,255,0.07);
    border-bottom: 1px solid rgba(255,255,255,0.07);
    background: rgba(255,255,255,0.015);
    padding: 0.9rem 0;
    position: relative;
    z-index: 5;
  }

  .ticker-track {
    display: flex;
    gap: 0;
    animation: ticker 30s linear infinite;
    white-space: nowrap;
  }

  .ticker-track:hover {
    animation-play-state: paused;
  }

  .ticker-item {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 0.95rem;
    letter-spacing: 0.3em;
    color: var(--mid);
    padding: 0 3rem;
    display: inline-flex;
    align-items: center;
    gap: 2rem;
  }

  .ticker-item span {
    color: var(--red);
    font-size: 0.5rem;
  }

  @keyframes ticker {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
  }

  /* ─── PDF CTA ─── */
  .pdf-cta {
    padding: 5rem 3rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--gray);
    border-top: 1px solid #333;
    position: relative;
    overflow: hidden;
  }

  .pdf-cta::before {
    content: '↓';
    position: absolute;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 30vw;
    color: rgba(255,255,255,0.015);
    right: 5%;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    line-height: 1;
  }

  .pdf-left { position: relative; z-index: 1; }

  .pdf-eyebrow {
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.4em;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 0.7rem;
  }

  .pdf-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem);
    color: var(--white);
    letter-spacing: 0.05em;
    line-height: 1;
  }

  .pdf-sub {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1rem;
    color: var(--light);
    letter-spacing: 0.1em;
    margin-top: 0.4rem;
  }

  .btn-pdf {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem;
    letter-spacing: 0.35em;
    color: var(--black);
    background: var(--white);
    padding: 1.1rem 2.5rem;
    text-decoration: none;
    text-transform: uppercase;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
  }

  .btn-pdf::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--red);
    transform: translateX(-102%);
    transition: transform 0.35s ease;
  }

  .btn-pdf span { position: relative; z-index: 1; }
  .btn-pdf:hover { color: var(--black); }
  .btn-pdf:hover::before { transform: translateX(0); }

  /* ─── TOGGLE BUTTONS ─── */
  .btn-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1rem;
    letter-spacing: 0.35em;
    color: var(--black);
    background: var(--white);
    padding: 1.1rem 2.5rem;
    text-transform: uppercase;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
    border: none;
    cursor: pointer;
  }
  .btn-toggle::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--red);
    transform: translateX(-102%);
    transition: transform 0.35s ease;
  }
  .btn-toggle span { position: relative; z-index: 1; }
  .btn-toggle:hover { color: var(--black); }
  .btn-toggle:hover::before { transform: translateX(0); }
  .btn-toggle.active { color: var(--black); }
  .btn-toggle.active::before { transform: translateX(0); }

  /* ─── FOOTER ─── */
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

  .footer-logo-adjara {
    height: 60px; width: auto;
    filter: invert(1) brightness(0.5);
    opacity: 0.6; transition: all 0.2s ease;
  }
  .footer-logo-adjara:hover { opacity: 0.9; filter: invert(1) brightness(1); }

  .footer-logo-geolab {
    height: 60px; width: auto;
    filter: brightness(0.5);
    opacity: 0.6; transition: all 0.2s ease;
  }
  .footer-logo-geolab:hover { opacity: 0.9; filter: brightness(1); }

  .footer-logo-art {
    height: 44px; width: auto;
    filter: brightness(0.5);
    opacity: 0.6; transition: all 0.2s ease;
  }
  .footer-logo-art:hover { opacity: 0.9; filter: brightness(1); }

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
  .footer-contact a:hover { opacity: 0.8; }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 900px) {
    .nav { padding: 1.5rem; }
    .prog-hero { padding: 4rem 1.5rem 3rem; min-height: 50vh; }
    .stat-strip { grid-template-columns: repeat(2, 1fr); }
    .stat-block:nth-child(2) { border-right: none; }
    .stat-block:nth-child(3) { border-top: 1px solid #333; }
    .stat-block:nth-child(4) { border-top: 1px solid #333; border-right: none; }
    .schedule-wrap { padding: 4rem 1.5rem; }
    .schedule-header { flex-direction: column; gap: 1rem; }
    .schedule-item { grid-template-columns: 120px 30px 1fr; }
    .sched-time { padding: 2rem 1rem 2rem 1rem; }
    .sched-body { padding: 2rem 1rem; }
    .pdf-cta { flex-direction: column; gap: 2rem; align-items: flex-start; padding: 3rem 1.5rem; }
    footer { flex-direction: column; gap: 2rem; text-align: center; }
    .footer-credit { text-align: center; }
  }

  @media (max-width: 600px) {
    .schedule-item { grid-template-columns: 90px 24px 1fr; }
    .sched-dot { display: none; }
    .schedule-item { grid-template-columns: 90px 1fr; }
  }

</style>

<!-- ═══ HERO ═══ -->
<section class="prog-hero">
  <div class="prog-hero-bg">
    <svg viewBox="0 0 1400 900" preserveAspectRatio="none">
      <line x1="0"    y1="80"  x2="1400" y2="300" />
      <line x1="300"  y1="0"   x2="700"  y2="900" />
      <line x1="900"  y1="0"   x2="500"  y2="900" />
      <line x1="1200" y1="50"  x2="200"  y2="600" />
      <line x1="0"    y1="500" x2="1400" y2="100" />
      <line x1="600"  y1="0"   x2="800"  y2="900" />
      <line x1="1300" y1="0"   x2="50"   y2="900" />
      <line x1="0"    y1="300" x2="1400" y2="700" />
    </svg>
    <div class="prog-hero-bg-text">PROGRAMME</div>
  </div>

  <div class="prog-hero-content">
    <div class="prog-label">18 April 2026 — Rooms, Tbilisi</div>
    <h1 class="prog-title">
      <span class="glitch" data-text="PROGRAMME">PROGRAMME</span>
    </h1>
    <div class="prog-subtitle">Hostile Noise — Collisions of Art, Design, Technology &amp; Interventions</div>
  </div>
</section>



<!-- ═══ STATS ═══ -->
<div class="stat-strip">
  <div class="stat-block">
    <div class="stat-label">Date</div>
    <div class="stat-value">18 <span>APR</span></div>
    <div class="stat-sub">2026</div>
  </div>
  <div class="stat-block">
    <div class="stat-label">Venue</div>
    <div class="stat-value">Rooms</div>
    <div class="stat-sub">14 Merab Kostava St, Tbilisi</div>
  </div>
  <div class="stat-block">
    <div class="stat-label">Duration</div>
    <div class="stat-value">9<span>+</span> hrs</div>
    <div class="stat-sub">1:00 PM — Late</div>
  </div>
  <div class="stat-block">
    <div class="stat-label">Programme items</div>
    <div class="stat-value js-count" data-target="12">0</div>
    <div class="stat-sub">Talks, Performances &amp; Installations</div>
  </div>
</div>

<!-- ═══ SCHEDULE TOGGLES ═══ -->
<div class="schedule-toggle-container" style="display: flex; justify-content: center; gap: 1rem; padding: 4rem 1.5rem 0; flex-wrap: wrap;">
  <button class="btn-toggle active" data-target="day-schedule">
    <span>Day Programme</span>
  </button>
  <button class="btn-toggle" data-target="wellcome-schedule">
    <span>Participants Welcome Programme</span>
  </button>
</div>

<!-- ═══ PARTICIPANTS WELCOME PROGRAMME ═══ -->
<div class="schedule-wrap" id="wellcome-schedule" style="border-bottom: 1px solid rgba(255,255,255,0.07); padding-bottom: 0; display: none;">

  <div class="schedule-header">
    <div class="schedule-header-left">
      <div class="section-tag">// Participants</div>
      <div class="section-title">Welcome Programme</div>
    </div>
    <div class="schedule-date-tag">17 – 18 April 2026</div>
  </div>

  <!-- DAY LABEL: April 17 -->
  <div style="padding: 1.2rem 0 0.4rem 0; font-family: 'Space Mono', monospace; font-size: 0.75rem; font-weight: bold; letter-spacing: 0.4em; color: var(--red); text-transform: uppercase;">Friday, 17 April 2026</div>

  <!-- 1:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">1:00 PM</div>
      <div class="time-to">→ 2:00 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Cultural Visit</div>
      <div class="sched-name">Georgian National Museum</div>
      <div class="sched-desc">Visit with <strong>Zaza Iashvili</strong></div>
      <a class="sched-venue" href="https://maps.app.goo.gl/uQL9ZPmY14Q1TD3dA" target="_blank" rel="noopener">Google Maps ↗</a>
    </div>
  </div>

  <!-- 3:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">3:00 PM</div>
      <div class="time-to">→ 4:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Cultural Visit</div>
      <div class="sched-name">Apollon Kutateladze Tbilisi State Academy of Arts</div>
      <div class="sched-desc">Meeting point: Main Entrance</div>
      <a class="sched-venue" href="https://maps.app.goo.gl/XJALcPGPM1NfGojP8" target="_blank" rel="noopener">Google Maps ↗</a>
    </div>
  </div>

  <!-- 6:30 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">6:30 PM</div>
      <div class="time-to">→ 7:30 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Social</div>
      <div class="sched-name">Visit to Design Institute</div>
      <div class="sched-desc">Wine &amp; Cheese</div>
      <a class="sched-venue" href="https://maps.app.goo.gl/Lmx6WWYFPRi96cMH9" target="_blank" rel="noopener">Google Maps ↗</a>
    </div>
  </div>

  <!-- 8:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">8:00 PM</div>
      <div class="time-to">→ 10:00 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Festival Preparation</div>
      <div class="sched-name">Installation Testing — Rooms Hotels Tbilisi</div>
      <div class="sched-desc">Testing installations and equipment</div>
      <a class="sched-venue" href="https://maps.app.goo.gl/mubD8exQVmcTbGrb7" target="_blank" rel="noopener">Google Maps ↗</a>
    </div>
  </div>

  <!-- DAY LABEL: April 18 -->
  <div style="padding: 2rem 0 0.4rem 0; font-family: 'Space Mono', monospace; font-size: 0.75rem; font-weight: bold; letter-spacing: 0.4em; color: var(--red); text-transform: uppercase;">Saturday, 18 April 2026 — Festival Day</div>

  <!-- 10:30 AM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">10:30 AM</div>
      <div class="time-to">→ 12:30 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Festival Preparation</div>
      <div class="sched-name">Sound Check — Rooms Hotels Tbilisi</div>
      <div class="sched-desc">Testing music and DJ set</div>
      <a class="sched-venue" href="https://maps.app.goo.gl/mubD8exQVmcTbGrb7" target="_blank" rel="noopener">Google Maps ↗</a>
    </div>
  </div>

  <!-- 1:00 PM Festival -->
  <div class="schedule-item is-highlight">
    <div class="sched-time">
      <div class="time-from">1:00 PM</div>
      <div class="time-to">→ 10:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div></div>
    <div class="sched-body">
      <div class="sched-type">Festival</div>
      <div class="sched-name">Hostile Noise Festival — Start to End</div>
      <div class="sched-venue">Rooms Hotels Tbilisi</div>
    </div>
  </div>

</div>

<!-- ═══ SCHEDULE ═══ -->
<div class="schedule-wrap" id="day-schedule">

  <div class="schedule-header">
    <div class="schedule-header-left">
      <div class="section-tag">// Schedule</div>
      <div class="section-title">Day Programme</div>
    </div>
    <div class="schedule-date-tag">Saturday, 18 April 2026</div>
  </div>

  <!-- 1:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">1:00 PM</div>
      <div class="time-to">→ 2:00 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Exhibition Opening</div>
      <div class="sched-name">Opening of Installations</div>
      <div class="sched-desc">
        Sandro Asatiani, Katharina Diem, Nino Esaishvili, Gagosh, Gernot Passath,
        Lina Tonev, David Angelo Tschmuck, Maria Amparo Gomar Vidal.<br>
        <strong>Welcome and tour.</strong>
      </div>
      <div class="sched-venue">Central Room</div>
    </div>
  </div>

  <!-- 2:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">2:00 PM</div>
      <div class="time-to">→ 2:30 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Activity</div>
      <div class="sched-name">Gagosh — "Connections"</div>
      <div class="sched-venue">Rooms Garden</div>
    </div>
  </div>

  <!-- 2:30 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">2:30 PM</div>
      <div class="time-to">→ 2:45 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Welcome &amp; Intro</div>
      <div class="sched-name">Teamwave Rise — A Manifesto for Collaborative Systems</div>
      <div class="sched-desc"><strong>Sandro Asatiani &amp; Karl Stocker</strong></div>
      <div class="sched-venue">Event Room</div>
    </div>
  </div>

  <!-- 2:45 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">2:45 PM</div>
      <div class="time-to">→ 4:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Symposium</div>
      <div class="sched-name">Talks &amp; Interventions</div>
      <div class="sched-desc">
        Short talks by <strong>Tomislav Bobinec</strong>,
        <strong>Bostjan Botas Kenda</strong>,
        <strong>Reanne Leuning</strong>, and performance with interactive moments by
        <strong>Igor Petkovic</strong>.
      </div>
      <div class="sched-venue">Event Room</div>
    </div>
  </div>

  <!-- 4:15 PM BREAK -->
  <div class="schedule-item is-break">
    <div class="sched-time">
      <div class="time-from">4:15 PM</div>
      <div class="time-to">→ 4:45 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Pause</div>
      <div class="sched-name">Break &amp; Networking</div>
    </div>
  </div>

  <!-- 4:45 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">4:45 PM</div>
      <div class="time-to">→ 6:00 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Discussion</div>
      <div class="sched-name">Theory Meets Practice</div>
      <div class="sched-desc">
        Panel moderated by <strong>Karl Stocker</strong> with
        <strong>Sandro Asatiani</strong>, <strong>Katharina Diem</strong>,
        <strong>Nino Esaishvili</strong>, <strong>Gagosh</strong>,
        <strong>David Angelo Tschmuck</strong>.<br>
        Topic: <em>"Why the hell do we need an artistic PhD?"</em> — Q&amp;A.
      </div>
      <div class="sched-venue">Event Room</div>
    </div>
  </div>

  <!-- 6:00 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">6:00 PM</div>
      <div class="time-to">→ 6:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Workshop Presentation</div>
      <div class="sched-name">Remixing Physical Space</div>
      <div class="sched-desc">Apollon Kutateladze Tbilisi State Academy of Arts / Master students of Media Faculty.</div>
      <div class="sched-venue">Central Room</div>
    </div>
  </div>

  <!-- 6:15 PM BREAK -->
  <div class="schedule-item is-break">
    <div class="sched-time">
      <div class="time-from">6:15 PM</div>
      <div class="time-to">→ 6:45 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Pause</div>
      <div class="sched-name">Break &amp; Networking</div>
    </div>
  </div>

  <!-- 6:45 PM KEYNOTE -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">6:45 PM</div>
      <div class="time-to">→ 7:45 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Keynote</div>
      <div class="sched-name">Too Old to Fail: The Belvedere Faces the Future</div>
      <div class="sched-desc"><strong>Stella Rollig</strong> — Q&amp;A.</div>
      <div class="sched-venue">Event Room</div>
    </div>
  </div>

  <!-- 7:45 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">7:45 PM</div>
      <div class="time-to">→ 8:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Music Performance</div>
      <div class="sched-name">Schubertbarbie feat. Dr. phil. Gut.</div>
      <div class="sched-venue">Rooms Garden</div>
    </div>
  </div>



  <!-- 8:15 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">8:15 PM</div>
      <div class="time-to">→ 8:45 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Music Performance</div>
      <div class="sched-name">Deta</div>
      <div class="sched-venue">Rooms Garden</div>
    </div>
  </div>

  <!-- 8:45 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">8:45 PM</div>
      <div class="time-to">→ 9:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">AV Intervention</div>
      <div class="sched-name">Audiovisual Stereoscopic Intervention</div>
      <div class="sched-desc"><strong>MO:YA</strong></div>
      <div class="sched-venue">Central Room</div>
    </div>
  </div>

  <!-- 9:15 PM -->
  <div class="schedule-item">
    <div class="sched-time">
      <div class="time-from">9:15 PM</div>
      <div class="time-to">→ 10:15 PM</div>
    </div>
    <div class="sched-dot"><div class="dot"></div><div class="dot-line"></div></div>
    <div class="sched-body">
      <div class="sched-type">Closing Performance</div>
      <div class="sched-name">feelipa</div>
      <div class="sched-desc">High-energy bass rhythms at 140 BPM.</div>
      <div class="sched-venue">Rooms Garden</div>
    </div>
  </div>

  <!-- 10:15 PM AFTERPARTY -->
  <div class="schedule-item is-highlight">
    <div class="sched-time">
      <div class="time-from">10:15 PM</div>
      <div class="time-to">→ ∞</div>
    </div>
    <div class="sched-dot"><div class="dot"></div></div>
    <div class="sched-body">
      <div class="sched-type">Afterparty</div>
      <div class="sched-name">Open Networking &amp; Additional Interventions</div>
      <div class="sched-venue">Rooms Garden</div>
    </div>
  </div>

</div>



<?php include '../footer.php'; ?>

<script>
/* ─── SCROLL REVEAL ─── */
const items = document.querySelectorAll('.schedule-item');

const revealObs = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      // stagger within viewport batch
      const delay = (Array.from(items).indexOf(entry.target) % 5) * 80;
      setTimeout(() => {
        entry.target.classList.add('visible');
      }, delay);
      revealObs.unobserve(entry.target);
    }
  });
}, { threshold: 0.08 });

items.forEach(item => revealObs.observe(item));

/* ─── COUNTER ANIMATION ─── */
const counters = document.querySelectorAll('.js-count');

const countObs = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el = entry.target;
    const target = parseInt(el.dataset.target);
    const duration = 1200;
    const start = performance.now();

    const tick = (now) => {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(ease * target);
      if (progress < 1) requestAnimationFrame(tick);
      else el.textContent = target;
    };
    requestAnimationFrame(tick);
    countObs.unobserve(el);
  });
}, { threshold: 0.5 });

counters.forEach(c => countObs.observe(c));

/* ─── CURSOR CROSSHAIR GLOW on schedule items ─── */
document.querySelectorAll('.schedule-item').forEach(item => {
  item.addEventListener('mousemove', (e) => {
    const rect = item.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width * 100).toFixed(1);
    const y = ((e.clientY - rect.top) / rect.height * 100).toFixed(1);
    item.style.backgroundImage =
      `radial-gradient(circle at ${x}% ${y}%, rgba(241,238,117,0.05) 0%, transparent 65%)`;
  });
  item.addEventListener('mouseleave', () => {
    item.style.backgroundImage = '';
  });
});

/* ─── TOGGLE LOGIC ─── */
const toggles = document.querySelectorAll('.btn-toggle');
const daySchedule = document.getElementById('day-schedule');
const wellcomeSchedule = document.getElementById('wellcome-schedule');

toggles.forEach(toggle => {
  toggle.addEventListener('click', () => {
    // Remove active class from all
    toggles.forEach(t => t.classList.remove('active'));
    // Add to clicked
    toggle.classList.add('active');

    if (toggle.dataset.target === 'day-schedule') {
      daySchedule.style.display = 'block';
      wellcomeSchedule.style.display = 'none';
      setTimeout(() => {
        // Re-trigger scroll observer for new items
        document.querySelectorAll('#day-schedule .schedule-item').forEach(item => {
          if(item.getBoundingClientRect().top < window.innerHeight) {
            item.classList.add('visible');
          }
        });
      }, 50);
    } else {
      daySchedule.style.display = 'none';
      wellcomeSchedule.style.display = 'block';
      setTimeout(() => {
        document.querySelectorAll('#wellcome-schedule .schedule-item').forEach(item => {
          if(item.getBoundingClientRect().top < window.innerHeight) {
            item.classList.add('visible');
          }
        });
      }, 50);
    }
  });
});
</script>
