<?php

return [
    // Site metadata
    'site.title' => 'Српски Речник API',
    'site.version' => 'Верзија',
    'site.description' => 'Свеобухватни CodeIgniter4 API који служи српске речи, имена и презимена са подршком за латиницу и ћирилицу.',
    
    // Navigation
    'nav.home' => 'Почетна',
    'nav.api_docs' => 'API Документација',
    'nav.converter' => 'Конвертор',
    'nav.use_cases' => 'Примене',
    'nav.examples' => 'Примери',
    'nav.github' => 'GitHub',
    
    // Hero section
    'hero.title' => 'Српски Речник API',
    'hero.subtitle' => 'Свеобухватни CodeIgniter4 API који служи српске речи, имена и презимена са подршком за латиницу и ћирилицу.',
    'hero.getStarted' => 'Почните',
    'hero.viewDocs' => 'Погледајте документацију',
    
    // Stats
    'stats.words' => 'Речи',
    'stats.names' => 'Имена',
    'stats.surnames' => 'Презимена',
    'stats.scripts' => 'Писма',
    
    // API Documentation section
    'apiDocs.title' => 'API Документација',
    'apiDocs.params' => 'Параметри',
    'apiDocs.examples' => 'Примери',
    
    // API Endpoints
    'api.words.description' => 'Преузмите листу српских речи подељену на странице, са опцијама за филтрирање',
    'api.words.param.dataset' => 'Изаберите између малог (41K речи) или великог (2.8M речи) скупа података',
    'api.words.param.script' => 'Враћајте речи латиницом или ћирилицом',
    'api.words.param.starts_with' => 'Филтрирајте речи које почињу одређеним словима',
    'api.words.param.contains' => 'Филтрирајте речи које садрже одређени текст',
    'api.words.param.length' => 'Филтрирајте речи по тачној дужини',
    'api.words.param.min_length' => 'Филтрирајте речи са минималном дужином',
    'api.words.param.max_length' => 'Филтрирајте речи са максималном дужином',
    'api.words.param.random' => 'Примените насумични редослед резултата',
    'api.words.param.page' => 'Број странице за пагинацију (подразумевано: 1)',
    'api.words.param.limit' => 'Број резултата по страници (подразумевано: 50, max: 100)',
    'api.words.example.1' => 'Преузмите првих 10 речи из малог скупа података',
    'api.words.example.2' => 'Речи које почињу са "пре" у ћирилици',
    'api.words.example.3' => '20 насумичних речи са 5 слова',
    'api.words.example.4' => 'Речи које садрже "ов" са 6+ карактера',
    'api.words.example.5' => 'Кратке речи (≤4 знака) из великог скупа података',
    
    'api.names.description' => 'Преузмите српска имена са информацијама о роду и вокативним облицима',
    'api.names.param.gender' => 'Филтрирајте по мушком, женском или свим родовима',
    'api.names.param.starts_with' => 'Филтрирајте имена која почињу одређеним словима',
    'api.names.param.with_vocative' => 'Укључите вокативне облике у одговор',
    'api.names.param.random' => 'Примените насумични редослед резултата',
    'api.names.param.page' => 'Број странице за пагинацију',
    'api.names.param.limit' => 'Број резултата по страници',
    'api.names.example.1' => 'Преузмите 15 мушких имена',
    'api.names.example.2' => 'Имена која почињу са "М" са вокативним облицима',
    'api.names.example.3' => '5 насумичних женских имена',
    'api.names.example.4' => 'Друга страница имена са вокативима',
    
    'api.surnames.description' => 'Преузмите српска презимена са варијантама на латиници и ћирилици',
    'api.surnames.param.starts_with' => 'Филтрирајте презимена која почињу одређеним словима',
    'api.surnames.param.random' => 'Примените насумични редослед резултата',
    'api.surnames.param.page' => 'Број странице за пагинацију',
    'api.surnames.param.limit' => 'Број резултата по страници',
    'api.surnames.example.1' => 'Презимена која почињу са "Пет"',
    'api.surnames.example.2' => '20 насумичних презимена',
    'api.surnames.example.3' => 'Сва презимена која почињу са "Ж"',
    
    'api.transliterate.description' => 'Конвертујте текст између латинице и ћирилице',
    'api.transliterate.param.text' => 'Текст за транслитерацију (обавезно)',
    'api.transliterate.param.to' => 'Циљно писмо: latin или cyrillic (аутоматски детектује ако није наведено)',
    'api.transliterate.example.1' => 'Аутоматски детектуј и конвертуј "Здраво"',
    'api.transliterate.example.2' => 'Конвертуј мешовити текст у латиницу',
    'api.transliterate.example.3' => 'Конвертуј име у ћирилицу',
    
    'api.random.description' => 'Преузмите насумичан унос из било ког типа скупа података',
    'api.random.param.type' => 'Тип уноса: word, name или surname (обавезно)',
    'api.random.example.1' => 'Преузмите насумичну српску реч',
    'api.random.example.2' => 'Преузмите насумично српско име са вокативом',
    'api.random.example.3' => 'Преузмите насумично српско презиме',
    
    // Use Cases section
    'useCases.title' => 'Примене',
    'useCase.language.title' => 'Апликације за учење језика',
    'useCase.language.description' => 'Интегриши српски вокабулар у апликације за учење језика и картице са аутоматском транслитерацијом између писама.',
    'useCase.content.title' => 'Генерисање садржаја',
    'useCase.content.description' => 'Генериши реалистична српска имена и текст за тестирање, демо податке или креативне пројекте.',
    'useCase.localization.title' => 'Алати за локализацију',
    'useCase.localization.description' => 'Изградите алате који помажу у локализацији на српски језик, подржавајући и латиницу и ћирилицу.',
    'useCase.research.title' => 'Лингвистичка истраживања',
    'useCase.research.description' => 'Приступите свеобухватним скуповима података на српском језику за лингвистичку анализу, NLP пројекте и академска истраживања.',
    
    // Code Examples section
    'codeExamples.title' => 'Примери кода',
    'codeExamples.subtitle' => 'Брзи примери интеграције у популарним програмским језицима',
    
    // Features section
    'features.comprehensive.title' => 'Свеобухватна база података',
    'features.comprehensive.description' => 'Приступ екстензивним колекцијама српских речи, имена и презимена.',
    'features.bilingual.title' => 'Подршка за два писма',
    'features.bilingual.description' => 'Пуна подршка за латиницу и ћирилицу са аутоматском конверзијом.',
    'features.flexible.title' => 'Флексибилно филтрирање',
    'features.flexible.description' => 'Напредне опције филтрирања укључујући почетак, садржај, дужину и још.',
    'features.modern.title' => 'Модеран API',
    'features.modern.description' => 'RESTful API са JSON одговорима, пагинацијом и свеобухватном документацијом.',
    
    // Footer
    'footer.builtWith' => 'Направљено са',
    'footer.openSource' => 'Отворени код',
    'footer.license' => 'Лиценцирано под MIT',
    'footer.viewOnGithub' => 'Погледај на GitHub-у',
    
    // Converter page
    'converter.title' => 'Српски конвертор текста',
    'converter.description' => 'Конвертуј српски текст између латинице и ћирилице',
    'converter.direction.auto' => 'Аутоматска детекција',
    'converter.direction.latinToCyrillic' => 'Латиница → Ћирилица',
    'converter.direction.cyrillicToLatin' => 'Ћирилица → Латиница',
    'converter.input.label' => 'Улазни текст',
    'converter.input.placeholder' => 'Укуцајте или налепите српски текст овде...',
    'converter.output.label' => 'Излаз',
    'converter.output.placeholder' => 'Конвертовани текст ће се појавити овде...',
    'converter.button.copy' => 'Копирај текст',
    'converter.button.clear' => 'Обриши',
    'converter.button.swap' => 'Замени улаз и излаз',
    'converter.message.copied' => 'Копирано у clipboard!',
    'converter.message.cleared' => 'Текст обрисан!',
    'converter.feature.instant.title' => 'Тренутна конверзија',
    'converter.feature.instant.description' => 'Транслитерација у реалном времену док куцате',
    'converter.feature.bidirectional.title' => 'Двосмерна',
    'converter.feature.bidirectional.description' => 'Конвертуј између латинице и ћирилице без проблема',
    'converter.feature.accurate.title' => 'Прецизна',
    'converter.feature.accurate.description' => 'Чува специјалне карактере и дијакритике',
    'converter.feature.free.title' => 'Бесплатна за коришћење',
    'converter.feature.free.description' => 'Без регистрације или API кључа',
    
    // Language switcher
    'lang.english' => 'English',
    'lang.serbian_latin' => 'Srpski (latinica)',
    'lang.serbian_cyrillic' => 'Српски (ћирилица)',
];
