<table class="table table-condensed table-bordered table-hover" id="example1">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th colspan="2">Deskripsi Item</th>
      <th>Stok Awal</th>
      <th>Keluar</th>
      <th>Masuk</th>
      <th>Stok Akhir</th>
        <th>HET</th>
        <th>Netto</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1;foreach ($items as $item): ?>
        <?php $query1 = $this->db->query("SELECT SUM(qty) AS 'keluar' FROM tbl_keluar WHERE id_barang = '{$item->id_barang}' AND DATE_FORMAT(tanggal_keluar,'%d %M %Y') LIKE '{$item->tanggal}'")->row();?>
        <?php $query2 = $this->db->query("SELECT SUM(qty) AS 'masuk' FROM tbl_pembelian WHERE id_barang = '{$item->id_barang}' AND DATE_FORMAT(tanggal_masuk,'%d %M %Y') LIKE '{$item->tanggal}'")->row();?>
    <tr>
        <td align="center"><?= $no ?></td>
        <td align="center"><?= $item->tanggal ?></td>
        <td align="center"><?= $item->nomor_part ?></td>
        <td align="center"><?= $item->nama_part ?></td>
        <td align="center">
                <?= (int) $item->stok_akhir + $query1->keluar - $query2->masuk ?>
        </td>
        <td align="center">
              <?= $query1->keluar==""?'0': $query1->keluar?>
        </td>
        <td align="center">
                <?= $query2->masuk==""?'0': $query2->masuk?>
        </td>
        <td align="center">
          <strong><?= $item->stok_akhir?>
        </td>
          <td align="right">
            <?= toRP($item->stok_akhir * $item->harga_jual) ?>
          </td>
          <td align="right">
              <?= toRP($item->stok_akhir * $item->harga_beli) ?>
          </td>
      </tr>
    <?php $no++;endforeach; ?>
  </tbody>
</table>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#example1').DataTable();
  })
</script>
