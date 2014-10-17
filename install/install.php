<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHPortfolio Install</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
</head>

<body>

<div class="outer">
    <div class="middle">
        <div class="inner">
            <?php

                // Start the session
                session_start();

                // Turn off default errors
                error_reporting(0);

                // Set current step
                $current_step = 1;

                // Process Step 1
                if (isset($_POST['db_host']) && isset($_POST['root_user']))
                {
                    // Get variables
                    $db_host = $_POST['db_host'];
                    $root_user = $_POST['root_user'];
                    $root_pass = $_POST['root_pass'];

                    // Test connection
                    $con = mysqli_connect($db_host, $root_user, $root_pass);

                    if (mysqli_connect_errno())
                    {
                        include 'steps/step1.php';
                        die("<p class='error'>Unable to connect to the server!<br>" . mysqli_connect_error() . "</p>");
                    }
                    else
                    {
                        $_SESSION['db_host'];
                        $_SESSION['root_user'];
                        $_SESSION['root_pass'];
                        $current_step = 2;
                    }
                }
                // Process Step 2
                else if (isset($_POST['db_name']) && isset($_POST['db_prefix']))
                {
                    // Get variables
                    $db_name = $_POST['db_name'];
                    $db_prefix = $_POST['db_prefix'];

                    $con = mysqli_connect($_SESSION['db_host'], $_SESSION['root_user'], $_SESSION['root_pass']);

                    $result = mysqli_query($con, "CREATE DATABASE $db_name");

                    if ($result)
                    {
	                    $db_selected = mysqli_select_db($con, $db_name);

                        if ($db_selected)
                        {
                            // Create options table
                            $result = mysqli_query($con, "CREATE TABLE " . $db_prefix . "options(id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), portfolio_title varchar(255), portfolio_description text, theme_path varchar(255))");
                            if ($result)
                            {
                                // Create categories table
                                $result = mysqli_query($con, "CREATE TABLE " . $db_prefix . "categories(id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), category_title varchar(255), category_description text)");
                                if ($result)
                                {
                                    mysqli_query($con, "INSERT INTO " . $db_prefix . "categories (category_title) VALUES ('Uncategorized')");

                                    // Create projects table
                                    $result = mysqli_query($con, "CREATE TABLE " . $db_prefix . "projects(id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), project_title varchar(255), project_description text, project_category varchar(255), project_link varchar(255), project_thumbnail varchar(255))");
                                    if ($result)
                                    {
                                        // Successfully created all tables
                                        $_SESSION['db_name'] = $db_name;
                                        $_SESSION['db_prefix'] = $db_prefix;
                                        $current_step = 3;
                                    }
                                    else
                                    {
                                        die("<p class='error'>Unable to create tables!<br>" . mysqli_error($con) . "</p>");
                                    }
                                }
                                else
                                {
                                    die("<p class='error'>Unable to create tables!<br>" . mysqli_error($con) . "</p>");
                                }
                            }
                            else
                            {
                                die("<p class='error'>Unable to create tables!<br>" . mysqli_error($con) . "</p>");
                            }
                        }
                    }
                    else
                    {
                        include 'steps/step2.php';
                        die("<p class='error'>Unable to create database!<br>" . mysqli_error($con) . "</p>");
                    }
                }
                // Process Step 3
                else if (isset($_POST['db_user']) && isset($_POST['db_pass']))
                {
                    $db_user = $_POST['db_user'];
                    $db_pass = $_POST['db_pass'];

                    $con = mysqli_connect($_SESSION['db_host'], $_SESSION['root_user'], $_SESSION['root_pass']);

                    $domain = "localhost";
                    if ($_SESSION['db_host'] !== "localhost")
                    {
                        $domain = "%";
                    }
                    $query = "CREATE USER '$db_user'@'$domain' IDENTIFIED BY '$db_pass';";
                    $query .= "GRANT SELECT, INSERT, UPDATE, DELETE on " . $_SESSION['db_name'] . ".* TO '$db_user'@'$domain'";
                    $result = mysqli_multi_query($con, $query);

                    // User has been created and privileges have been granted
                    if ($result)
                    {
                        $_SESSION['db_user'] = $db_user;
                        $_SESSION['db_pass'] = $db_pass;

                        mysqli_close($con);

                        $current_step = 4;
                    }
                    // Something has gone wrong
                    else
                    {
                        include 'steps/step3.php';
                        die("<p class='error'>Unable to create user!<br>" . mysqli_error($con) . "</p>");
                    }
                }
                // Process Step 4
                else if (isset($_POST['portfolio_title']) && isset($_POST['portfolio_description']))
                {
                    $portfolio_title = $_POST['portfolio_title'];
                    $portfolio_description = $_POST['portfolio_description'];
                    $portfolio_theme = $_POST['portfolio_theme'];

                    $con = mysqli_connect($_SESSION['db_host'], $_SESSION['root_user'], $_SESSION['root_pass'], $_SESSION['db_name']);

                    if (mysqli_connect_errno())
                    {
                        include 'steps/step4.php';
                        die("<p class='error'>Unable to connect to the server!</p>");
                    }

                    $query = "INSERT INTO {$_SESSION['db_prefix']}options (portfolio_title, portfolio_description, theme_path) VALUES ('$portfolio_title', '$portfolio_description', './includes/themes/$portfolio_theme/')";

                    $result = mysqli_query($con, $query);

                    // Successfully put into database
                    if ($result)
                    {
                        // Write MySQL information to config.php
                        $config = "<?php\n";
                        $config .= "// MySQL Config\n";
                        $config .= "define('DB_HOSTNAME', '" . $_SESSION['db_host'] . "');\n";
                        $config .= "define('DB_USERNAME', '" . $_SESSION['db_user'] . "');\n";
                        $config .= "define('DB_PASSWORD', '" . $_SESSION['db_pass'] . "');\n";
                        $config .= "define('DB_NAME', '" . $_SESSION['db_name'] . "');\n";
                        $config .= "define('DB_PREFIX', '" . $_SESSION['db_prefix'] . "')\n";
                        $config .= "?>";
                        $config_file = "../includes/config.php";

                        file_put_contents($config_file, $config);

                        $current_step = 5;
                    }
                    else
                    {
                        include 'steps/step4.php';
                        die("<p class='error'>Unable to save preferences!<br>" . mysqli_error($con) . "</p>");
                    }
                }
                // First time viewing the page
                else
                {
                    $current_step = 1;
                }

                if ($current_step === 1) { include 'steps/step1.php'; }
                else if ($current_step === 2) { include 'steps/step2.php'; }
                else if ($current_step === 3) { include 'steps/step3.php'; }
                else if ($current_step === 4) { include 'steps/step4.php'; }
                else if ($current_step === 5) { include 'steps/done.php'; }

            ?>
        </div>
    </div>
</div>
</body>
</html>
