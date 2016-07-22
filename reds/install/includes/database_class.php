<?php

class Database {

    // Function to the database and tables and fill them with the default data
    function create_database($data) {
        // Connect to the database
        $mysqli = new mysqli($data['hostname'], $data['username'], $data['password'], '');

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Create the prepared statement
        $mysqli->query("CREATE DATABASE IF NOT EXISTS " . $data['database']);

        // Close the connection
        $mysqli->close();

        return true;
    }

    // Function to create the tables and fill them with the default data
    function create_tables($data) {
        // Connect to the database
        $mysqli = new mysqli($data['hostname'], $data['username'], $data['password'], $data['database']);

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents('assets/db.sql');

        // Execute a multi query
        $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        return true;
    }

    //admin
    function create_tableadmin() {


        // Create the prepared statement
        $mysqli = new mysqli($data['hostname'], $data['username'], $data['password'], $data['database']);

        // Check for errors
        if (mysqli_connect_errno())
            return false;
        $query="INSERT into setting (idgm,title,emails,theme,password) Values ('1','My Web',emails,theme,password)";
        $mysqli->query($query);
        $mysqli->close();
        return true;
    }

}
