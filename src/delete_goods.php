<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $goods_id = $_GET["goods_id"];
    
    $sql = "DELETE FROM goods WHERE goods_id = $goods_id";
    echo $sql;
        
    if ($conn->query($sql) === TRUE) {
    echo "ลบสินค้าสำเร็จ";
    header('Location: admin_managegoods.php');
    } else {
        echo "Error " . $conn->error;
    }
    $conn->close();
}
