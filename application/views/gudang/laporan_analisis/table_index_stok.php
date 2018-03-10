<table class="table table-condensed table-bordered table-hover" id="example1">
    <thead>
    <tr>
        <th>No</th>
        <th>No.Part</th>
        <th>Nama Part</th>
        <th>Qty</th>
        <th>Het</th>
        <th>Disc1</th>
        <th>Disc2</th>
        <th>No.Rak</th>
        <th>Netto</th>
        <th>Jumlah</th>
        <th>Detail</th>
    </tr>
    </thead>
    <tbody>
    <?php $totalnet=array();$totalqty=array();$total=array();$no=1;foreach($items as $item):?>
        <tr>
            <td align="center"><?= $no?></td>
            <td><?= $item->nomor_part?></td>
            <td><?= $item->nama_part?></td>
            <td align="center"><span class="badge"><?= $totalqty[]=$item->qty?></span></td>
            <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_jual) ?></strong></td>
            <td align="center"><?= $item->disc1 ?></td>
            <td align="center"><?= $item->disc2 ?></td>
            <td align="center">
                <span class="label label-info"><?= $item->no_rak ?></span>
            </td>
            <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($item->harga_beli) ?></strong></td>
            <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($totalnet[]=$item->harga_jual*$item->qty) ?></strong></td>
            <td align="center"><a href="<?= base_url('keuangan/Laporan_Analisis/detail_keluar?id='.$item->id)?>" id="nomor"><i class="fa fa-search fa-fw"></i></a></td>
        </tr>
        <?php $no++;endforeach;?>
    </tbody>
</table>

<div class="well well-sm">
  Total QTY : <?= array_sum($totalqty); ?>
  Total Netto : <strong>Rp. <?= toRP(array_sum($totalnet)); ?></strong>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#example1').DataTable();
  })
</script>
