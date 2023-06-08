<?php
function mySort($a, $b)
{
  return $a <=> $b;
}

$numbers = array(12, 6463, 1, 5235, 5);
usort($numbers, "mySort");

for ($i = 0; $i < count($numbers); $i++) {
  echo $numbers[$i] . ", ";
}
