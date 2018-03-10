<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>

 <table class="table table-condensed table-bordered" id="example1">
 <thead>
     <tr>
         <th>No</th>
         <th>No.Part</th>
         <th>Nama Part</th>
         <th>Jenis Part</th>
         <th>Qty</th>
         <th>Netto</th>
         <th>HET</th>
         <th>DISC 1</th>
         <th>DISC 1</th>
         <th>Rak</th>
     </tr>
 </thead>
 <tbody>
   <?php $totalqty=array();$totalnetto=array();$totalhet=array(); $no=1;foreach($items as $item):?>
   <tr>
       <td align="center"><?= $no ?></td>
       <td><?= $item->nomor_part ?></td>
       <td><?= $item->nama_part ?></td>
       <td align="center"><?= $item->jenis_part?></td>
       <td align="center"><span class="badge"><?= $totalqty[] = $item->qty ?></span></td>
       <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_beli)?></strong></td>
       <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_jual)?></strong></td>
       <td align="right"><span style="float:left;"><?= $item->disc1 ?></strong></td>
       <td align="right"><span style="float:left;"><?= $item->disc2 ?></strong></td>
       <td align="right"><span style="float:left;"><?= $item->no_rak?></td>
   </tr>
   <?php $no++;endforeach;?>
 </tbody>
 </table>
