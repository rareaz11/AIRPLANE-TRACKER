<?php

require_once('system/AbstractPage.class.php');
class GetCountryPage extends AbstractPage
{

    public $templateName='GetCountry';

    public function execute()
    {
        $db=AppCore:: getDB();

        $results= $db->sendQuery("SELECT*FROM country");

        $results1=$results->num_rows;
     
    
     
        if($results1==null)
        {
            $this->data=
            [
                'Message'=>'EMPTY DATA'
            ];

            //pitati profesora koliko je to u praksi ovako raditi 
            //ili pisati svoje varijable

            $this->data=json_encode($this->data);

            header('HTTP/1.1 404 NOT FOUND');
        }

        else
        {
            foreach($results as $x=>$key)
            {
                $this->data[]=
                [

                    "countryid"=> $key['countryid'],
                    "countryName"=> htmlspecialchars( $key['countryName']),
                    "lomax"=>$key['lomax'],
                    "lomin"=>$key['lomin'],
                    "lamax"=>$key['lamax'],
                    "lamin"=>$key['lamin']

                ];
            }
        
            $this->data=json_encode($this->data);
            header('HTTP/1.1 200 OK');


        }
      
        
   
  // var_dump($results);
    //    var_dump($resources);

   
      
        //$json=json_encode($results);

    }

}
?>