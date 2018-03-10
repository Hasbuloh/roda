<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>
<html>
    <head>
        <title>Title</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Part</th>
                    <th>Nama Part</th>
                    <th>Qty</th>
                    <th>Jenis Part</th>
                    <th>Het</th>
                    <th>Netto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $item): ?>
                    <tr>
                        <td><?= $item['No']?></td>
                        <td><?= $item['Nomor Part']?></td>
                        <td><?= $item['Nama Part']?></td>
                        <td><?= $item['Qty']?></td>
                        <td><?= $item['Jenis Part']?></td>
                        <td><?= $item['Het']?></td>
                        <td><?= $item['Netto']?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </body>
</html>