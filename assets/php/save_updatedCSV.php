<?php

include './connect.php';
$csvName = "new_Vehicles";
$delimiter = ",";

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=' . $csvName . '.csv');
$writeFile = fopen('php://output', 'w');
fputcsv($writeFile, array(
    'VIN',
    'year',
    'make',
    'model',
    'body',
    'title',
    'color',
    'image',
    'url',
    'final_price',
    'type',
    'stock_number'
));
$sql = "SELECT * from updatedCSV";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result))
{
fputcsv($writeFile, $row, /*$delimiter*/);
}
fclose($writeFile);
exit();

?>
