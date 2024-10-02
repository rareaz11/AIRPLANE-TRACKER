<?php

require_once("system/AbstractPage.class.php");
require_once('system/exception/SystemException.class.php');

class AddCountryPage  extends AbstractPage 
{

    public $templateName="AddCountry";

    function execute()
    {
       
        $db=AppCore::getDB();
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
        if($user==null || $pass==null)
        {
                $this->data=["message"=>"Empty Field "];

                $this->data=json_encode($this->data);

                header("HTTP/1.1 404 Not Acceptable");

        }

        else if($num1==0)
        {
                $this->data=
                [
                        "message"=>"WRONG USER OR PASSWORD "
                ];

                $this->data=json_encode($this->data);

                header("HTTP/1.1 404 Not Acceptable");
        }
        else
        {
   
       
                if($ime==""||$loMax==""||$loMin==""||$laMax==""||$laMin=="")
                    {
                        $this->data=
                        [
                            "Message"=>"Error Empty Field"
                        ];
                header("HTTP/1.1 404 Not Found");

                $json=json_encode($this->data);
                $this->data=$json;
          

                    }
        

                else
                    {
                        $rezCountry=$this-> CheckCountry($ime);
                        if($rezCountry==false)
                            {
                                $this-> data=
                                [
                                    'Message'=>"the specified ".htmlspecialchars($ime) ." country does not exist."
                                 ];

                                $json=json_encode($this->data);

                                 $this->data=$json;
                                header("HTTP/1.1 406 Not Acceptable");

                            }

                        else{
                                //check if is number
                                if(is_numeric($loMax)==true && is_numeric($loMin)==true&&is_numeric($laMax)==true&&is_numeric($laMin)==true)
                                    {
                                        $sql=$db->sendQuery("SELECT COUNT(*) as num  FROM country where countryName='"."$ime'");


                                        $rez=$sql->fetch_assoc();
               
                                        $rez=$rez['num'];
                                        $rez=intval($rez);
            
                                        // $name=$db->real_escape_string($ime);
      
                                        if($rez>=1)
                                            {
                                                $this-> data=
                                                [
                                                    'Message'=>"Already exsist"
                                                ];
      
                                                $json=json_encode($this->data);
      
                                                $this->data=$json;
                                                header("HTTP/1.1 406 Not Acceptable");
      
      
                                            }
      
                                        else{
                                                $sql=$db->sendQuery("INSERT INTO country(countryName,lomax,lomin,lamax,lamin)
                                                VALUES('$ime',".floatval($loMax).",".floatval($loMin).",".floatval($laMax).",".floatval($laMin).")");
      
                                                $this->data=
                                                [
                                                     "Message"=>"Seccessfuly added"
                                                ];
      
                                                $json=json_encode($this->data);
      
                                                $this->data=$json;

                                                header("HTTP/1.1 201 CREATED");
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


    
    }


    function CheckCountry($country)
    {
        $countryList=['Croatia','Spain','Germany','Monaco',
        'Slovakia','Slovenia','Belgium','France','Italy',
        'Norway','Finland','Ireland','Albania','Sweden','Malta','Portugal','Austria'];

        $rezC=in_array($country,$countryList);

        return $rezC;
    }

}



?>