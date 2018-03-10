<h4>Detail Barang Masuk <small><?= $this->input->get('id')?></small></h4>

    <div class="well well-sm">
     Nomor Faktur <strong><?= $header->nomor_faktur ?></strong> <br>
     Tanggal <strong class="text text-info"><?= $header->tanggal_faktur ?></strong> , Jatuh Tempo <strong class="text text-info"><?= $header->tanggal_jt ?></strong> , Tanggal Masuk <strong><?= $header->tanggal_masuk ?></strong><br> Supplier <strong><?= $header->supplier == 1?'Daya Adi Cipta':'Non-Daya'; ?></strong>
    </div>

    <hr>
      <table class="table table-bordered table-responsive table-condensed table-hover" id="example1" width="100%">
        <thead>
          <tr>
            <th style="text-align:center">No</th>
            <th style="text-align:center">Nomor Part</th>
            <th style="text-align:center">Nama Part</th>
            <th style="text-align:center">HET</th>
            <th style="text-align:center">Qty</th>
            <th style="text-align:center">Disc1</th>
            <th style="text-align:center">Disc2</th>
            <th>Netto</th>
            <th style="text-align:center">Subtotal</th>
            <th>Hapus</th>
          </tr>
        </thead>
        <tbody>
          <?php error_reporting(0);$total=array();$no=1;foreach ($items as $key => $item): ?>
            <tr>
              <td align="center"><?= $no ?></td>
              <td>
                <?= $item->nomor_part ?>
              </td>
              <td><?= $item->nama_part ?></td>
              <td align="right">
                <?= toRP($item->harga_jual) ?>
              </td>
              <td align="center"><?= $item->qty ?></td>
              <td align="center"><?= $item->disc1 ?></td>
              <td align="center"><?= $item->disc2 ?></td>
              <td align="right">
                <?= toRP($item->harga_beli) ?>
              </td>
              </td>
              <td align="right">
                <span style="float:left;">Rp. </span><?php if(isset($item->jumlah)): echo toRP($item->jumlah); endif;?>
                <input type="hidden" class="form-control" name="subtotal<?= $item->id?>" value="<?php if(isset($item->jumlah)): echo $total[] = $item->jumlah; endif;?>" readonly="">
              </td>
              <td align="center"><a href="javascript:void(0)" onclick="HapusItem(<?= $item->id ?>)"><i class="fa fa-trash fa-fw"></i></a></td>
            </tr>
          <?php $no++;endforeach; ?>
            <tr>
              <td colspan="8" align="center"><strong>Total</strong></td>
              <td align="right"><strong><span style="float:left">Rp. </span><?= toRP(array_sum($total)) ?></strong></td>
              <td></td>
            </tr>
        </tbody>
      </table>
<script type="text/javascript">

function hapus(id) {
  $.ajax({
    url: '<?= base_url('gudang/Masuk_Barang/hapus')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': id},
    success: function(data){
      if(data.status){
        reload();
      }
    }
  })
}

$('#tgl_tempo').on('click',function() {
  $('#tempo').html('<input type="date" name="tgl_tempo" id="tgl_tempo" class="form-control" onchange="update_tanggal()">');
})

function update_tanggal() {
  var tanggal = $('#tgl_tempo').val();
  var id = $('#inv').val();
  $.ajax({
    url: '<?= base_url("gudang/Masuk_Barang/update_jatuhtempo")?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': id, 'tanggal': tanggal},
    success: function(data) {
      if (data.status) {
        $('#tempo').html(data.tanggal);
      }
    }
  })
  
}

function Simpan() {
    var id = '<?= $this->input->get('id')?>';
    $.ajax({
        url: '<?= base_url(('gudang/Masuk_Barang/update_status'))?>',
        dataType: 'JSON',
        type: 'POST',
        data: {'id': id},
        success: function(data) {
            if(data.status) {
                redirect();
            }
        }
    })
}

function HapusItem(id) {
    var notif = confirm('Apakah anda yakin?');
    if (notif) {
        $.ajax({
            url: '<?= base_url('gudang/Masuk_Barang/hapus')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(data) {
                if (data.status) {
                    reload();
                }else{
                    alert('Gagal');
                }
            }
        })
    }
}


function redirect() {
    window.location = "<?= base_url('gudang/Masuk_Barang')?>";
}

</script>
