# REFLECTION.md

A szűrés és rendezés követelményt szándékosan nyitva hagyta a feladat, így itt kellett dönteni az
implementáció módjáról. Az idő tényezőt és az egyszerűség elvét figyelembe véve az AI által
javasolt URL paraméter alapú, in-memory megoldás került elfogadásra: a lekért 20 feliratkozón
PHP szinten történik a szűrés email cím alapján és a rendezés kiválasztott mező szerint. Ez elkerüli
a felesleges API hívásokat, nem ütközik a rate limit korlátba, és az eredmény átlátható és
debuggolható marad.

A projekt három AI modell együttműködésével készült. A ChatGPT végezte az előfeldolgozást:
a feladat értelmezését, a dokumentációs struktúra felépítését és az implementációs terv
meghatározását. A Claude Sonnet 4.6 felelt a tényleges végrehajtásért: a kód megírásáért,
az API kutatásért és a hibakezelés kialakításáért. A Docker Gordon egy specifikus Dockerfile
hibát azonosított, amelyet Claude vezetett be egy üres `docker-php-ext-install` hívással.

Az AI-k legnagyobb hozzájárulása a kódbázis megírása, az ismeretlen API feltérképezése és
a hibakezelési architektúra kialakítása volt. Az emberi szerepkör főképp az architektúrális
döntések jóváhagyására, manuális tesztelésre és visszajelzésekre korlátozódott — a feladat
egyszerűsége ezt lehetővé tette. Korrekció volt szükséges a Dockerfile hibánál, a helyes API
base URL azonosításánál, valamint a `.env` újratöltési problémánál, amelyet a user észlelt,
nem az AI.

Ha újra csinálnám, a ChatGPT-re bízott előfeldolgozási és tervezési munkát is Claude-ra bíznám
— egy olcsóbb Claude modell elegendő lett volna a tervezési fázishoz, míg a végrehajtáshoz
a Sonnet maradt volna. Ez egységesebb kontextust és hatékonyabb együttműködést eredményezett
volna a két fázis között. Claude-ból jelenleg az ingyenes verzió áll számomra rendelkezésre, 
emiatt döntöttem elsőnek a ChatGPT előfeldolgozás mellett, hogy ne merítsem ki a rendelekzésre álló kevés kontextust.
Emellett az automatizált smoke teszteket a fejlesztés elejétől bevezettük volna, ne csak a végén.