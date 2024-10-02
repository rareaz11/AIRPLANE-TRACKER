<?php
/* 
NAPOMENA KORISTENO 
php vjezbe,
sluzbena php dokumentacija-https://www.php.net/docs.php
i openAI
 --radi se o par lnija koda uzetih kao ===>>
   curl_setopt($ch,CURLOPT_TIMEOUT,2);
radi  pucanja interneta ili ako stranica ne odgovara n vremena;
tj.kod je preoblikovan i uzet za potrebe ovog projekta



*/
//zastita od SQL na liniji 99
//try catch 140 linija koda

require_once('system/AbstractPage.class.php');
require_once('system/exception/SystemException.class.php');
class SaveAllFlightsPage extends AbstractPage
{
 

    public  $templateName="SaveAllFlights";

    function execute()
    {//provjerava broj drzava u bazi
        $numberIndb=0;
        $listOfBool=[];
        //provejrava koliko je apia prazno
        $numofAPI=0;
        $db=AppCore::getDB();

        $sql=$db->sendQuery("SELECT * FROM country");
        $num=$sql->num_rows;

       
        if($num==0)
        {
            $this->data=
            [
              "Message"=>"DATA EMPTY"
            ];

            $this->data=json_encode($this->data);


            header("HTTP/1.1 404 NOT FOUND");
        }

        else
        {

            $rez=[];

            foreach($sql as $value=>$key)
            {
              $rez[]=$key;
              $numberIndb++;
            }
            
            $fullResults=[];


            foreach($rez as $value => $key)
            {
                
                //ulazimo u foreach radi metode da se pozove za svaku drzavu
                $apiValue=$this->GetData(floatval($key['lamin']),floatval($key['lomin']),floatval($key['lamax']),floatval($key['lomax']));
            
                if($apiValue==NULL)
                {
                    $listOfBool[]=false;
                 
                }
              
                
              

                else
                {

                    $jsonApi= json_decode($apiValue);
      
                   
      
                    foreach($jsonApi as $x )
                    {
                        $fullResults[]=$x;
    

                    }
                    
                    if($fullResults[1]==null)
                    {
                        $numofAPI++;
                        if($numofAPI==$numberIndb)
                        {
                           
                            //aktiviranje fakeMetode za punjenje podataka

                            foreach($rez as $value => $key)
                             {
                
                                 //ulazimo u foreach radi metode da se pozove za svaku drzavu
                                    $apiValue=$this->fakeData(floatval($key['lamin']),floatval($key['lomin']),floatval($key['lamax']),floatval($key['lomax']));

                                    foreach($apiValue as $x=>$key)
                                    {
                                        $db->sendQuery("INSERT INTO flighthistory(imeDrzave,imeLeta,longituda,latituda,time)
                                        VALUES('".$db->protectInput($key['origin_country'])."',
                                        '".$db->protectInput($key['callsign'])."',
                                        ".$db->protectInput($key['longitude']).",
                                        ".$db->protectInput($key['latitude']).",
                                    ".$db->protectInput($key['time_position']).")");
                                        
                                    }
                                       
                                }

                                $this->data=
                                [
                                    "Message"=>"FAKE DATA"
                                ];
                                $this->data=json_encode($this->data);
              
                                header("HTTP/1.1 404 NOT FOUND");

                        }

                    }

                    else
                    {

                        foreach($fullResults[1] as $x)
                        {
                            if($x[1]==null)
                            {
                                    //preskace avione- drzave koje nemaju ime;

                            }

                            else
                            {
                                $db->sendQuery("INSERT INTO flighthistory(imeDrzave,imeLeta,longituda,latituda,time)
                                VALUES('".$db->protectInput($key['countryName'])."',
                                '".$db->protectInput($x[1])."',
                                $x[5],$x[6],$x[4])");
                            }
                        }

 
                        $fullResults=null;

                      

   
                    }
                }

            }
            if(in_array(false,$listOfBool))
            {
                $this->data=
                [
                    "Message"=>"ERROR DATA"
                ];
                $this->data=json_encode($this->data);

                header("HTTP/1.1 404 NOT FOUND");
            }
            else
            {
                $this->data=
                [
                    "Message"=>"OK"
                ];
                $this->data=json_encode($this->data);

                header("HTTP/1.1 200 OK");
            }

      
        
        }

            

      
    
  

    }


    private function GetData($lamin,$lomin,$lamax,$lomax)
    {
    
        try
        {
            $api="https://opensky-network.org/api/states/all?lamin=$lamin&lomin=$lomin&lamax=$lamax&lomax=$lomax";
            $ch=curl_init($api);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            $this->response=curl_exec($ch);
            curl_close($ch);
      
               
            if($this->response==false)
            {
                throw new SystemException("ERROR INTERNET");
            }
          
            
                return $this->response;
            

        }

        catch(SystemException $e)
        {
            return $e->show();
            
        }
     


    }

    private function fakeData($lamin,$lomin,$lamax,$lomax)
    {
        
        $listOfAirplaneName=["CRO111","CRO123","GER123","GER222","SPA123","SPA222"];
        $dataList=[];

        $randomForList=rand(10,20);
        for($i=0;$i<$randomForList;$i++)
        {
            $randomLongitude=$lomin+mt_rand()/mt_getrandmax()*($lomax-$lomin);
            $randomLatitude=$lamin+mt_rand()/mt_getrandmax()*($lamax-$lamin);
            $time=strtotime("now");
            $dataList[]=
            [
                "icao24"=>null,
                "callsign"=>$listOfAirplaneName[rand(0,count($listOfAirplaneName)-1)],
                "origin_country"=>"undefinded",
                "time_position"=>$time,
                "last_contact"=>$time,
                "longitude"=>$randomLongitude,
                "latitude"=>$randomLatitude



            ];
        
        
        }


        return $dataList;


        
    }

    private function ToManyRequest()
    {
     require_once("system/view/ToMany.tpl.php");
    }



}
?>