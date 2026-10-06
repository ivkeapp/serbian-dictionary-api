<?= $this->extend('layouts/main') ?>

<?php
$copyIcon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>';
$directions = [
    'auto'              => lang('App.converter.direction.auto'),
    'latin-to-cyrillic' => lang('App.converter.direction.latinToCyrillic'),
    'cyrillic-to-latin' => lang('App.converter.direction.cyrillicToLatin'),
];
?>

<?= $this->section('content') ?>
<section class="converter">
  <div class="hero">
    <div class="kicker"><?= lang('App.converter.kicker') ?></div>
    <h1><?= lang('App.converter.title') ?></h1>
    <p class="lede"><?= lang('App.converter.description') ?></p>
  </div>

  <div class="direction-row">
    <div class="seg seg-lg" role="radiogroup">
      <?php foreach ($directions as $value => $label): ?>
        <label class="seg-opt"><input type="radio" name="dir" value="<?= $value ?>"<?= $value === 'auto' ? ' checked' : '' ?>><?= $label ?></label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="panes-clip">
    <div class="panes">
      <div class="pane">
        <div class="pane-head">
          <span class="pane-title"><?= lang('App.converter.input.label') ?></span>
          <span class="label-caps" id="inLabel"><?= lang('App.converter.script.auto') ?></span>
        </div>
        <textarea id="convIn" placeholder="<?= esc(lang('App.converter.input.placeholder')) ?>" spellcheck="false"></textarea>
        <div class="pane-count" id="inCount"></div>
      </div>
      <div class="pane">
        <div class="pane-head">
          <span class="pane-title"><?= lang('App.converter.output.label') ?></span>
          <span class="label-caps" id="outLabel"><?= lang('App.converter.script.auto') ?></span>
        </div>
        <textarea id="convOut" readonly title="<?= esc(lang('App.converter.output.copy_hint')) ?>" placeholder="<?= esc(lang('App.converter.output.placeholder')) ?>"></textarea>
        <div class="pane-count" id="outCount"></div>
      </div>
    </div>
  </div>

  <div class="converter-actions">
    <button type="button" class="btn btn-primary" id="copyBtn"><?= $copyIcon ?> <?= lang('App.converter.button.copy') ?></button>
    <button type="button" class="btn btn-secondary" id="swapBtn" title="<?= esc(lang('App.converter.button.swap')) ?>">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/></svg>
      <?= lang('App.converter.button.swap_short') ?>
    </button>
    <button type="button" class="btn btn-secondary" id="clearBtn">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      <?= lang('App.converter.button.clear') ?>
    </button>
  </div>
  <div class="status" id="status"></div>
  <div class="shortcuts"><?= lang('App.converter.shortcuts') ?></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
  // Same-origin path so requests always go to the domain serving this page
  const ENDPOINT = <?= json_encode(parse_url(base_url('converter/translate'), PHP_URL_PATH)) ?>;
  const T = <?= json_encode([
      'latin'          => lang('App.converter.script.latin'),
      'cyrillic'       => lang('App.converter.script.cyrillic'),
      'auto'           => lang('App.converter.script.auto'),
      'autoSuffix'     => lang('App.converter.script.auto_suffix'),
      'one'            => lang('App.converter.count.one'),
      'few'            => lang('App.converter.count.few'),
      'many'           => lang('App.converter.count.many'),
      'copied'         => lang('App.converter.message.copied'),
      'cleared'        => lang('App.converter.message.cleared'),
      'nothingToCopy'  => lang('App.converter.message.nothing_to_copy'),
      'nothingToSwap'  => lang('App.converter.message.nothing_to_swap'),
      'swapped'        => lang('App.converter.message.swapped'),
      'error'          => lang('App.converter.message.error'),
      'unknownError'   => lang('App.converter.message.unknown_error'),
      'connection'     => lang('App.converter.message.connection_error'),
  ], JSON_UNESCAPED_UNICODE) ?>;

  const $ = id => document.getElementById(id);
  const inEl = $('convIn'), outEl = $('convOut'), statusEl = $('status');
  let dir = 'auto', detected = null, typeT, statusT;

  const plural = n => { const m10 = n % 10, m100 = n % 100; return m10 === 1 && m100 !== 11 ? T.one : (m10 >= 2 && m10 <= 4 && (m100 < 12 || m100 > 14)) ? T.few : T.many; };
  const scriptName = sc => sc === 'cyrillic' ? T.cyrillic : T.latin;

  function render() {
    let inLabel, outLabel;
    if (dir === 'latin-to-cyrillic') { inLabel = T.latin; outLabel = T.cyrillic; }
    else if (dir === 'cyrillic-to-latin') { inLabel = T.cyrillic; outLabel = T.latin; }
    else if (detected) { inLabel = scriptName(detected) + ' · ' + T.autoSuffix; outLabel = scriptName(detected === 'cyrillic' ? 'latin' : 'cyrillic'); }
    else { inLabel = T.auto; outLabel = T.auto; }
    $('inLabel').textContent = inLabel;
    $('outLabel').textContent = outLabel;
    $('inCount').textContent = `${inEl.value.length} ${plural(inEl.value.length)}`;
    $('outCount').textContent = `${outEl.value.length} ${plural(outEl.value.length)}`;
  }

  function showStatus(text, isError) {
    statusEl.textContent = text;
    statusEl.classList.toggle('is-error', !!isError);
    clearTimeout(statusT); statusT = setTimeout(() => { statusEl.textContent = ''; }, 3000);
  }

  async function transliterate() {
    const text = inEl.value.trim();
    if (!text) { outEl.value = ''; detected = null; render(); return; }
    try {
      const r = await fetch(ENDPOINT, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ text, direction: dir }) });
      if (!r.ok) throw new Error('HTTP ' + r.status);
      const d = await r.json();
      if (d.success) { outEl.value = d.data.transliterated; detected = d.data.detected_script; }
      else showStatus(T.error + (d.error || T.unknownError), true);
    } catch (e) {
      showStatus(T.connection, true);
    }
    render();
  }

  async function copyOut() {
    if (!outEl.value) return showStatus(T.nothingToCopy, true);
    try { await navigator.clipboard.writeText(outEl.value); }
    catch (e) { outEl.select(); document.execCommand('copy'); }
    showStatus(T.copied);
  }

  function setDir(value) {
    dir = value;
    document.querySelectorAll('input[name="dir"]').forEach(r => { r.checked = r.value === dir; });
  }

  function swap() {
    if (!inEl.value && !outEl.value) return showStatus(T.nothingToSwap, true);
    [inEl.value, outEl.value] = [outEl.value, inEl.value];
    setDir(dir === 'latin-to-cyrillic' ? 'cyrillic-to-latin' : dir === 'cyrillic-to-latin' ? 'latin-to-cyrillic' : 'auto');
    transliterate();
    showStatus(T.swapped);
  }

  function clearAll() {
    inEl.value = ''; outEl.value = ''; detected = null;
    render(); inEl.focus();
    showStatus(T.cleared);
  }

  inEl.addEventListener('input', () => { render(); clearTimeout(typeT); typeT = setTimeout(transliterate, 300); });
  outEl.addEventListener('click', copyOut);
  $('copyBtn').addEventListener('click', copyOut);
  $('swapBtn').addEventListener('click', swap);
  $('clearBtn').addEventListener('click', clearAll);
  document.querySelectorAll('input[name="dir"]').forEach(r => r.addEventListener('change', () => { setDir(r.value); transliterate(); }));
  document.addEventListener('keydown', e => {
    if (!(e.ctrlKey || e.metaKey)) return;
    if (e.key === 'Enter') { e.preventDefault(); transliterate(); }
    if (e.key === 'l' || e.key === 'L') { e.preventDefault(); clearAll(); }
  });

  render();
})();
</script>
<?= $this->endSection() ?>
