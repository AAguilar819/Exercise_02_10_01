<?php
class OnlineStore {
    private $DBConnect  = NULL;
    private $DBName = "";
    private $storeID = "";
    private $inventory = array();
    private $shoppingCart = array();
    
    function __construct() {
        include("inc_OnlineStoresDB.php");
        $this->DBConnect = $DBConnect;
        $this->DBName = $DBName;
    }
    
    function __destruct() {
        if (!$this->DBConnect->connect_error) {
            echo "<p>Closing database <em>$this->DBName</em>.</p>\n";
            $this->DBConnect->close();
        }
    }
    
    function __wakeup() {
        include("inc_OnlineStoresDB.php");
        $this->DBConnect = $DBConnect;
        $this->DBName = $DBName;
    }
    
    public function setStoreID($storeID) {
        if ($this->storeID != $storeID) {
            $this->storeID = $storeID;
            $TableName = "inventory";
            $SQLstring = "SELECT * FROM $TableName WHERE storeID='" . $this->storeID . "'";
            $QueryResult = $this->DBConnect->query($SQLstring);
            if (!$QueryResult) {
                echo "<p>unable to execute the query, error code: " . $this->DBConnect->errno . ": " . $this->DBConnect->error . ".</p>";
            } else {
                $inventory = array();
                $shoppingCart = array();
                while (($row = $QueryResult->fetch_assoc()) != NULL) {
                    $this->inventory[$row['productID']] = array();
                    $this->inventory[$row['productID']]['name'] = $row['name'];
                    $this->inventory[$row['productID']]['description'] = $row['description'];
                    $this->inventory[$row['productID']]['price'] = $row['price'];
                    $this->shoppingCart[$row['productID']] = 0;
                }
                // echo "<pre>\n";
                // print_r($this->inventory);
                // print_r($this->shoppingCart);
                // echo "</pre>\n";
            }
        }
    }
    
    public function getStoreInformation() {
        $retval = false;
        if ($this->storeID != "") {
            $TableName = "storeinfo";
            $SQLstring = "SELECT * FROM $TableName WHERE storeID='" . $this->storeID . "'";
            $QueryResult = $this->DBConnect->query($SQLstring);
            if ($QueryResult) {
                $retval = $QueryResult->fetch_assoc();
            }
        }
        return $retval;
    }
    
    public function getProductList() {
        $retval = false;
        $subtotal = 0;
        if (count($this->inventory) > 0) {
            echo "<table width='100%'>\n";
            echo "<tr>";
            echo "<th>Product</th>\n";
            echo "<th>Description</th>\n";
            echo "<th>Price Each</th>\n";
            echo "<th># in Cart</th>\n";
            echo "<th>Total Price</th>\n";
            echo "<th>&nbsp;</th>\n";
            echo "</tr>";
            foreach ($this->inventory as $ID => $info) {
                echo "<tr>";
                echo "<td>" . htmlentities($info['name']) . "</td>\n";
                echo "<td>" . htmlentities($info['description']) . "</td>\n";
                printf("<td calss='currency'>$%.2f</td>\n", $info['price']);
                echo "<td class='currency'>" . $this->shoppingCart[$ID] . "</td>\n";
                printf("<td class='currency'>$%.2f</td>\n", $info['price'] * $this->shoppingCart[$ID]);
                echo "<td><a href='" . $_SERVER['SCRIPT_NAME'] . "?PHPSESSID=" . session_id() . "&ItemToAdd=$ID'>Add Item</a></td>";
                $subtotal += ($info['price'] * $this->shoppingCart[$ID]);
                echo "</tr>\n";
            }
            echo "<tr>";
            echo "<td colspan='4'>Subtotal</td>";
            //printf("<td calss='currency'>$%.2f</td>\n", $subtotal);
            echo "</tr>\n";
            echo "</table>\n";
            $retval = true;
        }
        return($retval);
    }
    
    public function addItem() {
        $prodID = $_GET['ItemToAdd'];
        if (array_key_exists($prodID, $this->shoppingCart)) {
            $this->shoppingCart[$prodID] += 1;
        }
    }
}


?>
