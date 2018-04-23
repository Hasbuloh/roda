<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
      <form role="form" id="form-tambah-item" method="post">
          <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i> Inputkan Barang</legend>
          <input type="hidden" name="id_barang" id="id_barang">
          <input type="hidden" name="id_header" value="<?= $detail->id ?>">
          <input type="hidden" name="disc1" id="disc1">
          <input type="hidden" name="disc2" id="disc2">
          <input type="hidden" class="form-control" name="nomor_keluar" value="<?= $detail->nomor_keluar ?>" readonly="">
          <input type="hidden" name="jenis_keluar" value="<?= $detail->jenis ?>">
          <input type="hidden" name="tanggal_keluar" value="<?= $detail->tanggal_keluar?>">
          <input type="text" name="netto" id="netto">
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
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">HET</label>
                <input type="number" class="form-control" name="harga" id="harga" placeholder="" readonly="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Qty</label>
                <input type="number" class="form-control" placeholder="Qty" id="qty" name="qty" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-danger" id="peringatan-gagal" style="display:none;"></div>
            </div>
          </div>

          <div class="form-group">
            <label for="">Jumlah</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah_harga" readonly="">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block btn-md" name="tambah_item" id="tambah_item_btn"><i class="fa fa-plus-circle fa-fw"></i> Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <a href="<?= base_url('gudang/Keluar_Barang')?>"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a> | <a href="javascript:void(0)" class="text text-danger" onclick="Simpan('<?= $this->input->get('id') ?>')"><i class="fa fa-save fa-fw"></i> Simpan</a>
      </div>
      <div class="panel-body">
        <div id="table">

        </div>
      </div>
    </div>

  </div>
</div>


<!--Modal Retur Keuar-->
<div class="modal fade" id="modal-retur" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">Form Retur Barang Keluar</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-tambah-retur" method="post">
                    <div class="alert alert-danger" id="peringatan-retur-gagal" style="display:none;"></div>
                    <input type="hidden" name="id_barang" id="id_barang">
                    <input type="hidden" name="nomor_keluar" value="<?= $this->input->get('id')?>" id="nomor_keluar">
                    <input type="hidden" name="harga_jual" id="harga_jual">
                    <input type="hidden" name="nomor_retur" id="nomor_retur">
                    <input type="hidden" name="jumlah_beli" id="jumlah_beli">
                    <input type="hidden" name="disc1" id="disc1">
                    <input type="hidden" name="disc2" id="disc2">
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="qty" id="qty_retur" required placeholder="Masukan Jumlah Retur">
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Masukan Keterangan" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" name="tambah_retur" id="tambah_retur_btn"><i class="fa fa-save fa-fw"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal Retur Keluar Berakhir-->

<!--modal-batal-->
<div class="modal fade" id="modal-batal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">Modal Batal</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-tambah-batal" method="post">
                    <div class="alert alert-danger" id="peringatan-batal-gagal" style="display:none;"> </div>
                    <input type="hidden" id="id" name="id"">
                    <input type="hidden" id="nomor_keluar" name="nomor_keluar_batal">
                    <input type="hidden" id="id_barang" name="id_barang">
                    <input type="hidden" id="qty_beli" name="qty_pesan">
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="qty_batal" id="qty_batal" placeholder="Qty item batal" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" name="tambah_batal" id="tambah_batal_btn"><i class="fa fa-save fa-fw"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--modal batal berkahir-->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/maskmoney/jquery.maskMoney.min.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    reload();
    $('#autocomplete-nomor').focus();
  });

  $('#qty').keyup(function(){
    var total = $('#qty').val()*$('#harga').val();
    $('#jumlah').val(total);
  });

  function reload() {
    $('#table').load('<?= base_url('gudang/Keluar_Barang/table_detail?id=').$this->input->get('id') ?>');
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
          $('#harga').val(suggestion.harga_jual);
          $('#disc1').val(suggestion.disc1);
          $('#disc2').val(suggestion.disc2);
          $('#netto').val(suggestion.harga_beli);
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


  setInterval(function(){
      $('.alert').hide('slow');
      peringatan(false,'');
  },5000);

  $('#form-tambah-item').on('submit',function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      var qty = $('#qty').val();
      if (qty == 0) {
        peringatan(1,'gagal','<p><i class="fa fa-warning fa-fw"></i> Quantity tidak boleh '+qty+'</p>');
        $('#qty').focus();
      }else if(qty > 0){
        $.ajax({
        url: '<?= base_url('gudang/Keluar_Barang/cek_stok') ?>',
        dataType: 'JSON',
        type: 'POST',
        data: {'id': $('[name="id_barang"]').val(),'jumlah': qty},
        success: function(data) {
          if (data.status) {
            peringatan(1,'gagal','<p><i class="fa fa-warning fa-fw"></i> Stok item ini tidak mencukupi</p>');
            $('#form-tambah-item')[0].reset();
            $('#nomor_part').focus();
          }else{
            peringatan(0);
              $.ajax({
                  url: '<?= base_url('gudang/Keluar_Barang/edit_detail')?>',
                  dataType: 'JSON',
                  type: 'POST',
                  data: formData,
                  success: function(data) {
                      if (data.status){
                          reload();
                          $('#form-tambah-item')[0].reset();
                          $('#autocomplete-nomor').focus();
                      }else{
                          peringatan(1,'gagal','<p><i class="fa fa-warning fa-fw"></i> Item sudah ada!</p>');
                          $('#form-tambah-item')[0].reset();
                          $('#autocomplete-nomor').focus();
                      }
                  }
              });
          }
        }
      });
    }
  })

  $("#form-tambah-retur").on('submit',function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      var qty_beli = $('#jumlah_beli').val();
      var qty_retur = $('#qty_retur').val();
      // alert(qty_beli+' '+qty_retur);
      if (qty_retur < 1) {
          $('#qty_retur').focus();
          peringatan(true,'retur-gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf jumlah retur tidak boleh '+qty_retur+'</p>');
      }else if (qty_retur > qty_beli) {
          $('#qty_retur').focus().val('');
          peringatan(true,'retur-gagal',' <p><i class="fa fa-warning fa-fw"></i> Maaf jumlah retur tidak boleh lebih dari '+ qty_beli +'</p>');
      }else{
          $.ajax({
              url: '<?= base_url('gudang/Retur_Keluar/edit_detail')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data) {
                  if (data.status) {
                      reload();
                      $('#modal-retur').modal('hide');
                      $('#form-tambah-retur')[0].reset();
                  }else{
                      peringatan(true,'retur-gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf item ini sudah di retur!</p>');
                      $('#qty_retur').val('');
                      $('#keterangan').val('');
                  }
              }
          })
      }

  })

  $('#form-tambah-batal').on('submit',function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      var qty_beli = $('#qty_beli').val();
      var qty_batal = $('#qty_batal').val();
      if(qty_batal < 1) {
        peringatan(true,'batal-gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf jumlah batal tidak boleh '+qty_batal+'</p>');
      } else if (qty_beli < qty_batal) {
          peringatan(true,'batal-gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf jumlah batal tidak boleh lebih dari '+qty_beli+'</p>');
          $('#qty_batal').focus().val('');
      }else{
          $.ajax({
              url: '<?= base_url('gudang/Keluar_Barang/simpan_batal')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data){
                  reload();
                  $('#qty_batal').val('');
                  $('#modal-batal').modal('hide');
              }
          })
      }

  })


  function modalRetur(nomor,nama,jumlah,harga,disc1,disc2,id_barang) {
      $('#modal-retur').modal('show');
      $('[name="nomor_part"]').val(nomor);
      $('[name="nama_part"]').val(nama);
      $('[name="jumlah_beli"]').val(jumlah);
      $('[name="harga_jual"]').val(harga);
      $('[name="disc1"]').val(disc1);
      $('[name="disc2"]').val(disc2);
      $('[name="id_barang"]').val(id_barang);
      $('[name="keterangan"]').val("");
      $('[name="qty"]').val("");
      $('.simpan').attr('disabled','TRUE');
      $.ajax({
          url: '<?= base_url('gudang/Retur_Keluar/cek_no_retur')?>',
          dataType: 'JSON',
          type: 'POST',
          data: {'nomor_keluar': $('[name="nomor_keluar"]').val()},
          success: function(data) {
              $('[name="nomor_retur"]').val(data.noretur);
          }
      })
  }

  function modalBatal(nomor,qty,id,id_barang) {
      $('#modal-batal').modal('show');
      $('[name="qty_pesan"]').val(qty);
      $('[name="id"]').val(id);
      $('[name="id_barang"]').val(id_barang);
      $('[name="nomor_keluar_batal"]').val(nomor);
  }

  function peringatan(aktif,kind,pesan) {
      if (aktif) {
          $('#peringatan-'+kind).show('400').html(pesan);
      }else{
          $('#peringatan-'+kind).hide('400').html('');
      }
  }
</script>
