<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Totals</title>
    <link rel="stylesheet" href="totalStyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/transactionspage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Total a Transaction</h1>

    <?php
        $servername = "mariadb";
        $username = "cs332u24";
        $password = "qT7SwEpE";
        $dbname = "cs332u24";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $customerID = $conn->query("SELECT customerID FROM Customers;");
        $transactionID = $conn->query("SELECT DISTINCT transactionID FROM Transactions;");
    ?>
    <div class="total-container">
    <form method="post" action="totalTransactions.php" class="totalform">
        <div class="total-inner">
        <label for="customerID" class="inventorybtn customer">Customer ID: </label>
            <select name="customerselect" required>
                <optgroup label="Customers">
                    <option value="custselect" selected disabled hidden>Select a Customer</option>
                    <?php
                        while($rows = $customerID->fetch_assoc()) {
                            $customer = $rows['customerID'];
                            echo "<option value='$customer'>$customer</option>";
                        }
                    ?>
                </optgroup>
            </select>
        <label for="customerID" class="inventorybtn customer">Transaction ID: </label>
            <select name="transactselect" required>
                <optgroup label="Transactions">
                    <option value="transelect" selected disabled hidden>Select a Transaction</option>
                    <?php
                        while($rows = $transactionID->fetch_assoc()) {
                            $transaction = $rows['transactionID'];
                            echo "<option value='$transaction'>$transaction</option>";
                        }
                    ?>
                </optgroup>
            </select>
        <input type="submit" value="Check Total" class="totalsubmit">
        <?php
            $customerSelected = $_POST['customerselect'];
            $transactionSelected = $_POST['transactselect'];

            $totalQuery = "SELECT * FROM Transactions WHERE transactionID = " . $transactionSelected . " AND customerID = '" . $customerSelected . "';";
        ?>
        </form>
        </div>
    </div>
    <div class="receipt-table">
        <?php
            $totalResult = mysqli_query($conn, $totalQuery);
            //echo "Error " . $conn->error;
            if(mysqli_num_rows($totalResult) > 0) {
                echo "<table class='totalsTable'>
                      <tr><th>Transaction ID</th>
                      <th>Occured At</th>
                      <th>UPC</th>
                      <th>Item Amount</th>
                      <th>Item Price</th>
                      <th>Customer ID</th>";
                while($row = mysqli_fetch_assoc($totalResult)) {
                    echo "<tr>
                    <td>" . $row['transactionID'] . "</td>" .
                    "<td>" . $row['transactionOccur'] . "</td>" .
                    "<td>" . $row['itemUPC'] . "</td>" .
                    "<td>" . $row['transactionItemAmt'] . "</td>" .
                    "<td>" . $row['transactionItemPrice'] . "</td>" .
                    "<td>" . $row['customerID'] . "</td></tr>";
                }
                echo "</table>";
                $totalSum = $conn->prepare("SELECT CAST(SUM(itemPrice) AS decimal(10,2)) AS TOTAL FROM Item INNER JOIN Transactions ON Item.UPC = Transactions.itemUPC WHERE Transactions.transactionID = " . $transactionSelected . " AND Transactions.customerID = '" . $customerSelected . "';");
                $totalSum->execute();
                $result = $totalSum->get_result();
                while($row = $result->fetch_assoc())
                    $total = $row['TOTAL'];
                echo "<h2>Total is $" . $total . "</h2>";
            } else if ($customerSelected != "" && mysqli_num_rows($totalResult) == 0) {
                echo "<h1>No results found!</h1>";
            }
        ?>
    </div>
</body>
</html>