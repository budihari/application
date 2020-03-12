<table style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
         <tr>
            <td>Judul</td>
            <td>
               <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="sellingtitle" value="<?php if(!empty($sellingtitle)){$sellingtitle;}?>" placeholder="Judul Selling Point">
            </td>
         </tr>
         <tr>
            <td>Sub Judul</td>
            <td>
               <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="sellingsubtitle" value="<?php if(!empty($sellingsubtitle)){$sellingsubtitle;}?>" placeholder="Sub Judul Selling Point">
            </td>
         </tr>
         <tr>
            <td>Foto Master</td>
            <td>
               <div>
               <?php
               if (isset($fotomaster)) {
                  echo '<input type="hidden" name="old_fotomaster" value="'.$fotomaster.'">';
                  echo '<img style="max-width:80%; max-height:200px;" src="'.base_url('assets/upload/sellingpoint/'.$fotomaster).'">';
                  echo '<div class="clear-fix"></div><br />';
               }
               ?>
               <input type="file" name="fotomaster">
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
            </td>
         </tr>
      </table>
      <hr>
      <style>
         #mySelling tr td{
            vertical-align:top;
         }
      </style>
      <table id="mySelling" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
      <?php
         if(!empty($ketpoin)){
            $no = 0;
            $ip = explode(",_,", $imgpoint);
            $kp = explode(",/,", $ketpoin);
            $jp = explode(",_,", $kp[0]);
            $kp = explode(",_,", $kp[1]);
            $garis = "";
            foreach($jp as $value){
               if($no >= 1){
                  $garis = "<hr>";
               }
      ?>
         <tr>
            <td style="width:40%;">
            <?php echo $garis;?>
            <p>Gambar</p>
            <div style="width:100%;">
               <?php
               if (isset($ip[$no])) {
                  echo '<input type="hidden" name="old_imgpoint[]" value="'.$ip[$no].'">';
                  echo '<center><img style="max-width:80%; max-height:200px;" src="'.base_url('assets/upload/sellingpoint/'.$ip[$no]).'"></center>';
                  echo '<div class="clear-fix"></div><br />';
               }
               ?>
               <input type="file" name="imgpoint[]" style="padding: 6px; width:100%; box-sizing:border-box;">
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
            </td>
            <td style="width:60%;">
            <?php echo $garis;?>
            <div style="width:100%;">
               <p>Keterangan</p>
               <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pointjudul[]" value="<?php echo $jp[$no];?>" placeholder="Judul Point">
               <br>
               <textarea style="width: 100%;" name="pointketerangan[]" placeholder="Keterangan"><?php echo $kp[$no];?></textarea>
            </div>
            </td>
         </tr>
      <?php
            $no++;
            }
         }
         else{
      ?>
         <tr>
            <td style="width:40%;">
            <p>Gambar</p>
            <div>
               <input type="file" name="imgpoint[]">
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
            </td>
            <td style="width:60%;">
               <p>Keterangan</p>
               <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pointjudul[]" placeholder="Judul Point">
               <br>
               <textarea style="width: 100%;" name="pointketerangan[]" placeholder="Keterangan"></textarea>
            </td>
         </tr>
      <?php
         }
      ?>
      </table>
      <div style="padding:12px;">
      <button type="button" onclick="mySelling()">Tambah Baris</button>
      <button type="button" onclick="DeleteSelling()">Hapus Baris</button>
      </div>
      <hr>
   <script>
    function mySelling() {
      var table = document.getElementById("mySelling");
      var row = table.insertRow();
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      //var cell3 = row.insertCell(2);
      var nomer = document.getElementById("mySelling").rows.length;
      var hr = "";
      if(nomer > 1){
         hr = "<hr>";
      }
      var nama = hr + '<p>Gambar ' + nomer + '</p><div>               <input type="file" name="imgpoint[]">               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p></div>';
      var ket = hr + '<p>Keterangan</p><input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pointjudul[]" placeholder="Judul Point"><br><textarea style="width: 100%;" name="pointketerangan[]" placeholder="Keterangan"></textarea>';
      var button = '<button type="button" onclick="myFunction()">+</button><button type="button" onclick="DeleteFunction()">-</button>';
      cell1.innerHTML = nama;
      cell2.innerHTML = ket;
      //cell3.innerHTML = button;
    }

    function DeleteSelling() {
        document.getElementById("mySelling").deleteRow(-1);
    }
   </script>