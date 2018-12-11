<?php require_once("inc_OnlineStoresDB.php"); ?>

<!doctype html>

<!--

Exercise 02.10.01

Author: Abraham Aguilar
Date: 12.10.18

GourmetCoffee.php

-->

<html>

<head>
    <title>Gourmet Coffee</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>Gourmet Coffee</h1>
    <h2>Description goes here</h2>
    <p>Welcome message goes here</p>
    <p>Inventory goes here</p>
    <?php
    if (count($errorMsgs) > 0) {
        foreach ($errorMsgs as $msg) {
            echo "<p>$msg</p>\n";
        }
    }
    ?>
</body>

</html>
