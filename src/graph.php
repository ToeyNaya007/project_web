<?php
require 'config.php';


$sql = "SELECT category.category_name, SUM(receipt.sale_count) as total_sale_count
FROM (
    SELECT goods.category_id, COUNT(*) as sale_count
    FROM receipt
    JOIN goods ON receipt.goods_id = goods.goods_id
    GROUP BY goods.category_id
) receipt
JOIN category ON category.category_id = receipt.category_id
GROUP BY category.category_name";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Return the data as a JSON response
echo json_encode($data);
?>