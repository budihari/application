<?php
/*
$item = $this->db->get('t_kategori');
$lokasi = './assets/upload/';
$x = 0;
foreach ($item->result() as $value) {
    $x++;
    $old_name = $value->foto_kategori;
    $new_name = $value->url;
    $extention = substr($old_name,-4);
    echo $x.". ".$lokasi." => ".$old_name." => ".$new_name." => ".$extention."<br>";
    $where = array('foto_kategori' => $old_name);
    $data = array('foto_kategori' => $new_name.$extention);
    $this->db->where($where);
    $this->db->update("t_kategori",$data);
    echo "berhasil di update<br>";
    rename ($lokasi.$old_name, $lokasi.$new_name.$extention);
    echo "berhasil diubah ke ".$lokasi.$new_name.$extention."<br>";
}
*/
?>