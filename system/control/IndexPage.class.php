<?php
require_once('system/AbstractPage.class.php');

class IndexPage extends AbstractPage
{
    public $templateName='index';

    public function execute()
    {
        $db=AppCore::getDB();

        $resources=$db->sendQuery("SELECT *FROM resources");

      

        $this->data=
        [
            'resources'=>$resources
        ];

        header('HTTP/1.1 200 OK');
        
         /*


         lamin float

lower bound for the latitude in decimal degrees

lomin

float

lower bound for the longitude in decimal degrees

lamax

float

upper bound for the latitude in decimal degrees

lomax

float

upper bound for the longitude in decimal degrees
            foreach($resources as $x)
            {
                $this->data=
                [  'url'=>$x['url'],

                'method'=>$x['method'],
                'description'=>$x['description']
            ];
         }
         
        
        
        $resources=[

            1=>['url'=>'http://localhost/AvioniApp/index.php?page=Index',
            'method'=>'GET',
            'description'=>'Get data from db']
        ];

        $this->data=[
            'resources'=>$resources
        ];*/
       
    }
    
}

?>