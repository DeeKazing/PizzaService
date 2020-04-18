<?php	
abstract class Page
{
    // --- ATTRIBUTES ---

    /**
     * Reference to the MySQLi-Database that is
     * accessed by all operations of the class.
     */
    protected $_database = null;
    
    // --- OPERATIONS ---
    
    /**
     * Connects to DB and stores 
     * the connection in member $_database.  
     * Needs name of DB, user, password.
     *
     * @return none
     */
    protected function __construct() 
    {
        error_reporting (E_ALL);

        $this->_database = new MySQLi("localhost", "root", "", "pizzaservice_2020");
        
        //$this->_database = new MySQLi("localhost", "root", "", "pizzaservice2020");
        
        if (mysqli_connect_errno())
            throw new Exception("Connect failed: " . mysqli_connect_error());
        
        // set charset to UTF8!!
        if (!$this->_database->set_charset("utf8"))
          throw new Exception($this->_database->error);
    }
    
    /**
     * Closes the DB connection and cleans up
     *
     * @return none
     */
    public function __destruct()    
    {
        // to do: close database
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
        header("Content-type: text/html; charset=UTF-8");
        
        // to do: output common beginning of HTML code 
        // including the individual headline
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
} // end of class

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >