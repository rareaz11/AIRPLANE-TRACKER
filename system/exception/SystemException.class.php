<?php

class SystemException extends Exception
{


    public function show()
    {

            return "SYSTEM ERROR: ".'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> is not a valid PAGE';
    }

   
}

?>