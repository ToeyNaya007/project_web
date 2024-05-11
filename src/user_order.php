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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
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
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
<nav id="header" class="w-full z-30 top-0 py-1">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-6 py-3">

        <label for="menu-toggle" class="cursor-pointer md:hidden block">
            <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                viewBox="0 0 20 20">
                <title>menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </label>


        <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
            <nav>
                <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
                    <?php
                    $sqlbrand = "SELECT * FROM brand";
                    $resultbrand = $conn->query($sqlbrand);
                    if ($resultbrand->num_rows > 0) {
                        while ($row = $resultbrand->fetch_assoc()) {
                            ?>

                            <li class="relative group">
                                <a class="inline-block no-underline hover:text-black hover:underline py-2 px-4"
                                    href="category.php?brand_id=<?php echo $row['brand_id'] ?>">
                                    <?php echo $row['brand_name'] ?>
                                </a>

                                <ul class="absolute hidden bg-white text-gray-700 pt-2 group-hover:block">
                                    <?php
                                    $sqlcategory = "SELECT * FROM category";
                                    $resultcat = $conn->query($sqlcategory);
                                    if ($resultcat->num_rows > 0) {
                                        while ($rows = $resultcat->fetch_assoc()) {
                                            ?>
                                            <li><a class="block py-2 px-4"
                                                    href="category.php?brand_id=<?php echo $row['brand_id'] ?>&category_id=<?php echo $rows['category_id'] ?>">
                                                    <?php echo $rows['category_name'] ?>
                                                </a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>

                            <?php
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>



        <div class="order-1 md:order-2" style="text-align: center;">
            <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                href="index.php">
                <svg class="fill-current text-gray-800 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M5,22h14c1.103,0,2-0.897,2-2V9c0-0.553-0.447-1-1-1h-3V7c0-2.757-2.243-5-5-5S7,4.243,7,7v1H4C3.447,8,3,8.447,3,9v11 C3,21.103,3.897,22,5,22z M9,7c0-1.654,1.346-3,3-3s3,1.346,3,3v1H9V7z M5,10h2v2h2v-2h6v2h2v-2h2l0.002,10H5V10z" />
                </svg>
                SPORTEDSTORE
            </a>
        </div>



        <div class="order-2 md:order-3 " id="nav-content">

            <div id="dropdownAvatar"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">

                    <div class="font-medium truncate">
                        <?php echo $user['username']; ?>
                    </div>
                </div>
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUserAvatarButton">
                    <li>
                        <a href="user_profile.php"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">ข้อมูลส่วนตัว</a>
                    </li>
                    <li>
                        <a href="user_order.php"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">การสั่งซื้อของฉัน</a>
                    </li>

                </ul>
                <div class="py-2">
                    <a href="logout.php"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                        out</a>
                </div>
            </div>

            <div class="flex items-center">
                <a class="pl-5 pt-1 inline-block no-underline hover:text-black">
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                        class="flex text-sm bg-gray-800 rounded-full md:mr-5 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        type="button">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-9 h-9 rounded-full" src="<?php echo $user['image'] ?>" alt="user photo">
                    </button>
                    <!-- Dropdown menu -->
                </a>

                <a class="pl-5 pt-1 inline-block no-underline hover:text-black" href="cart.php">
                    <svg class="fill-current hover:text-black md:mr-5 mt-1" xmlns="http://www.w3.org/2000/svg"
                        width="30" height="30" viewBox="0 0 24 24">
                        <path
                            d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                        <circle cx="10.5" cy="18.5" r="1.5" />
                        <circle cx="17.5" cy="18.5" r="1.5" />
                    </svg>
                    <?php
                    $user_id = $user['id']; // Assuming you have the user ID in the $user array
                    $sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = $user_id AND status = 'n'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $cart_count = $row['cart_count'];

                    if ($cart_count > 0) {
                        echo "<span class='bg-red-500 text-white rounded-full px-2 py-1 text-xs absolute -mt-12 -ml-3'>$cart_count</span>";
                    }
                    ?>
                </a>
            </div>


        </div>
    </div>
</nav>
<div class="w-full overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <div class="w-full mt-12">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-list mr-3"></i> ประวัติการสั่งซื้อ
            </p>
            <div class="bg-white overflow-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm ">รหัสอ้างอิง</th>

                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm ">ชื่อสินค้า</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">หมวดหมู่</th>

                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">ราคา</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">จำนวน</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">ราคารวม</th>

                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">ผู้ซื้อ</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">วันที่ทำการ</th>
                            <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">ดูใบเสร็จ</th>






                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php

                        // ตรวจสอบการเชื่อมต่อ
                        if ($conn->connect_error) {
                            die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
                        }

                        // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
                        $user_id = $_SESSION['user_id']; // หรือวิธีการรับ user_id จากการล็อกอิน
                        
                        $sql = "SELECT *
                                        FROM receipt
                                        JOIN goods ON goods.goods_id = receipt.goods_id
                                        JOIN users ON users.id = receipt.user_id
                                        JOIN category ON category.category_id = goods.category_id
                                        WHERE users.id = $user_id
                                        ORDER BY receipt.date";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                ?>
                                <td class="text-left py-3 px-4">
                                    <?= $row["order_id"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= $row["goods_name"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= $row["category_name"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= number_format($row["price"]) ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= $row["quantity"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= number_format($row["total"]) ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= $row["username"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <?= $row["date"] ?>
                                </td>
                                <td class="text-left py-3 px-4">
                                    <a class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700"
                                        href="user_showreceipt.php?order_id=<?= $row["order_id"] ?>">ดูใบเสร็จ</a>

                                    <?php
                            }
                        } else {
                            echo "ไม่พบข้อมูล";
                        }

                        // ปิดการเชื่อมต่อฐานข้อมูล
                        $conn->close();

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>


</div>