<?php

if (!defined('SHOULD_LOAD'))
{
    header('Location: ../');
    die();
}

?>

<div class="outer">
    <div class="middle">
        <div class="inner">
            <h1>Create A Project</h1>
            <p>This will create a new project and add it to the database.</p>
            <br>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr><td>Project Title:&nbsp;</td><td><input type="text" name="project_title" placeholder="Project Title"></td></tr>
                    <tr><td>Project Description:&nbsp;</td><td><textarea name="project_description" placeholder="You can use <html> tags here for custom styling if you would like."></textarea></td></tr>
                    <tr><td>Category:&nbsp;</td><td><select name="project_category">
                        <?php

                        db_load();

                        foreach ($portfolio->getCategories() as $category)
                        {
                            echo "<option value='{$category->getTitle()}'>{$category->getTitle()}</option>";
                        }

                        ?>
                    </select></td></tr>
                    <tr><td>Link:&nbsp;</td><td><input type="text" name="link" placeholder="http://example.com"></td></tr>
                    <tr><td>Thumbnail (&lt;1MB):&nbsp;</td><td style="text-align:left"><input type="file" name="thumbnail"></td></tr>
                    <tr><td></td><td><input type="submit" value="Create Project"></td></tr>
                </table>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            </form>
        </div>
    </div>
</div>
