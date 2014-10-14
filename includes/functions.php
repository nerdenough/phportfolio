<?php

    /**
     * Functions used by "Portfolio Project"
     */

    // Include necessary classes
    function __autoload($class_name)
    {
        include_once 'class/' . $class_name . '.inc.php';
    }

    // MySQL
    $mysql = array();

    // Disable default error reporting
    //error_reporting(0);

    /**
     * Output any errors to the user.
     * @param string $filename filename
     * @param int $line line number
     * @param string $error error message
     */
    function error($filename, $line, $error)
    {
        die("File: $filename<br>Line: $line<br>Error: $error");
    }

    /**
     * Connects to MySQL and selects the database.
     */
    function db_connect()
    {
        // Globalize variables
        global $mysql;

        // Connect to MySQL and add it to the array
        $mysql['connection'] = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or error(__FILE__, __LINE__, mysqli_connect_error());

        // Check whether the connection exists in the array
        if (!$mysql['connection'])
        {
            // Connection does not exist
            error(__FILE__, __LINE__, mysqli_error());
        }
        else
        {
            // Select the database to use
            $mysql['database'] = mysqli_select_db($mysql['connection'], DB_NAME) or error(__FILE__, __LINE__, mysqli_error($mysql['connection']));

            // Database does not exist
            if (!$mysql['database'])
            {
                error(__FILE__, __LINE, mysqli_error());
            }
        }
    }

    /**
     * Closes the connection to the database.
     */
    function db_close()
    {
        global $mysql;
        mysqli_close($mysql['connection']);
    }

    /**
     * Loads the database.
     */
    function db_load()
    {
        // Globalize variables
        global $mysql;
        global $portfolio;

        // Connect to the database
        db_connect();

        // Find all categories
        $result = mysqli_query($mysql['connection'], "SELECT * FROM test_categories");

        // Database has categories
        while ($row = mysqli_fetch_array($result))
        {
            $category = new Category($row['title'], $row['description']);
            $portfolio->addCategory($category);
        }

        // Find all projects
        $result = mysqli_query($mysql['connection'], "SELECT * FROM test_projects");

        // Database has projects
        while ($row = mysqli_fetch_array($result))
        {
            $title = $row['title'];
            $description = $row['description'];
            $category_title = $row['category'];

            $project = new Project($title, $description);

            $portfolio->addProject($project);

            foreach ($portfolio->getCategories() as $category)
            {
                if ($category->getTitle() === $category_title)
                {
                    $project->setCategory($category);
                }
            }
        }

        // Close connection
        db_close();
    }

    /**
     * Retrieves an option from the database.
     * @param string $option option to be retrieved
     * @return mixed
     */
    function get_option($option)
    {
        global $mysql;

        db_connect();

        $result = mysqli_query($mysql['connection'], "SELECT $option FROM test_info");

        while ($row = mysqli_fetch_array($result))
        {
            return $row[$option];
        }

        db_close();
    }

?>
