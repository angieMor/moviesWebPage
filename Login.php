<?php      
include('ClassUser.php');
# New object is created from the class User
$user = new User(); 

# Validating if the fields are filled propertly as we asked in the Registration section
if(isset($_POST["UsernameLogin"]) && isset ($_POST["PasswordLogin"])){
    $errors = $user->validateUser($_POST["UsernameLogin"], $_POST["PasswordLogin"]); 
    
    if(empty($errors['uerror']) && empty($errors['perror'])) {
        # Validates if the user exists in the JSON/database
        $errors = $user->userExists($_POST["UsernameLogin"], $_POST["PasswordLogin"]);   
    }
}
?>
<!-- Font API -->
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<!-- CSS file -->
<link rel='stylesheet' href='FrontEnd.css' type='text/css'> 

<body>
<!-- The form pass the info stored in POST to itself -->
<form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
<div class='backgroundColor'> 
    <br></br>
    <h1 class='title'> Welcome to Cuevanna++ </h1>
    <h2 class = 'title'> Already registered? Let's start with signing you in</h2>
</div>
<br></br>
<div class = 'labels'>
    <input type='text' class='input' name='UsernameLogin' placeholder="Your Username" value="<?= $_POST['UsernameLogin']?>">
    <!-- Message will show when the Username as asked in the Registration section -->
    <span class='error'> <?= $errors['uerror']?></span>
    <!-- Message will show when the Username field of this Login section is empty -->
    <span class='error'> <?= $errors['nameUserErr']?></span>
    <!-- Message will show when the user already exists in the JSON file (its registered) -->
    <span> <?= $errors['loggin in']?></span> 
    <!-- Message will show when the Username is not registered yet but the user tries to loggin in -->
    <span> <?= $errors['not registered']?></span>
    <br></br>
    <input type='password' class='input' name='PasswordLogin' placeholder="Your Password" value="<?= $_POST['PasswordLogin']?>">
    <span class='error'> <?= $errors['perror']?></span> <!-- this error will show up if the Password is not like we asked in the Registration section-->
    <span class='error'> <?= $errors['passUserErr']?></span> <!-- this message will show up if the Password field is empty-->
    <br></br>
</div>
<br></br>
<br></br>
<div class = 'buttons'>
    <!-- Button to take back the user to the Registration section -->
    <input type = 'button' class='input' onclick = 'location.href="PrincipalWeb.php"' value="Register">
    <!-- Button Submit from the Login section -->
    <input type = 'submit' class='input'  value = 'Log in'> 
</div>
<img class='imageLog' src='Talent.png'></img> 
<img class='imageLog2' src='Movies.png'></img>
</form>   
</body>