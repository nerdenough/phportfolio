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
            $mysql['db_prefix'] = DB_PREFIX;

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
        $result = mysqli_query($mysql['connection'], "SELECT * FROM {$mysql['db_prefix']}categories");

        // Database has categories
        while ($row = mysqli_fetch_array($result))
        {
            $category = new Category($row['category_title'], $row['category_description']);
            $portfolio->addCategory($category);
        }

        // Find all projects
        $result = mysqli_query($mysql['connection'], "SELECT * FROM {$mysql['db_prefix']}projects");

        // Database has projects
        while ($row = mysqli_fetch_array($result))
        {
            $title = $row['project_title'];
            $description = $row['project_description'];
            $category_title = $row['project_category'];
            $link = $row['project_link'];
            $thumbnail = $row['project_thumbnail'];

            $project = new Project($title, $description);
            $project->setLink($link);
            $project->setThumbnail($thumbnail);

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
        //db_close();
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

        $result = mysqli_query($mysql['connection'], "SELECT $option FROM {$mysql['db_prefix']}options");

        while ($row = mysqli_fetch_array($result))
        {
            return $row[$option];
        }

        db_close();
    }

    /**
     * Displays all projects on the page.
     */
    function display_all_projects()
    {
        global $portfolio;

        echo "<div id='portfolio'>";

        // Display each project
        foreach ($portfolio->getProjects() as $project)
        {
            echo "<div class='project-container'><a href='?project={$project->getTitle()}'><div class='project'>
                    <div class='project-title'>{$project->getTitle()}</div>
                </div></a></div>";
        }

        echo "</div>";
    }

    /**
     * Returns all projects of a certain category on the page.
     * @param string $category category title
     * @return array
     */
    function get_projects_in_category($category)
    {
        global $portfolio;

        $projects = array();

        foreach ($category->getProjects() as $project)
        {
            array_push($projects, $project);
        }

        return $projects;
    }

    function display_project($project)
    {
        global $portfolio;

        $project = $portfolio->getProjectByTitle($project);
        $external_link = $project->getLink('external');

        echo "<div class='project'>
            <div class='thumbnail-wide' style='background:url(/images/thumbs/{$project->getThumbnail()}) center no-repeat; background-size: cover'>
                <div class='thumbnail-overlay' style='background:url(/images/thumbs/overlay.png) center; background-size: contain'>
                    <div class='container'><div class='project-title'><a href='./?project={$project->getTitle()}'>{$project->getTitle()}</a></div></div>
                </div>
            </div>
            <div class='container'>
                <div class='project-content'>
                    {$project->getDescription()}
                    <p>External Link: <a href='$external_link'>$external_link</a></p>
                </div>
            </div>";

        echo "</div>";
    }

    function add_project($title, $description, $category, $link, $thumbnail)
    {
        global $mysql;

        db_connect();

        $query = "INSERT INTO " . DB_PREFIX . "projects (project_title, project_description, project_category, project_link, project_thumbnail) VALUES ('$title', '$description', '$category', '$link', '$thumbnail')";
        $result = mysqli_query($mysql['connection'], $query);

        // Return whether project was successfully added or not
        return $result;
    }

    function db_delete_category($title)
    {
        global $mysql;
        global $porfolio;

        db_connect();

    $category_projects =    get_projects_in_category($portfolio->getCategoryByTitle($title)->getProjects());

        foreach ($category_projects as $project)
        {
            $query = "UPDATE {$mysql['db_prefix']}projects SET project_category='Uncategorized' WHERE project_category='$title'";
            mysqli_query($mysql['connection'], $query);
        }

        $query = "DELETE FROM {$mysql['db_prefix']}categories WHERE category_title='$title'";

        $result = mysqli_query($mysql['connection'], $query);

        if (!$result)
        {
            echo "Error: " . mysqli_error($mysql['connection']);
        }
    }

?>
