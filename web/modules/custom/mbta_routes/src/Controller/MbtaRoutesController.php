<?php

namespace Drupal\mbta_routes\Controller;

use Drupal\Core\Controller\ControllerBase;



//Initializing curl
function getAPIData() {

$curl = curl_init();
    
// Sending GET request to MBTA
// server to get JSON data

curl_setopt($curl, CURLOPT_URL, 
   "https://api-v3.mbta.com/routes/Red");
    
// Telling curl to store JSON
// data in a variable instead
// of dumping on screen


curl_setopt($curl, 
   CURLOPT_RETURNTRANSFER, true);
    
// Executing curl
$response = curl_exec($curl);
  
// Checking if any error occurs 
// during request or not
if($e = curl_error($curl)) {
    echo $e;
} else {
      
    // Decoding JSON data
    $decodedData = 
        json_decode($response, true); 
          
    // Outputing JSON data in
    // Decoded form
    return $decodedData;

    
}
  
// Closing curl
curl_close($curl);

}


class MbtaRoutesController extends ControllerBase {


  /**
   * Builds the response.
   */
      
   public function build() {
    
    $data = getAPIData(); 
     
    foreach($data as $key => $value) {
        $table = [
            '#type' => 'table',
            '#header' => ['Route ID', 'Route Name', 'Route Type', 'Fare Class'],
            '#rows' => [
                [$value['id'], $value['attributes']['long_name'], $value['attributes']['type'], $value['attributes']['fare_class']],
                ],
                        
        ];

        return $table;
    }
    }

  }
