 <div class="col-md-3">
     <div class="panel panel-default">
         <div class="panel-body">
             <form role="form" id="form-tambah-item">
                 <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i> Inputkan Barang</legend>
                 <input type="hidden" name="id_header" value="<?= $detail->id ?>" id="id">
                 <input type="hidden" class="form-control" name="id_barang" id="id_barang">
                 <input type="hidden" class="form-control" placeholder="Nomor Part" name="nomor_po" readonly="" value="<?= $detail->nopo ?>">
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
                 <div class="alert alert-danger" id="peringatan-gagal" style="display: none;">

                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                             <label for="">Harga</label>
                             <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Eceran Tertinggi" readonly="">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label for="">Qty</label>
                             <input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" required>
                         </div>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="">Jumlah</label>
                     <input type="number" class="form-control" id="" placeholder="Jumlah Beli" name="jumlah_beli" readonly="">
                 </div>
                 <div class="form-group">
                     <button type="submit" class="btn btn-info btn-block btn-md" name="tambah_item" id="tambah_item_btn"><i class="fa fa-plus fa-fw"></i> Tambah</button>
                 </div>
             </form>
         </div>
         <div class="panel-footer">
             <a href="<?= base_url('gudang/Pemesanan')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
         </div>
     </div>
 </div>
  <div class="col-md-9">
    <div id="table">

    </div>
  </div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
 <script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script>
  $(document).ready(function(){
    $('#autocomplete-nomor').focus();
    reload();
  });

  setInterval(function(){
      $('.alert').hide('slow');
      $('#tambah_item_btn').removeAttr('disabled');
  },5000);


  $('#autocomplete-nomor').autocomplete({
      serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nomor')?>',
      dataType: 'JSON',
      noCache: true,
      type: 'POST',
      noSuggestionNotice: 'No Result',
      onSelect: function (suggestion) {
          $('#autocomplete-nama').val(suggestion.nama_part);
          $('#id_barang').val(suggestion.id);
          $('#harga').val(suggestion.harga_jual);
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
          $('#harga').val(suggestion.harga_jual);
          $('#disc1').val(suggestion.disc1);
          $('#disc2').val(suggestion.disc2);
      },
      onSearchError: function() {
          console.log('error');
      }
  });

  $('[name="qty"]').keyup(function(){
    var jumlah = parseInt($('[name="harga"]').val())*parseInt($(this).val());
    $('[name="jumlah_beli"]').val(jumlah);
  })

  $('#form-tambah-item').on('submit',function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      var qty = $('#qty').val();
      if (qty < 1) {
          peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> QTY tidak boleh 0 </p>');
      }else{
          $.ajax({
              url: '<?= base_url('gudang/pemesanan/edit_detail')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data) {
                  if (data.status) {
                      $('#form-tambah-item')[0].reset();
                      $('#autocomplete-nomor').focus();
                      reload();
                  }else{
                      peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Item ini sudah ada!</p>');
                  }
              }
          })
      }
  })



  function hapus(id,nopo){
    var alert = confirm('Apakah anda yakin?');
    if (alert) {
        $.ajax({
            url: '<?= base_url('gudang/pemesanan/hapus')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id':id,'nomor_po':nopo},
            success:function(data) {
                if (data.status) {
                    reload();
                }
            }
        })
    }
  }

  function reload() {
      $('#table').load('<?= base_url('gudang/Pemesanan/table_detail?id=').$this->input->get('id') ?>');
  }

  function peringatan(aktif,kind,pesan) {
      if (aktif) {
          $('#tambah_item_btn').attr('disabled','TRUE');
          $('#peringatan-'+kind).show('400').html(pesan);
      }else{
          $('#tambah_item_btn').removeAttr('disabled');
          $('#peringatan-'+kind).hide('400').html('');
      }
  }
</script>
