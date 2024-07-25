<?php
require_once('Animal.php');
require_once('Frog.php');
require_once('Ape.php');

$sheep = new Animal("shaun");

echo "Nama Hewan : " . $sheep->name . "<br>";
echo "Jumlah Kaki : " . $sheep->legs . "<br>";
echo "Apakah berdarah dingin : " . $sheep->cold_bloodes . "<br> <br>";

$kodok = new Frog("buduk");

echo "Nama Hewan : " . $kodok->name . "<br>";
echo "Jumlah Kaki : " . $kodok->legs . "<br>";
echo "Apakah berdarah dingin : " . $kodok->cold_bloodes . "<br>";
echo "Jump : " . $kodok->jump() . "<br>";

$sungokong = new Ape("kera sakti");

echo "Nama Hewan : " . $sungokong->name . "<br>";
echo "Jumlah Kaki : " . $sungokong->legs . "<br>";
echo "Apakah berdarah dingin : " . $sungokong->cold_bloodes . "<br>";
echo "Yell : " . $sungokong->yell() . "<br>";
