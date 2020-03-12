<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart', 'encryption'));
		$this->load->model('app');
	}
public function city()
   {
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('prov', 'Provinsi', 'required');

			if ($this->form_validation->run() == TRUE)
			{
		      $prov = explode(",", $this->encryption->decrypt($this->input->post('prov', TRUE)));
				$key  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
		      $curl = curl_init();

		      curl_setopt_array($curl, array(
		        CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$prov[0]",
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

		         echo '<option value="" selected disabled>Kota / Kabupaten</option>';

		         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		         	$kabupaten = $this->encryption->encrypt($data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name']);
		         	if ($kota == $kabupaten) {
		         		$selected = "selected";
		         	}
		            echo '<option value="'.$kabupaten.'" '.$selected.'>'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
		         }
		      }
			}
		}
   }

   public function allcity()
   {
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

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

		         echo '<option value="" selected disabled>Kota / Kabupaten</option>';

		         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		         	$kabupaten = $this->encryption->encrypt($data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name']);
		         	if ($kota == $kabupaten) {
		         		$selected = "selected";
		         	}
		            echo '<option value="'.$kabupaten.'" '.$selected.'>'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
		         }
		      }
		}
   }

	public function getcost()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('dest', 'Tujuan', 'required');
			$this->form_validation->set_rules('kurir', 'Kurir', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$api  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$asal = $api->asal;
				$dest = explode(",", $this->encryption->decrypt($this->input->post('dest', TRUE)));
				$kurir = $this->input->post('kurir', TRUE);
				$berat = 0;

				foreach ($this->cart->contents() as $key) {
					$berat += ($key['weight'] * $key['qty']);
				}

				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "origin=$asal&destination=$dest[0]&weight=$berat&courier=$kurir",
				  CURLOPT_HTTPHEADER => array(
				    "content-type: application/x-www-form-urlencoded",
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

				  	echo '<option value="" selected disabled>Layanan yang tersedia</option>';

				  	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

						for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

							echo '<option value="'.$this->encryption->encrypt($data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service']).'">';
							echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

						}

				  	}
			  	}
			}
		}
	}

		public function layanan()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('dest', 'Tujuan', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$api  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$asal = $api->asal;
				$dest = explode(",", $this->encryption->decrypt($this->input->post('dest', TRUE)));
				$kurir = $this->input->post('kurir', TRUE);
				$berat = 0;

				foreach ($this->cart->contents() as $key) {
					$berat += ($key['weight'] * $key['qty']);
				}
				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "origin=$asal&destination=$dest[0]&weight=$berat&courier=$kurir",
				  CURLOPT_HTTPHEADER => array(
				    "content-type: application/x-www-form-urlencoded",
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

				  	echo '<option value="" selected disabled>Layanan yang tersedia</option>';

				  	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

						for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

							echo '<option value="'.$this->encryption->encrypt($data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service']).'">';
							echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

						}

				  	}
			  	}
			}
		}
	}

	public function cost()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('layanan', 'Layanan', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$biaya = explode(',', $this->encryption->decrypt($this->input->post('layanan', TRUE)));
				$total = $this->cart->total() + $biaya[0];

				echo $biaya[0].','.$total;
			}
		}
	}
}
?>