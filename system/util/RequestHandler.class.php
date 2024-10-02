<?php


class RequestHandler
{
    public function __construct($className)
    {
        $className=$className."Page";
        require_once('system/control/'.$className.'.class.php');
        new $className();
    }

   public static function handle()
   {

        $request=$_GET['page']??'Index';
        new RequestHandler($request);
   }


}
?>