<?php
$myfile = fopen("setParameterFolder.txt", "r") or die("Unable to open file!");
$file = fread($myfile,filesize("setParameterFolder.txt"));
echo $file;
fclose($myfile);


$myFile = "4-24-11.txt";
$lines = file($myFile);//file in to an array
echo $lines[1]; //line 2

?>