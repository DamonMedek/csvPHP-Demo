<?php

/* Getting file name */
$filename = $_FILES['file']['name'];

/* Getting File size */
$filesize = $_FILES['file']['size'];

/* Location */
$location = $filename;


if (move_uploaded_file($_FILES['file']['tmp_name'], $location)){
    echo $location;
} else {
    echo 0;
}
