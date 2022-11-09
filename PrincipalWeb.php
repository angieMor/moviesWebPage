<?php      
include('ClassUser.php');
$user = new User();
# Making sure that all the fields have info
if(isset($_POST["Username"]) && isset ($_POST["Password"]) && isset($_POST["Email"]) && isset($_POST['Phone'])){
    $errors = $user->validateUser($_POST["Username"], $_POST["Password"], $_POST["Email"], $_POST["Phone"]); //it is assigned to a variable, the new object with the desired function to be used
    if(empty($errors)) {
        # The user gets validated
        $errors = $user->newUser($_POST["Username"], $_POST["Password"]); 
    }
}
?>
<!-- Font from the google API -->
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> 
<!-- CSS file -->
<link rel='stylesheet' href='FrontEnd.css' type='text/css'> 

<body>
<div class='backgroundColor'>
    <!-- The form pass the info stored in POST to itself -->
    <form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post"> 
    <h1 class='title'> Welcome to Cuevanna++ </h1>
    <h2 class='title'> do you want to watch movies and series!?</h2>
</div>

    <p class = 'websitedesc'> Want to begin? Let's start with creating your new user </p> 
    <span class='error'> <?= $errors['registrated'] ?> </span>
    <!-- User got registered -->
    <span> <?= $errors['success'] ?> </span> 
    <br></br>
    <div class = 'labels'>
        <input type='text' class='input' name='Username' placeholder="Your Username" value="<?= $_POST['Username']?>">
        <!-- Error shows that the name field doesn't have the minimum conditions to be a valid username -->
        <span class='error'> <?= $errors['uerror'] ?> </span> 
        <br></br>
        <input type='password' class='input' name='Password' placeholder="Your Password" value="<?= $_POST['Password']?>">
        <span class='error'> <?= $errors['perror'] ?> </span>
        <br></br>
        <input type='text' class='input' name='Email' placeholder="Your Email" value="<?= $_POST['Email']?>">
        <span class='error'> <?= $errors['eerror'] ?> </span>
        <br></br>
        <input type='text' class='input' name='Phone' placeholder="Your Phone" value="<?= $_POST['Phone']?>">
        <span class='error'> <?= $errors['ephone'] ?> </span>   
    </div>
    <br></br>
    <br></br>
    <br></br>
    <br></br>
    <div class = 'buttons'>
        <!-- Register button -->
        <input type = 'submit' class='input' value="Register"> 
        <!-- User can be redirected to the Login site -->
        <input type = 'button' class='input' onclick = 'location.href="Login.php"' value = 'Log in'>
    </div>
    <img class='image' src='Talent.png'></img>
    <img class='image2' src='Movies.png'></img>
    </form>    
</body>