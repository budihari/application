<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="faq">
<div class="content">
<div class="header" style="width: 100%;">
    <h1 style="font-size: 24px; text-align:center; padding:18px; padding-top:32px;">faq</h1>
    <hr style="border:solid 1px #ddd; margin:0px auto 18px auto; max-width:300px;">
</div>

<div id='faq'>

<div class='col' style="padding:0px 20px;">
    <?php
    $query = 'select * from faq';
    $data = $this->db->query($query);
    $num = $data->num_rows() / 2;
    $num = round($num);
    $query = 'select * from faq limit 0,'.$num;
    $data = $this->db->query($query);
    $no = 0;
    foreach($data->result() as $key){
    ?>
    <div style="background:#fafafa; margin-bottom:6px; border-radius:8px;">
        <div class='tanya' style="padding:12px; line-height:20px;" onclick="change('jawab','<?php echo $no;?>')">
            <?=strtolower($key->tanya);?>
        </div>
        <div class='jawab' style="padding:12px; padding-top:0px; line-height:20px;">
            <?=strtolower($key->jawab);?>
        </div>
    </div>
    <?php
    $no++;
    }
    ?>
</div>

<div class='col' style="padding:0px 20px;">
    <?php
    $query = 'select * from faq';
    $data = $this->db->query($query);
    $num = $data->num_rows() / 2;
    $num = round($num);
    $query = 'select * from faq limit '.$num.','.$num;
    $data = $this->db->query($query);
    $no = $num;
    foreach($data->result() as $key){
    ?>
    <div style="background:#fafafa; margin-bottom:6px; border-radius:8px;">
        <div class='tanya' style="padding:12px; line-height:20px;" onclick="change('jawab','<?php echo $no;?>')">
            <?=strtolower($key->tanya);?>
        </div>
        <div class='jawab' style="padding:12px; padding-top:0px; line-height:20px;">
            <?=strtolower($key->jawab);?>
        </div>
    </div>
    <?php
    $no++;
    }
    ?>
</div>

</div>


</div>
</div>
<br>
<script>
function change(data,x){
    var submenu = document.getElementsByClassName(data)[x];
    $(submenu).slideToggle(500);
}
</script>