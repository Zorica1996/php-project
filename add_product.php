<?php
session_start();
$db = new PDO ('mysql:host=localhost;dbname=supermarketdb', 'root', 'admin');
if ($_POST){
    $code = $_POST['code'];
    $name = $_POST['name'];
    $unit_price = $_POST['price'];

    $query = "insert into products (product_name, product_code, unit_price) values(?, ?, ?)";
    $st = $db->prepare($query);
    $st->execute([$name, $code, $unit_price]);
}

?>
<html>
<head>
    table, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
    }
</head>
<body>
<form action="add_product.php" method="post">
    Code: <input type="number" name="code"/> <br/>
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
    <input type="submit" value="REPORT" name="report"/>
</form>
</body>
</html>