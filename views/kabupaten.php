<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$key  = $this->app->get_where('t_profil', ['id_profil' => 1]);
$api = $key->row();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=$provinsi[0]",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: ".$api->api_key
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $data = json_decode($response, TRUE);

  for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
    $prov = $data['rajaongkir']['results'][$i]['city_name'];
    if (!empty($kabupaten[1])) {
      $prov1 = $kabupaten[1];
    }
    else{
      $prov1 = "";
    }
    
    $selected = "";
    if ($prov == $prov1) {
      $selected = "selected";
    }
     echo '<option value="'.$data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name'].'" '.$selected.'>'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
  }
}
