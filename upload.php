<?php

$uploaddir = $_SERVER["DOCUMENT_ROOT"] . '/images/';
define('maxfilesize','2000000');

if ((($_FILES['image']['type'] == 'image/gif')
        || ($_FILES['image']['type'] == 'image/jpeg')
        || ($_FILES['image']['type'] == 'image/png')
        || ($_FILES['image']['type'] == 'image/pjpeg'))
    && ($_FILES['image']['size'] < maxfilesize))
{
    $uploadfile = $uploaddir . basename($_FILES['image']['name']);

    echo "<p>";

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
        echo "Image was successfully uploaded.<br/><br/><img src=\"images/" . $_FILES['image']['name'] . "\" />";
    } else {
        echo "Upload failed";
    }

    echo "</p>";
}