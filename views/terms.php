<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="terms">
<?php echo $keterangan;?>
</div>
<script>
function change(data){
   $.ajax({
      url: "<?=base_url();?>home/lang_terms",
      method: "POST",
      data: { lang:data },
      success: function(obj) {
         var hasil = obj;

         var element = document.getElementById("terms");
         element.innerHTML = hasil;
      }
   });
}

$(document).ready(function() {

$('#lang').change(function() {
    var lang = document.getElementById('lang').value;

   $.ajax({
      url: "<?=base_url();?>home/lang_terms",
      method: "POST",
      data: { lang:lang },
      success: function(obj) {
         var hasil = obj;

         var element = document.getElementById("terms");
         element.innerHTML = hasil;
      }
   });
   document.getElementById("language").remove;
});

});
</script>