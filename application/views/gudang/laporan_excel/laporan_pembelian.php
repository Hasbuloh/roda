<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>
 
<table class="table table-condensed table-hover table-bordered">
<thead>
    <tr>
        <th>No</th>
        <th>No.Faktur</th>
        <th>Tgl.Masuk</th>
        <th>Tgl.Faktur</th>
        <th>Tgl.Jatuh Tempo</th>
        <th>Supplier</th>
        <th>Jumlah</th>
    </tr>
</thead>
<tbody>
    <?php $total=array();$no=1;foreach($items as $item){?>
        <tr <?= $item->status_bayar == "0"?'style="background:#ef000021;"':'';?>>
			<td align="center"><?= $no ?></td>
			<td><?= $item->nomor_faktur ?></td>
			<td align="center"><?= $item->tanggal_masuk ?></td>
			<td align="center"><?= $item->tanggal_faktur ?></td>
			<td align="center"><?= $item->tanggal_jt ?></td>
			<td><strong><?= $item->supplier == 1 ? 'Daya Adi Cipta':'Non-Daya';?></strong></td>
			<td style="text-align: right;"><strong><?= toRP($total[]=$item->jumlah) ?></strong></td>
        </tr>
    <?php $no++; }?>
		<tr>
			<td colspan="6" align="center"><strong>Total</strong></td>
			<td style="text-align: right;"><strong><?= toRP(array_sum($total)) ?></strong></td>
		</tr>
</tbody>
</table>
