<?php

 header("Content-type: application/vnd-ms-excel");

 header("Content-Disposition: attachment; filename=$title.xls");

 header("Pragma: no-cache");

 header("Expires: 0");

 ?>
 <p>Laporan Tagihan</p>
 <table border="1" width="100%">

      <thead>
           <tr>
                <th>No</th>
                <th>No.Invoice</th>
                <th>No.Faktur</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Faktur</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Supplier</th>
                <th>Jumlah</th>
           </tr>
      </thead>

      <tbody>

           <?php $i=1; foreach($items as $item) { ?>

           <tr>
                <td><?= $i ?></td>
                <td><?php echo $item->nomor_invoice; ?></td>
                <td><?php echo $item->nomor_faktur; ?></td>
                <td><?php echo $item->tanggal_masuk; ?></td>
                <td><?php echo $item->tanggal_faktur; ?></td>
                <td><?php echo $item->tanggal_jt; ?></td>
                <td><?= $item->supplier == '1' ? 'Daya Adi Cipta':'Non-Daya'; ?></td>
                <td><?php echo $item->jumlah; ?></td>

           </tr>

           <?php $i++; } ?>

      </tbody>

 </table>
