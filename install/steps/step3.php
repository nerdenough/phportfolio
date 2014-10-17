<h1>Step 3:</h1>
<br>
<p>We need to create a new MySQL user for PHPortfolio.<br>
You will use this username and password to login on the admin page.</p>
<br>
<form action="install.php" method="post">
    <table>
        <tr>
            <td>Username:&nbsp;</td><td><input type="text" name="db_user" value="<?php echo $_SESSION['db_name'] ?>"></td>
        </tr>
        <tr>
            <td>Password:&nbsp;</td><td><input type="text" name="db_pass" autocomplete="off"></td>
        </tr>
        <tr>
            <td></td><td><input type="submit" value="Next Step"></td>
        </tr>
    </table>
</form>
