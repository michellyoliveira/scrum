<?php
    function __autoload($classe){
        require_once("controles/{$classe}.php");
    }
