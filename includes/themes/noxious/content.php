<?php
    // Only load if the file is being included by another page
    if (!defined('SHOULD_LOAD'))
    {
        // Redirect to root directory
        header('Location: /');
        exit();
    }
?>
<div id="portfolio">
    <?php

    // No project or category specified
    if (!isset($_GET['project']) || !isset($_GET['category']))
    {
        // Display each project
        foreach ($portfolio->getProjects() as $project)
        {
            echo "<div class='project-container'><a href='?project={$project->getTitle()}'><div class='project'>
                    <div class='project-title'>{$project->getTitle()}</div>
                </div></a></div>";
        }
    }
    else if(isset($_GET['project']))
    {

    }

    ?>
</div>
