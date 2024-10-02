<?php
require_once('../config.inc.php');

$conn= new mysqli($dbHost,$dbUser,$dbPassword);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}





    $sql="CREATE DATABASE avioni";
    if($conn->query($sql)===TRUE)
    {
        $db="testAvion";
        $conn= new mysqli($dbHost,$dbUser,$dbPassword,$db);
        
        $sql="CREATE TABLE admins(adminId int auto_increment primary key,
        userName varchar(50) not null,
        pass varchar(50) not null);";

        $conn->query($sql);


        $sql="INSERT INTO admins(userName,pass)
        VALUES('admin','1234'),
        ('admin','4321')";
         $conn->query($sql);


        $sql="CREATE TABLE country(
            countryid int auto_increment primary key,
            countryName varchar(50) not null,
            lomax float not null,
            lomin float not null,
            lamax float not null,
            lamin float not null
        )";
         $conn->query($sql);

        $sql="CREATE TABLE flighthistory(
            imeDrzave varchar(20) not null,
            imeLeta varchar(20) not null,
            longituda float not null,
            latituda float not null,
            time int not null
        )";
         $conn->query($sql);



         $sql="CREATE TABLE resources(
            resourcesId int auto_increment primary key,
            url varchar(200) not null,
            method varchar(50) not null,
            description varchar(255) not null
         )";
         $conn->query($sql);

         $sql="INSERT INTO resources(url,method,description)
         VALUES('http://localhost/AvioniApp/?page=Index','GET','popis svih resursa stranica'),
         ('http://localhost/AvioniApp/?page=AddCountry&ime=&loMax=&loMin=&laMax=&laMin=&user=&pass=','POST','Dodavanje nove drzave'),
         ('http://localhost/AvioniApp/?page=Delete&countryName=&user=&pass=','DELETE','Brisanje drzave sa popisa'),
         ('http://localhost/AvioniApp/?page=UpdateCountry&ime=&loMax=&loMin=&laMax=&laMin=&user=&pass=','UPDATE','Promjena kordinata za odredenu drzavu'),
         ('http://localhost/AvioniApp/?page=CurrentFlights','GET','Dohvacanje letova unutar zadnje 2 minute i prikazuje na karti sve letove odredenjih drzava. Prije pokretanja ovog reusrsa, pokrenuti SaveAllFlights za sigurnu izvedbu'),
         ('http://localhost/AvioniApp/?page=GetCountry','GET','Prikazuje sve odabrane drzave i njihove box kordinate'),
         ('http://localhost/AvioniApp/?page=FollowFlight&flight=','GET','Prikazuje odabrani let, podatke i na karti'),
         ('http://localhost/AvioniApp/?page=SaveAllFlights','POST','Sprema u bazu podataka sve letove odabranih drzava')
         ";
          $conn->query($sql);







    }

    else
    {
        echo "Error crating database".$conn->error;
    }


    $conn -> close();

?>