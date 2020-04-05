<?php

require_once './Page.php';
require_once '../Hilfs_Klassen_Methoden/angebot.php';

class Bestellung extends Page
{

    protected function __construct()
    {
        parent::__construct();
    }


    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
        $angebotitems = $this->_database->query("SELECT * FROM angebot");
        if (!$angebotitems)
            throw new Exception("Query failed:" /*.$_database->error_reporting */);
        $pizzenausdb = [];
        while ($item = $angebotitems->fetch_assoc()) {
            array_push($pizzenausdb, new Angebot($item['PizzaName'], $item['Bilddatei'], $item['Preis']));
        }
        return $pizzenausdb;
        // to do: fetch data for this view from the database

    }

    protected function generateView()
    {
        $pizzenausdb = $this->getViewData();
        $this->generatePageHeader('Bestellung');
        echo <<<HTML
        <header>
        <!--img id="logo" src="../Bilder/Igris.png" alt="logo"-->
        <nav id="navbar">
            <ul>
                <li><a class="active" href= "Bestellung.php">Bestellungen</a></li>
                <li><a href="Pizzabäcker.php">Bäcker</a></li>
                <li><a href="Kunde.php">Kunde</a></li>
                <li><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </header>
    <h1>Bestellung</h1>
    <h2>Speisekarte</h2>
    <div class="flex-container">
    HTML;
        foreach ($pizzenausdb as $item) {
            $onepiz = htmlspecialchars(json_encode($item));
            echo <<<HTML
        <div class = "item">
            <div class="text">$item->pizzaname</div>
            <div class="price">$item->preis €</div>
             <div class="picture"><img src="$item->bildpfad" width="150" alt="$item->pizzaname" onclick="hinzufuegenWarenkorb('$onepiz')"></div>
        </div>    
    HTML;
        }
        echo <<<HTML
    </div>
    <form action="https://echo.fbi.h-da.de/" method="post">
        <!--Hinweis: Bedenken Sie, dass ein Formular nur Daten für Formularelemente überträgt, 
            die ein name-Attribut haben! Außerdem brauchen Sie üblicherweise ein <form>, 
                das die Formularelemente umschließt!-->
            <select name="Pizzas[]" id="warenkorb" size="5" multiple>
                <!--  <option value="volvo">Volvo</option> -->
                <!--  ^^option  ^^value     ^^InnerText -->
            </select>
            <div id="gesamtPreis">Gesamtpreis: 0.00€</div>
        Name:
        <br>
        <input type="text" name="Name" value="" id="name" required>
        <br>
        Adresse:
        <br>
        <input type="text" name="Adresse" value="" id="adresse" required>
        <br>
        Postleitzahl:
        <br>
        <input pattern="[0-9]{5}" name="plz" id="plz" title="Fünfstellige Postleitzahl in Deutschland." value="" required>
        <br>
        <input type="button" id="warenkorbleeren" value="Alles Löschen!" onclick="WarenkorbLeeren()">
        <input type="button"  value="Auswahl Löschen!" onclick="entfernenWarenkorb()">
        <!--type submit schickt Formular ab-->
        <input type="submit" value="Bestellen!">    
    </form>
    HTML;
        $this->generatePageFooter();
    }

    protected function processReceivedData()
    {
        parent::processReceivedData();
    }

    public static function main()
    {
        try {
            $page = new Bestellung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Bestellung::main();
