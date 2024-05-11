<?php require 'config.php'; ?>
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
    </style>
</head>

<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl overflow-y-auto">
        <div class="p-6">
            <a href="admin_index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button
                class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> Add User
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">

            <a href="admin_index.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                หน้าแรก
            </a>
            <a href="admin_addgoods.php"
                class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">

                <i class=" fas fa-sticky-note mr-3"></i>
                เพิ่มสินค้า
            </a>
            <a href="admin_managegoods.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
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

    <div class="w-full flex flex-col h-screen overflow-y overflow-y-auto">ป
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div class="relative w-1/2 flex justify-end">

                <a class="pl-3 inline-block no-underline hover:text-black" href="logout.php">Logout</a>

            </div>
        </header>

        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">แก้ไขสินค้า </h1>
            <section class="bg-white py-8">
                <div class="container mx-auto">
                    <div class="max-w-md mx-auto">

                        <form action="edit_goods.php" method="post" class="space-y-4" enctype="multipart/form-data">
                            <?php
                            $goods_id = $_GET['goods_id'];
                            $sql = "SELECT * FROM goods
                        JOIN category on goods.category_id = category.category_id
                        JOIN brand on goods.brand_id = brand.brand_id WHERE goods.goods_id = $goods_id";
                            $result = $conn->query($sql);
                            foreach ($result as $key => $row) {

                                ?>
                                <input type="hidden" name="goods_id" value="<?= $row['goods_id'] ?>">
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700">ชื่อสินค้า:</label>
                                    <input type="text" id="name" name="name" class="border rounded-md w-full py-2 px-3"
                                        value="<?= $row['goods_name'] ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">
                                        <?php echo "หมวดหมู่สินค้าเดิม: " . $row['category_name'] ?>
                                    </label>
                                    <label for="category" class="block text-gray-700">แก้ไขหมวดหมู่สินค้า:</label>

                                    <select id="category" name="category" class="border rounded-md w-full py-2 px-3">
                                        <option value="<?= $row['category_id'] ?>">เลือกหมวดหมู่</option>

                                        <?php
                                        $sqlcategory = "SELECT category_id , category_name FROM category";
                                        $resultcategory = $conn->query($sqlcategory);
                                        if ($resultcategory->num_rows > 0) {
                                            while ($rowCategory = $resultcategory->fetch_assoc()) {
                                                echo '<option value="' . $rowCategory['category_id'] . '">' . $rowCategory['category_name'] . '</option>';
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700">
                                        <?php echo "แบรนด์สินค้าเดิม: " . $row['brand_name'] ?>
                                    </label>
                                    <label for="brand" class="block text-gray-700">แบรนด์:</label>

                                    <select id="brand" name="brand" class="border rounded-md w-full py-2 px-3">
                                        <option value="<?= $row['brand_id'] ?>">เลือกแบรนด์</option>

                                        <?php
                                        $sqlbrand = "SELECT brand_id , brand_name FROM brand";
                                        $resultbrand = $conn->query($sqlbrand);
                                        if ($resultbrand->num_rows > 0) {
                                            while ($rowbrand = $resultbrand->fetch_assoc()) {
                                                echo '<option value="' . $rowbrand['brand_id'] . '">' . $rowbrand['brand_name'] . '</option>';
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>




                                <div class="mb-4">
                                    <label for="price" class="block text-gray-700">ราคาสินค้า:</label>
                                    <input type="number" id="price" name="price" class="border rounded-md w-full py-2 px-3"
                                        value="<?= $row['price'] ?>">
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
                                    class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700">แก้ไขสินค้า</button>


                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>
        var chartOne = document.getElementById('chartOne');
        var myChart = new Chart(chartOne, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
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

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
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
    </script>
</body>

</html>