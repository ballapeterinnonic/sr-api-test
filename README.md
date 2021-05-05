# sr-api-test

**config.json**
```json
{
    "url": "http://demo.api.aurora.{{DOMAIN_ENDING}}",
    "auth": {
        "username": "",
        "password": ""
    }
}
```

**Running console command**

Mivel rushban lett csinálva ez a mini app és amúgyis csak max 2-3-szor kell felhasználni, így a futtatásához több dolgot is be kell állítani.

1. Vannak olyan resourceok, amikhez szükséges adatokat a FileSystemből szed. Ehhez

    - Ne legyen kommentbe a 31.sor `$fixtureRepository = new FilesystemFixtureRepository($rootDir . '/fixtures');`
    - Kommenteljük ki a 32. sort `$fixtureRepository = new HttpClientFixtureRepository($httpClient);`
    - Ne legyen kommentben a **productExtend** resourcetól a **attributeDescriptions** resourcig
    - Kommenteljük ki a **attributeWidgetCategoryRelations** resourcetól a **textAttributeValueDescriptions** resourcig
    - PHP verziótól függően, azaz, hogy hova mentse a responset a 33. sortban adjunk egy mappa nevet pl `$resultRepository = new FilesystemResultRepository($rootDir . '/var/php7_4');`
    - Futtatás a gyökérben (nem kell konténer): `php bin/console`

2. Vannak olyan resourceok, amikhez szükséges adatokat a dokumentáció átlal is felhasznált példákból nyeri (https://github.com/Shoprenter/sr-api-docs/tree/master/fixtures/api) HTTP-n keresztül.

    - Kommenteljük ki a 31.sort `$fixtureRepository = new FilesystemFixtureRepository($rootDir . '/fixtures');`
    - Ne legyen kommentbe a 32. sor `$fixtureRepository = new HttpClientFixtureRepository($httpClient);`
    - Kommenteljük ki a **productExtend** resourcetól a **attributeDescriptions** resourcig
    - Ne legyen kommentbe a **attributeWidgetCategoryRelations** resourcetól a **textAttributeValueDescriptions** resourcig
    - PHP verziótól függően, azaz, hogy hova mentse a responset a 33. sortban adjunk egy mappa nevet pl `$resultRepository = new FilesystemResultRepository($rootDir . '/var/php7_4');`
    - Futtatás a gyökérben (nem kell konténer): `php bin/console`