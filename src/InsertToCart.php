<?php

include('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_real_id = $_POST['user_realid'];
    $goods_id = $_POST['goods_id'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $totalPrice = $_POST['totalPrice'];

}






// $user_id = $_SESSION['user_id'];
// echo "User_id : ".$user_id;
// echo "<br>";
// echo "realID : ".$_POST['user_realid'];
// echo "<br>";
// echo "goods_id : ".$_POST['goods_id'];
// echo "<br>";
// echo "quantity : ".$_POST['quantity'];
// echo "<br>";
// echo "Size : ".$_POST['size'];
// echo "<br>";

// echo "Total : ".$totalPrice;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- sweet alert js & css -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>


    <?php
    $sql = "INSERT INTO cart (user_id, goods_id, size, quantity, amount) VALUES ('$user_real_id', '$goods_id', '$size', '$quantity', '$totalPrice')";
    if ($conn->query($sql) === TRUE) {
        
        ?><script>
			setTimeout(function() {
			swal({
					title: "เพิ่มเข้าตะกร้าสำเร็จ!", //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
					text: "กำลังกลับไปหน้าแรก", //ข้อความเปลี่ยนได้ตามการใช้งาน
					type: "success", //success, warning, danger
					timer: 2000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
					showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
				}, function(){
					window.location.href = "index.php"; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
					});
			});
		</script>
        <?php
        
    } else {
        echo "Error " . $conn->error;
    }

    $conn->close();
    ?>



</body>

</html>