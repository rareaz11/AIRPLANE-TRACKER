<?php

//dodane jos metode za close db() iako nepotrebno samo radi testa
//ali za potrebe zastite od sql injection trebalo je napraviti metodu protectInput
class MySQLiDatabase
{
    public $MySQL;
    protected $host;
    protected $user;
    protected $password;
    protected $database;


    

    function __construct($host,$user,$password,$database)
    {

        $this->host=$host;
        $this->user=$user;
        $this->password=$password;
        $this->database=$database;

        $this-> connect();



    }

    function connect()
    {
        $this->MySQL= new MySQLi($this->host,$this->user,$this->password,$this->database);
        

    }

    function sendQuery($query)
    {
        return $this->MySQL->query($query);

    }
    function closeDb()
    {
        return $this->MySQL->close();
    }

    function protectInput($value)
    {
        return $this->MySQL->real_escape_string($value);
    }
}
?>