<?php
//Start
if (!empty($key->penggunaan) && $kat->kategori == 'shallow submersible pumps') {
?>
  <tr>
    <td>pengguna</td><td>:</td><td><?= $key->penggunaan; ?></td>
  </tr>
<?php
}
if (!empty($spesifik->daya) && $kat->kategori != 'pressure tanks' && substr($judul[0],0,5) != 'PRSFC') {
?>
  <tr>
    <td>output (<span style="font-size: 12px; font-style: italic;">p2</span>)</td><td>:</td><td><?= $spesifik->daya; ?></td>
  </tr>
<?php
}
if (!empty($spesifik->input) && $kat->kategori != 'shallow submersible pumps' && $kat->kategori != 'deep-well submersible pumps') {
?>
  <tr>
    <td>input (<span style="font-size: 12px; font-style: italic;">p1</span>)</td><td>:</td><td><?= $spesifik->input; ?></td>
  </tr>
<?php
}
if($judul[0] == 'FLWST-011'){
?>
  <tr>
    <td>current (<span style="font-size: 12px; font-style: italic;">I</span>)</td><td>:</td><td><?= $spesifik->currentarus; ?></td>
  </tr>
<?php
}
if(!empty($spesifik->minflow)){
?>
  <tr>
    <td>min flow (<span style="font-size: 12px; font-style: italic;">Qmin</span>)</td><td>:</td><td><?= $spesifik->minflow; ?></td>
  </tr>
<?php
}
  if (!empty($spesifik->totalhead)) {
?>
  <tr>
    <td>total head (<span style="font-size: 12px; font-style: italic;">Hmax</span>)</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->totalhead.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->hisap) && $kat->kategori != 'shallow submersible pumps' && $kat->kategori != 'deep-well submersible pumps') {
?>
  <tr>
    <td>hisap maks (<span style="font-size: 12px; font-style: italic;">Hs</span>)</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->hisap.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->kapasitas) && $kat->kategori != 'booster pumps') {
?>
  <tr>
    <td>kapasitas</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->kapasitas.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->membrane)) {
?>
  <tr>
    <td>membrane</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->membrane.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->precharge_pressure)) {
    if(substr($judul[0],0,5) == 'PRSFC'){
        $text = 'pre-set starting pressure';
    }
    else{
        $text = 'pre-charge pressure';
    }
?>
  <tr>
<?php
echo '<td>'.$text.'</td><td>:</td><td class="gray">'.$spesifik->precharge_pressure.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->pressure) && $kat->kategori == 'accessories' && substr($judul[0],0,5) == 'PRSFC') {
?>
  <tr>
    <td>starting pressure range</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->pressure.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->daya) && $kat->kategori == 'accessories' && substr($judul[0],0,5) == 'PRSFC') {
?>
  <tr>
    <td>max power</td><td>:</td><td><?= $spesifik->daya; ?></td>
  </tr>
<?php
}
if (!empty($spesifik->currentarus) && $kat->kategori == 'accessories' && substr($judul[0],0,5) == 'PRSFC') {
?>
  <tr>
    <td>max current</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->currentarus.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->max_pressure)) {
    if(substr($judul[0],0,5) == 'PRSFC'){
        $text = 'max pressure';
    }
    else{
        $text = 'max working pressure';
    }
?>
  <tr>
<?php
echo '<td>'.$text.'</td><td>:</td><td>'.$spesifik->max_pressure.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->on_off)) {
?>
  <tr>
    <td>on-off setting</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->on_off.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->pressure) && substr($judul[0],0,5) != 'PRSFC') {
    if(substr($judul[0],0,3) == 'FFC'){
        $text = 'tekanan';
    }
    else{
        $text = 'pressure range';
    }
?>
  <tr>
<?php
echo '<td>'.$text.'</td><td>:</td><td>'.$spesifik->pressure.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->currentarus) && $kat->kategori == 'accessories' && substr($judul[0],0,5) == 'PRSST') {
?>
  <tr>
    <td>rated current</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->currentarus.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->ukuran)) {
?>
  <tr>
    <td>ukuran</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->ukuran.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->temperatur)) {
    if(substr($judul[0],0,3) == 'FFC'){
        $text = 'suhu penggunaan';
    }
    else{
        $text = 'max temp';
    }
?>
  <tr>
<?php
echo '<td>'.$text.'</td><td>:</td><td>'.$spesifik->temperatur.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->flange)) {
?>
  <tr>
    <td>flange</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->flange.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->maxcapacity)) {
?>
  <tr>
    <td>kapasitas max (<span style="font-size: 12px; font-style: italic;">Qmax</span>)</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->maxcapacity.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->rated) && $kat->kategori != 'booster pumps') {
?>
  <tr>
    <td>kapasitas rated (<span style="font-size: 12px; font-style: italic;">Qrated</span>)</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->rated.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->impeler)) {
?>
  <tr>
    <td>impeler</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->impeler.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->dmsumur)) {
?>
  <tr>
    <td>diameter sumur</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->dmsumur.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->kabel) && $kat->kategori != 'shallow submersible pumps' && $kat->kategori != 'booster pumps') {
?>
  <tr>
    <td>kabel</td><td>:</td>
<?php
echo '<td class="gray">'.$spesifik->kabel.'</td>';
?>
  </tr>
<?php
}
if (!empty($garansi[1])) {
?>
  <tr>
    <td>garansi motor</td><td>:</td><td><?=$gm;?></td>
  </tr>
<?php
}
if(!empty($garansi[0]) && $kat->kategori != 'shallow submersible pumps' && $kat->kategori != 'deep-well submersible pumps'){
?>
  <tr>
    <td>garansi sparepart</td><td>:</td><td><?=$garansi[0];?></td>
  </tr>
<?php
}
//End