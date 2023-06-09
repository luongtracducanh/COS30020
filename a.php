<?php
function mySort($a, $b)
{
  return $a <=> $b;
}

$numbers = array(1, 4, 3, 2, 5);
usort($numbers, function ($a, $b)
{
  return $a <=> $b;
});

for ($i = 0; $i < count($numbers); $i++) {
  echo $numbers[$i] . ", ";
}
