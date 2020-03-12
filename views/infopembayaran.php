<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$waktu = explode(" / ", $bts_bayar);
$tanggal = explode("-", $waktu[0]);
$tgl = $tanggal[2];
$bulan = $tanggal[1];
$tahun = $tanggal[0];
/*
echo '<!DOCTYPE html>
          <html>
          <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <title>detail pembayaran</title>
          </head>
          <body>';
*/
$table = '';
foreach ($detail->result() as $row)
{
    $t_items = $this->db->query("SELECT i.*, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
    $subtotal = $row->biaya;
    $table .= '<tr><td><a href="'.site_url($t_items->link.'/'.$t_items->url.'/'.$row->link).'">'.$row->nama_item.'</a> ('.$row->qty.' x rp'.number_format($subtotal / $row->qty, 0, ',', '.').')</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($subtotal, 0, ',', '.').'</td></tr>';
}
$total1 = substr($total, 0, -3);
$total2 = substr($total, -3);
echo '
<style>
@media only screen and (max-width: 620px) {
    .info_pembayaran{
        padding: 0px; border-radius: 0px;
    }
    .info_bayar{
        border-radius: 0px;
    }
}
@media only screen and (min-width: 621px) {
    .info_pembayaran{
        padding: 24px 0px;
    }
    .info_bayar{
        border-radius: 12px;
    }
}
</style>
<div class="info_pembayaran">
        <div class="info_bayar" style="margin:auto; max-width: 600px; background: #fff; padding: 12px 24px;">
        <div>
            <p>hi '.$nama.'</p>
            <p style="max-width:430px;">one more step and this item will be yours! don\'t wait until it runs out, complete the process now.</p>
        </div>
        <div>
            <h1 style="font-size: 14px;">please complete the payment before the item runs out.</h1>
            <div style="text-align: center; background: #ddd; padding:12px; font-size: 12px; border-radius:8px;">
                <p>remaining time for your payment</p>
                <p id="demo"></p>

                <script>
                    // Set the date we\'re counting down to
                    var countDownDate = Date.parse("'.$bulan.' '.$tgl.', '.$tahun.' '.$waktu[1].'");
                    
                    // Update the count down every 1 second
                    var x = setInterval(function() {
                    
                      // Get today\'s date and time
                      var now = new Date().getTime();
                        
                      // Find the distance between now and the count down date
                      var distance = countDownDate - now;
                        
                      // Time calculations for days, hours, minutes and seconds
                      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                      // Output the result in an element with id="demo"
                      document.getElementById("demo").innerHTML = \'<table cellpadding="8" style="margin: auto; text-align: center; width:auto; font-size: 12px;"><tr><td style="font-size: 24px;">\' + hours + \'<br><span style="font-size: 12px;">hour</span></td><td  style="font-size: 24px;">:</td><td style="font-size: 24px;">\' + minutes + \'<br><span style="font-size: 12px;">minute</span></td><td style="font-size: 24px;">:</td><td style="font-size: 24px;">\' + seconds + \'<br><span style="font-size: 12px;">second</span></td></tr></table>\';
                        
                      // If the count down is over, write some text 
                      if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "<h3>EXPIRED</h3>";
                      }
                    }, 1000);
                    </script>

                <p>(before '.$waktu[0].' '.$waktu[1].' WIB)</p>
            </div>
            <br>
            <div style="text-align: center; padding: 12px; border-radius: 8px; background: #ffa; font-size: 14px;">
                <p>please ensure that you do not give any proof of payment and/or payment details to any party apart from waterplus+</p>
            </div>
            <br>
            <div style="font-size: 14px;">
                <p style="line-height:24px;">total amount payable:<br>
                <span style="font-size:24px;">rp '.number_format($total1, 0, ',', '.').'.<span style="color:#007;"><u>'.$total2.'</u></span></span><br>
                <span>enter payment until exactly the last 3 digits</span>
                <input id="amount" type="hidden" value="'.$total.'" readonly><br>
                <span><a style="text-decoration: none; cursor:pointer;" onclick="textcopy(\'amount\')">click to copy the total amount</a></span></p>
            </div>
            <div style="font-size: 14px;">
                <p>transfer your payment to the following bank account:</p>
                <table style="width:auto; margin:0px 12px;">
                <tr>
                    <td><img style="max-width:80px;" src="'.base_url().'assets/img/bca.png"></td>
                    <td>&nbsp;&nbsp;<span>'.$rekening.'</span>
                    <input id="rekening" type="hidden" value="'.$rekening.'" readonly>
                    </td>
                </tr>
                </table>
                <p style="padding:0px 12px;">p.t. bisnis plus sosial</p>
                <p><a style="text-decoration: none; cursor:pointer;" onclick="textcopy(\'rekening\')">click to copy the bank account number</a></p>
            </div>
            <hr>
        </div>
        <table style="overflow:hidden; position:relative;" cellpadding="12">
				<tr>
					<td style="width: 50%; position:relative;"><p><b>ID order</b><br>'.$id_order.'</p></td>
					<td style="width: 50%; position:relative;"><p><b>due date of payment</b><br>'.$waktu[0].'</p></td>
				</tr>
				<tr>
					<td><p><b>payment method</b><br>bank transfer</p></td><td><p><b>payment status</b><br>not paid</p></td>
				</tr>
				<tr style="width:100%;">
					<td><div style="text-align:center;background: rgba(10,42,59,1); border-radius:8px; padding:12px;"><a style="color: #fff; text-decoration: none; line-height:24px;" href="'.base_url().'payment/confirm/'.$id_order.'">upload proof of payment</a></div></td>
					<td><div style="text-align:center;background: rgba(10,42,59,1); border-radius:8px; padding:12px;"><a style="color: #fff; text-decoration: none; line-height:24px;" href="'.base_url().'home/detail_transaksi/'.$id_order.'">check transaction status</a></div></td>
				</tr>
            </table>
        <div style="padding: 12px;">
            <span>please note the order ID in the bank transfer statement or upload proof of payment</span>
        </div>
        <hr>
        <div style="padding: 0px 12px;">
				<h2 style="margin: 0px; padding:0; font-size: 24px;">your order</h2>
			</div>
			<hr>
			<div style="padding: 0px 4px;">
				<table cellpadding="8" style="width:100%;">
				'.$table.'
					<tr>
					<td>discount</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($potongan, 0, ',', '.').'</td>
                    </tr>
                    <tr>
					<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($uniq, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>delivery ( '.$kurir.'/'.$layanan.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
					</tr>
			
				<tr>
					<td colspan="3"><hr style="margin:0px;"></td>
				</tr>
			
					<tr>
					<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($total, 0, ',', '.').'</td>
					</tr>
				</table>
				<br>
			</div>
    </div>
</div>';
?>
<div id="detail_pembayaran" class="modal" style="margin:auto; max-width:600px; border-radius:12px; background:#fff; padding:12px;">
<table cellpadding="8" style="width:100%;">
    <tr>
        <th>item</th><th colspan="2">price</th>
    </tr>
<?php
echo $table;
?>
<tr>
    <td colspan="3"></td>
</tr>
    <?php
    echo '<tr>';
    echo '<td>discount</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($potongan, 0, ',', '.').'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($uniq, 0, ',', '.').'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>delivery</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>';
    echo '</tr>';
    ?>
<tr>
    <td colspan="3"><hr style="margin:0px;"></td>
</tr>
<?php
    echo '<tr>';
    echo '<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($total, 0, ',', '.').'</td>';
    echo '</tr>';
    ?>
</table>
</div>
<?php
/*
		</body>
		</html>';
*/
?>