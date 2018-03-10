<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$title.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table class="table table-condensed table-bordered table-hover" id="example1">
    <thead>
    <tr>
        <th>No</th>
        <th>Nomor Part</th>
        <th>Nama Part</th>
        <th>Qty</th>
        <th>HET</th>
        <th>Disc1</th>
        <th>Disc1</th>
        <th>Netto</th>
    </tr>
    </thead>
    <tdbody>
        <?php $no=1;foreach($items as $item) {?>

            <tr>
                <td align="center"><?= $no ?></td>
                <td align="center"><?= $item->nomor_part ?></td>
                <td align="center"><?= $item->nama_part ?></strong></td>
                <td align="center"><span class="text-mutted"><?= $item->qty?></td>
                <td align="right"><span style="float:left"><?= $item->harga_jual ?></td>
                <td align="center"><?= $item->disc1 ?></td>
                <td align="center"><?= $item->disc2 ?></td>
                <td align="right"><span style="float:left"><?= $item->harga_beli ?></td>
            </tr>
            <?php $no++;}?>
    </tdbody>
</table>