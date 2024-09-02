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

    if (isset($decodedData['country_id'])) {
        $country_id = $decodedData['country_id'];
        
        include 'connect.php';
        $sql = "select * from em_states where country_id=$country_id";
        $result1 = $con->query($sql);

        $arr = [];
        $arr[]=['state_id'=>'select', 'country_id'=>$country_id,'state_name'=>'Select State'];
        while ($row = $result1->fetch_assoc()) {
            $arr[] = [
                'state_id' => $row['state_id'],
                'country_id' => $row['country_id'],
                'state_name' => $row['state_name'],
            ];
        }



        echo json_encode($arr);
    } else {
        echo json_encode(['error' => 'country_id not provided']);
    }
}

?>