<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
      <form role="form" id="form-tambah-item" method="post">
          <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i> Inputkan Barang</legend>
          <input type="hidden" value="<?= $header->tanggal_masuk?>" name="tanggal_masuk">
          <input type="hidden" value="<?= $header->tanggal_faktur?>" name="tanggal_faktur">
          <input type="hidden" value="<?= $header->tanggal_jt ?>" name="tanggal_jt">
          <input type="hidden" value="<?= $header->nomor_invoice ?>" name="nomor_invoice">
          <input type="hidden" value="<?= $header->nomor_faktur ?>" name="nomor_faktur">
          <input type="hidden" name="id_barang" id="id_barang">
          <div class="form-group">
              <label for="">No.Part</label>
              <input type="text" name="nomor_part" id="autocomplete-nomor" placeholder="Masukan Nomor Part" class="form-control" required/>
              <div id="selection"></div>
          </div>
          <div class="form-group">
              <label for="">Nama Part</label>
              <input type="text" name="nama_part" id="autocomplete-nama" placeholder="Masukan Nama Part" class="form-control" required/>
              <div id="selection"></div>
          </div>
          <div class="alert alert-danger" style="display:none;" id="peringatan-masuk-barang">

          </div>


          <div class="row">

            <div class="col-md-8">
              <div class="form-group">
                <label for="">HET</label>
                <input type="number" name="harga_jual" placeholder="Harga Eceran Tertinggi" class="form-control" required id="harga_jual" step='.01'>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
              <label for="">Qty</label>
              <input type="number" class="form-control" placeholder="Qty" name="qty" id="qty" required>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="">Disc1</label>
                <input type="number" class="form-control" name="disc1" placeholder="Masukan Diskon 1" step=".01" id="disc1" required="">
              </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="">Disc2</label>
                <input type="number" class="form-control" name="disc2" placeholder="Masukan Diskon 2" step=".01" id="disc2" required="">
              </div>
            </div>

          </div>

          <div class="form-group">
            <label for="">Netto</label>
            <input type="number" class="form-control" name="harga_beli" readonly="" id="harga_beli">
          </div>

          <div class="form-group">
            <label for="">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" readonly="">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-mds btn-info btn-block" name="tambah_item" id="tambah_item_btn"><i class="fa fa-plus-circle fa-fw"></i> Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="<?= base_url('gudang/Masuk_Barang')?>"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a> | <a href="javascript:void(0)" onclick="Simpan('<?= $this->input->get('id') ?>')" class="text text-danger"><i class="fa fa-save fa-fw"></i> Simpan</a>
      </div>
      <div class="panel-body">
      <div id="table" style="display:yes">

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
  })


  $('[name="harga_jual"]').keyup(function(){
    cekInput($(this).val());
  });

  $('[name="harga_jual"],[name="qty"],[name="disc1"],[name="disc2"]').keyup(function(){
    hitungNetto();
  });

  function reload() {
    $('#table').load('<?= base_url('gudang/Masuk_Barang/table_detail?id=').$header->nomor_invoice ?>');
  }

  $('#autocomplete-nomor').autocomplete({
      serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nomor')?>',
      dataType: 'JSON',
      noCache: true,
      type: 'POST',
      noSuggestionNotice: 'No Result',
      onSelect: function (suggestion) {
          $('#autocomplete-nama').val(suggestion.nama_part);
          $('#id_barang').val(suggestion.id);
          $('#harga_jual').val(suggestion.harga_jual);
          $('#harga_beli').val(suggestion.harga_beli);
          $('#disc1').val(suggestion.disc1);
          $('#disc2').val(suggestion.disc2);
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
          $('#harga_jual').val(suggestion.harga_jual);
          $('#harga_beli').val(suggestion.harga_beli);
          $('#disc1').val(suggestion.disc1);
          $('#disc2').val(suggestion.disc2);
      },
      onSearchError: function() {
          console.log('error');
      }
  });

  setInterval(function(){
      $('.alert').hide('slow');
      $('#tambah_item_btn').removeAttr('disabled');
  },5000);

  $('#form-tambah-item').on('submit',function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var qty = $('#qty').val();
        if (qty == 0) {
            peringatan(1,'<p><i class="fa fa-warning fa-fw"></i> Quantity tidak boleh '+qty+'</p>');
            $('#qty').focus();
        }else if(qty > 0) {
            $.ajax({
              url: '<?= base_url('gudang/Masuk_Barang/edit_detail')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data) {
                if(data.status) {
                  reload();
                    $('#form-tambah-item')[0].reset();
                    $('#autocomplete-nomor').focus();
                }else{
                    peringatan(1,'<p><i class="fa fa-warning fa-fw"></i> Item ini sudah ada! </p>');
                    $('#form-tambah-item')[0].reset();
                    $('#autocomplete-nomor').focus();
                }
              }
            })
        }
  })

  function peringatan(aktif,pesan) {
      if (aktif) {
          $('#tambah_item_btn').attr('disabled','TRUE');
          $('#peringatan-masuk-barang').show('400').html(pesan);
      }else{
          $('#tambah_item_btn').removeAttr('disabled');
          $('#peringatan-masuk-barang').hide('400').html('');
      }
  }

  function hitungNetto() {
    var het = $('[name="harga_jual"]').val();
    var disc1 = $('[name="disc1"]').val();
    var disc2 = $('[name="disc2"]').val();

    var total = het - het * disc1/100;
    var total1 = total - total * disc2/100;

    $('[name="harga_beli"]').val(total1);
    hitungJumlah()
  }

  function hitungJumlah() {
    var hitung = $('[name="harga_beli"]').val()*$('[name="qty"]').val();
    $('[name="jumlah"]').val(hitung);
  }

</script>
