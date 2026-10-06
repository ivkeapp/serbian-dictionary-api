<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="search-page">
  <div class="hero">
    <div class="flag" title="<?= lang('App.search.flag') ?>"></div>
    <div class="kicker"><?= lang('App.search.kicker') ?></div>
    <h1><?= lang('App.search.heading') ?></h1>
    <p class="lede"><?= lang('App.search.tagline') ?></p>
  </div>

  <div class="search-box" id="searchBox">
    <label class="search-field">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-600)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      <input id="searchInput" type="text" placeholder="<?= esc(lang('App.search.placeholder')) ?>" autocomplete="off" autofocus spellcheck="false">
      <button type="button" class="unbutton search-clear" id="clearBtn" title="<?= esc(lang('App.search.clear')) ?>" hidden>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </label>

    <div class="suggestions" id="suggestions" hidden>
      <div class="suggestions-msg" id="suggestionsMsg" hidden></div>
      <div id="suggestionsList"></div>
      <div class="suggestions-hints" id="suggestionsHints" hidden>
        <span><?= lang('App.search.hint_select') ?></span><span><?= lang('App.search.hint_open') ?></span><span><?= lang('App.search.hint_close') ?></span>
      </div>
    </div>
  </div>

  <div class="examples" id="examples">
    <span class="examples-label"><?= lang('App.search.try_examples') ?></span>
    <?php foreach (['kuća', 'majka', 'sunce', 'ljubav', 'sreća'] as $word): ?>
      <button type="button" class="unbutton example-word" data-word="<?= $word ?>"><?= $word ?></button>
    <?php endforeach; ?>
  </div>

  <div class="random-row">
    <button type="button" class="btn btn-ghost" id="randomBtn">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m18 14 4 4-4 4"/><path d="m18 2 4 4-4 4"/><path d="M2 18h1.973a4 4 0 0 0 3.3-1.7l5.454-8.6a4 4 0 0 1 3.3-1.7H22"/><path d="M2 6h1.972a4 4 0 0 1 3.6 2.2"/><path d="M22 18h-6.041a4 4 0 0 1-3.3-1.8l-.359-.45"/></svg>
      <?= lang('App.search.random') ?>
    </button>
  </div>

  <article class="entry" id="entry" hidden>
    <div class="rule-title"><span><?= lang('App.search.result_title') ?></span></div>

    <div class="entry-grid">
      <div>
        <div class="label-caps"><?= lang('App.search.latin') ?></div>
        <div class="entry-word">
          <h2 id="entryLatin"></h2>
          <button type="button" class="btn btn-ghost btn-muted" data-copy="latin" title="<?= esc(lang('App.search.copy')) ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
          </button>
        </div>
      </div>
      <div>
        <div class="label-caps"><?= lang('App.search.cyrillic') ?></div>
        <div class="entry-word">
          <h2 class="is-cyr" id="entryCyrillic"></h2>
          <button type="button" class="btn btn-ghost btn-muted" data-copy="cyrillic" title="<?= esc(lang('App.search.copy')) ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
          </button>
        </div>
      </div>
    </div>

    <div class="flash" id="copiedMsg" hidden></div>

    <div class="similar" id="similar" hidden>
      <div class="similar-title"><?= lang('App.search.similar_words') ?></div>
      <div class="similar-list" id="similarList"></div>
    </div>
  </article>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
  // Same-origin path (e.g. "/api") so requests always go to the domain serving this page
  const API_BASE = <?= json_encode(parse_url(base_url('api'), PHP_URL_PATH)) ?>;
  const T = <?= json_encode([
      'loading'   => lang('App.search.loading'),
      'noResults' => lang('App.search.no_results_for'),
      'copied'    => lang('App.search.copied'),
  ], JSON_UNESCAPED_UNICODE) ?>;

  const L2C = {a:'а',b:'б',v:'в',g:'г',d:'д',đ:'ђ',e:'е',ž:'ж',z:'з',i:'и',j:'ј',k:'к',l:'л',lj:'љ',m:'м',n:'н',nj:'њ',o:'о',p:'п',r:'р',s:'с',t:'т',ć:'ћ',u:'у',f:'ф',h:'х',c:'ц',č:'ч',dž:'џ',š:'ш'};
  const C2L = Object.fromEntries(Object.entries(L2C).map(([k, v]) => [v, k]));
  const isCyr = t => /[Ѐ-ӿ]/.test(t);
  function toCyr(t) {
    let o = '';
    for (let i = 0; i < t.length; i++) {
      const two = t.substr(i, 2), tl = two.toLowerCase();
      if (L2C[tl] && tl.length === 2) { const c = L2C[tl]; o += two[0] !== two[0].toLowerCase() ? c.toUpperCase() : c; i++; continue; }
      const ch = t[i], lc = ch.toLowerCase();
      o += L2C[lc] ? (ch !== lc ? L2C[lc].toUpperCase() : L2C[lc]) : ch;
    }
    return o;
  }
  function toLat(t) {
    return [...t].map(ch => { const lc = ch.toLowerCase(), l = C2L[lc]; if (!l) return ch; return ch !== lc ? l[0].toUpperCase() + l.slice(1) : l; }).join('');
  }

  const $ = id => document.getElementById(id);
  const input = $('searchInput'), clearBtn = $('clearBtn'), box = $('suggestions'), msg = $('suggestionsMsg'),
        list = $('suggestionsList'), hints = $('suggestionsHints'), examples = $('examples'), entryEl = $('entry'),
        copiedEl = $('copiedMsg'), similarEl = $('similar'), similarList = $('similarList'), randomBtn = $('randomBtn');

  let suggestions = [], sel = -1, token = 0, lastQ = '', entry = null, debounceT, copiedT;

  const wordOf = it => it.latin || it.word || String(it);

  async function getJSON(url) { const r = await fetch(url); if (!r.ok) throw new Error(r.status); return r.json(); }
  async function words(params) {
    const d = await getJSON(`${API_BASE}/words?${new URLSearchParams(params)}`);
    return d.data || [];
  }

  // ── Suggestions dropdown ──
  function showMessage(text) {
    list.replaceChildren(); hints.hidden = true;
    msg.textContent = text; msg.hidden = false; box.hidden = false;
  }
  function closeBox() { box.hidden = true; }

  function highlight(w) {
    const span = document.createElement('span');
    span.className = 'suggestion-word';
    const i = lastQ ? w.toLowerCase().indexOf(lastQ.toLowerCase()) : -1;
    if (i < 0) { span.textContent = w; return span; }
    const strong = document.createElement('strong');
    strong.textContent = w.slice(i, i + lastQ.length);
    span.append(w.slice(0, i), strong, w.slice(i + lastQ.length));
    return span;
  }

  function renderSuggestions() {
    msg.hidden = true;
    list.replaceChildren(...suggestions.map((it, i) => {
      const row = document.createElement('div');
      row.className = 'suggestion' + (i === sel ? ' is-active' : '');
      const cyr = document.createElement('span');
      cyr.className = 'suggestion-cyr';
      cyr.textContent = it.cyrillic || '';
      row.append(highlight(wordOf(it)), cyr);
      row.addEventListener('mousedown', e => { e.preventDefault(); openWord(null, it); });
      row.addEventListener('mouseenter', () => setSel(i));
      return row;
    }));
    hints.hidden = !suggestions.length;
    box.hidden = !suggestions.length;
  }
  function setSel(i) {
    sel = i;
    [...list.children].forEach((row, j) => row.classList.toggle('is-active', j === sel));
  }

  async function suggest(raw) {
    const q = isCyr(raw) ? toLat(raw) : raw;
    const my = ++token;
    if (!suggestions.length) showMessage(T.loading);
    let items = [];
    try {
      items = await words({ starts_with: q, limit: 6 });
      if (!items.length) items = await words({ contains: q, limit: 6 });
    } catch (e) { console.error('Search error:', e); }
    if (my !== token) return;
    lastQ = q;
    suggestions = items.slice(0, 6);
    sel = suggestions.length ? 0 : -1;
    if (suggestions.length) renderSuggestions();
    else { showMessage(T.noResults.replace('{q}', raw)); }
  }

  // ── Entry ──
  async function openWord(word, known) {
    const latin = word && isCyr(word) ? toLat(word) : word;
    let item = known;
    if (!item) {
      try { const l = await words({ starts_with: latin, limit: 6 }); item = l.find(w => wordOf(w) === latin) || l[0]; } catch (e) {}
      item = item || { latin, cyrillic: toCyr(latin) };
    }
    const lat = wordOf(item), cyr = item.cyrillic || toCyr(lat);
    entry = { latin: lat, cyrillic: cyr };
    input.value = lat; clearBtn.hidden = false;
    token++; closeBox();
    $('entryLatin').textContent = lat;
    $('entryCyrillic').textContent = cyr;
    entryEl.hidden = false; examples.hidden = true;
    copiedEl.hidden = true; similarEl.hidden = true;
    history.replaceState(null, '', '#/rec/' + encodeURIComponent(lat));
    if (lat.length < 2) return;
    try {
      const l = await words({ starts_with: lat.substring(0, Math.min(3, lat.length)), limit: 10 });
      renderSimilar(l.filter(w => wordOf(w) !== lat).slice(0, 5));
    } catch (e) { console.error(e); }
  }

  function renderSimilar(items) {
    similarList.replaceChildren(...items.map(it => {
      const lat = wordOf(it);
      const btn = document.createElement('button');
      btn.type = 'button'; btn.className = 'unbutton similar-item';
      const a = document.createElement('span'); a.className = 'lat'; a.textContent = lat;
      const b = document.createElement('span'); b.className = 'cyr'; b.textContent = it.cyrillic || '';
      btn.append(a, b);
      btn.addEventListener('click', () => { openWord(null, { latin: lat, cyrillic: it.cyrillic }); window.scrollTo({ top: 0, behavior: 'smooth' }); });
      return btn;
    }));
    similarEl.hidden = !items.length;
  }

  function clearQuery() {
    input.value = ''; clearBtn.hidden = true;
    token++; suggestions = []; closeBox();
    entry = null; entryEl.hidden = true; examples.hidden = false;
    history.replaceState(null, '', location.pathname + location.search);
    input.focus();
  }

  async function copy(text) {
    try { await navigator.clipboard.writeText(text); }
    catch (e) { const t = document.createElement('textarea'); t.value = text; document.body.appendChild(t); t.select(); document.execCommand('copy'); t.remove(); }
  }

  // ── Events ──
  input.addEventListener('input', () => {
    const v = input.value;
    clearBtn.hidden = !v;
    clearTimeout(debounceT);
    if (v.trim().length >= 2) debounceT = setTimeout(() => suggest(v.trim()), 250);
    else { token++; suggestions = []; closeBox(); }
  });
  input.addEventListener('focus', () => { if (input.value.trim().length >= 2 && suggestions.length) renderSuggestions(); });
  input.addEventListener('blur', closeBox);
  input.addEventListener('keydown', e => {
    const n = suggestions.length;
    if (e.key === 'ArrowDown' && n) { e.preventDefault(); renderSuggestions(); setSel((sel + 1) % n); }
    else if (e.key === 'ArrowUp' && n) { e.preventDefault(); renderSuggestions(); setSel((sel - 1 + n) % n); }
    else if (e.key === 'Enter') {
      e.preventDefault();
      if (!box.hidden && sel >= 0 && suggestions[sel]) openWord(null, suggestions[sel]);
      else if (input.value.trim()) openWord(input.value.trim());
    }
    else if (e.key === 'Escape') closeBox();
  });
  clearBtn.addEventListener('click', clearQuery);

  document.querySelectorAll('.example-word').forEach(el => el.addEventListener('click', () => openWord(el.dataset.word)));

  randomBtn.addEventListener('click', async () => {
    randomBtn.disabled = true;
    let item;
    try {
      const d = await getJSON(`${API_BASE}/random?type=word`);
      const v = d.data ?? d; item = Array.isArray(v) ? v[0] : v;
      if (typeof item === 'string') item = { latin: item };
    } catch (e) { console.error('Random word error:', e); }
    randomBtn.disabled = false;
    if (item) openWord(null, item);
  });

  document.querySelectorAll('[data-copy]').forEach(btn => btn.addEventListener('click', async () => {
    if (!entry) return;
    const text = entry[btn.dataset.copy];
    await copy(text);
    copiedEl.textContent = T.copied.replace('{w}', text); copiedEl.hidden = false;
    clearTimeout(copiedT); copiedT = setTimeout(() => { copiedEl.hidden = true; }, 2000);
  }));

  // Deep link: #/rec/<word>
  function route() {
    const m = decodeURIComponent(location.hash.replace(/^#\/?/, '')).match(/^rec\/(.+)$/);
    if (m && (!entry || entry.latin !== m[1])) openWord(m[1]);
  }
  window.addEventListener('hashchange', route);
  route();
})();
</script>
<?= $this->endSection() ?>
