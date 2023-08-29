<?php
    mysqli_connect("localhost", "adalberto", "password", "project1");

    if(!mysqli_connect_error()) {
        echo "Database connection successful!";
    }
    else {
        echo "There was an error connecting to the database!";
    }
?>