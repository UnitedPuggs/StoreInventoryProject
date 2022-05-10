<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order as Employee</title>
    <link rel="stylesheet" href="empOrderStyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/orderspage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Order an Item</h1>

    <?php
        $servername = "mariadb";
        $username = "cs332u24";
        $password = "qT7SwEpE";
        $dbname = "cs332u24";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $upcNums = $conn->query("SELECT UPC FROM Item;");
        $empID = $conn->query("SELECT empID FROM Employees;");
    ?>

    <div class="order-container">
        <form method="post" action="employeeOrder.php">
            <div class="order-inner">
                <label for="employeeID" class="inventorybtn empID">Employee ID: </label>
                <select name="empselect" required>
                    <optgroup label="Employee ID">
                    <option value="empnew" selected disabled hidden>Select an ID</option>
                        <?php
                            while($rows = $empID->fetch_assoc()) {
                                $emp = $rows['empID'];
                                echo "<option value='$emp'>$emp</op>";
                            }
                        ?>
                    </optgroup>
                </select>
                <label for="itemUPC" class="inventorybtn upc">UPC: </label>
                <select name="upcselect" required>
                    <optgroup label="UPCs">
                    <option value="upcnew" selected disabled hidden>Select a UPC</option>
                        <?php
                            while($rows = $upcNums->fetch_assoc()) {
                                $upc = $rows['UPC'];
                                echo "<option value='$upc'>$upc</op>";
                            }
                        ?>
                    </optgroup>
                </select>
                <label for="itemAmt" class="inventorybtn amt">Order Amount: </label>
                <input type="number" name="itemCurrStock" id="itemCurrStock" min="0" max="9999" placeholder="0" step="1" required>
                <input type="submit" value="Place Order" class="ordersubmit">

                <?php
                    $employee = $_POST['empselect'];
                    $upc = $_POST['upcselect'];
                    $amount = $_POST['itemCurrStock'];

                    $employeePermission = $conn->prepare("SELECT empPermission FROM Employees WHERE empID = " . $employee . ";");
                    $employeePermission->execute();
                    $result = $employeePermission->get_result();
                    while($row = $result->fetch_assoc())
                            $permission = $row['empPermission'];
                    
                    $orderQuery = "INSERT INTO Orders(itemUPC, orderAmt, orderPlaced, orderOnDelivery, orderDeliveryID) 
                                   VALUES(" . $upc . ", " . $amount . ", '" . date("Y-m-d") . "', 0, NULL);";

                    //echo "Query " . $orderQuery;
                    echo '<script type="text/javascript">
                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                    </script>';
                ?>
            </div>
        </form>
    </div>
    <?php 
        if($permission == 1) {
            $makeOrder = mysqli_query($conn, $orderQuery);
            echo "<h2>Order placed!</h2>";
        } else {
            echo '<script>
                  alert("Insufficient Permissions");
                  </script>';
        }
    ?>
</body>
</html>