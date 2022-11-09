<?php
include('ClassMovies.php');
session_start();
# Validates if the user isn't loggedin and for some reason tries to reach this webpage
if(!isset($_SESSION['USERDATA']['USERNAME'])) {
    #Takes him back to the Login area
    header("location:Login.php");
    exit;
}

$movies = new Movies();
# If theres info in the field Title of the website and the user had clicked the Search button
if($_POST['Title'] && $_POST['Search']) {
    # Constructing the url based on the Title and/or year written by the user
    $link = $movies->constructUrl($_POST['Title'], $_POST['Year']); 
    # Making the curl request with the passing the url needed
    $Api = $movies->curlForApi($link);
    # Organize the movie elements in ascendent or descendent
    $Api = $movies->orderMovies($Api, $_POST['order']); 
}
if($_POST['save'] && $_POST['Title']){ 
    $stored = $movies->storeApi($_POST['Title']);
}

# Initialization of the variable that will be filled with the movies info
$moviesHTML = '';
foreach ($Api as $movie) { 
    $moviesHTML = $moviesHTML . '<h3>' . $movie["Title"] . '</h3>' .
    '<p>' . $movie["Year"] . '</p>' .
    '<p>' . $movie["Type"] . '</p>' .
    "<img src = {$movie["Poster"]} >" . '<br>'.'</br>' . '<br>'.'</br>';
}



?>
<!-- Font from google API -->
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<!-- CSS file -->
<link rel='stylesheet' href='FrontEnd.css' type='text/css'> 

<body>
<div class='backgroundColor'>
<h1> Cuevana ++ </h1>
</div>
<!-- The form pass the info stored in POST to itself -->
<form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">   
    <div class='fields'>
        <!-- Title input to type the desired movie/serie to look for-->
        <input type= "text" class = 'input' placeholder='Title' name='Title' value="<?= $_POST['Title']?>"> 
        <br></br>
        <!-- Year input, to search the year of the movies wanted -->
        <input type= "text" class = 'input' placeholder='Year' name='Year' value="<?= $_POST['Year']?>"> 
        <br></br>
        <select name="order">
            <!-- Ascendent or Descendent order -->   
            <option value="1">Asc</option>
            <option value="2">Desc</option>
        </select>
        <label><input type="checkbox" name="sortTitle">Sort by Title</label>
        <label><input type="checkbox" name="sortYear">Sort by Year</label>
        <br><br>
        <input type= 'submit' value="Search" name='Search'>
        <!-- This button will download the Api desired in the text file movieList.txt -->
        <input type="submit" name="save" value='Save the info'> 
        <br>
        <!-- this message will show to the user if he had clicked on the 'Save the API' button -->
        <span> <?= $stored ?></span> 
    </div>
</form>
<img class='imageL3' src='Talent.png'></img>
<img class='image3' src='Movies.png'></img>
<div class ="logout">
    <!-- Logout button, needed to close the session/account-->
    <input type= "button" value= 'Log out' onclick= 'location.href="LogOut.php"'> 
</div>
<div class='movies'>
    <!-- The movies will be shown-->
    <?= $moviesHTML ?> 
</div>
</body>