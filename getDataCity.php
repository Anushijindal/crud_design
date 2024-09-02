<?php

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    handlePostRequest();
} else { 
    echo json_encode(['error' => 'Unsupported request method']);
}


function handlePostRequest() {
    // Read the raw POST data
    $data = file_get_contents('php://input');

    // Decode the JSON data to get the countryId
    $decodedData = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        return;
    }

    if (isset($decodedData['state_id'])) {
        $state_id = $decodedData['state_id'];
        
        include 'connect.php';
        $sql = "select * from em_cities where state_id=$state_id";
        $result1 = $con->query($sql);

        $arr = [];
        $arr[]=['city_id'=>'select','state_id'=>$state_id,'city_name'=>"Select City"];
        while ($row = $result1->fetch_assoc()) {
            $arr[] = [
                'city_id' => $row['city_id'],
                'state_id' => $row['state_id'],
                'city_name' => $row['city_name'],
            ];
        }



        echo json_encode($arr);
    } else {
        echo json_encode(['error' => 'country_id not provided']);
    }
}

?>