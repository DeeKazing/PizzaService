<?php

require_once './Page.php';

class Pizzabäcker extends Page
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
        $this->generatePageHeader('Pizzabäcker');
        echo <<<HTML
        <header>
        <!--img id="logo" src="../Bilder/Igris.png" alt="logo"-->
        <nav id="navbar">
            <ul>
                <li><a href= "Bestellung.php">Bestellungen</a></li>
                <li><a class="active" href="Pizzabäcker.php">Bäcker</a></li>
                <li><a href="Kunde.php">Kunde</a></li>
                <li><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </header>
    <h1>Fahrer</h1>
    <h2>auslieferbare Bestellungen:</h2>
    <form action="https://echo.fbi.h-da.de/" method="post">
        <!--Hinweis: Bedenken Sie, dass ein Formular nur Daten für Formularelemente überträgt, 
            die ein name-Attribut haben! Außerdem brauchen Sie üblicherweise ein <form>, 
                das die Formularelemente umschließt!-->
                <table>
                    <tr>
                        <th></th>
                        <th>bestellt</th>
                        <th>im Ofen</th>
                        <th>fertig</th>
                    </tr>
                    <tr>
                        <td>Fungi</td>
                        <td><input type="radio" name="status0" value="bestellt"></td>
                        <td><input type="radio" name="status0" value="im Ofen"></td>
                        <td><input type="radio" name="status0" value="fertig"></td>
                    </tr>
                    <tr>
                        <td>Salami</td>
                        <td><input type="radio" name="status1" value="bestellt"></td>
                        <td><input type="radio" name="status1" value="im Ofen"></td>
                        <td><input type="radio" name="status1" value="fertig"></td>
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
            $page = new Pizzabäcker();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Pizzabäcker::main();

