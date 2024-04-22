<?php
require_once "dbconection/db.php";


//===================================== SORTING =====================================//

$id = $_POST['sid'] ? $_POST['sid'] : '';
$sort = $_POST['sort'] ? $_POST['sort'] : '';


$a = array(
    "Price-Desc" => "Price DESC",
    "Price-Asc" => "Price ASC",
    "InStockFirst" => "CASE WHEN InStock = 'In Stock' THEN 1 ELSE 2 END ASC",
    "OutofStockFirst" => "CASE WHEN InStock = 'Out of Stock' THEN 0 ELSE 1 END ASC",
    "Brand-Asc" => "Brand ASC",
    "Brand-Desc" => "Brand DESC"
);
$query = "SELECT * FROM user ";
if (isset($a[$sort]) && !empty($a[$sort])) {
    $query .= "ORDER BY $a[$sort] ";
}

if (!empty($id)) {
    $query .= "WHERE Brand LIKE '%$id%'";
}

$select = mysqli_query($con, $query);
if ($select) {
    while ($data = mysqli_fetch_assoc($select)) {
        $image = explode(',', $data['image']);
        echo "<tr>";
        echo "<td>" . $data['id'] . "</td>";
        echo "<td>";
        foreach ($image as $img) {
            echo "<img src='img/$img' width='50px' height='50px'>";
        }
        echo "</td>";
        echo "<td>" . $data['title'] . "</td>";
        echo "<td>" . $data['Brand'] . "</td>";
        echo "<td>" . $data['Model'] . "</td>";
        echo "<td>" . $data['Price'] . "</td>";
        echo "<td>" . $data['InStock'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "No Record Found";
}
