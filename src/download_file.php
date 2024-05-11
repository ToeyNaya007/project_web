<?php
require_once 'config.php';
require 'checkSession.php';

if (isset($_GET['file'])) {
    $encryptedFileName = $_GET['file'];
    $filePath = "uploads/" . $encryptedFileName;

    if (file_exists($filePath)) {
        $encryptionMethod = "AES-256-CBC";
        $secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
        $ivLength = openssl_cipher_iv_length($encryptionMethod);
        
        $fileData = file_get_contents($filePath);
        
        $iv = substr($fileData, 0, $ivLength);
        $encryptedData = substr($fileData, $ivLength);

        $fileContent = openssl_decrypt($encryptedData, $encryptionMethod, $secretHash, 0, $iv);

        $originalFileName = basename($encryptedFileName, ".enc"); 

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $originalFileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        echo $fileContent;
        exit;
    } else {
        echo "ไม่พบไฟล์ที่ร้องขอ";
    }
}
?>
