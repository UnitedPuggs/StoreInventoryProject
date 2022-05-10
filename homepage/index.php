<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Inventory Main Page</title>
    <link rel="stylesheet" href="./mainpagestyles.css">
</head>
<body>
    <h1>S t o r e  I n v e n t o r y  M a i n  P a g e</h1>
    <div class="main-container">
            <div class="options-header">
                <div class="options-header inventory">
                    <form>
                        <button class ="header-buttons inventorybtn" formaction="inventorypage.php">
                            Inventory
                        </button>
                    </form>
                </div>
                <div class="options-header customers">
                    <form>
                        <button class ="header-buttons customersbtn" formaction="customerspage.php">
                            Customers
                        </button>
                    </form>
                </div>
                <div class="options-header orders">
                    <form>
                        <button class ="header-buttons ordersbtn" formaction="orderspage.php">
                            Orders
                        </button>
                    </form>
                </div>
                <div class="options-header orders">
                    <form>
                        <button class ="header-buttons transactionsbtn" formaction="transactionspage.php">
                            Transactions
                        </button>
                    </form>
                </div>
            </div>
        <div class="mainpage">
            <img src="mainpagebackground.png" alt="Walter">
        </div>
    </div>
</body>
</html>