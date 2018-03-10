<table class="table table-condensed table-bordered" id="example1">
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
        <th>Jumlah</th>
    </tr>
</thead>
<tbody>
  <?php $totalqty=array();$totalnetto=array();$totalhet=array(); $no=1;foreach($items as $item):?>
  <tr>
      <td align="center"><?= $no ?></td>
      <td><?= $item->nomor_part ?></td>
      <td><?= $item->nama_part ?></td>
      <td align="center"><?= $item->tanggal_masuk?></td>
      <td align="center"><span class="badge"><?= $totalqty[] = $item->jumlah_masuk ?></span></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_beli)?></strong></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($totalnetto[]=$item->harga_beli * $item->jumlah_masuk)?></strong></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_jual)?></strong></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($totalhet[] = $item->harga_jual * $item->jumlah_masuk)?></strong></td>
  </tr>
  <?php $no++;endforeach;?>
  <tr>
      <td colspan="4" align="center"><strong>Total </strong></td>
      <td align="center"><strong><?= array_sum($totalqty)?></strong></td>
      <td></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalnetto))?></strong></td>
      <td></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalhet))?></strong></td></td>
  </tr>
</tbody>
</table>
