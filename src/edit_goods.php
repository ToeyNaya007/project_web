<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goods_id = $_POST["goods_id"];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];

    // เช็คว่ามีการอัพโหลดรูปภาพหรือไม่
    if ($_FILES['image']['error'] === 0) {
        $profile_image = $_FILES['image']['name'];
        $profile_image_tmp = $_FILES['image']['tmp_name'];
        $profile_image_path = "uploads/" . $profile_image;
        move_uploaded_file($profile_image_tmp, $profile_image_path);
    } else {
        $profile_image_path = null;
    }

    $sql = "UPDATE goods SET 
        goods_name = '$name', 
        category_id = '$category', 
        brand_id = '$brand', 
        price = '$price',
        image = '$profile_image_path' 
        WHERE goods_id = '$goods_id'";

    // แก้ไขข้อมูลสินค้า
    if ($conn->query($sql) === TRUE) {
        echo "แก้ไขสินค้าเรียบร้อยแล้ว";
        header('Location: admin_managegoods.php');
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขสินค้า: " . $conn->error;
    }
}
$conn->close();
?>