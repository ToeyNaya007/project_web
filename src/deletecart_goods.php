<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $cart_id = $_GET["cart_id"];
    
    $sql = "DELETE FROM cart WHERE cart_id = $cart_id";
    echo $sql;
        
    if ($conn->query($sql) === TRUE) {
    echo "ยกเลิกสินค้าสำเร็จ";
    header('Location: cart.php');
    } else {
        echo "Error " . $conn->error;
    }
    $conn->close();
}
