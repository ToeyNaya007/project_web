<?php
include('config.php');
$token = '4pSncHjQTijJJ2UWaP7gOM4RcW1c5jViVaGSAa2heAx';

require_once dirname(__FILE__) . '/omise-php/lib/Omise.php';
define('OMISE_API_VERSION', '2015-11-17');
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
            // Get the product ID, quantity, and total price from the form
            $user_realid = $_POST['user_realid'];
            $totalPrice = $_POST['totalPrice_No0'];

            $sql_select_cart = "SELECT *
            FROM `cart`
            JOIN `users` ON cart.user_id = users.id
            JOIN `goods` ON cart.goods_id = goods.goods_id
            WHERE `cart`.`user_id` = $user_realid AND `cart`.`status` = 'n';";
            $result_select_cart = mysqli_query($conn, $sql_select_cart);
            if ($result_select_cart) {
                while ($row = mysqli_fetch_assoc($result_select_cart)) {
                    // Retrieve the data from the cart table and prepare it for insertion
                    $cart_id = $row['cart_id'];
                    $goods_id = $row['goods_id'];
                    $quantity = $row['quantity'];
                    $total = $row['amount'];
                    $username = $row['username'];
                    $goodsname = $row['goods_name'];

                    $sqlreceipt = "INSERT INTO receipt (user_id, goods_id, quantity, total) VALUES ('$user_realid', '$goods_id', '$quantity', '$total')";
                    $sqlcart = "UPDATE cart SET status = 'y' WHERE cart_id = '$cart_id'";

                    if ($conn->query($sqlreceipt) === TRUE && $conn->query($sqlcart) === TRUE) {
                        // Successfully inserted into receipt and updated cart
                        // Now, send a Line Notify message
                        $productID = $goods_id; // Assuming you want to include the product ID
                        $message = "มีรายการสั่งซื้อ\n"
                            . "รหัสลูกค้า: " . $user_realid . "\n"
                            . "ชื่อลูกค้า: " . $username . "\n"
                            
                            . "รหัสสินค้า: " . $productID . "\n"
                            . "ชื่อสินค้า: " . $goodsname . "\n"

                            . "จำนวน: " . $quantity . " ชิ้น\n"
                            . "รวมเป็นเงิน: " . number_format($total) ;

                        $api_url = 'https://notify-api.line.me/api/notify';
                        $headers = [
                            'Content-Type: application/x-www-form-urlencoded',
                            'Authorization: Bearer ' . $token,
                        ];
                        $data = http_build_query(['message' => $message]);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $api_url);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                        }

                        curl_close($ch);

                        // Output the Line Notify response
                        echo 'Line Notify Response: ' . $response;
                    } else {
                        echo 'Error inserting into receipt or updating cart.';
                    }
                }

                // Free the result resource
                mysqli_free_result($result_select_cart);
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
        } else {
            echo 'Payment was not successful.';
        }
    }
    ?>
</body>
</html>
