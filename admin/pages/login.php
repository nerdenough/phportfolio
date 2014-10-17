<div class="outer">
    <div class="middle">
        <div class="inner">
            <h1>Login</h1>
            <br>
            <form action="index.php" method="post">
                <table>
                    <tr><td>Username:&nbsp;</td><td><input type="text" name="username"></td></tr>
                    <tr><td>Password:&nbsp;</td><td><input type="password" name="password"></td></tr>
                    <tr><td></td><td><input type="submit" value="Login"></td></tr>
                </table>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            </form>
        </div>
    </div>
</div>
