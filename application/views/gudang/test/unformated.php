<?php

header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nomor</th>
        <th>Nama</th>
        <th>QTY</th>
        <th>Jenis</th>
        <th>Harga</th>
    </tr>
    </thead>
    <tbody>
    <?php $no=1;foreach($items as $item):?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $item['nomor_part'] ?></td>
            <td><?= $item['nama_part'] ?></td>
            <td><?= $item['qty'] ?></td>
            <td><?= $item['jenis'] ?></td>
            <td>
               <?php
                $data = explode('.',$item['harga']);
                if (count($data) > 1) {
                    echo $data[0].$data[1].'00';
                }else{
                    echo $item['harga'].'000';
                }
               ?>
            </td>
        </tr>
        <?php $no++;endforeach;?>
    </tbody>
</table>