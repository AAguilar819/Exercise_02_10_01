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
                echo "<pre>\n";
                print_r($this->inventory);
                print_r($this->shoppingCart);
                echo "</pre>\n";
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
}


?>
