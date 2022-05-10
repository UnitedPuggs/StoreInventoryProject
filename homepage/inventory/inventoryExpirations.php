<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Expirations Page</title>
    <link rel="stylesheet" href="expirationstyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24/inventorypage.php?">
        <button class="back-button">Go back</button>
    </a>

    <h1>Check Expirations</h1>

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

    <div class="expirations-container">
        <form method="post" action="inventoryExpirations.php" class="expirationForm">
            <div class="expirations-inner">
                <label for="itemDept" class="inventorybtn dept">Department:</label>
                <select name="dptselect" required>
                    <optgroup label="Departments">
                        <option value="selectDpt" selected disabled hidden>Select a Department</option>
                        <?php
                        while($rows = $deptNames->fetch_assoc()) {
                        $department = $rows['deptName'];
                        echo "<option value='$department'>$department</op>";
                        }
                        ?>
                    </optgroup>
                </select>
                <label for="expiration" class="inventorybtn expiration">Expiration Date: </label>
                <input type="date" name="expirationDate" id="expiration" value="2000-01-1" min="2000-01-01" max="2100-01-01" required>
                <input type="submit" value="Check Expirations">
                <?php
                    $date = $_POST["expirationDate"];
                    $department = $_POST["dptselect"];
                    $datePlusTwo = date("Y-m-d", strtotime($date . ' + 2 days'));
                    $selectExpirations = "SELECT itemUPC, itemExpDate FROM ItemExpirations INNER JOIN Item ON ItemExpirations.itemUPC = Item.UPC WHERE Item.itemDept = '". $department . "' AND itemExpDate >= '" . $date . "' AND itemExpDate <= '" . $datePlusTwo . "' ;";
                    $result = mysqli_query($conn, $selectExpirations);
                ?>
            </div>
        </form>
    </div>
    <div>
        <?php
            if(mysqli_num_rows($result) > 0) {
                echo "<table class=\"expirationTable\">
                      <tr><th>UPC</th>
                      <th>Expiration Date</th>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>" . $row["itemUPC"] . "</td>" .
                    "<td>" . $row["itemExpDate"] . "</td>" . "</tr>";
                }
                echo "</table>";
            } else if($department != "") {
                echo "<h1>No results found!</h1>";
            }
        ?>
    </div>
</body>
</html>