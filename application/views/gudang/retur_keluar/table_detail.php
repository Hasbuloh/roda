<table class="table table-condensed table-bordered table-hover table-responsive" id="example1">
<thead>
  <tr>
    <th></th>
    <th style="text-align:center;">No</th>
    <th style="text-align: center;">Nomor</th>
    <th style="text-align: center;">Nama</th>
    <th>QTY</th>
    <th>Disc1</th>
    <th>Disc2</th>
    <th>HET</th>
    <th>Subtotal</th>
    <th>Keterangan</th>
  </tr>
</thead>
<tbody>
  <?php $totalqty=array();$totalnetto=array();$totalharga=array();$no=1;foreach ($items as $item): ?>
    <tr>
      <td align="center"><span class="text text-danger"><i class="fa fa-trash fa-fw"></i></span></td>
      <td align="center"><?= $no ?></td>
      <td><?= $item->nomor_part?></td>
      <td><?= $item->nama_part?></td>
      <td align="center"><?= $totalqty[]=$item->qty ?></td>
      <td align="center">
      <?= $item->disc1 ?>
      </td>
      <td align="center">
      <?= $item->disc2 ?>
      </td>
      <td align="right">
      <?= $item->harga_jual ?>
      </td>
      <td align="right">
      <?= $totalharga[] = $item->qty * $item->harga_jual?>
      </td>
      <td align="left" width="20%"><?= $item->keterangan?></td>
    </tr>
  <?php $no++;endforeach; ?>
    <tr>
      <td colspan="4" align="center"><strong>Total</strong></td>
      <td align="center"><strong><?= array_sum($totalqty)?></strong></td>
      <td colspan="3"></td>
      <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalharga))?></strong></td>
      <td></td>
    </tr>
</tbody>
</table>
