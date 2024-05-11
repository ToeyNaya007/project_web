<?php
require 'config.php';


$sql = "SELECT brand.brand_name, SUM(receipt.sale_count) as total_sale_count
        FROM (
            SELECT goods.brand_id, COUNT(*) as sale_count
            FROM receipt
            JOIN goods ON receipt.goods_id = goods.goods_id
            GROUP BY goods.brand_id
        ) receipt
        JOIN brand ON brand.brand_id = receipt.brand_id
        GROUP BY brand.brand_name";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "label" => $row["brand_name"],
            "value" => $row["total_sale_count"]
        );
    }
}

// ส่งข้อมูลเป็น JSON
echo json_encode($data);

$conn->close();
?>