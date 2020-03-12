<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart'));
		$this->load->model('app');
	}

	public function index()
	{
		$table = 'last_view l
						JOIN t_items i ON (l.id_item = i.id_item)';
		//$data['last'] = $this->app->get_where($table, ['id_user' => $this->session->userdata('user_id')]);
		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		$data['last'] = $this->db->order_by('waktu', 'DESC')->get_where($table, ['id_user' => $this->session->userdata('user')]);
		$data['title'] 		= "Your cart";
      $this->template->olshop('cart',$data);
	}

	public function add()
	{
		if ($this->uri->segment(3))
		{
			$id 	= $this->uri->segment(3);
			$get 	= $this->app->get_where('t_items', array('link' => $id))->row();

			if ($this->input->post('submit', TRUE) == 'Submit')
			{

				$qty 	= $this->input->post('qty', TRUE);
				$quantity = '';
				$note = "";
				
				foreach($this->cart->contents() as $key){
				    if($key['link'] == $id){
						$quantity = $key['qty'];
						$note = $key['note'];
				    }
				}

				if (!is_numeric($qty) || $qty < 1)
				{

					$this->session->set_flashdata('alert', 'Submit tidak valid');

					redirect('home');

				}
				elseif ($quantity >= $get->stok)
				{
				    $this->session->set_flashdata('alert', 'insufficient stock');
				    echo '<script type="text/javascript">window.history.go(-1);</script>';
				}
				else{

				$special_char = ['`','~','!','@','#','$','%','^','&','*','(',')','_','+','=','[',']','{','}','\'','|','"',':',';','/','\\','?','/','<','>',','];
				//clean item name
				$name = str_replace($special_char, ' ', $get->nama_item);
				$harga = $get->harga;
				if($get->hargapromo != 0){
					$harga = $get->hargapromo;
				}
				if($get->grosir != 0 && $quantity >= $get->grosir){
					$harga = $get->harga_grosir;
				}

	         $data = array(
	            'id'			=> $get->id_item,
				'link' 			=> $get->link,
	            'name' 			=> $name,
				'price'			=> $harga,
	            'weight'		=> $get->berat,
	            'qty' 			=> $qty,
	            'note'			=> $note
	         );
				//insert cart
	         $this->cart->insert($data);

				$this->session->set_flashdata('success', 'item was added to cart');

	         echo '<script type="text/javascript">window.history.go(-1);</script>';
				}
			}

			elseif ($this->input->post('buy', TRUE) == 'beli')
			{

				$qty 	= $this->input->post('qty', TRUE);
				$quantity = '';
				$note = "";
				foreach($this->cart->contents() as $key){
				    if($key['link'] == $id){
						$quantity = $key['qty'];
						$note = $key['note'];
				    }
				}

				if (!is_numeric($qty) || $qty < 1)
				{

					$this->session->set_flashdata('alert', 'Submit tidak valid');

					redirect('home');

				}
				elseif ($quantity >= $get->stok)
				{
				    $this->session->set_flashdata('alert', 'insufficient stock');
				    echo '<script type="text/javascript">window.history.go(-1);</script>';
				}
				else{

				$special_char = ['`','~','!','@','#','$','%','^','&','*','(',')','_','+','=','[',']','{','}','\'','|','"',':',';','/','\\','?','/','<','>',','];
				//clean item name
				$name = str_replace($special_char, ' ', $get->nama_item);
				$harga = $get->harga;
				if($get->hargapromo != 0){
					$harga = $get->hargapromo;
				}
				if($get->grosir != 0 && $quantity >= $get->grosir){
					$harga = $get->harga_grosir;
				}

	         $data = array(
	            'id'			=> $get->id_item,
				'link' 			=> $get->link,
	            'name' 			=> $name,
				'price'			=> $harga,
	            'weight'		=> $get->berat,
	            'qty' 			=> $qty,
	            'note'      	=> $note
	         );
				//insert cart
	         $this->cart->insert($data);

				$this->session->set_flashdata('success', 'item was added to cart');

	         echo '<script type="text/javascript">window.location="'.base_url().'cart";</script>';
				}
			}

		} else {
			redirect('home');
		}
	}

	public function up()
   {
      if ($this->uri->segment(3) && is_numeric($this->input->post('qty', TRUE)))
      {
         $this->load->library('form_validation');

         $this->form_validation->set_rules('qty', 'Jumlah Pesanan', 'required|numeric');

         if ($this->form_validation->run() == TRUE)
         {
				//ambil data cart
				foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$quantity = $c['qty'];
						$id		 = $c['id'];
					}
				}

				//ambil stok terkini
				$get = $this->app->get_where('t_items', ['id_item' => $id])->row();

				$stok = $get->stok;

				if ($this->input->post('qty', TRUE) > $stok)
				{
					$this->session->set_flashdata('alert', 'insufficient stock');

					//redirect('cart');
				}

            $data = array(
               'qty' 	=> $this->input->post('qty', TRUE),
               'rowid'	=> $this->uri->segment(3)
            );

            $this->cart->update($data);

				$this->session->set_flashdata('success', 'item has been update');

            //redirect('cart');
         } else {

            $this->template->olshop('cart');
         }

      }
      elseif ($this->uri->segment(3) && $this->input->post('note') && $this->input->post('submit') == "Submit")
      {

         	foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$note 	= $c['note'];
						$id		= $c['id'];
					}
				}
            $data = array(
               'note' 	=> $this->input->post('note'),
               'rowid'	=> $this->uri->segment(3)
            );
            $this->cart->update($data);

				$this->session->set_flashdata('success', 'note has been update');

            //redirect('cart');

      }
      elseif ($this->uri->segment(3) && $this->input->post('hapus') == "hapus") {
      	foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$note 	= $c['note'];
						$id		= $c['id'];
					}
				}
      	$data = array(
               'note' 	=> "",
               'rowid'	=> $this->uri->segment(3)
            );
            $this->cart->update($data);
            $this->session->set_flashdata('success', 'note has been delete');

            //redirect('cart');
      }
       else {
			$this->session->set_flashdata('alert', 'Item gagal diupdate');

         //redirect('cart');
      }
      echo '<script type="text/javascript">window.history.go(-1)</script>';
   }

   public function update()
   {
      if ($this->uri->segment(3) && is_numeric($this->input->post('qty', TRUE)))
      {
         $this->load->library('form_validation');

         $this->form_validation->set_rules('qty', 'Jumlah Pesanan', 'required|numeric');

         if ($this->form_validation->run() == TRUE)
         {
				//ambil data cart
				foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$quantity = $c['qty'];
						$id		 = $c['id'];
					}
				}

				//ambil stok terkini
				$get = $this->app->get_where('t_items', ['id_item' => $id])->row();

				$stok = $get->stok;

				if ($this->input->post('qty', TRUE) > $stok)
				{
					$this->session->set_flashdata('alert', 'insufficient stock');
					$qty	= $stok;
					//redirect('cart');
				}
				else{
					$qty	= $this->input->post('qty', TRUE);
				}

				$id 	= $id;
				$get 	= $this->app->get_where('t_items', array('id_item' => $id))->row();
				$harga = $get->harga;
				if($get->hargapromo != 0){
					$harga = $get->hargapromo;
				}
				if($get->grosir != 0 && $qty >= $get->grosir){
					$harga = $get->harga_grosir;
				}

            $data = array(
               'qty' 	=> $qty,
			   'rowid'	=> $this->uri->segment(3),
			   'price'	=> $harga
            );

            $this->cart->update($data);

				$this->session->set_flashdata('success', 'item has been update');

            //redirect('cart');
         } else {

            $this->template->olshop('cart');
         }

      }
      elseif ($this->uri->segment(3) && $this->input->post('note') && !empty($this->input->post('note')) && $this->input->post('submit') == "Submit")
      {

         	foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$note 	= $c['note'];
						$id		= $c['id'];
					}
				}
				$message = htmlspecialchars($this->input->post('note'));
                $message = addslashes($message);
            $data = array(
               'note' 	=> $message,
               'rowid'	=> $this->uri->segment(3)
            );
            $this->cart->update($data);

				$this->session->set_flashdata('success', 'note has been update');

            //redirect('cart');

      }
      elseif ($this->uri->segment(3) && empty($this->input->post('note'))) {
      	foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$note 	= $c['note'];
						$id		= $c['id'];
					}
				}
      	$data = array(
               'note' 	=> "",
               'rowid'	=> $this->uri->segment(3)
            );
            $this->cart->update($data);
            $this->session->set_flashdata('success', 'note has been delete');

            //redirect('cart');
      }
       else {
			$this->session->set_flashdata('alert', 'item has not update');

         //redirect('cart');
      }
      echo '<script type="text/javascript">window.history.go(-1)</script>';
   }

   public function delete()
   {
      if ($this->uri->segment(3))
      {

         $rowid = $this->uri->segment(3);

         $this->cart->remove($rowid);

			$this->session->set_flashdata('success', 'item has been deleted');

         //redirect('cart');

      } else {

			$this->session->set_flashdata('alert', 'item has not deleted');

         //redirect('cart');
      }
      echo '<script type="text/javascript">window.history.go(-1)</script>';
   }
}
