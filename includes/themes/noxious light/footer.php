<?php
    // Only load if the file is being included by another page
    if (!defined('SHOULD_LOAD'))
    {
        // Redirect to root directory
        header('Location: /');
        exit();
    }
?>

        <div class="container">
            <footer>
                <!-- You can remove this if you want -->
                <p>Powered by <a href="https://github.com/nerdenough/PHPortfolio" target="_blank">PHPortfolio</a></p>
            </footer>
        </div>
    </div>
</body>
</html>
