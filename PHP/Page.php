<?php
abstract class Page
{

    protected $_database = null;

    protected function __construct()
    {
        $this->_database = new MySQLi("localhost", "root", "", "pizzaservice2020");
        $this->_database->set_charset("utf8");
    }

    /**
     * Closes the DB connection and cleans up
     *
     * @return none
     */
    protected function __destruct()
    {
        $this->_database->close();
    }

    /**
     * Generates the header section of the page.
     * i.e. starting from the content type up to the body-tag.
     * Takes care that all strings passed from outside
     * are converted to safe HTML by htmlspecialchars.
     *
     * @param $headline $headline is the text to be used as title of the page
     *
     * @return none
     */
    protected function generatePageHeader($headline = "")
    {
        $headline = htmlspecialchars($headline);
        $refresh = true;
        $script = "";
        $meta = "";
        $css = "";
        header("Content-type: text/html; charset=UTF-8");

        if ($headline == "Bestellung") {
            $script = ' <script src="../JS/functions.js"></script>';
            $css =  '<link rel="stylesheet" href="../CSS/Bestellung.css"/>';
        }

        if ($headline == "Fahrer" || $headline == "Pizzabäcker") {
            $meta = '<meta http-equiv="refresh" content="5">';
        }

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="de">  
        <head>
        <meta charset="UTF-8" />
        $script
        $meta
        $css
        <title>$headline</title>
        </head>
HTML;
    }

    /**
     * Outputs the end of the HTML-file i.e. /body etc.
     *
     * @return none
     */
    protected function generatePageFooter()
    {
        // to do: output common end of HTML code
    }

    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If every page is supposed to do something with submitted
     * data do it here. E.g. checking the settings of PHP that
     * influence passing the parameters (e.g. magic_quotes).
     *
     * @return none
     */
    protected function processReceivedData()
    {
    }
}
