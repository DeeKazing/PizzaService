<?php

require_once './Page.php';

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

    protected function getViewData()
    {
    }

    protected function generateView()
    {
        $this->getViewData();
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
