<?php

defined('INCLUDED') or die;

function hourIsInRange($min, $max) {
  $hour = intval(date('H'));
  return $hour >= $min && $hour <= $max;
}