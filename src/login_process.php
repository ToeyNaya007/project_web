<?php
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Your database query here...
        // คำสั่ง SQL สำหรับตรวจสอบชื่อผู้ใช้และรหัสผ่าน
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);


        

        if ($result->num_rows > 0) {
            // Your login logic here...
            $row = $result->fetch_assoc();
            $id = $row['id']; // หาค่า id จากฐานข้อมูล
            $userRole = $row['role'];
    
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            if ($userRole === '1') {
                header("Location: admin_index.php");
            }else{
            header("Location: index.php"); // เปลี่ยนเส้นทางไปยังหน้าที่คุณต้องการ
            }

        } else {
            ?>
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
                        text: "โปรดตรวจสอบ",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.href = "login.php";
                    });
                });
            </script>
            <?php
        }
    }
    $conn->close();
    ?>
</body>

</html>