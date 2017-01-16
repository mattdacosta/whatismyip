<!-- <pre>
  <?php //print_r($_SERVER); ?>
</pre> -->

<?php
// returns first forwarded IP it finds
function forwarded_ip() {
  // Simulate a proxy locally
  // $server = array(
  //   'HTTP_X_FORWARDED_FOR'  => '3.3.3.3,1.1.1.1',
  //   'HTTP_X_FORWARDED'     => '2.1.1.1'
  // );

  $keys = array(
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'HTTP_CLIENT_IP',
    'HTTP_X_CLUSTER_CLIENT_IP'
  );

  foreach ($keys as $key) {
    if(isset($_SERVER[$key])){
      $ip_array = explode(',', $_SERVER[$key]);
      foreach ($ip_array as $ip) {
        $ip = trim($ip);
        if(validate_ip($ip)){
          return $ip;
        }
        return $ip;
      }
    }
  }
  return '';
}

// Check ip address is valid format using filter_var
function validate_ip($ip) {
  if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4|FILTER_FLAG_NO_PRIV_RANGE|FILTER_FLAG_NO_RES_RANGE) === false){
    return false;
  } else {
    return true;
  }
}

$remote_ip = $_SERVER['REMOTE_ADDR'];
$forwarded_ip = forwarded_ip();

?>

Your IP Address is
<?php
  echo $_SERVER['REMOTE_ADDR'] . '<br /><br />';

  if($forwarded_ip != '') {
    echo 'Forwarder For: ' . $forwarded_ip;
  }
?>
