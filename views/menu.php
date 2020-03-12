<div id="header" style="max-height: 50px;">
<div id="head">
<a href="index.php"><img style="max-height: 30px;padding: 10px 14px;" src="<?php echo base_url();?>img/logo.png" alt="logo"/></a>
</div>
<a id="i-nav"><div style="margin:auto;"><img style="width:20px;" src="<?php echo base_url();?>img/icon/menu4.png" alt="menu" /></div></a>
<nav id="nav">
<ul id="menu">
<li class="child"><a id="home" href="<?php echo base_url();?>">home</a></li>
<li class="menu-store"><a id="toko" style="color: #000;" href="<?php echo base_url();?>store">store</a><img style="max-height: 20px" src="img/icon/bottom.png" alt="store">
<ul id="kat1" class="substore">
<?php foreach ($kategori->result() as $kat): ?>
   <li>
      <a href="<?=site_url('home/kategori/'.$kat->url);?>"> <?=$kat->kategori;?></a>
   </li>
<?php endforeach; ?>
</ul>
<?php
/*
<ul class="substore">
	<li class="child"><a id="bathkithen" href="?page=bathkithen">bath & kithen</a></li>
	<li><a id="waterpump" href="?page=waterpump">waterpump</a></li>
	<li><a id="filter" href="?page=filter">water filterr</a></li>
</ul>
*/
?>
</li>
<li><a id="ourstory" href="<?php echo base_url();?>?page=ourstory">our story</a></li>
<li><a id="whyus" href="<?php echo base_url();?>?page=whyus">why us</a></li>
<li><a id="one_for_one" href="<?php echo base_url();?>?page=one_for_one">one for one</a></li>
<li class="menu-contact"><a style="color: #000;" href="<?php echo base_url();?>?page=showroom">contact</a><img style="max-height: 20px" src="img/icon/bottom.png" alt="contact">
<ul class="subcontact">
	<li class="child"><a id="show" href="<?php echo base_url();?>?page=showroom">showrooms</a></li>
	<li><a id="service" href="<?php echo base_url();?>?page=service_centre">service centre</a></li>
	<li><a id="dealer" href="<?php echo base_url();?>?page=dealer">dealer</a></li>
</ul>
</li>
</ul>
</nav>
</div>