<?php

require_once('system/AbstractPage.class.php');
class DeletePage extends AbstractPage
{

   public $templateName="Delete";
   

    function execute()
    {
        $name=$_GET['countryName'];
        $user=$_GET['user'];
        $pass=$_GET['pass'];
        $db=AppCore::getDB();
        $ime=$db->protectInput($ime);

        $user=$db->protectInput($user);
        $pass=$db->protectInput($pass);


        $sql1=$db->sendQuery("SELECT*FROM admin where userName='$user' AND pass='$pass'");
        $num1=$sql1->num_rows;
        if($user==null || $pass==null)
        {
            $this->data=["message"=>"Empty Field "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");

        }
        else if($num1==0)
        {
            $this->data=["message"=>"NULL VALUE "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");

        }

        else
        {

       
       

            $sql=$db->sendQuery("SELECT COUNT(*) as num FROM country WHERE countryName='$name'");

            $rez=$sql->fetch_assoc();

            $rez=intval($rez['num']);

            if($rez==0)
            {

                $this->data=[
                    'Message'=>"WRONG DATA--COUNTRY DONT EXSIST"
                ];

                $json= json_encode($this->data);

                $this->data=$json;

                header('HTTP/1.1 404 NOT FOUND');
            }

            else
            {
                $sql=$db->sendQuery("DELETE FROM country WHERE countryName='$name'");
                $this->data=[
                    'Message'=>'OK'
                ];
    
                $json=json_encode($this->data);
    
                $this->data=$json;
    
                header('HTTP/1.1 200 OK');
            }
        

        
    
        }

    }
}




?>