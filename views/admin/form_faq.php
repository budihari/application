<?php
defined('BASEPATH') or exit('No direct script access allowed');
$today = date("Y-m-d", time());
$time = date("H:i:s", time());
$table = '';
$query = "SELECT * from faq order by urut ASC";
$cek = $this->db->query($query);
?>
<div class="x_panel">
    <div class="x_title">
        <h2><?= $header; ?></h2>
        <div class="clearfix"></div>
        <?php
        if ($this->session->flashdata('alert')) {
            echo '<div class="alert alert-danger alert-message">';
            echo $this->session->flashdata('alert');
            echo '</div>';
        }
        else if ($this->session->flashdata('success')) {
            echo '<div class="alert alert-success alert-message">';
            echo $this->session->flashdata('success');
            echo '</div>';
        }
        ?>
    </div>
    <style>
        #myTable tr td{
            padding: 8px;
            vertical-align:middle; 
        }
    </style>
    <div id="item" class="x_content">

        <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

        <div class="form-group">
         <div>
            <table id="myTable" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
           <tr>
               <th>
                   
               </th>
           </tr>
           <?php
           
           if($cek->num_rows() == 0){
           ?>
           <tr>
           <td style="width:28%;">
                   Tanya : <input type="hidden" name="idpertanyaan[]" value="">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pertanyaan[]" value="" placeholder="Masukkan Pertanyaan"><br>
                   Jawab : <textarea style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box; resize: none;" name="jawaban[]" placeholder="Masukkan Jawaban"></textarea>
                   <br><br>
               </td>
           </tr>
           <?php
           }
           else if($cek->num_rows() > 0){
           $no = 0;
           foreach($cek->result() as $row){
           ?>
           <tr>
               <td style="width:28%;">
                   Tanya : <input type="hidden" name="idpertanyaan[]" value="">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pertanyaan[]" value="<?php echo $row->tanya;?>" placeholder="Masukkan Pertanyaan"><br>
                   Jawab : <textarea style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box; resize: none;" name="jawaban[]" placeholder="Masukkan Jawaban"><?php echo $row->jawab;?></textarea>
                   <br><br>
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
      //var cell2 = row.insertCell(1);
      //var cell3 = row.insertCell(2);
      var table = 'Tanya : <input type="hidden" name="idpertanyaan[]" value=""><input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="pertanyaan[]" value="" placeholder="Masukkan Pertanyaan"><br>Jawab : <textarea style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box; resize: none;" name="jawaban[]" placeholder="Masukkan Jawaban"></textarea><br><br>';
      //var ket = '<input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="urlsubkategori[]" placeholder="url subkategori">';
      //var button = '<button type="button" onclick="myFunction()">+</button>                <button type="button" onclick="DeleteFunction()">-</button>';
      cell1.innerHTML = table;
      //cell2.innerHTML = ket;
      //cell3.innerHTML = button;
      getSelectedRow();
    }
    
    function DeleteFunction() {
        var r = document.getElementById("rowselect");
        var i = r.rowIndex;
        document.getElementById("myTable").deleteRow(i);
        //document.getElementById("myTable").deleteRow(-1);
        //document.getElementById("rowselect").deleteRow();
        getSelectedRow();
    }

    function deleteRow(data, r) {
        var i = r.rowIndex;
        var r = confirm("Yakin ingin menghapus gambar ini ?");
        if (r == true) {
            document.getElementById(data).deleteRow(i);
        }
        var table = document.getElementById(data);
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var img = document.getElementsByClassName('bg_selling');
        var nomer = img.length;
        if(nomer == 0){
            var newrow = '<p class="center">Tidak ada data</p>';
            cell1.innerHTML = newrow;
            table.remove();
        }
        console.log (nomer);
        console.log (i);
    }
    </script>
    <script>
            function clearSelectedRow()
            {
                var index;  // variable to set the selected row index
                var table = document.getElementById("myTable");
                for(var i = 1; i < table.rows.length; i++)
                {
                        if(typeof index !== "undefined"){
                            table.rows[index].setAttribute("id", "");
                            table.rows[index].style.background="";
                        }
                }
            }
            
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
                            table.rows[index].setAttribute("id", "");
                            table.rows[index].style.background="";
                        }
                       
                        index = this.rowIndex;
                        this.setAttribute("id", "rowselect");
                        this.style.background="#ddd";
                        

                    };
                }
                    //getSelectedRow();
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

        <hr>

        <div style="padding: 0px 12px;">
            <button class="btn btn-primary" type="submit" name="form_faq" value="true">Submit</button>
            <button class="btn btn-default" type="button" onclick="window.history.go(-1)">Kembali</button>
        </div>

        </form>

    </div>



</div>