<?php
session_set_cookie_params(72000);
session_start();
$msg = "";
$cart_id = 0;
$products = array();
$db = new PDO ('mysql:host=localhost;dbname=supermarketdb', 'root', 'admin');
function check_for_product($code, $db)
{
    $query = "select * from products where product_code = ?";
    $st = $db->prepare($query);
    $st->execute([$code]);
    return $st->fetch(PDO::FETCH_OBJ);
}

function get_shopping_cart($cart_id, $db)
{
    //select p.product_name, p.product_code, p.unit_price, c.cart_id, sum(c.product_amount) from products p JOIN cart_items c on p.id=c.product_id where cart_id = 17

    $query = "select * from products p JOIN cart_items c on p.id=c.product_id where cart_id = ?";
    $st = $db->prepare($query);
    $st->execute([$cart_id]);
    return $st->fetchAll(PDO::FETCH_OBJ);
}

if (isset($_SESSION['c_id'])) {
    $cart_id = $_SESSION['c_id'];
    $products = get_shopping_cart($cart_id, $db);
}

if ($_POST) {
    $p_code = $_POST['code'];
    $p_quantity = $_POST['quantity'];
    $res = check_for_product($p_code, $db);
    if (!$res) {
        $msg = "No such product";
    } else {
        if (!isset($_SESSION['c_id'])) {
            $query = "insert into shopping_cart (date_and_time) values (now()) ";
            $st = $db->prepare($query);
            $st->execute();
            $cart_id = $db->lastInsertId();
            $_SESSION['c_id'] = $cart_id;
        } else {
            $cart_id = $_SESSION['c_id'];
        }
        $query = "insert into cart_items (product_id, cart_id, product_amount) values (?, ?, ?) ";
        $st = $db->prepare($query);
        $st->execute([$res->id, $cart_id, $p_quantity]);
        $products = get_shopping_cart($cart_id, $db);
    }
}
?>

<html>
<head>
    <style>
        table, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>
<body>
<p><?= $msg ?></p>

<form action="index.php" method="post">
    Code: <input type="number" name="code"/> <br/>
    Quantity: <input type="number" name="quantity" step="any"/> <br/>
    <br/>
    <br/>
    <input type="submit" value="ADD" name="add"/>
    <br/>
    <br/>
    <table>
        <tr>
            <td>Name</td>
            <td>Unit price</td>
            <td>Quantity</td>
            <td>Price</td>
        </tr>
        <?php
        $total = 0;
        foreach ($products as $p) {
            echo "<tr></tr><td>$p->product_name</td><td>$p->unit_price</td><td>$p->product_amount</td>
                    <td>".$p->product_amount * $p->unit_price."</td></tr>";
            $total += $p->product_amount * $p->unit_price;
        }
        echo "<p>Total sum: ".$total." </p>"
        ?>
    </table>
    <br/>
    <br/>
    <a href="pay_cash.php="> Pay card  </a>
</form>
</body>
</html>