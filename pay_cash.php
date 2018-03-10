<?php
session_start();
$db = new PDO ('mysql:host=localhost;dbname=supermarketdb', 'root', 'admin');
if (isset($_SESSION['c_id'])) {
    $cart_id = $_SESSION['c_id'];
}
$query = "select * from products p JOIN cart_items c on p.id=c.product_id where cart_id = ?";
$st = $db->prepare($query);
$st->execute([$cart_id]);
$products = $st->fetchAll(PDO::FETCH_OBJ);

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
<form action="index.php" method="post">
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
                    <td>" . $p->product_amount * $p->unit_price . "</td></tr>";
            $total += $p->product_amount * $p->unit_price;
        }
        $total= $total - $total * 0.05;
        echo "<p>Total sum: " . $total . " </p>"
        ?>
    </table>
    <br/>
    <br/>
</form>
</body>
</html>