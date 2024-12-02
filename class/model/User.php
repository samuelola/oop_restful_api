<?php 

class User extends Dbh{

    private static $db_users = 'users';
    
    public static function addUser($name,$email,$password,$phone){
      $sql = "INSERT INTO ".self::$db_users." (name,email,password,phone,created_at) VALUES (?,?,?,?,?)";
      $stmt = Dbh::connect()->prepare($sql);
      $hashed_password = password_hash($password,PASSWORD_DEFAULT);
      $result = $stmt->execute([$name,$email,$hashed_password,$phone,Date('Y-m-d H:i:s')]);
      $last_id = Dbh::connect()->lastInsertId();
      if(!$result){
          return false;
      }else{
          return true;
      }
    
   }

    public static function setUser($email,$password){

        $sql = "SELECT * FROM ".self::$db_users." WHERE email = ?";
        $stmt = Dbh::connect()->prepare($sql);
        $result = $stmt->execute([$email]);
        if(!$result){
          header("Location:../../mvc_inventory_system/index.php");
          exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            header("Location:../../mvc_inventory_system/index.php");
            exit();
        }

        $passwordHashed = $stmt->fetchAll();
        $check_pass = password_verify($password,$passwordHashed[0]['password']);
        if($check_pass == false){
           $stmt = null;
           header("Location:../../mvc_inventory_system/index.php");
           exit();
        }
        elseif($check_pass == true){
          $newpass = $passwordHashed[0]['password'];
          $sql = "SELECT * FROM ".self::$db_users." WHERE password = ?"; 
          $stmt = Dbh::connect()->prepare($sql);
          $stmt->execute([$newpass]);
          $user = $stmt->fetchAll();
          session_start();
          $_SESSION['user_id'] = $user[0]['id'];
          $_SESSION['username'] = $user[0]['name'];
          header("Location:../../mvc_inventory_system/dashboard/index.php");
       }

    }

   public static function getAllUsers(){

       $result = static::find_by_query("SELECT * FROM ".self::$db_users." ORDER BY id DESC");
       return $result;
   }

   private static function find_by_query($sql){

       $stmt = Dbh::connect()->query($sql);
       $users = $stmt->fetchAll();
       return $users;
   }

   public static function getUser($id){
       $result = static::find_by_id("SELECT * FROM ".self::$db_users." WHERE id= ?",$id);
       return $result;
   }

   private static function find_by_id($sql,$id){
       $stmt = Dbh::connect()->prepare($sql);
       $stmt->execute([$id]);
       $user = $stmt->fetch();
       return $user;
   }

   public static function update($name,$email,$phone,$id){
       $sql = "UPDATE ".self::$db_users." SET name= ?, email= ? , phone = ? WHERE id = ?";
       $stmt = Dbh::connect()->prepare($sql);
       if($stmt->execute([$name,$email,$phone,$id])){
           $stmt = null;
           return true;
        }else{
            return false;
        }

   }

   public static function delete($id){
      $sql = "DELETE FROM ".self::$db_users." WHERE id = ?";
      $stmt = Dbh::connect()->prepare($sql);
      if($stmt->execute([$id])){
           $stmt = null;
           return true;
      }else{
            return false;
      }
   }

   public static function emailExist($email){
       $sql = "SELECT email FROM ".self::$db_users." WHERE email = ?";
       $stmt = Dbh::connect()->prepare($sql);
       $stmt->execute([$email]);
       $resultCheck;
       if($stmt->rowCount() > 0){
            $resultCheck = true;
        }else{
        $resultCheck = false;
        }
        return $resultCheck;
   }
   public static function emailNotExist($email){
       $sql = "SELECT email FROM ".self::$db_users." WHERE email = ?";
       $stmt = Dbh::connect()->prepare($sql);
       $stmt->execute([$email]);
       $resultCheck;
       if($stmt->rowCount() == 0){
            $resultCheck = true;
        }else{
        $resultCheck = false;
        }
        return $resultCheck;
   }

   public static function checkEmailExist($email){
         $email_exist = self::emailExist($email);
         return $email_exist;
     }

     public static function checkEmailNotExist($email){
         $email_exist = self::emailNotExist($email);
         return $email_exist;
     }

     

  

}