<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Purchasing</title>
    <link rel="stylesheet" href="buystyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/inventorypage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Buy an Item</h1>

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
        $transactionID = $conn->query("SELECT DISTINCT transactionID FROM Transactions;");
        $customerID = $conn->query("SELECT customerID FROM Customers;");
    ?>
    <!-- JS to more dynamically populate transactions dropdown -->
    <script type="text/javascript">
        function populateTransactions(transactionID) {
            var option = document.createElement("option");
            option.text=transactionID;
            option.value=transactionID;
            var select = document.getElementById("transactselection");
            select.appendChild(option)
        }
    </script>

    <div class="buy-container">
        <form method="post" action="buyItem.php">
            <div class="buy-inner">
                <label for="itemUPC" class="inventorybtn upc">UPC: </label>
                <select name="upcselect" required>
                    <optgroup label="UPCs">
                        <?php
                            while($rows = $upcNums->fetch_assoc()) {
                                $upc = $rows['UPC'];
                                echo "<option value='$upc'>$upc</op>";
                            }
                        ?>
                    </optgroup>
                </select>
                <label for="itemAmount" class="inventorybtn amt">Amount: </label>
                <input type="number" name="itemAmount" id="itemAmount" min=1 max=9999 placeholder=0 step=1 required>
                <label for="customerID" class="inventorybtn customer">Customer ID: </label>
                <select name="customerselect" required>
                    <optgroup label="Customers">
                        <?php
                            while($rows = $customerID->fetch_assoc()) {
                                $customer = $rows['customerID'];
                                echo "<option value='$customer'>$customer</option>";
                            }
                        ?>
                    </optgroup>
                </select>
                <label for="transactionID" class="inventorybtn transaction">Transaction ID: </label>
                <select name="transactselect" id="transactselection" required>
                        <option value="sltnew" selected disabled hidden>Select a Transaction</option>
                        <option value="newtransaction">New Transaction</option>
                        <?php
                            while($rows = $transactionID->fetch_assoc()) {
                                $transaction = $rows['transactionID'];
                                echo '<script type="text/javascript">
                                      populateTransactions(' . $transaction . ');
                                      </script>';
                            }
                        ?>
                </select>
                <input type="submit" value="Add to cart" class="buysubmit">
                <?php
                    $newChoice = $_POST['transactselect'];
                    if($newChoice == "newtransaction") {
                        $newChoice = rand(100000000, 999999999);
                    }
                    $upcSelected = $_POST['upcselect'];
                    $customerSelected = $_POST['customerselect'];
                    $itemAmount = $_POST['itemAmount'];

                    $itemPrice = $conn->prepare("SELECT itemPrice FROM Item WHERE UPC = " . $upcSelected . ";");
                    $itemPrice->execute();
                    $result = $itemPrice->get_result();
                    while($row = $result->fetch_assoc())
                        $price = $row['itemPrice'];


                    $buyInsert = $conn->prepare("INSERT INTO Transactions(transactionID, transactionOccur, itemUPC, transactionItemAmt, transactionItemPrice, customerID)
                                                 VALUES(?, ?, ?, ?, ?, ?);");
                    $buyInsert->bind_param("dsiids", $newChoice, date("Y-m-d h:i:s"), $upcSelected, $itemAmount, $price, $customerSelected);
                    $buyInsert->execute();

                    //JS to make it so the form doesn't submit after refresh
                    echo '<script type="text/javascript">
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                        </script>';

                    echo '<script type="text/javascript">
                            populateTransactions( ' . $newChoice . ');
                            transactselection.value = ' . $newChoice . ';
                          </script>';
                ?>
            </div>
        </form>
    </div>
    <div class="receipt-table">
        <?php
            echo '<h1>Receipt for ' . $newChoice. '</h1>';
            if($_POST['transactselect'] == "newtransaction")
            $receiptQuery = "SELECT * FROM Transactions WHERE transactionID = " . $newChoice . " AND customerID = '" . $customerSelected .  "' ORDER BY transactionOccur DESC;";
            else
            $receiptQuery = "SELECT * FROM Transactions WHERE transactionID = " . $_POST['transactselect'] . " AND customerID = '" . $customerSelected .  "' ORDER BY transactionOccur DESC;";
           
            $receiptResult = mysqli_query($conn, $receiptQuery);

            if(mysqli_num_rows($receiptResult) > 0) {
                echo "<table class='transactionsTable'>
                      <tr><th>Transaction ID</th>
                      <th>Occured At</th>
                      <th>UPC</th>
                      <th>Item Amount</th>
                      <th>Item Price</th>
                      <th>Customer ID</th>";
                while($row = mysqli_fetch_assoc($receiptResult)) {
                    echo "<tr>
                    <td>" . $row['transactionID'] . "</td>" .
                    "<td>" . $row['transactionOccur'] . "</td>" .
                    "<td>" . $row['itemUPC'] . "</td>" .
                    "<td>" . $row['transactionItemAmt'] . "</td>" .
                    "<td>" . $row['transactionItemPrice'] . "</td>" .
                    "<td>" . $row['customerID'] . "</td></tr>";
                }
                echo "</table>";
            }
        ?> 
    </div>
</body>
</html>