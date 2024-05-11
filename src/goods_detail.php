<!DOCTYPE html>
<html lang="en">
<?php
require 'config.php';
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

// Get the product details based on a product ID (you'll need to implement this)
$goods_id = $_GET['goods_id']; // Get the product ID from the URL or another source
$sql = "SELECT * FROM goods JOIN category ON goods.category_id = category.category_id JOIN brand ON goods.brand_id = brand.brand_id WHERE goods.goods_id= $goods_id";
$get_product = mysqli_query($conn, $sql);


if (mysqli_num_rows($get_product) > 0) {
    $product = mysqli_fetch_assoc($get_product);
} else {
    // Handle the case where the product is not found
    header('Location: index.php');
    exit;
}



?>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPORTEDSTORE</title>
    <meta name="description" content="Free open source Tailwind CSS Store template">
    <meta name="keywords"
        content="tailwind,tailwindcss,tailwind css,css,starter template,free template,store template, shop layout, minimal, monochrome, minimalistic, theme, nordic">

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">


    <style>
        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        #menu-toggle:checked+#menu {
            display: block;
        }

        .hover\:grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover\:grow:hover {
            transform: scale(1.02);
        }

        .carousel-open:checked+.carousel-item {
            position: static;
            opacity: 100;
        }

        .carousel-item {
            -webkit-transition: opacity 0.6s ease-out;
            transition: opacity 0.6s ease-out;
        }

        #carousel-1:checked~.control-1,
        #carousel-2:checked~.control-2,
        #carousel-3:checked~.control-3 {
            display: block;
        }

        .carousel-indicators {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            bottom: 2%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        #carousel-1:checked~.control-1~.carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked~.control-2~.carousel-indicators li:nth-child(2) .carousel-bullet,
        #carousel-3:checked~.control-3~.carousel-indicators li:nth-child(3) .carousel-bullet {
            color: #000;
            /*Set to match the Tailwind colour you want the active one to be */
        }

        /* CSS เพิ่มสไตล์สำหรับ drop-down menu */
        li.relative {
            position: relative;
        }

        ul.absolute {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 120px;
            /* ปรับขนาดตามความต้องการ */
            z-index: 10;
            display: none;
        }

        li.relative:hover ul.absolute {
            display: block;
        }

        ul.absolute li {
            padding: 8px 0;
            white-space: nowrap;
        }

        ul.absolute a {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.3s, color 0.3s;
        }

        ul.absolute a:hover {
            background-color: #f0f0f0;
            color: #333;
        }






        .form-radio {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            outline: none;
            border: 2px solid #3490dc;
            width: 1.5rem;
            /* Set the width and height for the square buttons */
            height: 1.5rem;
            border-radius: 0.25rem;
            /* Add rounded corners */
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 0.5rem;
            /* Adjust spacing between buttons */
        }

        /* Style for the checked radio buttons */
        .form-radio:checked {
            background-color: #3490dc;
            border-color: #3490dc;
            content: "\2714"; 
        }

        /* Hide the default radio input */
        .form-radio:checked::before {
           
            /* Unicode checkmark symbol */
            
            position: absolute;
            top: 0rem;
            left: 0.25rem;
            right: 0.25rem;
            bottom: 0.25rem;
            text-align: center;
            line-height: 1.25rem;
            color: #ffffff;
            font-size: 1rem;
        }
    </style>
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
    <!-- ... (your existing navigation and carousel) ... -->
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
            <input class="hidden" type="checkbox" id="menu-toggle" />

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




    <form action="InsertToCart.php" method="Post">
        <section class="bg-white py-8">
            <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                <!-- Product Detail Section -->
                <div class="w-full md:w-1/2 p-6">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['goods_name']; ?>" width="400"
                        style="transform: translateX(250px);">
                </div>

                <div class="w-full md:w-1/2 p-6">
                    <h2 class="text-2xl font-bold">
                        <?php echo $product['goods_name']; ?>
                    </h2>
                    <p class="text-gray-700">หมวดหมู่:
                        <?php echo $product['category_name']; ?>
                    </p>
                    <p class="text-gray-700">เหมาะสำหรับ:
                        <?php echo $product['brand_name']; ?>
                    </p>
                    <p class="text-gray-700">ราคา:
                        <?php echo number_format($product['price']); ?> บาท

                    </p>



                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700">จำนวน:</label>
                        <input type="number" min="1" id="quantity" name="quantity"
                            class="border rounded-md w-1/5 py-2 px-3" min="1" value="1">
                    </div>



                    <script>
                        // สร้างฟังก์ชันสำหรับคำนวณราคารวม
                        function calculateTotalPrice() {
                            const price = <?php echo $product['price']; ?>;
                            const quantity = parseInt(document.getElementById('quantity').value);
                            const totalPrice = price * quantity;

                            // อัปเดตค่าใน <span> แสดงราคารวม
                            document.getElementById('totalPrice').textContent = totalPrice.toLocaleString();

                            // อัปเดตค่าใน <input> สำหรับการส่งไปยัง InsertToCart.php
                            document.getElementById('totalPriceInput').value = totalPrice;
                        }

                        // เรียกใช้ฟังก์ชันคำนวณเมื่อค่า quantity เปลี่ยนแปลง
                        document.getElementById('quantity').addEventListener('input', calculateTotalPrice);

                        // เรียกใช้ฟังก์ชันคำนวณเมื่อหน้าเว็บโหลดเสร็จ
                        window.addEventListener('load', calculateTotalPrice);
                    </script>




                    <p class="text-gray-700">Size:</p>
                    <br>

                    <div class="flex" style="width: 1000px;">
                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="S" class="form-radio" id="size-1">
                            <span>S</span>
                        </label>

                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="M" class="form-radio" id="size-2">
                            <span>M</span>
                        </label>

                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="L" class="form-radio" id="size-3">
                            <span>L</span>
                        </label>

                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="XL" class="form-radio" id="size-4">
                            <span>XL</span>
                        </label>
                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="2XL" class="form-radio" id="size-5">
                            <span>2XL</span>
                        </label>
                        <label class="inline-flex items-center mr-6">
                            <input type="radio" name="size" value="3XL" class="form-radio" id="size-6">
                            <span>3XL</span>
                        </label>

                        <!-- เพิ่ม radio button และ hidden input สำหรับแต่ละ Size ตามความต้องการ -->
                    </div>
                    <br>

                    <p class="text-gray-700">ราคารวม: <span id="totalPrice" name="totalPrice">
                            <?php echo number_format($product['price']); ?>
                        </span> บาท</p>

                    <br>
                    <input type="hidden" id="totalPriceInput" name="totalPrice"
                        value="<?php echo $product['price']; ?>">
                    <input type="hidden" value="<?= $goods_id ?>" name="goods_id">
                    <input type="hidden" value="<?= $user['id'] ?>" name="user_realid">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-800"
                        value="Add to Cart">
                        เพิ่มเข้าตะกร้า</button>
                </div>
            </div>
        </section>
    </form>
    <!-- ... (your existing footer or other sections) ... -->
</body>

</html>