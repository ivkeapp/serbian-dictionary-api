<?= $this->extend('layouts/main') ?>

<?php
$base     = rtrim(base_url(), '/');
$roman    = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII'];
$copyIcon = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>';
$openIcon = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3"/></svg>';

$stats = [
    ['2.8M+', lang('App.stats.words')],
    ['1.8K+', lang('App.stats.names')],
    ['8K+', lang('App.stats.surnames')],
    ['2', lang('App.stats.scripts')],
];

$toc = [];
foreach ($api_endpoints as $i => $ep) {
    $toc[] = ['ep' . $i, $roman[$i], $ep['endpoint'], $ep['note'], true];
}
$toc[] = ['primene', 'VI', lang('App.useCases.title'), lang('App.apiDocs.note.use_cases'), false];
$toc[] = ['primeri', 'VII', lang('App.codeExamples.title'), lang('App.apiDocs.note.examples'), false];

$code = [
    'JavaScript' => "const res = await fetch('{$base}/api/words?starts_with=pre&limit=10');\nconst { data } = await res.json();\n\ndata.forEach(w => console.log(w.latin, w.cyrillic));",
    'cURL'       => "curl \"{$base}/api/random?type=word\"\n\ncurl \"{$base}/api/transliterate?text=Zdravo&to=cyrillic\"",
    'Python'     => "import requests\n\nr = requests.get(\"{$base}/api/names\",\n                 params={\"gender\": \"male\", \"limit\": 5})\n\nfor name in r.json()[\"data\"]:\n    print(name)",
    'PHP'        => "\$json = file_get_contents('{$base}/api/surnames?starts_with=Pet');\n\$data = json_decode(\$json, true)['data'];\n\nforeach (\$data as \$s) echo \$s['latin'], PHP_EOL;",
];
?>

<?= $this->section('content') ?>
<section class="docs">
  <div class="hero">
    <div class="kicker"><?= lang('App.apiDocs.kicker') ?> <?= esc($version) ?></div>
    <h1><?= lang('App.hero.title') ?></h1>
    <p class="lede"><?= lang('App.hero.subtitle') ?></p>
  </div>

  <div class="stats">
    <?php foreach ($stats as [$n, $label]): ?>
      <div class="stat">
        <div class="stat-n"><?= $n ?></div>
        <div class="stat-label"><?= $label ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <nav class="toc">
    <div class="toc-title"><?= lang('App.apiDocs.toc') ?></div>
    <?php foreach ($toc as [$id, $num, $title, $note, $isMono]): ?>
      <a class="toc-item" href="#<?= $id ?>">
        <span class="toc-num"><?= $num ?></span>
        <span<?= $isMono ? ' class="toc-mono"' : '' ?>><?= esc($title) ?></span>
        <span class="toc-dots"></span>
        <span class="toc-note"><?= esc($note) ?></span>
      </a>
    <?php endforeach; ?>
  </nav>

  <?php foreach ($api_endpoints as $i => $ep): ?>
    <article class="chapter" id="ep<?= $i ?>">
      <div class="kicker"><?= lang('App.apiDocs.chapter') ?> <?= $roman[$i] ?> · <?= $ep['method'] ?></div>
      <h2 class="endpoint"><?= esc($ep['endpoint']) ?></h2>
      <p class="chapter-desc"><?= esc($ep['description']) ?></p>

      <div class="sub-title"><?= lang('App.apiDocs.params') ?></div>
      <div class="params">
        <?php foreach ($ep['params'] as $name => $desc): ?>
          <div class="param"><code><?= esc($name) ?></code><span><?= esc($desc) ?></span></div>
        <?php endforeach; ?>
      </div>

      <div class="sub-title"><?= lang('App.apiDocs.examples') ?></div>
      <?php foreach ($ep['examples'] as $path => $desc): ?>
        <div class="example">
          <div class="example-desc"><?= esc($desc) ?></div>
          <div class="example-row">
            <a href="<?= esc($base . $path) ?>" target="_blank" class="example-url"><?= esc($path) ?></a>
            <button type="button" class="btn btn-ghost btn-muted" data-copy="<?= esc($base . $path) ?>" title="<?= esc(lang('App.apiDocs.copy_url')) ?>"><?= $copyIcon ?></button>
            <a href="<?= esc($base . $path) ?>" target="_blank" title="<?= esc(lang('App.apiDocs.open')) ?>" class="icon-link"><?= $openIcon ?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </article>
  <?php endforeach; ?>

  <article class="chapter" id="primene">
    <div class="kicker"><?= lang('App.apiDocs.chapter') ?> VI</div>
    <h2 class="chapter-title"><?= lang('App.useCases.title') ?></h2>
    <div class="use-cases">
      <?php foreach ($use_cases as $uc): ?>
        <div>
          <h3><?= esc($uc['title']) ?></h3>
          <p><?= esc($uc['description']) ?></p>
          <a href="<?= esc($base . $uc['endpoint']) ?>" target="_blank"><?= esc($uc['endpoint']) ?></a>
        </div>
      <?php endforeach; ?>
    </div>
  </article>

  <article class="chapter" id="primeri">
    <div class="kicker"><?= lang('App.apiDocs.chapter') ?> VII</div>
    <h2 class="chapter-title"><?= lang('App.codeExamples.title') ?></h2>
    <p class="lede"><?= lang('App.codeExamples.subtitle') ?></p>
    <div class="code-bar">
      <div class="seg">
        <?php foreach (array_keys($code) as $j => $label): ?>
          <label class="seg-opt"><input type="radio" name="code" value="<?= $label ?>"<?= $j === 0 ? ' checked' : '' ?>><?= $label ?></label>
        <?php endforeach; ?>
      </div>
      <button type="button" class="btn btn-ghost" id="copyCode"><?= lang('App.apiDocs.copy_code') ?></button>
    </div>
    <?php foreach ($code as $label => $snippet): ?>
      <pre class="code-block" data-code="<?= $label ?>"<?= $label !== 'JavaScript' ? ' hidden' : '' ?>><?= esc($snippet) ?></pre>
    <?php endforeach; ?>
  </article>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
  const T = <?= json_encode(['copy' => lang('App.apiDocs.copy_code'), 'copied' => lang('App.apiDocs.copied')], JSON_UNESCAPED_UNICODE) ?>;
  const copyBtn = document.getElementById('copyCode');
  let current = 'JavaScript', copiedT;

  async function copy(text) {
    try { await navigator.clipboard.writeText(text); }
    catch (e) { const t = document.createElement('textarea'); t.value = text; document.body.appendChild(t); t.select(); document.execCommand('copy'); t.remove(); }
  }

  document.querySelectorAll('input[name="code"]').forEach(r => r.addEventListener('change', () => {
    current = r.value;
    document.querySelectorAll('[data-code]').forEach(pre => { pre.hidden = pre.dataset.code !== current; });
    copyBtn.textContent = T.copy;
  }));

  copyBtn.addEventListener('click', async () => {
    await copy(document.querySelector(`[data-code="${current}"]`).textContent);
    copyBtn.textContent = T.copied;
    clearTimeout(copiedT); copiedT = setTimeout(() => { copyBtn.textContent = T.copy; }, 2000);
  });

  document.querySelectorAll('[data-copy]').forEach(btn => btn.addEventListener('click', () => copy(btn.dataset.copy)));
})();
</script>
<?= $this->endSection() ?>
