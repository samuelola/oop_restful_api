<?php

class Dbh{

   private static $host = "localhost";
   private static $username = "root";
   private static $pwd = "";
   private static $dbName = "oop_restful_api";
   private static $handleDB;
  
    protected static function connect(){
        try{
          $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbName;
          $pdo = new PDO($dsn,self::$username,self::$pwd);
          $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          $pdo->lastInsertId();
          return $pdo;
   
        }catch(PDOException $e){
          print "Error!:" . $e->getMessage(). "<br/>";
          die();
        }
    }


    
}