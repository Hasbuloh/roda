<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>
<table class="table table-condensed table-bordered table-hover">
    <thead>
    <tr>
        <th>No</th>
        <th>Nomor Part</th>
        <th>Nama Part</th>
        <th>Jenis Part</th>
        <th>Qty</th>
        <th>Awal</th>
        <th>Masuk</th>
        <th>Retur Masuk</th>
        <th>Keluar</th>
        <th>Retur Keluar</th>
        <th>Akhir</th>
        <th>Het</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
        <?php $no=1;$qty=array();$awal=array();$akhir=array();$masuk=array();$keluar=array();$rm=array();$rk=array();$het=array();$total=array();foreach($items as $item):?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $item->nomor_part?></td>
                <td><?= $item->nama_part ?></td>
                <td align="center"><?php
                        switch ($item->jenis_part) {
                            case "O":
                                echo "Oli";
                                break;
                            case "S":
                                echo "Sparepart";
                                break;
                            case "A":
                                echo "Apparel";
                                break;
                        }

                    ?>
                </td>
                <td align="center"><?= $qty[]=$item->qty ?></td>
                <td align="center"><?= $awal[]=$item->STOK_AWAL ?></td>
                <td align="center"><?= $masuk[]=$item->QTY_IN ?></td>
                <td align="center"><?= $rm[]=$item->QTY_RM ?></td>
                <td align="center"><?= $keluar[]=$item->QTY_OUT ?></td>
                <td align="center"><?= $rk[]=$item->QTY_RK ?></td>
                <td align="center"><?= $akhir[]=$item->STOK_AKHIR ?></td>
                <td align="right"><?= toRP($het[]=$item->harga_jual) ?></td>
                <td align="right"><?= toRP($total[]=$item->TOTAL) ?></td>
            </tr>
        <?php $no++;endforeach;?>
            <tr>
                <td align="center" colspan="4"><strong>Total</strong></td>
                <td align="center"><strong><?= array_sum($qty)?></strong></td>
                <td align="center"><strong><?= array_sum($awal)?></strong></td>
                <td align="center"><strong><?= array_sum($masuk)?></strong></td>
                <td align="center"><strong><?= array_sum($rm)?></strong></td>
                <td align="center"><strong><?= array_sum($keluar)?></strong></td>
                <td align="center"><strong><?= array_sum($rk)?></strong></td>
                <td align="center"><strong><?= array_sum($akhir)?></strong></td>
                <td align="right"><strong><?= toRP(array_sum($het))?></strong></td>
                <td align="right"><strong><?= toRP(array_sum($total))?></strong></td>
            </tr>
    </tbody>
</table>
