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
        <th>Detail</th>
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
			<td style="text-align: right;"><span style="float:left;">Rp. </span><strong><?= toRP($total[]=$item->jumlah) ?></strong></td>
            <td align="center"><a href="<?= base_url('gudang/Laporan_Pembelian/detail_pembelian?id=').$item->nomor_invoice ?>"><i class="fa fa-search fa-fw"></i></a></td>
        </tr>
    <?php $no++; }?>
		<tr>
			<td colspan="6" align="center"><strong>Total</strong></td>
			<td style="text-align: right;"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($total)) ?></strong></td>
            <td></td>
		</tr>
</tbody>
</table>
