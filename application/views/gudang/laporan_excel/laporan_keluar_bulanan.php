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
         <th>Tanggal</th>
         <th>Qty</th>
         <th>Netto</th>
         <th>Jumlah</th>
         <th>HET</th>
         <th>No.Rak</th>
         <th>Jumlah</th>
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
         <td align="right"><strong><?= toRP($item->harga_beli) ?></strong></td>
         <td align="right"><strong><?= toRP($totalnet[]=$item->harga_beli*$item->jumlah_keluar) ?></strong></td>
         <td align="right"><strong><?= toRP($item->harga) ?></strong></td>
         <td align="center"><strong><?= $item->no_rak ?></strong></td>
         <td align="right"><strong><?= toRP($total[]=$item->jumlah_harga) ?></strong></td>
     </tr>
 <?php $no++;endforeach;?>
     <tr>
         <td colspan="4" align="center"><strong>Total</strong></td>
         <td align="center"><strong><?= array_sum($totalqty); ?></strong></td>
         <td></td>
         <td align="right"><strong><?= toRP(array_sum($totalnet)); ?></strong></td>
         <td></td>
         <td></td>
         <td align="right"><strong><?= toRP(array_sum($total)); ?></strong></td>
     </tr>
 </tbody>
 </table>
