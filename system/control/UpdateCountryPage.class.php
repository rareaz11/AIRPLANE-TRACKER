<?php

require_once('system/AbstractPage.class.php');
class UpdateCountryPage extends AbstractPage
{
    public $templateName="UpdateCountry";

    function execute()
    {

        $db=AppCore::getDB();
       // $admin=$_GET['admin'];
       // $pass=$_GET['pass'];
        $ime=$_GET['ime'];
        $loMax=$_GET['loMax'];
        $loMin=$_GET['loMin'];
        $laMax=$_GET['laMax'];
        $laMin=$_GET['laMin'];
        $user=$_GET['user'];
        $pass=$_GET['pass'];


        $ime=$db->protectInput($ime);

        $user=$db->protectInput($user);
        $pass=$db->protectInput($pass);
        
        $sql1=$db->sendQuery("SELECT*FROM admin where userName='$user' AND pass='$pass'");
        $num1=$sql1->num_rows;
   
       
        if($ime==""||$loMax==""||$loMin==""||$laMax==""||$laMin=="")
        {
            $this->data=
            [
                "Message"=>"Error Empty Field",

              
            ];
            header("HTTP/1.1 404 Not Found");

            $json=json_encode($this->data);
            $this->data=$json;
          

        }
       
        else if($user==null || $pass==null)
        {
            $this->data=["message"=>"Empty Field "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");

        }

        else if($num1==0)
        {
            $this->data=["message"=>"WRONG USER OR PASSWORD "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");
        }
       else if($user==null || $pass==null)
        {
            $this->data=["message"=>"Empty Field "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");

        }

        else if($num1==0)
        {
            $this->data=["message"=>"WRONG USER OR PASSWORD "];

            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 Not Acceptable");
        }

        else
        {
            //check if is number
            if(is_numeric($loMax)==true&& is_numeric($loMin)==true&&is_numeric($laMax)==true&&is_numeric($laMin)==true)
            {
                $sql=$db->sendQuery("SELECT COUNT(*) as num  FROM country where countryName='"."$ime'");


                $rez=$sql->fetch_assoc();
               
                $rez=$rez['num'];
                $rez=intval($rez);
            
                // $name=$db->real_escape_string($ime);
      
                  if($rez==1)
                  {


                        $sql=$db->sendQuery("UPDATE country SET
                        lomax=$loMax,lomin=$loMin,lamax=$laMax,
                        lamin=$laMin WHERE countryName='$ime'");
        
                        $this->data=
                        [
                            "Message"=>"Seccessfuly updated"
                        ];
        
                        $json=json_encode($this->data);
        
                        $this->data=$json;
        
        
        
                        header("HTTP/1.1 201 CREATED");
      
      
                  }
      
                  else
                  {

                        $this-> data=
                        [
                            'Message'=>"COUNTRY NOT FOUND"
                        ];
    
                        $json=json_encode($this->data);
    
                        $this->data=$json;
                        header("HTTP/1.1 406 Not Acceptable");
                    }
                
            }
            else
            {
                    $this->data=
                    [
                        "Message"=>"Data Type error"
                    ];

                    $json=json_encode($this->data);

                    $this->data=$json;

                    header("HTTP/1.1 406 NOT ACCEPTABLE");
            }

           
        }





    }

}
?>