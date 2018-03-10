<table class="table table-condensed table-bordered" id="example1">
    <thead>
      <tr>
        <th>No</th>
        <th>No.Retur</th>
        <th>No.Keluar</th>
        <th>Tanggal</th>
        <th>Item</th>
        <th>Jumlah</th>
        <th>Cetak</th>
        <th>Lihat</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1;foreach ($items as $item): ?>
        <tr>
          <td align="center"><?= $no?></td>
          <td align="center"><strong><?= $item->nomor_retur ?></strong></td>
          <td align="center"><?= $item->nomor_keluar ?></td>
          <td align="center"><?= $item->tanggal?></td>
          <td align="center">
            <?php $query = $this->db->query("SELECT SUM(qty) AS 'jumlah_item',SUM(qty*harga_jual) AS 'total_harga' FROM tbl_returkeluar WHERE nomor_retur = '{$item->nomor_retur}'")->row();
                  echo $query->jumlah_item;
            ?>
          </td>
          <td align="right"><span style="float:left">Rp. </span><strong><?= toRP($query->total_harga)?></strong></td>
          <td align="center"><a href="<?= base_url('kepala/Retur_Keluar/cetakBerita?id=').$item->nomor_retur ?>" target="_blank" class="btn btn-link btn-xs"><i class="fa fa-print fa-fw"></i></a></td>
          <td align="center"><a href="<?= base_url('kepala/Retur_Keluar/indexDetail?id=').$item->nomor_retur ?>"><i class="fa fa-search fa-fw"></i></a></td>
        </tr>
      <?php $no++;endforeach; ?>
    </tbody>
</table>
</div>


<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#example1').DataTable();
})
</script>
