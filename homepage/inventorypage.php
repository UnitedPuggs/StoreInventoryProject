<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Inventory</title>
    <link rel="stylesheet" href="inventorypagestyles.css">
</head>
<body>
    <a href="http://ecs.fullerton.edu/~cs332u24">
        <button class="back-button">Go back</button>
    </a>
    <h1>Inventory Options</h1>
    <div class="inventorybuttons">
        <form>
            <button class="invbtn add" formaction="./inventory/addToInventory.php">
                Add to Inventory
            </button>
        </form>
        <form>
            <button class="invbtn expirations" formaction="./inventory/inventoryExpirations.php">
                Check Item Expirations
            </button>
        </form>
        <form>
            <button class="invbtn orders" formaction="./inventory/orderItems.php">
                Order Items
            </button>
        </form>
        <form>
            <button class="invbtn buy" formaction="./inventory/buyItem.php">
                Buy an Item
            </button>
        </form>
    </div>
</body>
</html>