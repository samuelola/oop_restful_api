<?php
 include_once './cors.php';
 include "./class/dbh.php";
 include "./class/model/User.php";
 include "./class/controllers/UserController.php";
 include "./sanitize.php";
 include "./formatter.php";


//  ini_set("display_errors",0);

 // create a api variable to get HTTP method dynamically
    $api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['id'] ?? '');

$input = json_decode(file_get_contents('php://input'), true);

// Create object of Users class
$user = new UserController();

if ($api == 'GET') {
    if ($id != 0) {
    $data = $user->fetch($id);
    } else {
    $data = $user->fetchAll();
    }
    echo retrieve($data);
}

// Add a new user into database
if ($api == 'POST') {
    // $name = clean_input($_POST['name']);
    // $email = clean_input($_POST['email']);
    // $phone = clean_input($_POST['phone']);
    // $password = $_POST['password'];

    $name = clean_input($input['name']);
    $email = clean_input($input['email']);
    $phone = clean_input($input['phone']);
    $password = $input['password'];

    $userObject = new UserController();
    $result = $userObject->regUser($name,$email,$phone,$password);
    if($result){
        echo success('User added successfully!');
    }else{
        echo error('Failed to add an user!');
    }

} 

// Update an user in database
if ($api == 'PUT') {

    $name = clean_input($input['name']);
    $email = clean_input($input['email']);
    $phone = clean_input($input['phone']);
    if ($id != null) {
        $update  = $user->updateUser($name,$email,$phone,$id);
        if($update){
         echo retrieve('User updated successfully!');
        }else{
            echo error('Failed to update an user!');
        }
    }
    else {
      echo notfound('User not found!');
    }
}

// Delete an user from database
if ($api == 'DELETE') {
    if ($id != null) {
        $result = $user->deleteUser($id);
        if ($result) {
            echo success('User deleted successfully!');
        } else {
            echo error('Failed to delete an user!');
        }
    } else {
    echo notfound('User not found!');
    }
}

