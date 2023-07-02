# Laravel Labdarúgó-bajnokság

Egy fikcionális labdarúgó-bajnokságot kezelő webes alkalmazás, ahol böngészhetők és megfelelő jogosultság esetén szerkeszthetők az egyes csapatok és játékosok adatai, illetve a meccsek időpontjai és eseményei.

### Futtatás

-   A projekt klónozása után az init.bat fájl futtatásával a szükséges függőségek telepítése és a .env fájl létrehozása, az adatbázis létrehozása és feltöltése, valamint a szükséges kulcsok generálása automatikusan megtörténik, és az alkalmazás elindul. 

### Funkciók

-   **Adatbázis**

    -   `php artisan migrate:fresh --seed` parancs kiadásával feltöltött adatbázisban
        `userX@szerveroldali.hu` (ahol X eleme természetes számok) e-mail címmel és `password` jelszóval jönnek létre a felhasználók

    -   Egyetlen **admin** jogosultságú felhasználó van, akinek a bejelentkezési adatai:
        `admin@szerveroldali.hu` - `adminpwd`

-   **Főoldal**
    -   Egy statikus oldal, amelyen tájékoztatást kapunk arról, hogy milyen webhelyre érkeztünk
-   **Mérkőzések oldal**
    -   Az oldalon megjelenik az összes mérkőzés: a mérkőzésben részt vevő két csapat rövidítése, logója (ha van feltöltve, különben placeholder kép) és a meccs kezdési időpontja.
    -   A mérkőzések időrendi sorrendben jelennek meg
    -   A folyamatban lévő és befejezett mérkőzéseknél az aktuális eredmény is legyen látható!
    -   Egy adott mérkőzésre kattintva annak részletező oldalára jutunk.
-   **Mérkőzésrészletező oldal**
    -   Ezen az oldalon is láthatók a paraméterként kapott meccs alapvető adatai, illetve folyamatban lévő vagy befejezett mérkőzés esetén az eredmény is.
    -   Időrendi sorrendben megjelenik az adott meccshez tartozó összes esemény.
-   **Új esemény rögzítése**
    -   Az **admin** felhasználó számára a mérkőzésrészletező oldalról lehetőség van új esemény rögzítésére egy folyamatban lévő mérkőzéshez.
-   **Esemény visszavonása**
    -   Az **admin** felhasználó az egyes eseményeket vissza is vonhatja (törölheti), pl. téves rögzítés esetén.
    -   Visszavonni csak addig lehet eseményeket, amíg a meccs folyamatban van. Lezárt mérkőzés eseményeihez nem lehet hozzányúlni.
-   **Meccs lezárása**
    -   Az **admin** felhasználó számára a mérkőzésrészletező oldalról lehetőség van a meccs lezárására, tehát befejezetté nyilvánítására.
    -   A lezárt meccshez további esemény nem rögzíthető, illetve a meccs ezután nem jelenik meg a folyamatban lévő mérkőzések szekciójában.
-   **Új mérkőzés létrehozása**
    -   Az **admin** felhasználó új mérkőzéseket is kiírhat.
-   **Meglévő mérkőzés módosítása**
    -   Az **admin** felhasználó módosíthatja is a meglévő mérkőzéseket.
-   **Mérkőzés törlése**
    -   Az **admin** felhasználó törölheti is a meglévő mérkőzéseket, amennyiben még nincs esemény rögzítve az adott meccshez!
-   **Csapatok listája**
    -   Az oldalon megjelenik az összes csapat neve, rövidítése és logója (ha van feltöltve, különben placeholder kép).
    -   Az egyes csapatokra kattintva továbblépünk az adott csapat részletező oldalára.
-   **Csapatrészletező oldal**
    -   A csapat mérkőzései időrendi sorrendben.
    -   A csapatban lévő összes játékos adatai.
-   **Új csapat hozzáadása**
    -   Az **admin** tud új csapatot felvenni a bajnokságba. Ehhez meg kell adjon minden kötelező adatot, de logó feltöltése opcionális!
-   **Meglévő csapat módosítása**
    -   Az **admin** a csapat részletező oldaláról átlépve tudja módosítani is a felvett csapatok adatait és/vagy logóját.
-   **Új játékos felvétele**
    -   Az **admin** tud új játékost felvenni a csapatba annak részletező oldaláról indulva.
-   **Meglévő játékos törlése**
    -   Az **admin** tud törölni olyan játékosokat, akikhez nem tartozik még esemény egy meccsen sem.
-   **Tabella oldal**
    -   A tabella oldalon megjelenik a bajnokságban résztvevő összes csapat az elért pontszámuk szerinti sorrendben.
    -   Egy csapat pontszámát a befejezett mérkőzései alapján kell számítani a következő módon:
        -   nyert mérkőzés: +3 pont
        -   döntetlen: +1 pont
        -   vesztes mérkőzés: +0 pont
    -   Ha két csapat pontszáma a fentiek szerint azonos, akkor az kerül a sorrendben előrébb, akinek jobb a gólkülönbsége. Ha még mindig egyenlőség van, akkor a betűrendben előbb lévő csapat kerül feljebb a rangsorban.
-   **Kedvenceim oldal**
    -   Ez az oldal csak **bejelentkezett** felhasználók számára elérhető.
    -   A bejelentkezett felhasználók minden olyan helyen, ahol csapatnév vagy rövidítés szerepel (pl. meccsek, csapatok, tabella) kedvencnek tudják jelölni a csapatukat egy gombra vagy ikonra kattintva.
    -   A már kedvencnek jelölt csapat ugyanígy el is távolítható a kedvencek közül.
    -   A kedvenceim oldalon a bejelentkezett felhasználók csak azokat a mérkőzéseket látják, amelyben valamelyik kedvencnek jelölt csapatuk részt vesz.
