<?php
session_start();

/*  $db = new mysqli("localhost", "root", "", "blog_system"); // Change credentials */

$db = new mysqli('localhost', 'root', '', 'blog_system'); // Change credentials

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>