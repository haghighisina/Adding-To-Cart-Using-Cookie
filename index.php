<?php
require_once "ToDo.php";

if (isset($_GET['success']))
{
    $massage = '
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Item Added
        </div>
    ';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="all.js" ></script>
</head>
<body>
    <div class="container">
        <?php
        $query = "SELECT * FROM stuff ORDER BY id ASC";

        $stat = $connect->prepare($query);

        $stat->execute();

        $result = $stat->fetchAll();

        foreach ($result as $row) { ?>
        <div class="col-md-3" style="margin: 0 auto; float: right">
            <form method="post" action="ToDo.php">
                <div style="border:1px solid #333; background-color: #f1f1f1;
                 border-radius: 5px; padding: 16px" align="center">
                    <img src="images/<?php echo $row['Image'];?>" style="width: 100%" class="img-responsive">
                    <h4 class="text-info"> <?php echo $row['Pname']; ?> </h4>
                    <h4 class="text-info">$ <?php echo $row['Price']; ?> </h4>
                    <input type="text" name="quantity" value="1" class="form-control">
                    <input type="hidden" name="hidden_name" value="<?php echo $row['Pname'];?>">
                    <input type="hidden" name="hidden_price" value="<?php echo $row['Price'];?>">
                    <input type="hidden" name="hidden_id" value="<?php echo $row['id'];?>">
                    <input type="submit" name="add" style="margin-top: 5px" class="btn btn-success" value="add">
                </div>
            </form>
        </div>
        <?php
        }
        ?>

        <div style="clear: both"></div>

        <br>

        <h3>Order Details</h3>

        <div class="table-responsive">

        <?php echo $massage; ?>
        <div align="right">
            <a href="Delete.php?action=clear"><b>Clear Cart</b></a>
        </div>
        <table class="table table-bordered">
            <tr>
                <th width="40%">Item</th>
                <th width="10%">Quantity</th>
                <th width="20%">Price</th>
                <th width="15%">Total</th>
                <th width="5%">Action</th>
            </tr>

<?php
    if (isset($_COOKIE["shopping_cart"])) {
        $total = 0;
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach ($cart_data as $keys => $values)
        {
            ?>
            <tr>
                <td><?php  echo $values['item_name']; ?></td>
                <td><?php  echo $values['item_quantity']; ?></td>
                <td>$<?php echo $values['item_price']; ?></td>
                <td>$<?php echo number_format($values['item_quantity'] *
                        $values['item_price'], 2); ?></td>
                <td>
                    <a href="Delete.php?action=delete&id=<?php echo $values['item_id']; ?>">

                        <span class="danger">Remove</span>

                    </a>
                </td>
            </tr>
            <?php

            $total = $total + ($values['item_quantity'] * $values['item_price']);

        }
        ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">$ <?php echo number_format($total, 2); ?></td>
                <td></td>
            </tr>
            <?php
        }
           else{
            echo '
                <tr>
                    <td colspan="5" align="center">No item Selected</td>
                </tr>
            ';
        }
    ?>

</table>
        </div>
    </div>
</body>
</html>
