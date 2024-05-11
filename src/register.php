<!DOCTYPE html>
<html lang="en">

<head>
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
    </style>

</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

    <!--Nav-->
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



                    </ul>

                </nav>
            </div>

            <div class="order-1 md:order-2">
                <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                    href="login.php">
                    <svg class="fill-current text-gray-800 mr-2" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
                        <path
                            d="M5,22h14c1.103,0,2-0.897,2-2V9c0-0.553-0.447-1-1-1h-3V7c0-2.757-2.243-5-5-5S7,4.243,7,7v1H4C3.447,8,3,8.447,3,9v11 C3,21.103,3.897,22,5,22z M9,7c0-1.654,1.346-3,3-3s3,1.346,3,3v1H9V7z M5,10h2v2h2v-2h6v2h2v-2h2l0.002,10H5V10z" />
                    </svg>
                    SPORTEDSTORE
                </a>
            </div>

            <div class="order-2 md:order-3 flex items-center" id="nav-content">





            </div>
        </div>
    </nav>
    <section class="bg-white py-8">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto">
                <h2 class="text-2xl font-semibold mb-4">สมัครสมาชิก</h2>
                <form action="register_process.php" method="post" class="space-y-4" enctype="multipart/form-data">

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">ชื่อผู้ใช้:</label>
                        <input type="text" id="username" name="username" class="border rounded-md w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">รหัสผ่าน:</label>
                        <input type="password" id="password" name="password" class="border rounded-md w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">ยืนยันรหัสผ่าน:</label>
                        <input type="password" id="password" name="confirmpassword"
                            class="border rounded-md w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">อีเมล:</label>
                        <input type="email" id="email" name="email" class="border rounded-md w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">อัพโหลดรูปภาพ:</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="border rounded-md w-full py-2 px-3">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-blue-700 text-white py-2 px-4 rounded-md hover:bg-blue-600">สมัครสมาชิก</button>
                      

                    </div>

                </form>
            </div>
        </div>
    </section>





</body>

</html>