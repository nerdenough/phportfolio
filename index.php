<?php

    // Redirect to install location if it exists
    if (is_dir('./install'))
    {
        header('Location: ./install');
    }

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

    // No project or category specified
    if (isset($_GET['project']) || isset($_GET['category']))
    {
        // Project is specified
        if(isset($_GET['project']))
        {
            display_project($_GET['project']);
        }
        // Category is specified
        else if (isset($_GET['category']))
        {
            display_projects_in_category($portfolio->getCategoryByTitle($_GET['category']));
        }
    }
    // No project or category is specified
    else
    {
        display_all_projects();
    }

    // Include header file
    if (file_exists(get_option('theme_path') . 'footer.php'))
    {
        include get_option('theme_path') . 'footer.php';
    }
    else
    {
        echo "<p>Could not locate footer.php!</p>";
    }

?>
