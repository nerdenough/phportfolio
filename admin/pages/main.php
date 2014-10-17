<?php

if (!defined('SHOULD_LOAD'))
{
    header('Location: ../');
    die();
}
else
{
    db_load();
    if (empty($portfolio->getProjects()))
    {
        include 'addproject.php';
    }

    else
    {
        ?>

<div id="wrap">
    <h1>Your Projects</h1>
    <br>
    <p><a href="?addproject=true">Create New Project</a></p>
    <br>
    <table id="projects">
        <?php

        foreach($portfolio->getCategories() as $category)
        {
            echo "<tr id='title'><td>{$category->getTitle()}:</td></tr>";
            if (empty($category->getProjects()))
            {
                echo "<tr><td>There are no projects in this category!</td><td><a href='?delete_category={$category->getTitle()}'>Delete?</a></td></tr>";
            }
            else
            {
                echo "<tr><td>Project Title:</td><td>Project Description:</td><td>Link:</td><td>Thumbnail:</td></tr>";
                foreach ($category->getProjects() as $project)
                {
                    echo "<tr><td>{$project->getTitle()}</td><td>{$project->getDescription()}</td><td>{$project->getLink()}</td><td>{$project->getThumbnail()}</td></tr>";
                }
            }
        }

        ?>
    </table>

    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
</div>

        <?php
    }
}

?>
