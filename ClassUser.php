<?php
# Class User, related to the process involved in creating or authenticating the user
class User {


    # Validating the format of the fields to register
    function validateUser($name, $password, $email='', $phone='') {
        # Empty array to storage all the errors
        $out = [];

        //----- Validating the name ---------//
        if(empty($name)) {
            $uerror = 'Please add your Username';       
        } 
        # Name will only be accepted if it has only letters on it
        else if(!preg_match("/^[a-zA-Z]*$/", $name)) {
            $uerror = 'Please add a valid Username: only with letters';
        }
        
        # If there is an $uerror, then it will be stored in the array $out
        if($uerror){ 
            $out['uerror'] = $uerror;
        }

        //----- Validating the password -----//
        if(empty($password)) {
            $perror = 'Please add your Password';
        }
        # Validates uppercase letter
        else if(!preg_match("/(?=.*[A-Z])/", $password)) { 
        $perror = 'Please add a valid Password: with at least 1 uppercase';
        }
        # Validates special character        
        else if(!preg_match("/(?=.*[*-.])/", $password)) { 
            $perror = 'Please add a Password with one of these special characters(*-.)';
        }
        # Validates if contains 6 characters
        else if(!preg_match("/[A-Za-z\d*-.]{6}/", $password)) { 
            $perror = 'Please add a Password with 6 characters';
        }

        # If there is an $perror, then it will be stored in the array $out
        if($perror) { 
            $out['perror'] = $perror;
        }

        //----- Validating the email -----//
        if(empty($email)) {
            $eerror = 'Please add your Email';
        }
        # Validates if email given contain letters, and @ and . 
        else if(!preg_match("/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/", $email)) { 
            $eerror = 'Please add a valid Email: with an @ and with ".com"';
        }

        # If there is an $eerror, then it will be stored in the array $out
        if($eerror) { 
            $out['eerror'] = $eerror;
        }

        ///----- Validating the phone -----//
        if(empty($phone)) {
            $ephone = "Please add your phone number";
        }
        # Validates if phone begins with a '+'
        else if(!preg_match("/^[+]/", $phone)) { 
            $ephone = 'Please add a phone number that begins with +';
        }
        # Validates if it have 9 numbers
        else if(!preg_match("/\d{9}$/", $phone)) { 
            $ephone = 'Please add 9 numbers';
        }

        # If there is an $ephone, then it will be stored in the array $out
        if($ephone) { 
            $out['ephone'] = $ephone;
        }
        
        return $out;
    }


    # Create the new user in the database if it name doesn't exists
    function newUser($name, $password) {
        
        # Array used to store some messages for the user
        $out = []; 
        $users = array();
        # Taking the JSON/database
        $users = file_get_contents('Database.json'); 
        $users = json_decode($users, true);

        # Validate if the username is already taken
        if (array_key_exists($name,$users)) {
            $out['registrated'] =  "Username already exist";
        }
        // Otherwise the user will be created, and user will get notified
        else {
            $out['success'] = "You've registered succesfully";
            $users[$name] = $password;
            # Stores the name and password in the JSON/database file
            file_put_contents('Database.json', json_encode($users)); 
        }
        return $out;
    }


    # In Login section, validates if user is registered
    function userExists($name, $password) { 
        # Empty array used to store user errors
        $out = [];
        # Getting the JSON file
        $users = file_get_contents('Database.json', true);
        $users = json_decode($users, true);

        if(empty($name)) {
            $nameUserErr = 'Please type your Username';
            $out['nameUserErr'] = $nameUserErr;
        }
        if(empty($password)) {
            $passUserErr = 'Please type your password';
            $out['passUserErr'] = $passUserErr;
        }

        # Validates in the JSON if the name is registered
        if (array_key_exists($name, $users)) {

            /*If the $name and the $password match, then the session will 
            start and will take to the user to the actual Movie's Website*/
            if (isset($users[$name]) && $users[$name] == $password){  
                $out['loggin in'] =  "Loggin in";
                session_start();    
                $_SESSION['USERDATA']['USERNAME'] = $users[$name];
                header("Location:Movies.php");
                exit();
            }
        }
        # If not, it'll show that the user entered is not registered
        else {
            $out['not registered'] = "You're not registered, please go to the Register section";
        }

        return $out;
    }
}
?>