<?php
//zastita od SQL na liniji 99
require_once('system/AbstractPage.class.php');
require_once('system/exception/SystemException.class.php');
class TestPage extends AbstractPage
{

    public  $templateName="Test";

    function execute()
    {
      
        $this->GetData();


    }


    private function GetData()
    {
        
        $url = 'https://opensky-network.org/api/states/all?lamin=45.8389&lomin=5.9962&lamax=47.8229&lomax=10.5226';

        $ch = curl_init($url);

        // Set cURL options


        curl_setopt($ch,CURLOPT_TIMEOUT,4);
        $x=curl_exec($ch);



        // Timeout in seconds
        curl_close($ch);
        var_dump($x);

    }



}
?>