<table class="table table-condensed table-bordered">
<thead>
    <tr>
        <th>No</th>
        <th>No.Part</th>
        <th>Nama Part</th>
        <th>Tanggal</th>
        <th>Qty</th>
        <th>Het</th>
        <th>Disc1</th>
        <th>Disc2</th>
        <th>No.Rak</th>
        <th>Netto</th>
        <th>Jumlah</th>
        <th>Detail</th>
    </tr>
</thead>
<tbody>
<?php $totalnet=array();$totalqty=array();$total=array();$no=1;foreach($items as $item):?>
    <tr>
        <td align="center"><?= $no?></td>
        <td><?= $item->nomor_part?></td>
        <td><?= $item->nama_part?></td>
        <td align="center"><?= $item->tanggal_keluar ?></td>
        <td align="center"><span class="badge"><?= $totalqty[]=$item->jumlah_keluar?></span></td>
        <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga) ?></strong></td>
        <td align="center"><?= $item->disc1 ?></td>
        <td align="center"><?= $item->disc2 ?></td>
        <td align="center">
            <span class="label label-info"><?= $item->no_rak ?></span>
        </td>
        <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_beli) ?></strong></td>
        <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($totalnet[]=$item->harga_jual*$item->jumlah_keluar) ?></strong></td>
        <td align="center"><a href="<?= base_url('keuangan/Laporan_Analisis/detail_keluar?id='.$item->id_barang."&date=".$item->tanggal_keluar_unformated)?>" target="_blank" id="nomor"><i class="fa fa-search fa-fw"></i></a></td>
    </tr>
<?php $no++;endforeach;?>
    <tr>
        <td colspan="4" align="center"><strong>Total</strong></td>
        <td align="center"><strong><?= array_sum($totalqty); ?></strong></td>
        <td colspan="5"></td>
        <td align="right"><strong><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalnet)); ?></strong></td>
        <td></td>
    </tr>
</tbody>
</table>
