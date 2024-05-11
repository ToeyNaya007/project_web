<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // เช็คว่ามีการอัพโหลดรูปภาพหรือไม่
    if ($_FILES['image']['error'] === 0) {
        $profile_image = $_FILES['image']['name'];
        $profile_image_tmp = $_FILES['image']['tmp_name'];
        $profile_image_path = "uploads/" . $profile_image;
        move_uploaded_file($profile_image_tmp, $profile_image_path);
    } else {
        $profile_image_path = null;
    }

    $sql = "UPDATE users SET 
        username = '$username',
        password = '$password', 
        email = '$email', 
        address = '$address', 
        phone = '$phone',
        image = '$profile_image_path' 
        WHERE id = '$id'";

    // แก้ไขข้อมูลสินค้า
    if ($conn->query($sql) === TRUE) {
        echo "แก้ไขข้อมูลเรียบร้อยแล้ว";
        header('Location: user_profile.php');
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขสินค้า: " . $conn->error;
    }
}
$conn->close();
?>