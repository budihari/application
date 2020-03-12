<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$key  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "key: ".$key->api_key
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
            echo "cURL Error #:" . $err;
          } else {
             $data = json_decode($response, TRUE);

             echo '<option value="" selected disabled>kota</option>';

             for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
              $kabupaten = $data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name'];
                echo '<option value="'.$kabupaten.'">'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
             }
          }
?>