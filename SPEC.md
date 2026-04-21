# Próbafeladat leírás

## Mini integráció a SalesAutopilot API-jával

Bevezetés

Ez a feladat nem tökéletes kódot vár. Azt szeretnénk látni, hogyan gondolkodsz, hogyan kezeled az
ismeretlen API-t, hogyan használod az AI-t, és mit csinálsz, ha valami nincs pontosan meghatározva.

Időkeret: Nagyságrendileg 60 perc.

Stack: PHP, Docker (lásd lentebb)

Verziókezelés: GitHub repó — ide kerüljön minden deliverable

## Feladat

Készíts egy egyszerű, Dockerben futtatható PHP webalkalmazást, amely a SalesAutopilot REST API-
ját használja.

Technikai keret:

```
PHP (verzió: tetszőleges, de indokold meg a választást a REFLECTION.md-ben)
A projekt tartalmaz egy docker-compose.yml-t, amivel egyetlen paranccsal (docker compose
up) elindul az alkalmazás
Külső adatbázis nem szükséges — ha mégis használsz, az is Dockerben fusson
Az API kulcsot .env fájlból olvassa be az alkalmazás (.env.example legyen a repóban, a valódi
.env ne)
```
## Funkcionális követelmények

```
1. Az alkalmazás kérjen be egy SAPI API kulcspárt (felhasználónév + jelszó), vagy olvassa be .env-
ből.
2. Listázza ki az adott fiókban lévő listákat (listák neve, mérete, létrehozás dátuma).
3. Legyen lehetőség egy listát kiválasztani, és megnézni az első 20 feliratkozóját.
4. A listanézeten lehessen valamilyen formában szűrni vagy rendezni a feliratkozókat.
```
Hibakezelési követelmények

Az alkalmazásnak az alábbi eseteket mind le kell kezelnie — hogyan kommunikálod a felhasználónak,
azt te döntöd el, de minden esetben legyen valamilyen visszajelzés:

```
Az utolsó szándékosan van nyitva hagyva: mit jelent ez pontosan, azt ő dönti el.
```
```
Eset Amit várunk
```

## Amit a repóban várunk

AI_LOG.md — Az AI-val folytatott lényeges beszélgetések másolata vagy linkje, cenzúrázás nélkül.
Nem kell minden prompt, de a főbb döntési pontok legyenek benne: hogyan kérdeztél, hogyan javíttattál
hibát, hogyan jutottál el egy-egy megoldásig.

```
REFLECTION.md — 8–12 mondat az alábbiakról:
Hogyan értelmezted a 4. pont szűrés/rendezés követelményt, és miért pont úgy döntöttél?
Melyik AI modell-t használta és miért?
Hol segített az AI, hol kellett korrigálni vagy más modellt bevonni?
Mi az, amit ha újra csinálnád, másképp csinálnál?
```
Ne felejtsd el publikussá tenni a repo-t.

```
Érvénytelen / hibás API kulcs Érthető hibaüzenet, ne csak egy
fehér oldal vagy nyers JSON
Üres lista (0 feliratkozó) Ne törjön el, ne maradjon üres oldal
magyarázat nélkül
A SAPI API nem válaszol / timeout Graceful degradation — az
alkalmazás ne fagyjon be
Rate limit elérése (APIv2:
párhuzamos kérés tiltott)
```
```
1 /
2 ├── docker-compose.yml
3 ├── .env.example
4 ├── src/ ← PHP alkalmazás kódja
5 ├── AI_LOG.md ← AI conversation log (lásd lentebb)
6 └── REFLECTION.md ← Rövid összefoglaló (lásd lentebb)
```

