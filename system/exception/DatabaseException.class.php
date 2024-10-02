<?php

class DatabaseException extends Exception
{


    function GetError(Exception $e)
    {
        return $e->getMessage(). "error on --->".$e->getLline();    }
    
}
?>