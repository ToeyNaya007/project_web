<?php
include('config.php');
$token = '4pSncHjQTijJJ2UWaP7gOM4RcW1c5jViVaGSAa2heAx';

require_once dirname(__FILE__) . '/omise-php/lib/Omise.php';
define('OMISE_API_VERSION', '2015-11-17');
// define('OMISE_PUBLIC_KEY', 'PUBLIC_KEY');
// define('OMISE_SECRET_KEY', 'SECRET_KEY');
define('OMISE_PUBLIC_KEY', 'pkey_test_5xbcsgc4r3gm5ovh0b3');
define('OMISE_SECRET_KEY', 'skey_test_5xbcsgd4n7xw6ur6ofy');

$charge = OmiseCharge::create(
  array(
    'amount' => $_POST["totalPrice"],
    // Use the dynamic amount received from the client
    'currency' => 'thb',
    'card' => $_POST["omiseToken"]
  )
);









?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>

<body>
  <?php
  if ($charge['status'] == 'successful') {
    echo 'Success';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $user_realid = $_POST['user_realid'];
      $productID = $_POST['productID'];
      $quantity = $_POST['quantity'];
      $totalPrice = $_POST['totalPrice_No0'];
      $cart_id = $_POST['cart_id'];



      $sqlreceipt = "INSERT INTO receipt (user_id, goods_id, quantity, total) VALUES ('$user_realid', '$productID', '$quantity', '$totalPrice')";

      $sqlcart = "UPDATE cart SET status = 'y' WHERE cart_id = '$cart_id'";

      if ($conn->query($sqlreceipt) === TRUE) {
        if ($conn->query($sqlcart) === TRUE) {



          // Initialize Line Notify message
          $message = "มีรายการสั่งซื้อเกิดขึ้น\n"
            . "รหัสผู้ใช้: " . $user_realid . "\n"
            . "รหัสสินค้า: " . $productID . "\n"
            . "จำนวน: " . $quantity . "\n"
            . "รวมเป็นเงิน: " . $totalPrice;


          // Set Line Notify API endpoint
          $api_url = 'https://notify-api.line.me/api/notify';

          // Set headers
          $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
          ];

          // Create POST data
          $data = http_build_query(['message' => $message]);

          // Initialize cURL session
          $ch = curl_init();

          // Set cURL options
          curl_setopt($ch, CURLOPT_URL, $api_url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          // Execute cURL session and get the response
          $response = curl_exec($ch);

          // Check for errors
          if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
          }

          // Close cURL session
          curl_close($ch);

          // Close the database connection
          $conn->close();

          // Output the Line Notify response
          echo 'Line Notify Response: ' . $response;






          ?>
          <script>

            setTimeout(function () {
              swal({
                title: "ชำระเงินสำเร็จ!", //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
                text: "กำลังกลับไปหน้าแรก", //ข้อความเปลี่ยนได้ตามการใช้งาน
                type: "success", //success, warning, danger
                timer: 2000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
                showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
              }, function () {
                window.location.href = "index.php"; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
              });
            });
          </script>
          <?php

        }
      }

    }

  }


  ?>



</body>

</html>




<?php
// print('<pre>');
// print_r($charge);
// print('</pre>');

?>