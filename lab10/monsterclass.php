<?php
class Monster
{ // start the Monster class
  private $num_of_eyes; // properties
  private $colour;

  function __construct($num, $col)
  { // constructor
    $this->num_of_eyes = $num; // initialise number of eyes
    $this->colour = $col; // initialise colour
  }

  function describe()
  {
    $ans = "The " . $this->colour . " monster has " . $this->num_of_eyes . " eyes.";
    return $ans;
  }
}
