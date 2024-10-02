<?php

require_once('core.functions.php');
require_once('system/exception/SystemException.class.php');
class AppCore
{


        protected static $dbObj=null;


        function __construct()
        {
            $this->initDB();
            require_once('util/RequestHandler.class.php');
            RequestHandler::handle();

        }

       private static $num=0;
        static function handleException()
        {
            AppCore:: $num++;
      
            if($num<=1)
            {
                    echo "<br>FATAL ERROR handleException <br>";
                    require_once('view/error.tpl.php');
                    header("HTTP/1.1 404 NOT FOUND FATAL ERROR handleException");}

            else
            {

            }
      
        }
        //for Warning errors
        public static function handleErrorexception($ernumber,$errname,$errPage,$eLast)
        {
       
    
                $message= "ERROR WARNING SE DOGODIO-->[$errname]<br>--------------[$errPage]<br>--NA LINIJI BROJ----[$eLast]<br>";
                AppCore::sendError($message);
                echo "<br>ERROR WARNING handleErrorexception <br>";
                require_once('view/error.tpl.php');
                header("HTTP/1.1 405 ERROR WARNING handleErrorexceptio");
     
        
       
        }

        protected function initDB()
        {
            //stvara objekt db a
            $dbHost=$dbUser=$dbPassword=$dbName='';
            
            require_once('config.inc.php');

            require_once('model/MySQLiDatabase.class.php');

            self::$dbObj=new MySQLiDataBase($dbHost,$dbUser,$dbPassword,$dbName);


        }
        final public static function getDB()
        {
            //dohvaca postavljeni  objekt
            return AppCore::$dbObj;
        }

        function initOptions()
        {
            require_once('system/options.inc.php');
        }



        //fake test slanje emaila

        private static function sendError($mess)
        {
            //mail("zelicantonio5@gmail.com","ERROR-PORUKA",$mess);
               
        }

}
?>