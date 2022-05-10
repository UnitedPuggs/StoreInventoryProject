<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Items Page</title>
    <link rel="stylesheet" href="orderstyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/inventorypage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Ordered Items</h1>


    <?php
        $servername = "mariadb";
        $username = "cs332u24";
        $password = "qT7SwEpE";
        $dbname = "cs332u24";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $deptNames = $conn->query("SELECT deptName FROM Departments");
    ?>

    <div class="order-container">
        <form method="post" action="orderItems.php" class="orderform">
            <div class="order-inner">
                <label for="itemDept" class="inventorybtn dept">Department:</label>
                <select name="dptselect" required>
                <option value="dptnew" selected disabled hidden>Select a Department</option>
                    <optgroup label="Departments">
                    <?php
                    while($rows = $deptNames->fetch_assoc()) {
                        $department = $rows['deptName'];
                        echo "<option value='$department'>$department</op>";
                    }
                    ?>
                    </optgroup>
            </select>
            <input type="submit" value="View">
            <?php   
                $itemDept = $_POST["dptselect"];
                $restock = "SELECT * FROM Item WHERE itemDept = '" . $itemDept . "' AND itemRestockAmt > itemCurrStock;";
                $orders = "SELECT itemUPC, orderAmt, orderPlaced, orderOnDelivery, orderDeliveryID FROM Orders INNER JOIN Item ON Orders.itemUPC = Item.UPC WHERE Item.itemDept = '" . $itemDept . "';";
            ?>
            </div>
        </form>
    </div>
    <div class="restock-table">
        <?php
            $restockResult = mysqli_query($conn, $restock);
            if(mysqli_num_rows($restockResult) > 0) {
                echo "<h1>Needs ordering</h1>
                      <table class=\"restockTable\">
                      <tr><th>UPC</th>
                      <th>Department</th>
                      <th>Restock</th>
                      <th>Price</th>
                      <th>Sale Price</th>
                      <th>Wholesale Price</th>
                      <th>Current Stock</th>
                      <th>Supplier ID</th>";
        
            while($row = mysqli_fetch_assoc($restockResult)) {
                echo "<tr>
                <td>" . $row["UPC"] . "</td>" .
                "<td>" . $row["itemDept"] . "</td>" .
                "<td>" . $row["itemRestockAmt"] . "</td>" .
                "<td>" . $row["itemPrice"] . "</td>" .
                "<td>" . $row["itemSalePrice"] . "</td>" .
                "<td>" . $row["itemWholeSalePrice"] . "</td>" .
                "<td>" . $row["itemCurrStock"] . "</td>" .
                "<td>" . $row["supplierID"] . "</td>"
                . "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
    <div class="orders-table">
        <?php
            $orderResult = mysqli_query($conn, $orders);
            if(mysqli_num_rows($orderResult) > 0) {
                echo "<h1>Orders</h1>
                      <table class=\"ordersTable\">
                      <tr><th>UPC</th>
                      <th>Ordered Amount</th>
                      <th>Order Placed On</th>
                      <th>Order On Delivery</th>
                      <th>Order Delivery ID</th>";
        
            while($row = mysqli_fetch_assoc($orderResult)) {
                if($row["orderOnDelivery"] == 0) {
                echo "<tr>
                <td>" . $row["itemUPC"] . "</td>" .
                "<td>" . $row["orderAmt"] . "</td>" .
                "<td>" . $row["orderPlaced"] . "</td>" .
                "<td>NO</td>" .
                "<td>" . $row["orderDeliveryID"] . "</td>"
                . "</tr>";
                } else {
                echo "<tr>
                <td>" . $row["itemUPC"] . "</td>" .
                "<td>" . $row["orderAmt"] . "</td>" .
                "<td>" . $row["orderPlaced"] . "</td>" .
                "<td>YES</td>" .
                "<td>" . $row["orderDeliveryID"] . "</td>"
                . "</tr>";
                }
            }
            echo "</table>";
        } else if($itemDept != "" && mysqli_num_rows($orderResult) == 0) {
            echo "<h1>No orders found!</h1>";
        }
        ?>
    </div>
</body>
</html>