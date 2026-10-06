<?php
/**
 * Shared page frame: head, header (nav + language switch) and footer.
 *
 * @var string      $title
 * @var string      $page        One of 'recnik', 'konvertor', 'api'
 * @var string|null $description
 */
$locale    = service('request')->getLocale();
$githubUrl = 'https://github.com/ivkeapp/serbian-dictionary-api';
$navItems  = [
    'recnik'    => [base_url(), lang('App.nav.dictionary')],
    'konvertor' => [base_url('converter'), lang('App.nav.converter')],
    'api'       => [base_url('docs'), lang('App.nav.api')],
];
$languages = ['en' => 'EN', 'sr-Lat' => 'LAT', 'sr-Cyrl' => 'ЋИР'];
$folio     = ['recnik' => 'i', 'konvertor' => 'ii', 'api' => 'iii'][$page] ?? 'i';
?>
<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($description ?? lang('App.site.description')) ?>">

    <link rel="icon" href="<?= base_url('favicon.ico') ?>" sizes="48x48">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon/favicon-32x32.svg') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon/favicon-16x16.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon/apple-touch-icon.png') ?>">
    <link rel="manifest" href="<?= base_url('favicon/site.webmanifest') ?>">
    <meta name="theme-color" content="#f3f2f2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Lora:ital,wght@0,400;0,600;1,400&display=swap">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
<div class="page">
  <div class="frame">

    <header class="site-header">
      <a href="<?= base_url() ?>" class="brand"><?= lang('App.site.brand') ?></a>
      <nav class="site-nav">
        <?php foreach ($navItems as $key => [$href, $label]): ?>
          <a href="<?= $href ?>"<?= $page === $key ? ' aria-current="page"' : '' ?>><?= esc($label) ?></a>
        <?php endforeach; ?>
      </nav>
      <div class="header-tools">
        <div class="lang-switch" title="<?= lang('App.lang.switch_title') ?>">
          <?php foreach ($languages as $code => $label): ?>
            <a href="<?= base_url('set-language/' . $code) ?>"<?= $locale === $code ? ' aria-current="true"' : '' ?>><?= $label ?></a>
          <?php endforeach; ?>
        </div>
        <a href="<?= $githubUrl ?>" target="_blank" rel="noopener" title="GitHub" class="github-link">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
        </a>
      </div>
    </header>

    <main class="main">
      <?= $this->renderSection('content') ?>
    </main>

    <footer class="site-footer">
      <div class="folio">— <?= $folio ?> —</div>
      <div class="footer-links">
        <span class="made-with"><?= lang('App.footer.builtWith') ?> <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#C6363C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></span>
        <span>·</span>
        <a href="<?= $githubUrl ?>" target="_blank" rel="noopener"><?= lang('App.footer.viewOnGithub') ?></a>
        <span>·</span>
        <span><?= lang('App.footer.license') ?></span>
      </div>
    </footer>

  </div>
</div>
<?= $this->renderSection('scripts') ?>
</body>
</html>
