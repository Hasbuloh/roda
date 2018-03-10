<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
      <form method="post" role="form" id="form-tambah-item">
          <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i> Inputkan Barang</legend>
          <input type="hidden" class="form-control" name="nomor_retur" readonly="" value="<?= $this->input->get('id')?>">
          <input type="hidden" name="id_barang" id="id_barang">
          <input type="hidden" name="harga" id="harga">
          <input type="hidden" name="disc1" id="disc1">
          <input type="hidden" name="disc2" id="disc2">
          <input type="hidden" value="<?= $header->supplier ?>" name="id_supplier" id="id_supplier">
          <div class="form-group">
              <label for="">Nomor</label>
              <input type="text" name="nomor_part" id="autocomplete-nomor" placeholder="Masukan Nomor Part" class="form-control" required/>
              <div id="selection"></div>
          </div>
          <div class="form-group">
              <label for="">Nama</label>
              <input type="text" name="nama_part" id="autocomplete-nama" placeholder="Masukan Nama Part" class="form-control" required/>
              <div id="selection"></div>
          </div>
          <div class="form-group">
            <label for="">No.Faktur</label>
            <select class="form-control" name="nomor_faktur" id="nomor_faktur" onchange="cariBarang()" required="">
              <option value="">-- Pilih Salah Satu --</option>
            </select>
          </div>
          <input type="hidden" id="qty">
          <div class="alert alert-danger" id="peringatan-gagal" style="display: none;">

          </div>
          <div class="alert alert-success" id="peringatan-berhasil" style="display: none;">
    
          </div>
          <div class="form-group">
            <label for="">Qty</label>
            <input type="number" class="form-control" name="qty" id="jumlah_retur" required="" placeholder="Jumlah Retur">
          </div>
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea name="keterangan" class="form-control" placeholder="Keterangan Retur" required=""></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block btn-md" name="tambah_item" id="tambah_item_btn"><i class="fa fa-plus fa-fw"></i> Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
          <a href="<?= base_url('gudang/Retur_Barang')?>"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a> | <a href="javascript:void(0)" class="text text-danger" onclick="Simpan('<?= $this->input->get('id') ?>')"><i class="fa fa-save fa-w"></i> Simpan</a> | <a href="<?= base_url('gudang/Retur_Barang/cetakBerita?id=').$this->input->get('id') ?>" target="_blank" class="text text-warning"><i class="fa fa-print fa-fw"></i> Cetak</a>
      
      </div>
      <div class="panel-body">
        <div id="table">

        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    reload();
    $('#autocomplete-nomor').focus();
  });


  setInterval(function(){
      $('.alert').hide('slow');
      peringatan(false,'');
  },8000);

  $('#autocomplete-nomor').autocomplete({
      serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nomor')?>',
      dataType: 'JSON',
      noCache: true,
      type: 'POST',
      noSuggestionNotice: 'No Result',
      onSelect: function (suggestion) {
          $('#autocomplete-nama').val(suggestion.nama_part);
          $('#id_barang').val(suggestion.id);
          cariFaktur();
      },
      onSearchError: function() {
          console.log('error');
      }
  });

  $('#autocomplete-nama').autocomplete({
      serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nama')?>',
      dataType: 'JSON',
      noCache: true,
      type: 'POST',
      noSuggestionNotice: 'No Result',
      onSelect: function (suggestion) {
          $('#autocomplete-nomor').val(suggestion.nomor_part);
          $('#id_barang').val(suggestion.id);
          cariFaktur();
      },
      onSearchError: function() {
          console.log('error');
      }
  });

  function cariFaktur() {
    var idBarang = $('#id_barang').val();
    var idSupplier = $('#id_supplier').val();
    // alert(idSupplier);
    var optionString = "<option value=''>-- Pilih Salah Satu --</option>";
    $.ajax({
      url: '<?= base_url('gudang/Retur_Barang/cari_faktur')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'id_barang': idBarang,'id_supplier': idSupplier},
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          optionString += '<option value="'+data[i].nomor_faktur+'">'+data[i].nomor_faktur+'</option>';
        }
        $('[name="nomor_faktur"]').html(optionString);
      }
    })
  }

  function cariBarang() {
    var idbarang = $('[name="id_barang"]').val();
    var nomorfaktur = $('[name="nomor_faktur"]').val();
    $.ajax({
      url: '<?= base_url('gudang/Retur_Barang/cariBarang')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'id_barang': idbarang,'nomor_faktur': nomorfaktur},
      success: function(data){
        peringatan(true,'berhasil','<strong>Nomor </strong>'+data[0].nomor_part+'<br><strong>Nama </strong>'+data[0].nama_part+'<br><strong>Qty </strong>'+data[0].qty+'<br><strong>Tanggal </strong>'+data[0].tanggal);
        $('[name="harga"]').val(data[0].het);
        $('[name="disc1"]').val(data[0].disc1);
        $('[name="disc2"]').val(data[0].disc2);
        $('#qty').val(data[0].qty);
      }
    })
  }

  function reload() {
    $('#table').load('<?= base_url('gudang/Retur_Barang/table_detail?id=').$this->input->get('id')?>')
  }

  $('#form-tambah-item').on('submit',function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
    var qty_retur = $('#jumlah_retur').val();
    var qty_masuk = $('#qty').val();
    if (qty_retur > qty_masuk) {
      peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Melebihi jumlah pembelian</p>');
      $('#jumlah_retur').focus();
    }else{
      $.ajax({
        url: '<?= base_url('gudang/Retur_Barang/editDetail')?>',
        dataType: 'JSON',
        type: 'POST',
        data: formData,
        success: function(data) {
          if (data.status) {
            reload();
            $("#form-tambah-item")[0].reset();
            $('#autocomplete-nomor').focus();
          }else{
            peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Item ini sudah ada</p>');
            $("#form-tambah-item")[0].reset();
            $('#autocomplete-nomor').focus();
          }
        }
      })
    }
  })

// function saveData() {

// }

  function peringatan(status,kind,pesan) {
    if (status) {
      $('#peringatan-'+kind).show('400').html(pesan);
    }else{
      $('#peringatan-'+kind).hide('400').html('');
    }
  }

</script>
