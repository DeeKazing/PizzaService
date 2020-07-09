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
        $bestelltePizzas = $this->_database->query("SELECT ordered_articles.status, article.name FROM `ordered_articles`,`article`,`order` WHERE ordered_articles.f_order_id = order.id AND ordered_articles.f_article_id = article.id AND order.id = $BestellungID;");
        if(!$bestelltePizzas)
            throw new Exception("Query failed!"); //.$_database->error);
        $ergebnis = [];
        var_dump($ergebnis);
        while($item = $bestelltePizzas->fetch_assoc()){
            array_push($ergebnis,new BestelltePizzas($item['status'],$item['name']));
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
    HTML;
    foreach($ergebnis as $item){
        $ostatus = htmlspecialchars($item->status, ENT_QUOTES | ENT_HTML5 | ENT_DISALLOWED | ENT_SUBSTITUTE, 'UTF-8');
        $oname = htmlspecialchars($item->name);
    echo <<<HTML
            <div class="text"><b>Pizza</b>:$oname</div>
            <div class="Status" id="status">$ostatus</div>
            <br>
    HTML;
    }
echo<<<HTML
           
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
            session_start();
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
