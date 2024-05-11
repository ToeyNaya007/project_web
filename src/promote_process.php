<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $category = $_POST['category'];

    
    
    
    if ($_FILES['image']['error'] === 0) {
        $profile_image = $_FILES['image']['name'];
        $profile_image_tmp = $_FILES['image']['tmp_name'];
        $profile_image_path = "uploads/" . $profile_image;
        move_uploaded_file($profile_image_tmp, $profile_image_path);
    } else {
        $profile_image_path = null;
    }

    

    $sql = "INSERT INTO promote_goods (goods_id, image_promote) VALUES ('$category', '$profile_image_path')";


    if ($conn->query($sql) === TRUE) {
        echo "เพิ่มสินค้าสำเร็จ";
        header('Location: admin_addgoods.php');
    } else {
        echo "Error " . $conn->error;
    }

    $conn->close();
}
?>