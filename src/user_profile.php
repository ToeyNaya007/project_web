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

$canEditProfile = false;

if ($user['google_id'] == 0) {
    // User is an admin and can edit the profile
    $canEditProfile = true;
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

        .centered-text {
            text-align: center;
        }
    </style>
</head>

<body>
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
                    <svg class="fill-current text-gray-800 mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
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
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownUserAvatarButton">
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
    <div class="w-full flex flex-col h-screen overflow-y overflow-y-auto">
        <main class="w-full flex-grow p-6">
            <div class="centered-text">
                <h1 class="text-3xl text-black pb-6">ประวัติส่วนตัว</h1>
            </div>
            <?php if ($canEditProfile): ?>
                <section class="bg-white py-8">
                    <div class="container mx-auto">
                        <div class="max-w-md mx-auto">
                            <form action="user_edit.php" method="post" class="space-y-4" enctype="multipart/form-data">
                                <?php
                                $id = $user['id'];
                                $sql = "SELECT * FROM users
                        WHERE id =  $id";
                                $result = $conn->query($sql);
                                foreach ($result as $key => $row) {

                                    ?>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <div class="mb-4">
                                        <label for="username" class="block text-gray-700">ชื่อผู้ใช่:</label>
                                        <input type="text" id="username" name="username"
                                            class="border rounded-md w-full py-2 px-3" value="<?= $row['username'] ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="block text-gray-700">รหัสผ่าน:</label>
                                        <input type="text" id="password" name="password"
                                            class="border rounded-md w-full py-2 px-3" value="<?= $row['password'] ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block text-gray-700">อีเมลล์:</label>
                                        <input type="text" id="email" name="email" class="border rounded-md w-full py-2 px-3"
                                            value="<?= $row['email'] ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="address" class="block text-gray-700">ที่อยู่:</label>
                                        <input type="text" id="address" name="address"
                                            class="border rounded-md w-full py-2 px-3" value="<?= $row['address'] ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone" class="block text-gray-700">เบอร์โทร:</label>
                                        <input type="number" id="phone" name="phone" class="border rounded-md w-full py-2 px-3"
                                            value="<?= $row['phone'] ?>">
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex justify-center items-center">
                                            <img src="<?= $row['image'] ?>" alt="" width="200px">
                                        </div>
                                        <label for="image" class="block text-gray-700">อัพโหลดรูปภาพ:</label>
                                        <input type="file" id="image" name="image" accept="image/*"
                                            class="border rounded-md w-full py-2 px-3">
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700">ยืนยันการแก้ไข</button>


                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <div class="text-center">
                    <p>You do not have permission to edit this profile.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>