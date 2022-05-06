<?php
include 'connect.php';
if (isset($_POST['fileLocation']))
{
    $name = basename($_POST['fileLocation']);
    $tmp = explode('.', $name);
    $ext = strtolower(end($tmp));
    if ($ext === 'csv')
    {
        $file = fopen($name, 'r');
        while (($column = fgetcsv($file, 10000, ",")) !== false)
        {
            $sqlInsert = "INSERT INTO originalCSV (id, dealership, stock_number, VIN, type_, year_, make, model, body, comments, images, color, price, msrp, internet_price, url_, days_in_stock)
          VALUES ('0','" . str_replace("'", "''", $column[0]) . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "','" . $column[11] . "', '" . $column[12] . "', '" . $column[13] . "', '" . $column[14] . "', '" . $column[15] . "')";
            if ($conn->query($sqlInsert) === true)
            {
                //echo "New record created successfully"; echo "<br>";
                
            }
            else
            {
                //echo "Error: " . $sqlInsert . "<br>" . $conn->error; echo "<br>";
            }
        }
        $deleteFirstRow = "DELETE FROM originalCSV ORDER BY id LIMIT 1";
        if ($conn->query($deleteFirstRow) === true)
        {
            //echo "First Record Deleted Successfully"; echo "<br>";
            
        }
        else
        {
            echo "Error: " . $deleteFirstRow . "<br>" . $conn->error;
        }
    }
    purgeData();
    

}
function purgeData() {
    include 'connect.php';
    $sql = " SELECT DISTINCT VIN, id, dealership, stock_number, type_, year_, make, model, body, comments, images, color, price, msrp, internet_price, url_, days_in_stock 
    FROM originalCSV WHERE year_ != '' AND make != '' AND model != '' AND images != ''";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        // output data of each row
        while ($row = $result->fetch_assoc())
        {
            //color condition
            if (empty($row['color']))
            {
                $row['color'] = "Other";
            }
            //url condition
            if (empty($row['url_']))
            {
                $row['url_'] = "https://test.com/inventory/{" . $row['VIN'] . "}";
            }
            if ($row["type_"] === "N")
            {
                $row["type_"] = "New";
                if ($row["internet_price"] != '')
                {
                    $finalPrice = $row["internet_price"];
                }
                else if ($row["internet_price"] == '' && $row["msrp"] != '')
                {
                    $finalPrice = $row["msrp"];
                }
                else if ($row["internet_price"] != '' && $row["msrp"] != '')
                {
                    continue;
                }
            }
            else if ($row["type_"] === "U")
            {
                $row["type_"] = "Used";
                if ($row["internet_price"] != '')
                {
                    $finalPrice = $row["internet_price"];
                }
                else
                {
                    continue;
                }
            }
            if ($finalPrice == "$0")
            {
                continue;
            }
            $title = "Come check out our " . $row["type_"] . " " . $row["year_"] . " " . $row["make"] . " " . $row["model"];
            
            
            
            //NOW INSERT INTO NEW TABLE
            $sql = "INSERT INTO updatedCSV (VIN, year, make, model, body, title, color, image, url, final_price, type, stock_number)
            VALUES ('" . $row["VIN"] . "', '" . $row["year_"] . "', '" . $row["make"] . "', '" . $row["model"] . "', '" . $row["body"] . "', '$title', 
            '" . $row["color"] . "', '" . $row["images"] . "', '" . $row["url_"] . "', '$finalPrice', '" . $row["type_"] . "', '" . $row["stock_number"] . "')";
            if ($conn->query($sql) === true)
            {
                // echo "New record created successfully <br>";
                
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            
        }
    }
    else
    {
        echo "0 results";
    }
   
}


?>
