<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin | PHPortfolio</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
</head>

<body>

<?php

require_once '../includes/config.php';
require_once '../includes/functions.php';
$portfolio = new Portfolio();

session_start();
$to_display = 0;

define("SHOULD_LOAD", true);

// Process Login Screen
if (isset($_POST['username']) && isset($_POST['password']))
{
    if ($_POST['username'] === DB_USERNAME && $_POST['password'] === DB_PASSWORD)
    {
        $_SESSION['portfolio_login'] = $_POST['username'];
        // Relaod the page
        header('Location: index.php');
    }
    else
    {
        $error = "Incorrect username or password!";
        include 'pages/login.php';
        die();
    }
}
else if (isset($_SESSION['portfolio_login']))
{
    // Process Adding Project
    if (isset($_POST['project_title']) && isset($_POST['project_description']))
    {
        $title = $_POST['project_title'];
        $description = $_POST['project_description'];
        $category = $_POST['project_category'];

        $link = "";
        if (isset($_POST['link']))
        {
            $link = $_POST['link'];
        }

        if ($_FILES['thumbnail']['size'] != 0 && $_FILES['thumbnail']['error'] == 0)
        {
            // Copy thumbnail to /images/thumbs
            $target_dir = "../images/thumbs/";
            $target_dir .= basename($_FILES["thumbnail"]["name"]);

            $allowed = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detected = exif_imagetype($_FILES['thumbnail']['tmp_name']);
            $thumbnail = "";

            if (in_array($detected, $allowed))
            {
                if (!file_exists($target_dir . $_FILES["thumbnail"]["name"]))
                {
                    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_dir))
                    {
                        echo "File uploaded!";
                        $thumbnail = $_FILES["thumbnail"]["name"];
                    }
                    else
                    {
                        echo "Failed upload";
                        die();
                    }
                }
                else
                {
                    echo "File exists";
                    die();
                }
            }
            else
            {
                echo "Invalid file type";
                die();
            }
        }

        if (add_project($title, $description, $category, $link, $thumbnail))
        {
            define('SUCCESS', "Project successfully created!");
            include 'pages/main.php';
        }
        else
        {
            echo "not added";
            define('ERROR', "Project could not be created!");
        }
    }
    // Add Project
    else if (isset($_GET['addproject']))
    {
        include 'pages/addproject.php';
    }
    // Delete Category
    else if (isset($_GET['delete_category']))
    {
        db_delete_category($_GET['delete_category']);
        include 'pages/main.php';
    }
    else
    {
        include 'pages/main.php';
    }
}
else
{
    include 'pages/login.php';
}


?>

</body>
</html>
