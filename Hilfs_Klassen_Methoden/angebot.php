<?php

Class Angebot{
    public $pizzaname;
    public $bildpfad;
    public $preis;
    
    public function __construct($pn,$pf,$pr){
        $this->pizzaname = $pn;
        $this->bildpfad = $pf;
        $this->preis = $pr;
    }
}
