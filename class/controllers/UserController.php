<?php

class UserController extends User{

    public function fetchAll(){
        $users = User::getAllUsers();
        return $users;
    }

    public function fetch($id){
        $users = User::getUser($id);
        return $users;
    }

    public function regUser($name,$email,$phone,$password){
         $user = User::addUser($name,$email,$phone,$password);
         return $user;
     }

    public function updateUser($name,$email,$phone,$id){
        $user_update = User::update($name,$email,$phone,$id);
        return $user_update;
    }

    public function deleteUser($id){
        $user_delete = User::delete($id);
        return $user_delete;
    }

}