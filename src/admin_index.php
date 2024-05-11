<!DOCTYPE html>
<?php
require 'config.php';
$userQuery = "SELECT COUNT(*) as user_count FROM users";
$goodsQuery = "SELECT COUNT(*) as goods_count FROM goods";
$receiptQuery = "SELECT COUNT(*) as receipt_count FROM receipt";

// Execute the queries
$userResult = $conn->query($userQuery);
$goodsResult = $conn->query($goodsQuery);
$receiptResult = $conn->query($receiptQuery);

// Check for errors
if (!$userResult || !$goodsResult || !$receiptResult) {
    die("Error in executing queries: " . $conn->error);
}

// Fetch the counts
$userCount = $userResult->fetch_assoc()['user_count'];
$goodsCount = $goodsResult->fetch_assoc()['goods_count'];
$receiptCount = $receiptResult->fetch_assoc()['receipt_count'];


date_default_timezone_set('Asia/Bangkok');

$currentDateTime = date("Y-m-d");


$salesQuery = "SELECT SUM(total) as today_sales FROM receipt WHERE date = '$currentDateTime'";
$salesResult = $conn->query($salesQuery);

$todaySales = $salesResult->fetch_assoc()['today_sales'];

// Close the database connection


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
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

<body class="bg-gray-100 font-family-karla flex">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="admin_index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <a href="admin_promote.php"
                class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> Promote Goods
            </a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">

            <a href="admin_index.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                หน้าแรก
            </a>
            <a href="admin_addgoods.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">

                <i class="fas fa-sticky-note mr-3"></i>
                เพิ่มสินค้า
            </a>
            <a href="admin_managegoods.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-solid fa-clipboard mr-3"></i>
                จัดการสินค้า
            </a>
            <a href="admin_manageuser.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-solid fa-user mr-3"></i>
                จัดการผู้ใช้
            </a>
            <a href="admin_order.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-solid fa-list mr-3"></i>
                รายการสั่งซื้อ
            </a>
            <a href="admin_addfiles.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-solid fa-list mr-3"></i>
                เพิ่มไฟล์
            </a>
            <a href="admin_managefiles.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-solid fa-list mr-3"></i>
                จัดการไฟล์
            </a>

        </nav>

    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div class="relative w-1/2 flex justify-end">

                <a class="pl-3 inline-block no-underline hover:text-black" href="logout.php">Logout</a>

            </div>
        </header>





        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Dashboard</h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
                    <div
                        class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-blue-800 dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl">
                                <?php echo $userCount; ?>
                            </p>
                            <p>ผู้ใช้ทั้งหมด</p>
                        </div>
                    </div>

                    <div
                        class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-blue-800 dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl">
                                <?php echo $goodsCount; ?>
                            </p>
                            <p>สินค้าทั้งหมด</p>
                        </div>
                    </div>

                    <div
                        class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-blue-800 dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl">
                                <?php echo $receiptCount; ?>
                            </p>
                            <p>ออร์เดอร์ทั้งหมด</p>
                        </div>
                    </div>
                    <div
                        class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-blue-800 dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl">$
                                <?php echo number_format($todaySales); ?>
                            </p>
                            <p>ยอดขายวันนี้</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap mt-6">

                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-plus mr-3"></i> Monthly Reports
                        </p>
                        <div class="p-6 bg-white">
                            <canvas id="chartOne" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
                        <p class="text-xl pb-3 flex items-center">
                            <i class="fas fa-check mr-3"></i> Resolved Reports
                        </p>
                        <div class="p-6 bg-white">
                            <canvas id="myChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <br>


                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> Latest Reports
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






                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php

                                // ตรวจสอบการเชื่อมต่อ
                                if ($conn->connect_error) {
                                    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
                                }

                                // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
                                $sql = "SELECT * 
                                FROM receipt
                                JOIN goods ON goods.goods_id = receipt.goods_id
                                JOIN users ON users.id = receipt.user_id
                                JOIN category ON category.category_id = goods.category_id
                                ORDER BY created_at DESC
                                LIMIT 6";

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
                                        <?php
                                    }
                                } else {
                                    echo "ไม่พบข้อมูล";
                                }

                                // ปิดการเชื่อมต่อฐานข้อมูล
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>


        </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI" crossorigin="anonymous"></script>



    <script>
        // Define an array of static colors
        var staticColors = ['#FF5733', '#33FF57', '#5733FF', '#33A0FF', '#FF33A0'];

        // Fetch data from your PHP script
        fetch('graph.php')
            .then(response => response.json())
            .then(data => {
                // Process the data and create the Chart.js chart
                var chartOne = document.getElementById('chartOne');
                var labels = data.map(item => item.category_name);
                var saleCounts = data.map(item => item.total_sale_count);

                // Use the static colors for each bar
                var backgroundColors = staticColors.slice(0, labels.length);

                var myChart = new Chart(chartOne, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '# of Sales',
                            data: saleCounts,
                            backgroundColor: backgroundColors, // Set the static colors here
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            })
            .catch(error => console.error(error));
    </script>


    <script>
        // ใช้ Fetch API เพื่อดึงข้อมูลจากไฟล์ PHP
        fetch('graph_pie.php')
            .then(response => response.json())
            .then(data => {
                // นำข้อมูลมาใช้ใน Chart.js
                var xValues = data.map(item => item.label + " (" + item.value + " ชิ้น)"); // แสดงจำนวนชิ้นใน Label
                var yValues = data.map(item => item.value);
                var barColors = [
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145"
                ];

                new Chart("myChart", {
                    type: "pie",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },

                });
            })
            .catch(error => {
                console.error("เกิดข้อผิดพลาดในการดึงข้อมูล: " + error);
            });
    </script>


</body>

</html>