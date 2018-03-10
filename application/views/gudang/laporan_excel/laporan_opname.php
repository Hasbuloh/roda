<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>
<table>
<thead style="background: gray;">
  <tr>
    <th style="text-align:center;">No</th>
    <th style="text-align:center;">No.Part</th>
    <th style="text-align:center;">Nama Part</th>
    <th>status</th>
    <th style="text-align:center;">Teori</th>
    <th style="text-align:center;">Fisik</th>
    <th>Keluar</th>
    <th>Masuk</th>
    <th>Retur Masuk</th>
    <th>Retur Keluar</th>
    <th style="text-align:center;">Rak</th>
    <th style="text-align:center;">Tanggal</th>
  </tr>
</thead>
<tbody>
<?php $no=1;foreach ($items as $item): ?>
  <tr>
    <td align="center"><?= $no?></td>
    <td><?= $item->nomor_part?></td>
    <td><?= $item->nama_part ?></td>
    <?php  if($item->fisik != $item->teori) {
      ?>
        <td style="background: #f9c7c7;">Selisih</td>
      <?php
    }else{
      ?>
        <td>Balance</td>
      <?php
    }?>
    <td align="center"><?= $item->teori?></td>
    <td align="center"><?= $item->fisik?></td>
    <td><?= $item->keluar ?></td>
    <td><?= $item->masuk ?></td>
    <td><?= $item->retur_masuk ?></td>
    <td><?= $item->retur_keluar ?></td>
    <td align="center"><span class="label label-info"><strong><?= $item->no_rak ?></strong></span></td>
    <td align="center"><?= $item->tanggal?></td>
  </tr>
<?php $no++;endforeach; ?>
</tbody>
</table>