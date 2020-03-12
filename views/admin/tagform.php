<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($kategori) {
   foreach ($kategori->result() as $l) {
      $r[] = $l->id_master;
   }
     $kat = $kategori->row();
}
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?= $header; ?></h2>
     <div class="clearfix"></div>
     <?= validation_errors('<p style="color:red">','</p>'); ?>
     <?php
     if ($this->session->flashdata('alert'))
     {
        echo '<div class="alert alert-danger alert-message">';
        echo $this->session->flashdata('alert');
        echo '</div>';
     }
     ?>
   </div>

   <div id="item" class="x_content">
      <br />

      <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Kategori
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="id" value="<?php if(!empty($kat->id_kategori)){ echo $kat->id_kategori; } ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Url Kategori
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="url" value="<?php if(!empty($kat->url)){ echo $kat->url; } ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Kategori
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="kategori" value="<?php if(!empty($kat->kategori)){ echo $kat->kategori; } ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Gambar Kategori
            </label>
            <div style="max-width:300px;" class="col-md-7 col-sm-6 col-xs-12">
              <?php
              if (isset($gambar)) {
                echo '<input type="hidden" name="old_pict" value="'.$gambar.'">';
                echo '<img src="'.base_url('assets/upload/kategori/'.$gambar).'" width="80%">';
                echo '<div class="clear-fix"></div><br />';
              }
               ?>
               <input type="file" name="gambar">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Master Kategori</label>
            <div class="col-md-7 col-sm-6">
               <?php foreach($master->result() as $k) :?>
                  <input type="radio" name="master" value="<?=$k->id;?>" onclick="addlist(this, 'txt1')" <?php if (isset($r)) { if($kategori){ if(in_array($k->id, $r)){echo 'checked';}}} ?>> <?=$k->masterkategori;?>&nbsp;
               <?php endforeach; ?>

            </div>
         </div>
         
         <div class="form-group">
         <label class="control-label col-md-2 col-sm-2 col-xs-12">Sub Kategori</label>
         <div class="form-group col-md-7 col-sm-6">
            <table id="myTable" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
           <tr>
               <th>
                   Nama Sub Kategori
               </th>
               <th>
                   URL Sub Kategori
               </th>
           </tr>
           <?php
           
           if(!isset($kat->kategori2) || $kat->kategori2 == ""){
           ?>
           <tr>
               <td style="vertical-align:middle; width:28%;">
                   <input type="hidden" name="idsubkategori[]" value="">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="subkategori[]" placeholder="subkategori">
               </td>
               <td style="vertical-align:middle; width:50%;">
                        <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="urlsubkategori[]" placeholder="url subkategori">
               </td>
           </tr>
           <?php
           }
           else{
           $no = 0;
           $subkategori = explode(",_,", $kat->kategori2);
           $urlsubkategori = explode(",_,", $kat->url2);
           foreach($subkategori as $value){
               $subkategori = explode(",/,", $value);
               $idsub = explode(".", $subkategori[0]);
           ?>
           <tr>
               <td style="vertical-align:middle; width:28%; padding:4px 0px;">
                   <input type="hidden" name="idsubkategori[]" value="<?php echo $idsub[1];?>">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="subkategori[]" value="<?php echo $subkategori[1];?>">
               </td>
               <td style="vertical-align:middle; width:50%;">
                        <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="urlsubkategori[]" value="<?php echo $urlsubkategori[$no];?>">
               </td>
           </tr>
           <?php
           $no++;
           }
           }
           ?>
       </table>
        <div style="padding:0px 12px;">
        <button type="button" onclick="myFunction()">Tambah Baris</button>
        <button type="button" onclick="upNdown('up');">&ShortUpArrow;</button>
        <button type="button" onclick="upNdown('down');">&ShortDownArrow;</button>
        <button type="button" onclick="DeleteFunction()">Hapus Baris</button>
        </div>
        </div>
         </div>
         
    <script>
    function myFunction() {
      var table = document.getElementById("myTable");
      var row = table.insertRow();
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      //var cell3 = row.insertCell(2);
      var nama = '<input type="hidden" name="idsubkategori[]" value=""><input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="subkategori[]" placeholder="subkategori">';
      var ket = '<input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="urlsubkategori[]" placeholder="url subkategori">';
      var button = '<button type="button" onclick="myFunction()">+</button>                <button type="button" onclick="DeleteFunction()">-</button>';
      cell1.innerHTML = nama;
      cell2.innerHTML = ket;
      //cell3.innerHTML = button;
    }
    
    function DeleteFunction() {
        document.getElementById("myTable").deleteRow(-1);
    }
    </script>
    <script>
            
            var index;  // variable to set the selected row index
            function getSelectedRow()
            {
                var table = document.getElementById("myTable");
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                        // clear the selected from the previous selected row
                        // the first time index is undefined
                        if(typeof index !== "undefined"){
                            table.rows[index].style.background="";
                        }
                       
                        index = this.rowIndex;
                        this.style.background="#ddd";

                    };
                }
                    
            }
  

            getSelectedRow();
            
            
            function upNdown(direction)
            {
                var rows = document.getElementById("myTable").rows,
                    parent = rows[index].parentNode;
                 if(direction === "up")
                 {
                     if(index > 1){
                        parent.insertBefore(rows[index],rows[index - 1]);
                        // when the row go up the index will be equal to index - 1
                        index--;
                    }
                 }
                 
                 if(direction === "down")
                 {
                     if(index < rows.length -1){
                        parent.insertBefore(rows[index + 1],rows[index]);
                        // when the row go down the index will be equal to index + 1
                        index++;
                    }
                 }
            }
            
        </script>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="itemform" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>