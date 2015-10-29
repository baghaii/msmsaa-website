<?php 

/* Query function that dies if the queries are invalid */
function query($query_string, $connection) {
  $result = mysqli_query($connection,$query_string);
  if(!$result) {
    die('Invalid query: '.mysqli_error($connection));
  }
  return $result;
}

function gendata() {
  require("../../php/dbinfo.php");
  /* Connect to database */
  $connection=mysqli_connect('localhost', $username,$password,$database);

  if(!$connection) {
    die('Not connected: '.mysqli_connect_error());
  }

  /* query strings */
  $query_string1 = "SELECT zip, lat, lon, count(*) FROM ".
    "(SELECT IF(currzip > '0', currzip, permzip) as zip FROM alumni) t1 ".
    "LEFT JOIN zips_2000 on t1.zip = zips_2000.zipcode GROUP BY zip";

  $result = query($query_string1, $connection);

  $data = array();
  $i = 0;
  /* generate $data from $result */
  while ($address = $result->fetch_assoc()) {
    if ($address['zip'] == TRUE) {
      if (!strpos(trim($address['zip']), ' ') && 
          !strpos($address['zip'],'-') ) { 
            $zipdata = array('zip'   => $address['zip'],
                               'count' => $address['count(*)'],
                               'lat'   => $address['lat'],
                               'lon'   => $address['lon']);
          $data[$i] = $zipdata;       
          $i = $i+1;
       }
       else {
      /* hyphenated address or international address */
     // printf("WEIRD DUDE: %s\n",  $address['currzip']);
       }
    }
  }

  mysqli_close($connection);
  return json_encode($data);
}
//This line is used for testing the output of the above function
//echo gendata();
?>
