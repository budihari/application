<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="terms">
<?php echo $keterangan;?>
</div>
<script>
function change(data){
   $.ajax({
      url: "<?=base_url();?>home/lang_privacy",
      method: "POST",
      data: { lang:data },
      success: function(obj) {
         var hasil = obj;

         var element = document.getElementById("terms");
         element.innerHTML = hasil;
      }
   });
}
</script>