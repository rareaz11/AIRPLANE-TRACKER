<?php


require_once('system/AbstractPage.class.php');

class FollowFlightMapPage extends AbstractPage
{
    
    public $templateName="FollowMap";

    function execute()
    {

        $finalValue=[];

        $flightName=$_GET['flight'];

        $db= AppCore::getDB();

        $flightName=$db->protectInput($flightName);

   

        if($flightName==NULL)
        {

        
            $this->data=
            [
                "Message"=>null
            ];
            $this->data=json_encode($this->data);

            header("HTTP/1.1 404 NOT FOUND");
        }





        else
        {
       
            $sql=$db->sendQuery("SELECT* FROM flighthistory where imeLeta='$flightName'");


            $num=$sql->num_rows;

           
    
            if($num==0)
            {

                $this->data=
                [
                    'Message'=>"Wrong Name-flight"

                ];

                    $this->data=json_encode($this->data);

                    header("HTTP/1.1 404 NOT FOUND");
            }

            else
            {

                foreach($sql as $x=>$key)
                {

                 
                    $this->data[]=
                    [
                        "flight"=>htmlspecialchars($key['imeLeta']),
                        "longituda"=>$key['longituda'],
                        "latituda"=>$key['latituda'],
                        "time"=>date("d-m-Y H:i:s",$key['time'])
                    ];
                   
                }

       

                $this->data=json_encode($this->data);
            }

      
        }
    }

}



?>