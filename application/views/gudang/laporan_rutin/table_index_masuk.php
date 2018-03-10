<table class="table table-condensed table-bordered table-hover" id="example1">
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
      <td align="center"><?= $totalqty[] = $item->jumlah_masuk ?></td>
      <td align="right"><?= toRP($item->harga_beli)?></td>
      <td align="right"><?= toRP($totalnetto[]=$item->harga_beli * $item->jumlah_masuk)?></td>
      <td align="right"><?= toRP($item->harga_jual)?></td>
      <td align="right"><?= toRP($totalhet[] = $item->harga_jual * $item->jumlah_masuk)?></td>
  </tr>
  <?php $no++;endforeach;?>
</tbody>
</table>
<div class="well well-sm">
  Total QTY : <?= array_sum($totalqty)?> <br>
  Total Netto : <strong>Rp. <?= toRP(array_sum($totalnetto))?></strong><br>
  Total HET : <strong>Rp. <?= toRP(array_sum($totalhet))?></strong>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example1').DataTable();
  })
</script>
