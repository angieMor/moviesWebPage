<?php

class Movies {


    # Search from the API with the movie title that the user will give us
    function constructUrl($title, $year=''){ 
        $url = 'https://www.omdbapi.com/?s=';
        $url = $url.$title; 
        if(!empty($year)) { 
            $url = $url.'&y='.$year.'&apiKey=fc59da33';
        } else { 
            $url = $url.'&apiKey=fc59da33';
        }
        return $url;
    }


    # Making a GET request with the url needed
    function curlForApi($url) {
        $ch = curl_init($url);
        # these 2 CURLOPT_SSL  were needed due to an error of SSL certificate with the curl metod
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, GET);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);        

        $information = json_decode($data, true);
        $information = $information['Search'];

        return $information;
    }


    #Organices the movies per ascendent or descendent form
    function orderMovies($array, $order) { 
        switch($order) {

            # Ascendent
            case 1:     
                if(isset($_POST['sortTitle'])){
                    usort($array, function($a, $b) { return strcmp($a['Title'], $b['Title']); });
                }
                else if(isset($_POST['sortYear'])){
                    usort($array, function($a, $b) { return $a['Year'] - $b['Year']; });
                }
                break;

            # Descendent
            case 2:     
                if(isset($_POST['sortTitle'])){
                    usort($array, function($a, $b) { return strcmp($a['Title'], $b['Title']); });
                    $array = array_reverse($array);
                }
                else if(isset($_POST['sortYear'])){
                    usort($array, function($a, $b) { return $a['Year'] - $b['Year']; });
                    $array = array_reverse($array);
                }
                break;
        }

        return $array;
    }
    

    # Store the API in the created movieList.txt
    function storeApi($name){
        # Build the url for search the movies/series desired
        $url = $this->constructUrl($name);
        # Get the Json from the API 
        $data = $this->curlForApi($url);
        # Open the file movieList.txt
        $storage = fopen("movieList.txt", "w");
        # Writing in the movieList.txt the info of the url that was gotten
        fwrite($storage, json_encode($data));  
        $success = "A file with your search was created!";
        return $success;
    }

}
?>