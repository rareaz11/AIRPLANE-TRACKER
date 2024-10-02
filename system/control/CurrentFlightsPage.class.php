
<?php

require_once('system/AbstractPage.class.php');
class CurrentFlightsPage extends AbstractPage
{

    public $templateName="Current";

    function execute()
    {

        $db=AppCore:: getDB();

        $currentDateTime=strtotime('now');

  
    

     
        $lastValue=$currentDateTime-600000;
        $sql=$db->sendQuery("SELECT * FROM flighthistory WHERE time between $lastValue AND $currentDateTime");


        $num=$sql->num_rows;
      
        if($num==0)
        {
            // var_dump($num);
            $this->data=
            [
                'Message'=>"RIGHT NOW WE DONT HAVE INFORMATIONS ABOUT FLIGHTS."
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
                        'imeDrzave'=>htmlspecialchars($key['imeDrzave']),
                        'imeLeta'=>htmlspecialchars($key['imeLeta']),
                        'longituda'=>$key['longituda'],
                        'latituda'=>$key['latituda'],
                        "time"=>date("d-m-Y H:i:s",$key['time'])
                    ];
            }


            $this->data= json_encode($this->data);

            header("HTTP/1.1 200 OK");
            
        }
    }

}

?>