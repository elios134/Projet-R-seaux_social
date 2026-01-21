<?php 
abstract class Db{
    private static $instance;

    protected static function connect(){
        if(self::$instance===null){
            try{
                self::$instance = new PDO("mysql:host=localhost;dbname=td_ri7","root","");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch(PDOException $e){
                die($e->getMessage());
            }
        }
        return self::$instance;
    }

    protected static function disconnect(){
        self::$instance=null;
    }
}
?>