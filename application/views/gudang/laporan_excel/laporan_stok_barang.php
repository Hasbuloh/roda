<?php

header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<table class="table table-condensed table-bordered">
    <thead>
    <tr>
        <th>No</th>
        <th>No.Part</th>
        <th>Nama Part</th>
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
    <?php $net=array();$totalnet=array();$totalqty=array();$total=array();$no=1;foreach($items as $item):?>
        <tr>
            <td align="center"><?= $no?></td>
            <td><?= $item->nomor_part?></td>
            <td><?= $item->nama_part?></td>
            <td align="center"><span class="badge"><?= $totalqty[]=$item->qty?></span></td>
            <td align="right"><strong><?= toRP($total[]=$item->harga_jual) ?></strong></td>
            <td align="center"><?= $item->disc1 ?></td>
            <td align="center"><?= $item->disc2 ?></td>
            <td align="center">
                <span class="label label-info"><?= $item->no_rak ?></span>
            </td>
            <td align="right"><strong><?= toRP($net[]=$item->harga_beli) ?></strong></td>
            <td align="right"><strong><?= toRP($totalnet[]=$item->harga_jual*$item->qty) ?></strong></td>
            <td align="center"><a href="<?= base_url('gudang/Laporan_Analisis/detail_keluar?id='.$item->id)?>" id="nomor"><i class="fa fa-search fa-fw"></i></a></td>
        </tr>
        <?php $no++;endforeach;?>
    <tr>
        <td colspan="3" align="center"><strong>Total</strong></td>
        <td align="center"><strong><?= array_sum($totalqty); ?></strong></td>
        <td align="right"><?= toRP(array_sum($total))?></td>
        <td colspan="3"></td>
        <td align="right"><?= toRP(array_sum($net))?></td>
        <td align="right"><strong><?= toRP(array_sum($totalnet)); ?></strong></td>
        <td></td>
    </tr>
    </tbody>
</table>
