<?php

return [
    // Site metadata
    'site.title' => 'Srpski Rečnik API',
    'site.version' => 'Verzija',
    'site.description' => 'Sveobuhvatni CodeIgniter4 API koji služi srpske reči, imena i prezimena sa podrškom za latinicu i ćirilicu.',
    
    // Navigation
    'nav.home' => 'Početna',
    'nav.api_docs' => 'API Dokumentacija',
    'nav.converter' => 'Konvertor',
    'nav.use_cases' => 'Primene',
    'nav.examples' => 'Primeri',
    'nav.github' => 'GitHub',
    
    // Hero section
    'hero.title' => 'Srpski Rečnik API',
    'hero.subtitle' => 'Sveobuhvatni CodeIgniter4 API koji služi srpske reči, imena i prezimena sa podrškom za latinicu i ćirilicu.',
    'hero.getStarted' => 'Počnite',
    'hero.viewDocs' => 'Pogledajte dokumentaciju',
    
    // Stats
    'stats.words' => 'Reči',
    'stats.names' => 'Imena',
    'stats.surnames' => 'Prezimena',
    'stats.scripts' => 'Pisma',
    
    // API Documentation section
    'apiDocs.title' => 'API Dokumentacija',
    'apiDocs.params' => 'Parametri',
    'apiDocs.examples' => 'Primeri',
    
    // API Endpoints
    'api.words.description' => 'Dobijte paginiranu listu srpskih reči sa opcijama za filtriranje',
    'api.words.param.dataset' => 'Izaberite između malog (41K reči) ili velikog (2.8M reči) skupa podataka',
    'api.words.param.script' => 'Vraćajte reči latinicom ili ćirilicom',
    'api.words.param.starts_with' => 'Filtrirajte reči koje počinju određenim slovima',
    'api.words.param.contains' => 'Filtrirajte reči koje sadrže određeni tekst',
    'api.words.param.length' => 'Filtrirajte reči po tačnoj dužini',
    'api.words.param.min_length' => 'Filtrirajte reči sa minimalnom dužinom',
    'api.words.param.max_length' => 'Filtrirajte reči sa maksimalnom dužinom',
    'api.words.param.random' => 'Randomizujte redosled rezultata',
    'api.words.param.page' => 'Broj stranice za paginaciju (podrazumevano: 1)',
    'api.words.param.limit' => 'Broj rezultata po stranici (podrazumevano: 50, max: 100)',
    'api.words.example.1' => 'Dobijte prvih 10 reči iz malog skupa podataka',
    'api.words.example.2' => 'Reči koje počinju sa "pre" u ćirilici',
    'api.words.example.3' => '20 nasumičnih reči sa 5 slova',
    'api.words.example.4' => 'Reči koje sadrže "ov" sa 6+ karaktera',
    'api.words.example.5' => 'Kratke reči (≤4 znaka) iz velikog skupa podataka',
    
    'api.names.description' => 'Dobijte srpska imena sa informacijama o rodu i vokativnim oblicima',
    'api.names.param.gender' => 'Filtrirajte po muškom, ženskom ili svim rodovima',
    'api.names.param.starts_with' => 'Filtrirajte imena koja počinju određenim slovima',
    'api.names.param.with_vocative' => 'Uključite vokativne oblike u odgovor',
    'api.names.param.random' => 'Randomizujte redosled rezultata',
    'api.names.param.page' => 'Broj stranice za paginaciju',
    'api.names.param.limit' => 'Broj rezultata po stranici',
    'api.names.example.1' => 'Dobijte 15 muških imena',
    'api.names.example.2' => 'Imena koja počinju sa "M" sa vokativnim oblicima',
    'api.names.example.3' => '5 nasumičnih ženskih imena',
    'api.names.example.4' => 'Druga stranica imena sa vokativima',
    
    'api.surnames.description' => 'Dobijte srpska prezimena sa varijantama na latinici i ćirilici',
    'api.surnames.param.starts_with' => 'Filtrirajte prezimena koja počinju određenim slovima',
    'api.surnames.param.random' => 'Randomizujte redosled rezultata',
    'api.surnames.param.page' => 'Broj stranice za paginaciju',
    'api.surnames.param.limit' => 'Broj rezultata po stranici',
    'api.surnames.example.1' => 'Prezimena koja počinju sa "Pet"',
    'api.surnames.example.2' => '20 nasumičnih prezimena',
    'api.surnames.example.3' => 'Sva prezimena koja počinju sa "Ž"',
    
    'api.transliterate.description' => 'Konvertujte tekst između latinice i ćirilice',
    'api.transliterate.param.text' => 'Tekst za transliteraciju (obavezno)',
    'api.transliterate.param.to' => 'Ciljno pismo: latin ili cyrillic (automatski detektuje ako nije navedeno)',
    'api.transliterate.example.1' => 'Automatski detektuj i konvertuj "Zdravo"',
    'api.transliterate.example.2' => 'Konvertuj mešoviti tekst u latinicu',
    'api.transliterate.example.3' => 'Konvertuj ime u ćirilicu',
    
    'api.random.description' => 'Dobijte nasumičan unos iz bilo kog tipa skupa podataka',
    'api.random.param.type' => 'Tip unosa: word, name ili surname (obavezno)',
    'api.random.example.1' => 'Dobijte nasumičnu srpsku reč',
    'api.random.example.2' => 'Dobijte nasumično srpsko ime sa vokativom',
    'api.random.example.3' => 'Dobijte nasumično srpsko prezime',
    
    // Use Cases section
    'useCases.title' => 'Primene',
    'useCase.language.title' => 'Aplikacije za učenje jezika',
    'useCase.language.description' => 'Integriši srpski vokabular u aplikacije za učenje jezika i kartice sa automatskom transliteracijom između pisama.',
    'useCase.content.title' => 'Generisanje sadržaja',
    'useCase.content.description' => 'Generiši realistična srpska imena i tekst za testiranje, demo podatke ili kreativne projekte.',
    'useCase.localization.title' => 'Alati za lokalizaciju',
    'useCase.localization.description' => 'Izgradite alate koji pomažu u lokalizaciji na srpski jezik, podržavajući i latinicu i ćirilicu.',
    'useCase.research.title' => 'Lingvistička istraživanja',
    'useCase.research.description' => 'Pristupite sveobuhvatnim skupovima podataka na srpskom jeziku za lingvističku analizu, NLP projekte i akademska istraživanja.',
    
    // Code Examples section
    'codeExamples.title' => 'Primeri koda',
    'codeExamples.subtitle' => 'Brzi primeri integracije u popularnim programskim jezicima',
    
    // Features section
    'features.comprehensive.title' => 'Sveobuhvatna baza podataka',
    'features.comprehensive.description' => 'Pristup ekstenzivnim kolekcijama srpskih reči, imena i prezimena.',
    'features.bilingual.title' => 'Podrška za dva pisma',
    'features.bilingual.description' => 'Puna podrška za latinicu i ćirilicu sa automatskom konverzijom.',
    'features.flexible.title' => 'Fleksibilno filtriranje',
    'features.flexible.description' => 'Napredne opcije filtriranja uključujući početak, sadržaj, dužinu i još.',
    'features.modern.title' => 'Moderan API',
    'features.modern.description' => 'RESTful API sa JSON odgovorima, paginacijom i sveobuhvatnom dokumentacijom.',
    
    // Footer
    'footer.builtWith' => 'Napravljeno sa',
    'footer.openSource' => 'Otvoreni kod',
    'footer.license' => 'Licencirano pod MIT',
    'footer.viewOnGithub' => 'Pogledaj na GitHub-u',
    
    // Converter page
    'converter.title' => 'Srpski konvertor teksta',
    'converter.description' => 'Konvertuj srpski tekst između latinice i ćirilice',
    'converter.direction.auto' => 'Automatska detekcija',
    'converter.direction.latinToCyrillic' => 'Latinica → Ćirilica',
    'converter.direction.cyrillicToLatin' => 'Ćirilica → Latinica',
    'converter.input.label' => 'Ulazni tekst',
    'converter.input.placeholder' => 'Ukucajte ili nalepite srpski tekst ovde...',
    'converter.output.label' => 'Izlaz',
    'converter.output.placeholder' => 'Konvertovani tekst će se pojaviti ovde...',
    'converter.button.copy' => 'Kopiraj tekst',
    'converter.button.clear' => 'Obriši',
    'converter.button.swap' => 'Zameni ulaz i izlaz',
    'converter.message.copied' => 'Kopirano u clipboard!',
    'converter.message.cleared' => 'Tekst obrisan!',
    'converter.feature.instant.title' => 'Trenutna konverzija',
    'converter.feature.instant.description' => 'Transliteracija u realnom vremenu dok kucate',
    'converter.feature.bidirectional.title' => 'Dvosmerna',
    'converter.feature.bidirectional.description' => 'Konvertuj između latinice i ćirilice bez problema',
    'converter.feature.accurate.title' => 'Precizna',
    'converter.feature.accurate.description' => 'Čuva specijalne karaktere i dijakritike',
    'converter.feature.free.title' => 'Besplatna za korišćenje',
    'converter.feature.free.description' => 'Bez registracije ili API ključa',
    
    // Language switcher
    'lang.english' => 'English',
    'lang.serbian_latin' => 'Srpski (latinica)',
    'lang.serbian_cyrillic' => 'Српски (ćirilica)',
];
