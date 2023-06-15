<?php
$str = "a@gmail.com";
$emails = array();
array_push($emails, "a@gmail.com");

if (in_array($str, $emails)) {
    echo "found";
} else {
    echo "not found";
}