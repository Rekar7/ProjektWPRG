<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
checkLogin($conn);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sklep</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-black text-light">

<!--   NAVBAR    -->

<nav class="navbar navbar-expand-lg bg-body-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">MEBLEX</a>
        <button class="navbar-toggler bg-light-subtle" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-light" aria-current="page" href="../index.php">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">O nas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="../pages/shop.php">Sklep</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="../pages/cart.php">Koszyk</a>
                </li>
                <?php
                showLoginProfile();
                showLogout();
                showAdminPanel();
                ?>
            </ul>
            <form class="d-flex" role="search" action="../pages/shop.php" method="get">
                <input class="form-control me-2 text-dark" type="search" placeholder="Szukaj przedmiotu"
                       aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Szukaj</button>
            </form>
        </div>
    </div>
</nav>

<!--   CONTENT    -->

<div class="container-fluid bg-black text-light mt-5">
    <div class="row text-left ms-1 display-1 gradient-text">
        <strong> MEBLEX</strong>
    </div>
    <div class="row text-left ms-3 display-5 secondary-gradient-text">
        Lider nr. 1 branży meblowej<br>
        w Sianowie.
    </div>
</div>

<div class="container-fluid bg-black text-light w-75 mt-5 ms-5 me-5">
    <h3 class="AboutUsHeader">MEBLEX - Lider Nr 1 w Branży Meblowej w Sianowie</h3>
    <p>
        MEBLEX to wiodąca firma w branży meblowej w Sianowie, znana z produkcji wysokiej jakości mebli, które łączą
        nowoczesny design z funkcjonalnością i trwałością. Od momentu powstania, MEBLEX zyskał reputację firmy, która
        stawia na innowacje, precyzję wykonania oraz zadowolenie klientów.
    </p>
    <h3 class="AboutUsHeader">Nasza Misja</h3>
    <p>
        Naszą misją jest tworzenie mebli, które nie tylko spełniają oczekiwania naszych klientów, ale także przewyższają
        je pod względem estetyki, komfortu i funkcjonalności. Dążymy do tego, aby każde wnętrze, w którym znajdą się
        nasze produkty, było miejscem komfortowym, eleganckim i wyjątkowym.
    </p>
    <h3 class="AboutUsHeader"> Nasze Produkty</h3>
    <p>
        W ofercie MEBLEX znajdują się meble do każdego pomieszczenia w domu i biurze. Oferujemy:
    </p>
    <ul>
        <li>Meble salonowe: sofy, fotele, stoliki kawowe, meblościanki</li>
        <li> Meble sypialniane: łóżka, szafy, komody, stoliki nocne</li>
        <li> Meble kuchenne: zestawy kuchenne, wyspy, stoły i krzesła</li>
        <li> Meble biurowe: biurka, regały, krzesła biurowe</li>
        <li> Meble dziecięce: łóżeczka, biurka, szafy</li>
        <li> Każdy nasz produkt jest starannie zaprojektowany i wykonany z najwyższej jakości materiałów, co gwarantuje
            trwałość i satysfakcję użytkowania przez wiele lat.
        </li>
    </ul>

    <h3 class="AboutUsHeader"> Dlaczego Warto Wybrać MEBLEX?</h3>
    <ul>
        <li> Wysoka jakość: Używamy tylko najlepszych materiałów i nowoczesnych technologii produkcji.</li>
        <li>Innowacyjny design: Nasze meble są projektowane przez uznanych designerów, którzy łączą estetykę z
            funkcjonalnością.
        </li>
        <li> Personalizacja: Oferujemy możliwość dostosowania mebli do indywidualnych potrzeb i preferencji naszych
            klientów.
        </li>
        <li> Kompleksowa obsługa: Zapewniamy pełną obsługę – od doradztwa, przez projektowanie, aż po dostawę i montaż
            mebli.
        </li>
        <li> Ekologia: Dbamy o środowisko, stosując ekologiczne materiały i procesy produkcji.</li>
        <li> Nasze Wartości</li>
        <li> Zadowolenie Klientów: Naszym priorytetem jest satysfakcja klienta, dlatego słuchamy i reagujemy na potrzeby
            naszych klientów.
        </li>
        <li> Profesjonalizm: Zespół MEBLEX to wykwalifikowani specjaliści, którzy z pasją i zaangażowaniem realizują
            każde zlecenie.
        </li>
        <li> Innowacyjność: Stale wprowadzamy nowe rozwiązania i technologie, aby oferować produkty na najwyższym
            światowym poziomie.
        </li>
    </ul>
    <h3 class="AboutUsHeader">Kontakt</h3>
    <p>
        Zapraszamy do odwiedzenia naszego salonu w Sianowie oraz do kontaktu telefonicznego lub mailowego. Nasi
        konsultanci
        chętnie odpowiedzą na wszystkie pytania i pomogą w wyborze idealnych mebli do Państwa domu lub biura.</p>

    <h3 class="AboutUsHeader"> MEBLEX - Tworzymy meble z pasją i dbałością o każdy detal.</h3>
</div>

<!--   FOOTER    -->

<footer class="mt-5">

    <div class="row text-start ms-3 pt-5">
        Meblex <br>
        Sianowskie Centrum Mebli <br>
        Koszalińska 2, 76-100 Sianów <br>
        +48 923 567 123
    </div>

</footer>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>
