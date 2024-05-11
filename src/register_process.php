<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    
    
    if ($_FILES['image']['error'] === 0) {
        $profile_image = $_FILES['image']['name'];
        $profile_image_tmp = $_FILES['image']['tmp_name'];
        $profile_image_path = "uploads/" . $profile_image;
        move_uploaded_file($profile_image_tmp, $profile_image_path);
    } else {
        $profile_image_path = null;
    }

    

    $sql = "INSERT INTO users (username, email, password, image) VALUES ('$username', '$email', '$password', '$profile_image_path')";


    if ($conn->query($sql) === TRUE) {
        echo "ลงทะเบียนสำเร็จ";
        header('Location: login.php');
    } else {
        echo "Error " . $conn->error;
    }

    $conn->close();
}
?>