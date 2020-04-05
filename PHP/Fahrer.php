<?php

require_once './Page.php';

class Fahrer extends Page
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
        $this->generatePageHeader('Fahrer');
        echo <<<HTML
        <header>
        <!--img id="logo" src="../Bilder/Igris.png" alt="logo"-->
        <nav id="navbar">
            <ul>
                <li><a href= "Bestellung.php">Bestellungen</a></li>
                <li><a href="Pizzabäcker.php">Bäcker</a></li>
                <li><a href="Kunde.php">Kunde</a></li>
                <li><a class="active" href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </header>
    <h1>Pizza Bäcker</h1>
    <h2>bestellte Pizzen:</h2>
    <form action="https://echo.fbi.h-da.de/" method="post">
        <!--Hinweis: Bedenken Sie, dass ein Formular nur Daten für Formularelemente überträgt, 
            die ein name-Attribut haben! Außerdem brauchen Sie üblicherweise ein <form>, 
                das die Formularelemente umschließt!-->
                <table>
                    <p>Aydogan</p><p>Kurt-Schumacher Str.5</p><p>13.50€</p>
                    <tr>
                        <th>fertig</th>
                        <th>unterwegs</th>
                        <th>geliefert</th>
                    </tr>
                    <tr>
                        <td><input type="radio" name="status0" value="fertig"></td>
                        <td><input type="radio" name="status0" value="unterwegs"></td>
                        <td><input type="radio" name="status0" value="geliefert"></td>
                    </tr>
                </table>
                <input type="submit">      
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
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Fahrer::main();

