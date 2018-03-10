<h4>Detail Retur</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="<?= base_url('kepala/Retur_Masuk')?>" class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        <form role="form" id="form">
          <input type="hidden" class="form-control" name="nomor_retur" readonly="" value="<?= $this->input->get('id')?>">
          <input type="hidden" name="id_barang">
          <input type="hidden" name="harga">
          <input type="hidden" name="disc1">
          <input type="hidden" name="disc2">
          <div class="form-group">
            <label for="">No.Part</label>
            <input type="text" class="form-control" id="nomor_part">
          </div>
          <div class="form-group">
            <label for="">Nama Part</label>
            <input type="text" class="form-control" id="nama_part">
          </div>
          <div class="form-group">
            <label for="">No.Faktur</label>
            <select class="form-control" name="nomor_faktur" id="nomor_faktur" onchange="cariBarang()">
              <option value="">-- Pilih Salah Satu --</option>
            </select>
          </div>

            <input type="hidden" id="qty">
          <div class="alert alert-danger peringatan" style="display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong><i class="fa fa-warning fa-fw"></i> Peringatan </strong> Jumlah melebihi dari jumlah item faktur
          </div>
            <div class="form-group">
                <div class="alert alert-success peringatans" style="display:none">
                </div>
            </div>
          <div class="form-group">
            <label for="">Qty Retur</label>
            <input type="number" class="form-control" name="qty">
          </div>
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea name="keterangan" class="form-control" placeholder="Keterangan Retur"></textarea>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm simpan" onclick="saveData()"><i class="fa fa-save fa-fw"></i> Simpan</button>
          </div>
        </form>
      </div>
      <div class="col-md-9">
        <div id="table">

        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">

  </div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/autocomplete/jquery.easy-autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
$(document).ready(function(){
  reload();
  $('#nomor_part').focus();
  // cariFaktur();
});

$('[name="qty"]').keyup(function(){
  var jumlah = parseInt($('#qty').val());
  var qty = parseInt($('[name="qty"]').val());
  if (qty > jumlah) {
     warningMessage(true);
  }else if(qty < 1) {
      warningMessage(true);
  }else{
      warningMessage(false);
  }
});

var options = {
  url: "<?= base_url('kepala/barang/autocomplete')?>",
  getValue: "nomor",
  list: {
    onSelectItemEvent: function() {
     $('#nama_part').val($('#nomor_part').getSelectedItemData().nama);
     $('[name="id_barang"]').val($('#nomor_part').getSelectedItemData().id);
     $('[name="harga"]').val($('#nomor_part').getSelectedItemData().harga_beli);
    },
    onClickEvent: function() {
      cariFaktur();
    },
    match: {
      enabled: true
    }
  }
};


var options1 = {
  url: "<?= base_url('kepala/barang/autocomplete')?>",

  getValue: "nama",

  list: {
    onSelectItemEvent: function() {
      $('#nomor_part').val($('#nama_part').getSelectedItemData().nomor);
      $('[name="id_barang"]').val($('#nama_part').getSelectedItemData().id);
      $('[name="harga"]').val($('#nama_part').getSelectedItemData().harga_beli);
    },
    onClickEvent: function() {
      cariFaktur();
    },
    match: {
      enabled: true
    }
  }
};


$('#nomor_part').easyAutocomplete(options);
$('#nama_part').easyAutocomplete(options1);

function cariFaktur() {
  var idbarang = $('[name="id_barang"]').val();
  var optionString = "<option value=''>-- Pilih Salah Satu --</option>";
  $.ajax({
    url: '<?= base_url('kepala/Retur_Masuk/cariFaktur')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id': idbarang},
    success: function(data) {
      for (var i = 0; i < data.length; i++) {
        optionString += '<option value="'+data[i].nomor_faktur+'">'+data[i].nomor_faktur+'</option>';
      }

      $('[name="nomor_faktur"]').html(optionString);
      // alert(optionString);
    }
  })
}

function cariBarang() {
  var idbarang = $('[name="id_barang"]').val();
  var nomorfaktur = $('[name="nomor_faktur"]').val();
  $.ajax({
    url: '<?= base_url('kepala/Retur_Masuk/cariBarang')?>',
    dataType: 'JSON',
    type: 'POST',
    data: {'id_barang': idbarang,'nomor_faktur': nomorfaktur},
    success: function(data){
      $('.peringatans').show('400');
      $('.peringatans').html(
        '<strong>Nomor Part</strong> :<p>'+data[0].nomor_part+'</p><strong>Nama Part</strong>:<p>'+data[0].nama_part+'</p><strong>Qty</strong>:<p class="qty">'+data[0].qty+'</p><strong>Tgl.Faktur</strong>:<p>'+data[0].tanggal+'</p>'
      );
      $('[name="harga"]').val(data[0].het);
      $('[name="disc1"]').val(data[0].disc1);
      $('[name="disc2"]').val(data[0].disc2);
      $('#qty').val(data[0].qty);
    }
  })
}

function reload() {
  $('#table').load('<?= base_url('kepala/Retur_Masuk/tableDetail?id=').$this->input->get('id')?>')
}

function saveData() {
  var formData = $('#form').serialize();
  $.ajax({
    url: '<?= base_url('kepala/Retur_Masuk/editDetail')?>',
    dataType: 'JSON',
    type: 'POST',
    data: formData,
    success: function(data) {
      if (data.status) {
        reload();
      }
    }
  })
}

function warningMessage(aktif) {
  if (aktif) {
    $('.peringatan').show('400');
    $('.simpan').attr('disabled','TRUE');
  }else{
    $('.peringatan').hide('400');
    $('.simpan').removeAttr('disabled','FALSE');
  }
}

</script>
