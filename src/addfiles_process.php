<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.min.css">
<?php

require_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset ($_FILES["fileToUpload"]["tmp_name"])) {
        $fileTmpPath = $_FILES["fileToUpload"]["tmp_name"];
        $fileName = $_FILES["fileToUpload"]["name"];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($fileExtension != "pdf") {
            ?>
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        title: "ไม่สำเร็จ",
                        text: "รองรับแค่ไฟล์ประเภท PDF เท่านั้น",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.href = "admin_addfiles.php";
                    });
                });
            </script>
            <?php
            exit;
        }

        $destination = "uploads/" . $fileName;
        $fileContent = file_get_contents($fileTmpPath);

        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($encryptionMethod));

        $encryptedData = openssl_encrypt($fileContent, $encryptionMethod, $secretHash, 0, $iv);

        $dataToWrite = $iv . $encryptedData;
        file_put_contents($destination . ".enc", $dataToWrite);

        $encryptedFileName = $fileName . ".enc";

        $query = "INSERT INTO files (filename, encrypted_name) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $fileName, $encryptedFileName);


        if (mysqli_stmt_execute($stmt)) {
            ?>
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        title: "สำเร็จ",
                        text: "เพิ่มข้อมูลเรียบร้อย",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.href = "admin_managefiles.php";
                    });
                });
            </script>
            <?php

        } else {
            echo "ไม่สำเร็จ";
        }
    } else {
        echo "เกิดข้อผิดพลาด";
    }
}
?>