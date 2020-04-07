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
    <form action="Bestellung.php" method="POST"> <!--https://echo.fbi.h-da.de/-->
    <!--POST bei Sensiblen Daten | GET bei vielen Daten und nicht sensiblen Daten-->
        <!--Hinweis: Bedenken Sie, dass ein Formular nur Daten für Formularelemente überträgt, 
            die ein name-Attribut haben! Außerdem brauchen Sie üblicherweise ein <form>, 
                das die Formularelemente umschließt!-->
            <select name="PizzaListe[]" id="warenkorb" size="5" multiple>
                <!--  <option value="volvo">Volvo</option> -->
                <!--  ^^option  ^^value     ^^InnerText -->
            </select>
            <div id="gesamtPreis">Gesamtpreis: 0.00€</div>
        <label>Name: <input type="text" name="Name" value="" id="name" placeholder="Ihr Name!" required></label>
        <label>Stadt: <input type="text" name="Stadt" value="" id="stadt" placeholder="Ihre Stadt!" required></label>
        <label>Postleitzahl: <input pattern="[0-9]{5}" name="Postleitzahl" id="plz" placeholder="Fünfstellige Postleitzahl!" value="" required></label>        
        <label>Straße: <input type="text" name="Straße" value="" id="straße" placeholder="Ihre Straße!" required></label>
        <br>
        <input type="button" id="warenkorbleeren" value="Alles Löschen!" onclick="WarenkorbLeeren()">
        <input type="button"  value="Auswahl Löschen!" onclick="entfernenWarenkorb()">
        <!--type submit schickt Formular ab-->
        <input type="submit" value="Bestellen!" onclick="bestellungSelectAll()">    
    </form>
    HTML;
        $this->generatePageFooter();
    }

    protected function processReceivedData()
    {
       {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
        if($this->_database == false){
            die("ERROR: Could not connect.". $this->_database->connect_error);
        }
        if(sizeof($_POST) > 0){
            //var_dump($_POST);
            if((!isset($_POST['Name'])) || (!isset($_POST['Stadt'])) || (!isset($_POST['Postleitzahl'])) || (!isset($_POST['Straße'])) || (sizeof($_POST['Pizzas']) < 0)){
                throw new Exception("Eingaben ungültig");
            }
            $Name = $this->_database->real_escape_string($_REQUEST['Name']);
            $Stadt = $this->_database->real_escape_string($_REQUEST['Stadt']);
            $Postleitzahl = $this->_database->real_escape_string($_REQUEST['Postleitzahl']);
            $Straße = $this->_database->real_escape_string($_REQUEST['Straße']);
        
            
            $sql = "INSERT INTO `bestellung` (KundeName, Stadt, Postleitzahl, Straße, Bestellstatus) VALUES ('$Name', '$Stadt', '$Postleitzahl','$Straße','Bestellt')";
            if($this->_database->query($sql) === true){
                echo "Records inserted successfully.";
            } else{
                echo "ERROR: Could not be able to execute $sql. ";//.$mysqli->error
            }
            $BestellungID = $this->_database->insert_id; 
            $_SESSION['BestellungID'] = $BestellungID;
            foreach(($_POST['Pizzas']) as $PizzaBestellung){
                $PizzaBestellung = $this->_database->real_escape_string($PizzaBestellung);
                $sql = "INSERT INTO `bestelltepizza` (fBestellungID, fPizzaNummer) VALUES(($BestellungID), (SELECT PizzaNummer FROM `angebot` WHERE angebot.PizzaName = '$PizzaBestellung'));";
                 if($this->_database->query($sql) === true){
                    echo "Records inserted successfully.";
            } else{
                echo "ERROR: Could not be able to execute $sql. ";//.$mysqli->error
            }
            }
           
            //var_dump($sql);
            header('Location: Kunde.php');
        }
    }
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
