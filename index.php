<?php
    $link = mysqli_connect("localhost", "adalberto", "password", "project1");

    if(mysqli_connect_error()) {
        die("There was an error connecting to the database.");
    }

    $query = "SELECT * FROM person";

    if(mysqli_query($link, $query)) {
        echo "Query was successful!";
    }
?>