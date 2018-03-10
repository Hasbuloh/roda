<h4>Detail Barang Keluar <small><?= $this->input->get('id')?></small></h4>
<div class="well well-sm">
    <?php $data = $this->db->query("SELECT *,DATE_FORMAT(tanggal, '%d %M %Y') AS 'tanggal_keluar' FROM tbl_headerkeluar WHERE nomor_keluar = '{$this->input->get('id')}'")->row()?>
    <span class="label label-warning"><?= $data->jenis == 1 ?'NSC':'NJB'?></span> Tanggal <strong><?= $data->tanggal_keluar ?></strong><br>
    Nomor SA <strong><?= $data->nomor_sa ?></strong><br>
    Nama <strong><?= $data->nama ?></strong>, Nomor Polisi <strong><?= $data->nomor_polisi ?></strong><br>
</div>
<hr>
<table class="table table-condensed table-bordered table-hover" id="example1">
<thead>
  <tr>
    <th>No</th>
    <th colspan="2">Deskripsi Item</th>
    <th width="7%">Qty</th>
    <th>HET</th>
    <th colspan="2">Disc</th>
    <th>Netto</th>
    <th>Subtotal</th>
    <th>Batal</th>
      <th>Hapus</th>
  </tr>
</thead>
<tbody>
  <?php error_reporting(0);$no=1;$i=0;$qty=array();$subtotal=array();$total= array();foreach ($items as $key => $item): ?>
    <tr>
      <td align="center"><?= $no ?></td>
      <td><?= $item->nama_part ?></td>
      <td><?= $item->nomor_part ?></td>
      <td align="center"><span class="badge"><?= $qty[] = $item->qty ?></span></td>
      <td align="right"><?= toRp($item->harga) ?></td>
      <td align="center"><?= $item->disc1?></td>
      <td align="center"><?= $item->disc2?></td>
      <td align="right">
        <!-- <?= toRP($item->harga)?> -->
        <?php
          $disc1 = $item->harga * $item->disc1 / 100;
          $disc2 = $disc1 + ($disc1 * $item->disc2 / 100);
          echo toRP($item->harga - $disc2);
        ?>
      </td>
      <td align="right">
      <span style="float:left;">Rp. </span>
        <?= toRP($subtotal[]=$item->harga * $item->qty)?>
      </td>
      <td align="center">
        <?php if ($item->jenis_keluar == 2): ?>
        <?php if($item->qty > 1): ?>
          <a href="javascript:void(0)" onclick="modalBatal('<?= $item->nomor_keluar ?>',<?= $item->qty?>,<?= $item->id ?>,<?= $item->id_barang ?>)"><i class="fa fa-exclamation-circle fa-fw"></i> Batal</a>
        <?php else: ?>
          <a href="javascript:void(0)" onclick="hapus(<?= $item->id ?>)"><i class="fa fa-exclamation-circle fa-fw"></i> Batal</a>
        <?php endif; ?>
        <?php else: ?>
          <a href="javascript:void(0)" onclick="modalRetur('<?= $item->nomor_part ?>','<?= $item->nama_part?>',<?= $item->qty ?>,<?= $item->harga_jual?>,'<?= $item->disc1 ?>','<?= $item->disc2 ?>',<?= $item->id_barang ?>)"><i class="fa fa-exchange fa-fw"></i></a>
        <?php endif; ?>
      </td>
        <td align="center">
            <span class="text text-danger"><a href="javascript:void(0)" onclick="HapusItem(<?= $item->id ?>)"><i class="fa fa-trash fa-fw"></i></a></span>
        </td>
    </tr>
  <?php $i++;$no++;endforeach; ?>
  <tr>
    <td colspan="3" align="center"><strong>Total</strong></td>
    <td align="center"><strong><?= array_sum($qty)?></strong></td>
    <td colspan="4"></td>
    <td align="right"><strong><span style="float:left;">Rp. </span><?= toRP(array_sum($subtotal))?></strong></td>
    <td colspan="2"></td>
  </tr>
</tbody>
</table>


<script type="text/javascript">


function hapus(id) {
  $.ajax({
    url: '<?= base_url('gudang/Keluar_Barang/hapus_detail')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': id},
    success: function(data) {
      if (data.status) {
        reload();
      }
    }
  })
}



function updateQTY(id) {
  var qty = $('[name="qty'+id+'"]').val();
  $.ajax({
    url: '<?= base_url('gudang/Keluar_Barang/update_detail')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': id, 'qty': qty},
    success: function(data) {
      if (data.status) {
        reload();
      }
    }
  })
}


function HapusItem(id) {
    var notif = confirm('Apakah anda yakin?');
    if (notif) {
        $.ajax({
            url: '<?= base_url('gudang/Keluar_Barang/hapus_detail')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(response) {
                if (response.status) {
                    reload();
                }else{
                    alert('Gagal Menghapus');
                }
            }
        })
    }
}

function Simpan(id) {
    $.ajax({
        url: '<?= base_url('gudang/Keluar_Barang/update_status')?>',
        dataType: 'JSON',
        type: 'POST',
        data: {'id': id},
        success: function(data) {
            if (data.status) {
                redirect();
            }else{
                alert('Coba Lagi');
            }
        }
    })
}

function redirect() {
    window.location = '<?= base_url('gudang/Keluar_Barang')?>';
}

</script>
