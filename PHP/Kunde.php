<?php

require_once './Page.php';
require_once '../Hilfs_Klassen_Methoden/Kunde_BestelltePizza.php';


class Kunde extends Page
{

    protected function __construct()
    {
        parent::__construct();
    }


    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData($BestellungID)
    {
        $bestelltePizzas = $this->_database->query("SELECT Bestellstatus, PizzaName FROM `bestelltepizza`,`angebot`,`bestellung` WHERE bestelltepizza.fBestellungID = bestellung.BestellungID AND bestelltepizza.fPizzaNummer = angebot.PizzaNummer AND bestellung.BestellungID = $BestellungID;");
        if(!$bestelltePizzas)
            throw new Exception("Query failed:" .$_database->error);
        $ergebnis = [];
        while($item = $bestelltePizzas->fetch_assoc()){
            $pizzaname = $item["PizzaName"];
            $bestellstatus = $item["Bestellstatus"];
            if(!$pizzaname)
                throw new Exception("Query failed:" .$_database->error);
            array_push($ergebnis, new BestelltePizzas($pizzaname,$bestellstatus));
        }
        return $ergebnis;
    }

    protected function generateView()
    {
        if(isset($_SESSION['BestellungID'])){
            $ergebnis = $this->getViewData($_SESSION['BestellungID']);
        }
        $this->generatePageHeader('Kunde');
        echo <<<HTML
        <header>
        <!--img id="logo" src="../Bilder/Igris.png" alt="logo"-->
        <nav id="navbar">
            <ul>
                <li><a href= "Bestellung.php">Bestellungen</a></li>
                <li><a href="Pizzabäcker.php">Bäcker</a></li>
                <li><a class="active" href="Kunde.php">Kunde</a></li>
                <li><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </header>
    <h1>Kunde</h1>
    <h2>Lieferstatus:</h2>
    <p>Margherita: bestellt</p>
    <p>Salami: Im Ofen</p>       
    <p>Tonno: feritg</p>       
    <p>Hawai: bestellt</p>            
    <a href="Bestellung.php"><button>Neue Bestellung</button></a>

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
            $page = new Kunde();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Kunde::main();
