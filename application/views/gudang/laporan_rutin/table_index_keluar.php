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
<?php $totalnet=array();$totalqty=array();$total=array();$no=1;foreach($items as $item):?>
    <tr>
        <td align="center"><?= $no?></td>
        <td><?= $item->nomor_part?></td>
        <td><?= $item->nama_part?></td>
        <td align="center"><?= $item->tanggal_keluar ?></td>
        <td align="center"><?= $totalqty[]=$item->jumlah_keluar?></td>
        <td align="right"><?= toRP($item->netto) ?></td>
        <td align="right"><?= toRP($totalnet[]=$item->netto*$item->jumlah_keluar) ?></td>
        <td align="right"><?= toRP($item->harga) ?></strong></td>
        <td align="right"><?= toRP($total[]=$item->harga_jual*$item->jumlah_keluar) ?></td>
    </tr>
<?php $no++;endforeach;?>
</tbody>
</table>
<div class="well well-sm">
Total QTY : <?= array_sum($totalqty); ?> <br>
Total Net : <strong>Rp. <?= toRP(array_sum($totalnet)); ?></strong> <br>
Total  : <strong>Rp. <?= toRP(array_sum($total)); ?></strong>
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
