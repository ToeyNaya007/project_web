<?php require 'config.php'; ?>
<?php
$get_user = null; // กำหนดเป็น null เพื่อป้องกันค่าที่ไม่ถูกกำหนดให้มีค่าเริ่มต้น
$google_id = null; // กำหนดเป็น null เพื่อป้องกันค่าที่ไม่ถูกกำหนดให้มีค่าเริ่มต้น

if (isset($_SESSION['google_id'])) {
    $google_id = $_SESSION['google_id'];
    $get_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `google_id` = '$google_id'");
} elseif (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $get_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$id'");
}

if ($get_user !== null && mysqli_num_rows($get_user) > 0) {
    $user = mysqli_fetch_assoc($get_user);
    $_SESSION['user_id'] = $user['id']; // เปลี่ยนเป็น id ที่พบในฐานข้อมูล
} else {
    header('Location: logout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .bg-sidebar {
            background: #3d68ff;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #1947ee;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }

        .centered-text {
            text-align: center;
        }

        * {
            box-sizing: border-box;
        }

        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap");

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Inter", sans-serif;
            background-color: #ededed;
            margin: 0;
        }

        .receipt {
            background-color: #fff;
            width: 22rem;
            position: relative;
            padding: 1rem;
            box-shadow: 0 -0.4rem 1rem -0.4rem rgba(0, 0, 0, 0.2);
        }

        .receipt:after {
            background-image: linear-gradient(135deg, #fff 0.5rem, transparent 0), linear-gradient(-135deg, #fff 0.5rem, transparent 0);
            background-position: left-bottom;
            background-repeat: repeat-x;
            background-size: 1rem;
            content: '';
            display: block;
            position: absolute;
            bottom: -1rem;
            left: 0;
            width: 100%;
            height: 1rem;
        }

        .receipt__header {
            text-align: center;
        }

        .receipt__title {
            color: #1f1f1f;
            font-size: 1.6rem;
            font-weight: 700;
            margin: 1rem 0 0.5rem;
        }

        .receipt__date {
            font-size: 0.8rem;
            color: #666;
            margin: 0.5rem 0 1rem;
        }

        .receipt__list {
            margin: 2rem 0 1rem;
            padding: 0 1rem;
        }

        .receipt__list-row {
            display: flex;
            justify-content: space-between;
            margin: 1rem 0;
            position: relative;
        }

        .receipt__list-row:after {
            content: '';
            display: block;
            border-bottom: 1px dotted rgba(0, 0, 0, 0.15);
            width: 100%;
            height: 100%;
            position: absolute;
            top: -0.25rem;
            z-index: 1
        }

        .receipt__item {
            background-color: #fff;
            z-index: 2;
            padding: 0 0.15rem 0 0;
            color: #1f1f1f;
        }

        .receipt__cost {
            margin: 0;
            padding: 0 0 0 0.15rem;
            background-color: #fff;
            z-index: 2;
            color: #1f1f1f;
        }

        .receipt__list-row--total {
            border-top: 1px solid #FF619B;
            padding: 1.5rem 0 0;
            margin: 1.5rem 0 0;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <?php
    $order_id = $_GET['order_id'];
   // $receiptid = $_GET['order_id'];
    $sql = "SELECT * FROM receipt
                        JOIN goods ON goods.goods_id = receipt.goods_id
                        JOIN users ON users.id = receipt.user_id
                        WHERE order_id =  $order_id";
    $result = $conn->query($sql);
    foreach ($result as $key => $row) {

    ?>
        <div class="receipt">
            <header class="receipt__header">
                <p class="receipt__title">
                    SPORTEDSTORE
                </p>
                <p class="receipt__date"><?php echo $row['date'] ?></p>
            </header>
            <dl class="receipt__list">
                <div class="receipt__list-row">
                    <dt class="receipt__item">ชื่อลูกค้า:</dt>
                    <dd class="receipt__cost"><?= $row["username"] ?></dd>#
                </div>
                <div class="receipt__list-row">
                    <dt class="receipt__item">รหัสลูกค้า:</dt>
                    <dd class="receipt__cost"><?= $row["user_id"] ?></dd>#
                </div>
                <div class="receipt__list-row">
                    <dt class="receipt__item">ชื่อสินค้า:</dt>
                    <dd class="receipt__cost"><?= $row["goods_name"] ?></dd>#
                </div>
                <div class="receipt__list-row">
                    <dt class="receipt__item">รหัสสินค้า:</dt>
                    <dd class="receipt__cost"><?= $row["order_id"] ?></dd>#
                </div>
                <div class="receipt__list-row">
                    <dt class="receipt__item">จำนวน:</dt>
                    <dd class="receipt__cost"><?= $row["quantity"] ?></dd>#
                </div>
                <div class="receipt__list-row receipt__list-row--total">
                    <dt class="receipt__item">รวมเป็นเงิน:</dt>
                    <dd class="receipt__cost"><?= $row["total"] ?></dd>$
                </div>
                <br>
                <br>
                <div class="flex justify-center">
                <a class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-700" href="user_order.php">ย้อนกลับ</a>
                </div>
            </dl>
        </div>
    <?php
    }
    ?>
</body>

</html>