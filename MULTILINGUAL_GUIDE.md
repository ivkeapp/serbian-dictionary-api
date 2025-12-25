# Višejezična Podrška / Multilingual Support

## Pregled / Overview

Aplikacija sada podržava tri jezika:
- **Engleski (en)** - Podrazumevani jezik
- **Srpski Latinica (sr-Lat)** - Srpski jezik sa latiničnim pismom
- **Srpski Ćirilica (sr-Cyrl)** - Srpski jezik sa ćiriličnim pismom

The application now supports three languages:
- **English (en)** - Default language
- **Serbian Latin (sr-Lat)** - Serbian language with Latin script
- **Serbian Cyrillic (sr-Cyrl)** - Serbian language with Cyrillic script

---

## Struktura / Structure

### Jezički Fajlovi / Language Files

```
app/Language/
├── en/
│   └── App.php          # Engleski prevodi
├── sr-Lat/
│   └── App.php          # Srpski (latinica) prevodi
└── sr-Cyrl/
    └── App.php          # Srpski (ćirilica) prevodi
```

### Language Switcher Komponenta

Lokacija: `app/Views/components/language_switcher.php`

Ova komponenta prikazuje dropdown meni za izbor jezika i automatski se učitava u navigaciji.

---

## Upotreba / Usage

### U Kontrolerima / In Controllers

```php
// Koristi lang() funkciju za učitavanje prevoda
$data = [
    'title' => lang('App.site.title'),
    'description' => lang('App.site.description')
];
```

### U Pogledima / In Views

```php
<!-- Prikazivanje prevoda -->
<h1><?= lang('App.hero.title') ?></h1>
<p><?= lang('App.hero.subtitle') ?></p>

<!-- Uključivanje language switchera -->
<?= view('components/language_switcher') ?>
```

### Promena Jezika / Changing Language

Jezik se može promeniti klikom na language switcher ili pristupanjem URL-u:

```
/set-language/en        # Postavi na engleski
/set-language/sr-Lat    # Postavi na srpski latinicu
/set-language/sr-Cyrl   # Postavi na srpski ćirilicu
```

Jezik se čuva u sesiji i primenjuje na sve stranice.

---

## Dodavanje Novih Prevoda / Adding New Translations

### 1. Dodajte ključ u sve jezičke fajlove

**app/Language/en/App.php:**
```php
'new.key' => 'English translation',
```

**app/Language/sr-Lat/App.php:**
```php
'new.key' => 'Prevod na srpskom (latinica)',
```

**app/Language/sr-Cyrl/App.php:**
```php
'new.key' => 'Превод на српском (ћирилица)',
```

### 2. Koristite ključ u kodu

```php
<?= lang('App.new.key') ?>
```

---

## Važne Napomene / Important Notes

### Primeri Koda / Code Examples

**Primeri koda (unutar `<code>` ili `<pre>` tagova) NE smeju biti prevođeni.**
Oni treba da ostanu na engleskom bez obzira na izabrani jezik.

Code examples (inside `<code>` or `<pre>` tags) should NOT be translated.
They should remain in English regardless of the selected language.

### Fallback

Ako prevod za određeni jezik ne postoji, aplikacija će automatski koristiti engleski prevod.

If a translation doesn't exist for a specific language, the application will automatically use the English translation.

### Session

Izabrani jezik se čuva u sesiji pod ključem `'locale'`.

The selected language is stored in the session under the key `'locale'`.

---

## Testiranje / Testing

### 1. Pokrenite aplikaciju / Start the application

```bash
php spark serve
```

### 2. Otvorite u browseru / Open in browser

```
http://localhost:8080
```

### 3. Testirajte language switcher

- Kliknite na ikonu globusa u navigaciji
- Izaberite različite jezike
- Proverite da li se svi tekstovi pravilno menjaju

### 4. Proverite sve stranice

- Homepage (`/`)
- Converter (`/converter`)
- API dokumentacija

---

## Konfiguracija / Configuration

### Podržani Jezici

Konfigurisano u `app/Config/App.php`:

```php
public string $defaultLocale = 'en';
public array $supportedLocales = ['en', 'sr-Lat', 'sr-Cyrl'];
```

### BaseController

`app/Controllers/BaseController.php` automatski postavlja jezik iz sesije:

```php
public function initController(...)
{
    parent::initController($request, $response, $logger);
    
    $session = session();
    $locale = $session->get('locale') ?? 'en';
    $request->setLocale($locale);
    service('language')->setLocale($locale);
}
```

---

## Struktura Prevoda / Translation Structure

### Kategorije

- **site** - Osnovne informacije o sajtu
- **nav** - Navigacioni elementi
- **hero** - Hero sekcija
- **stats** - Statistike
- **apiDocs** - API dokumentacija
- **api.*** - Detalji API endpoint-a
- **useCases** - Primene
- **codeExamples** - Primeri koda
- **features** - Karakteristike
- **footer** - Footer
- **converter** - Converter stranica
- **lang** - Nazivi jezika

---

## Troubleshooting

### Problem: Prevodi se ne prikazuju

**Rešenje:**
1. Proverite da li jezički fajl postoji u `app/Language/{locale}/App.php`
2. Proverite da li ključ prevoda postoji u fajlu
3. Očistite keš: `php spark cache:clear`

### Problem: Language switcher ne radi

**Rešenje:**
1. Proverite da li je ruta `/set-language/(:segment)` definisana u `app/Config/Routes.php`
2. Proverite da li metoda `setLanguage()` postoji u `Home` kontroleru
3. Proverite da li je sesija omogućena

### Problem: Jezik se ne čuva između stranica

**Rešenje:**
1. Proverite da li je sesija pravilno konfigurisan u `app/Config/App.php`
2. Proverite da li `writable/session` direktorijum postoji i ima prava za upis
3. Proverite da li `BaseController` pravilno učitava jezik iz sesije

---

## License

MIT License - isti kao i glavni projekat
