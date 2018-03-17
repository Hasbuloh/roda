<table class="table table-condensed table-bordered table-hover table-responsive" id="example1">
<thead>
  <tr>
    <th style="text-align:center;">No</th>
    <th style="text-align: center;">Nomor</th>
    <th style="text-align: center;">Nama</th>
    <th>QTY</th>
    <th>Disc1</th>
    <th>Disc2</th>
    <th>HET</th>
    <th>Subtotal</th>
  </tr>
</thead>
<tbody>
  <?php print_r($items) ?> -->
  <?php $totalqty=array();$totalnetto=array();$totalharga=array();$no=1;foreach ($items as $item): ?>
    <tr>
      <td align="center"><?= $no ?></td>
      <td><?= $item->nomor_part?></td>
      <td><?= $item->nama_part?></td>
      <td align="center"><span class="badge"><?= $totalqty[]=$item->qty ?></span></td>
      <td align="center">
      <?= $item->disc1 ?>
      </td>
      <td align="right">
      </td>
      <td align="right">
      </td>
    </tr>
  <?php $no++;endforeach; ?>
    <tr>
      <td colspan="3" align="center"><strong>Total</strong></td>
      <td align="center"><strong><?= array_sum($totalqty)?></strong></td>
      <td colspan="1"></td>
      <td></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalharga))?></strong></td>
    </tr>
</tbody>
</table>