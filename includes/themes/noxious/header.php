<?php
    // Only load if the file is being included by another page
    if (!defined('SHOULD_LOAD'))
    {
        // Redirect to root directory
        header('Location: /');
        exit();
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo get_option('title') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_option('theme_path') ?>style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
    <script src="<?php echo get_option('theme_path') ?>jquery.js"></script>
</head>

<body>
    <header>
        <div class="container">
            <h1><a href="#"><?php echo get_option('title') ?></a></h1>
        </div>
    </header>

    <div id="content">
        <div class="container">
