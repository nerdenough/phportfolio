<?php

    // Require core files
    require_once 'includes/config.php';
    require_once 'includes/functions.php';

    // Create a new Portfolio object
    $portfolio = new Portfolio();

    // Load categories and projects from database
    db_load();

    // Allow other pages to load
    define('SHOULD_LOAD', true);

    // Include header file
    if (file_exists(get_option('theme_path') . 'header.php'))
    {
        include get_option('theme_path') . 'header.php';
    }
    else
    {
        echo "<p>Could not locate header.php!</p>";
    }

    // Include content file
    if (file_exists(get_option('theme_path') . 'content.php'))
    {
        include get_option('theme_path') . 'content.php';
    }
    else
    {
        echo "<p>Could not locate content.php!</p>";
    }

?>
