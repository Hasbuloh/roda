<div class="panel panel-default">
  <div class="panel-body">
    <h3>Detail Retur Barang <small><?= $this->input->get('id')?></small></h3>
    <hr>
    <table class="table table-condensed table-bordered table-hover table-responsive" id="example1">
    <thead>
      <tr>
        <th>No</th>
        <th colspan="2">Deskripsi Item</th>
        <th>No.Faktur</th>
        <th>Qty</th>
        <th>HET</th>
        <th>Disc1</th>
        <th>Disc2</th>
        <th>Netto</th>
        <th>Subtotal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $total=array();$total1=array();$total2=array();$no=1;foreach ($items as $key => $item): ?>
        <tr>
          <td align="center"><?= $no ?></td>
          <td><?= $item->nomor_part?></td>
          <td><?= $item->nama_part?></td>
          <td align="center" class="text-danger"><strong><?= $item->nomor_faktur?></strong></td>
          <td align="center"><?= $total[]=$item->qty ?></td>
          <td align="right"><?= toRP($item->harga_jual) ?></td>
          <td align="center"><?= $item->disc1 ?></td>
          <td align="center"><?= $item->disc2 ?></td>
          <td align="right"><?php
            echo toRP($total1[]= $item->harga_beli);
          ?></td>
          <td align="right"><?php
            $disc1 = $item->harga - $item->harga*$item->disc1/100;
            $disc2 = $disc1 -  $disc1*$item->disc2/100;
            echo toRP($total2[]= $disc2*$item->qty);
          ?></td>
          <td align="center"><a href="javascript:void(0)" onclick="hapusDetail(<?= $item->id ?>)"><i class="fa fa-trash fa-fw"></i></a></td>
        </tr>
      <?php $no++;endforeach; ?>
      <tr>
        <td colspan="4" align="center"><strong>Total</strong></td>
        <td align="center"><strong><?= array_sum($total)?></strong></td>
        <td colspan="3"></td>
        <td align="right"><strong><?= toRP(array_sum($total1))?></strong></td>
        <td align="right"><strong>Rp. <?= toRP(array_sum($total2))?></strong></td>
        <td></td>
      </tr>
    </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <a href="<?= base_url('kepala/Retur_Masuk/cetakBerita?id=').$this->input->get('id') ?>" target="_blank" onclick="Simpan('<?= $this->input->get('id') ?>')" class="btn btn-primary btn-sm"><i class="fa fa-print fa-fw"></i> Cetak</a> | <span class="text-muted">Cetak Berita Acara</span>
  </div>
</div>

<script type="text/javascript">
$('#nomor_part').keypress(function(e) {
  if (e.which == 13) {
    // alert($(this).val());
    $('#nomor_faktur').focus();
    cariFaktur();
  }
})

function hapusDetail(id) {
  $.ajax({
    url: '<?= base_url('kepala/Retur_Masuk/hapusDetail')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': id},
    success: function(data) {
      if(data.status) {
        reload();
      }
    }
  })
}

function Simpan(id) {
    $.ajax({
        url: '<?= base_url('kepala/Retur_Masuk/update_status')?>',
        dataType: 'JSON',
        type: 'POST',
        data: {'id': id},
        success: function(data) {
            if (data.status) {
                window.location = '<?= base_url('kepala/Retur_Masuk')?>';
            }else{
                alert("Coba Lagi, Ada Kesalahan Jaringan");
            }
        }
    })
}
</script>
