<?php
elseif ($this->input->post('spekform') == 'Submit') {
	$spesifikasi = $this->items->get_where('spesifikasi', array('id_item' => $id_item));
		$spesifik = array (
					'voltase' => $this->input->post('voltase'),
					'daya' => $this->input->post('daya'),
					'currentarus' => $this->input->post('currentarus'),
					'totalhead' => $this->input->post('totalhead'),
					'maxcapacity' => $this->input->post('maxcapacity'),
					'hisap' => $this->input->post('hisap'),
					'head' => $this->input->post('head'),
					'kapasitas' => $this->input->post('kapasitas'),
					'pressure' => $this->input->post('pressure'),
					'pipa' => $this->input->post('pipa'),
					'beratkotor' => $this->input->post('beratkotor')
				);
		if ($spesifikasi->num_rows() == 1)
				{
		         $this->items->update('spesifikasi', $spesifik, array('id_item' => $id_item));
				} else {
					$data = [
							'id_item' => $id_item,
							'model' => $this->input->post('model'),
							'voltase' => $this->input->post('voltase'),
							'daya' => $this->input->post('daya'),
							'currentarus' => $this->input->post('currentarus'),
							'totalhead' => $this->input->post('totalhead'),
							'maxcapacity' => $this->input->post('maxcapacity'),
							'hisap' => $this->input->post('hisap'),
							'head' => $this->input->post('head'),
							'kapasitas' => $this->input->post('kapasitas'),
							'pressure' => $this->input->post('pressure'),
							'pipa' => $this->input->post('pipa'),
							'beratkotor' => $this->input->post('beratkotor')
						];

						$this->items->insert('spesifikasi', $data);
				}
}
?>










<div id="spesifikasi">
      <form class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST">

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >voltase
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="voltase" value="<?php if(!empty(
               $voltase)){echo $voltase;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >daya
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="daya" value="<?php if(!empty($daya)){echo $daya;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >current arus
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="currentarus" value="<?php if(!empty($currentarus)){echo $currentarus;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >total head
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="totalhead" value="<?php if(!empty($totalhead)){echo $totalhead;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >max kapasitas
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="maxcapacity" value="<?php if(!empty($maxcapacity)){echo $maxcapacity;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >hisap
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="hisap" value="<?php if(!empty($hisap)){echo $hisap;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >head
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="head" value="<?php if(!empty($head)){echo $head;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >kapasitas
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="kapasitas" value="<?php if(!empty($kapasitas)){echo $kapasitas;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >pressure switch
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="pressure" value="<?php if(!empty($pressure)){echo $pressure;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >pipa
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="pipa" value='<?php if(!empty($pipa)){echo $pipa;} ?>'>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >berat kotor
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="beratkotor" value="<?php if(!empty($beratkotor)){echo $beratkotor;} ?>">
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="spekform" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>
      </form>
   </div>