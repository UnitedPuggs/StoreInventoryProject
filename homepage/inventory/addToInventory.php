<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Adding</title>
    <link rel="stylesheet" href="addstyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/inventorypage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Add to Inventory</h1>

    <?php
        $servername = "mariadb";
        $username = "cs332u24";
        $password = "qT7SwEpE";
        $dbname = "cs332u24";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $deptNames = $conn->query("SELECT deptName FROM Departments;");
        $supplierNames = $conn->query("SELECT supplierID FROM Supplier;");
    ?>
    <div class="invbody">
        <form method="post" action="addToInventory.php" class="inventoryform">
            <div class="invdesc"> 
            <label for="itemUPC" class="inventorybtn upc">UPC:</label>
            <input type="number" name="itemUPC" id="itemUPC" min="100000000000" max="999999999999" placeholder="000000000000" step="1" required>
            <label for="itemDept" class="inventorybtn dept">Department:</label>
            <select name="dptselect" required>
                <optgroup label="Departments">
            <?php
                while($rows = $deptNames->fetch_assoc()) {
                    $department = $rows['deptName'];
                    echo "<option value='$department'>$department</op>";
                }
            ?>
                </optgroup>
            </select>
            <label for="itemRestockAmt" class="inventorybtn restock">Restock Amount:</label>
            <input type="number" name="itemRestock" id="itemRestock" min="0" max="9999" placeholder="0" step="1" required>
            <label for="itemPrice" class="inventorybtn price">Item Price: $</label>
            <input type="number" name="itemPrice" id="itemPrice" min="0" max="9999999" step="0.01" placeholder="0" required>
            <label for="itemSalePrice" class="inventorybtn saleprice">Item Sale Price: $</label>
            <input type="number" name="itemSalePrice" id="itemSalePrice" min="0" max="9999999" step="0.01" placeholder="0" required>
            <label for="itemWholesalePrice" class="inventorybtn wholesaleprice">Item Wholesale Price: $</label>
            <input type="number" name="itemWholesalePrice" id="itemWholesalePrice" min="0" max="9999999" step="0.01" placeholder="0" required>
            <label for="itemCurrStock" class="inventorybtn currentstock">Current Stock: </label>
            <input type="number" name="itemCurrStock" id="itemCurrStock" min="0" max="9999" placeholder="0" step="1" required>
            <label for="supplierID" class="inventorybtn supplier">Supplier ID: </label>
            <select name="suppselect" required>
                    <optgroup label="Suppliers">
                        <?php
                            while($rows = $supplierNames->fetch_assoc()) {
                                $supplier = $rows['supplierID'];
                                echo "<option value='$supplier'>$supplier</op>";
                            }
                        ?>
                    </optgroup>
                </select>
            <label for="expiration" class="inventorybtn expiration">Expiration Date: </label>
            <input type="date" name="expirationDate" id="expiration" value="2000-01-1" min="2000-01-01" max="2100-01-01" required>
            <input type="submit" value="Add Item">
            <?php
                $itemUPC = $_POST["itemUPC"];
                $itemDept = $_POST["dptselect"];
                $itemRestock = $_POST["itemRestock"];
                $itemPrice = $_POST["itemPrice"];
                $itemSalePrice = $_POST["itemSalePrice"];
                $itemWholeSale = $_POST["itemWholesalePrice"];
                $itemStock = $_POST["itemCurrStock"];
                $supplier = $_POST["supplierID"];
                $expiration = $_POST["expirationDate"];

                /*$test = $conn->prepare("INSERT INTO temp(IP) VALUES(?);");
                $test->bind_param("s", $_SERVER['REMOTE_ADDR']);
                $test->execute();*/
                

                $insert = $conn->prepare("INSERT INTO Item(UPC, itemDept, itemRestockAmt, itemPrice, itemSalePrice, itemWholeSalePrice, itemCurrStock, supplierID) 
                           VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
                $insert->bind_param("isidddis", $itemUPC, $itemDept, $itemRestock, $itemPrice, $itemSalePrice, $itemWholeSale, $itemStock, $supplier);
                $insert->execute();

                $insertExp = $conn->prepare("INSERT INTO ItemExpirations(itemUPC, itemExpDate) VALUES(?, ?);");
                $insertExp->bind_param("is", $itemUPC, $expiration);
                $insertExp->execute();
            ?>
            </div>
        </form>
    </div>
    <div>
    <?php   
        $sql = "SELECT * FROM Item";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            echo "<table class=\"addTable\">
            <tr><th>UPC</th>
            <th>Department</th>
            <th>Restock</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Wholesale Price</th>
            <th>Current Stock</th>
            <th>Supplier ID</th>";
        
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td>" . $row["UPC"] . "</td>" .
            "<td>" . $row["itemDept"] . "</td>" .
            "<td>" . $row["itemRestockAmt"] . "</td>" .
            "<td>" . $row["itemPrice"] . "</td>" .
            "<td>" . $row["itemSalePrice"] . "</td>" .
            "<td>" . $row["itemWholeSalePrice"] . "</td>" .
            "<td>" . $row["itemCurrStock"] . "</td>" .
            "<td>" . $row["supplierID"] . "</td"
            . "</tr>";
        }
        echo "</table>";
    }
    ?>
    </div>
</body>
</html>