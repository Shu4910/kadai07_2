<?php
//input file
$data=file_get_contents("data/data.csv");


//indicate the browser
echo nl2br($data);

?>