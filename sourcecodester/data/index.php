<?php
$csv = array();
$file = fopen('../../sourcecodester.csv', 'r');

while (($result = fgetcsv($file)) !== false)
{ 
    $csv[] = [
        'id' => $result[0],
        'client_id' => $result[1],
        'views' => $result[2],
        'title' => $result[3],
        'short_description' => $result[4],
        'url' => $result[5],
        'image' => $result[6]
    ];
}

fclose($file);


header("Content-Type: application/json");
echo json_encode($csv);

?>
