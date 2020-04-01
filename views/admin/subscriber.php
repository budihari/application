<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?=$header;?></h2>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-12">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="datatable">
               <thead>
                  <tr>
                     <th width="5%">#</th>
                     <th width="30%">Tanggal</th>
                     <th width="40%">Email</th>
                     <th width="15%">Status</th>
                     <th width="10%">Opsi</th>
                  </tr>
                  <?php
                    $i = 1;
                    foreach($data->result() as $subscribe) :
                    $tgl = explode(" ", $subscribe->tgl);
                  ?>
                  <tr>
                      <td><?=$i++;?></td>
                      <td><?php echo $tgl[0].'<br>'.$tgl[1];?></td>
                      <td style="vertical-align: middle;"><?=$subscribe->email;?></td>
                      <td style="vertical-align: middle;"><?=$subscribe->status;?></td>
                      <td style="vertical-align: middle;" class="center"><a href="<?=base_url();?>administrator/edit_subscribe/<?=$subscribe->id_subscriber;?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                      <a style="color: #b00;" href="<?=base_url();?>administrator/delete_subscribe/<?=$subscribe->id_subscriber;?>" onclick="return confirm('Yakin Ingin Menghapus Data ini ?')"><i class="fa fa-trash"></i></a>
                     </td>
                  </tr>
                  <?php
                    endforeach;
                  ?>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
