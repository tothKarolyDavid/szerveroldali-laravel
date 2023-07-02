@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Kezdőlap</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>
                            Üdvözöljük a Virtuális Labdarúgó Világbajnokság hivatalos oldalán! Ez a fantasztikus esemény
                            minden futballrajongó számára kihagyhatatlan, hiszen itt az esély arra, hogy a legjobb virtuális
                            labdarúgók világszerte összemérjék tudásukat és megküzdjenek a világbajnoki címért.
                        </p>
                        <p>
                            A bajnokságban több mint 100 ország legjobbjai küzdenek egymással, és egy hónapon keresztül
                            izgalmas meccseknek lehetünk tanúi. A legjobb játékosok olyan virtuális labdarúgó-készségekkel
                            rendelkeznek, amelyeket a legnagyobb erőfeszítés és kitartás révén értek el. Minden egyes
                            csapatnak megvan az esélye a győzelemre, és a legjobbak között talán új csillagokat fedezhetünk
                            fel, akik a jövőben az igazi labdarúgásban is csodákat fognak mutatni.
                        </p>
                        <p>
                            Kövesse velünk az eseményeket, és ne maradjon le a legjobb pillanatokról! Itt az ideje, hogy
                            kiválassza kedvenc csapatát, és szurkoljon nekik a végső győzelemért. Hajrá, Virtuális Labdarúgó
                            Világbajnokság!
                        </p>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Admin
                    </div>

                    <div class="card-body">
                        <p>
                            Bizonyos funkciók csak adminisztrátori jogosultsággal rendelkező felhasználók számára érhetőek
                            el, mint pl.: új csapatok létrehozása, meccsek eredményének rögzítése, stb.
                            Az adminisztrátori jogosultsággal rendelkező felhasználók adatai:
                            <br/><br/>
                            <strong>E-mail</strong>: admin@szerveroldali.hu <br/>
                            <strong>Jelszó</strong>: adminpwd
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
