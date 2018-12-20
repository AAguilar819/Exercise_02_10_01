<?php
session_start();
// require_once("inc_OnlineStoresDB.php");
require_once("class_OnlineStore.php");
$storeID = "COFFEE";
$storeInfo = array();

if (class_exists("OnlineStore")) {
    if (isset($_SESSION['currentStore'])) {
        echo "Unserializing object.<br>";
        $Store = unserialize($_SESSION['currentStore']);
    } else {
        echo "Instantiating new object.<br>";
        $Store = new OnlineStore();
    }
    $Store->setStoreID($storeID);
    $storeInfo = $Store->getStoreInformation();
    if (isset($_GET['ItemToAdd'])) {
        $Store->addItem();
    }
    // echo "<pre>\n";
    // print_r($storeInfo);
    // echo "</pre>\n";
} else {
    $errorMsgs[] = "The <em>OnlineStore</em> class is not available.";
    $Store = NULL;
}
?>

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
    <link rel="stylesheet" type="text/css" href="<?php echo $storeInfo['cssFile']; ?>">
</head>

<body>
    <h1>
        <?php echo htmlentities($storeInfo['name']); ?>
    </h1>
    <h2>
        <?php echo htmlentities($storeInfo['description']); ?>
    </h2>

    <p>
        <?php echo htmlentities($storeInfo['welcome']); ?>
    </p>
    <?php
    // $TableName = "inventory";
    // 
    // if (count($errorMsgs) == 0) {
    //     $SQLstring = "SELECT * FROM $TableName WHERE storeID='COFFEE'";
    //     $QueryResult = $DBConnect->query($SQLstring);
    //     if (!$QueryResult) {
    //         $errorMsgs[] = "Unable to perform the query.<br> Error code: " . $DBConnect->errno . ": " . $DBConnect->error . ".";
    //     } else {
    //         echo "<table width='100%'>\n";
    //         echo "<tr>";
    //         echo "<th>Product</th>\n";
    //         echo "<th>Description</th>\n";
    //         echo "<th>Price Each</th>\n";
    //         echo "</tr>";
    //         while (($row = $QueryResult->fetch_assoc()) != NULL) {
    //             echo "<tr><td>" . htmlentities($row['name']) . "</td>";
    //             echo "<td>" . htmlentities($row['description']) . "</td>";
    //             printf("<td>$%.2f</td></tr>\n", $row['price']);
    //         }
    //         echo "</table>\n";
    //         $_SESSION['currentStore'] = serialize($Store);
    //     }
    // }
    // if (count($errorMsgs) > 0) {
    //     foreach ($errorMsgs as $msg) {
    //         echo "<p>$msg</p>\n";
    //     }
    // }
    $Store->getProductList();
    $_SESSION['currentStore'] = serialize($Store);
    ?>
</body>

</html>
