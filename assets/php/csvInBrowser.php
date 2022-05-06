<?php
include 'connect.php';
    $sql = "SELECT * FROM updatedCSV";
    $result = $conn->query($sql);
    $updatedFile = array();
    $updatedRow = array();

    echo "<table><thead><tr><th>VIN</th><th>Year</th><th>Make</th><th>Model</th><th>Body</th><th>Title</th><th>Color</th><th>Image</th><th>Url</th><th>Final Price</th><th>Type</th><th>Stock #</th></tr></thead><tbody>";
    if ($result->num_rows > 0)
    {
        // output data of each row
        while ($row = $result->fetch_assoc())
        {
            echo "<tr><td>" . $row["VIN"] . "</td>" . "<td>" . $row["year"] . "</td>" . "<td>" . $row["make"] . "</td>" . "<td>" . $row["model"] . "</td>" . "<td>" . $row["body"] . "</td>" . "<td>" . $row["title"] . "</td>" . "<td>" . $row["color"] . "</td>" . "<td>" . $row["image"] . "</td>" . "<td>" . $row["url"] . "</td>" . "<td>" . $row["final_price"] . "</td>" . "<td>" . $row["type"] . "</td>" . "<td>" . $row["stock_number"] . "</td></tr>";
        }
    }
    else
    {
        echo "0 results";
    }

    echo "</tbody></table>";

    ?>