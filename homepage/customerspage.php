<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Page</title>
    <link rel="stylesheet" href="customerspagestyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24">
        <button class="back-button">Go back</button>
    </a>
    <h1>Customer List</h1>

    <?php
        $servername = "mariadb";
        $username = "cs332u24";
        $password = "qT7SwEpE";
        $dbname = "cs332u24";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $customerQuery = "SELECT DISTINCT customerID, customerName FROM Customers;";
        $result = mysqli_query($conn, $customerQuery);
        if(mysqli_num_rows($result) > 0) {
            echo "<table class=\"customerTable\">
            <tr><th>Customer ID</th>
            <th>Customer Name</th>";
        
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td>" . $row["customerID"] . "</td>" .
            "<td>" . $row["customerName"] . "</td>"
            . "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>