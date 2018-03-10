<h4>Pengelolaan Barang Masuk</h4>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="javascript:void(0)" class="btn btn-default btn-md" id="tombol-tambah"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Masuk Barang | <a href="javascript:void(0)" class="text text-success" onclick="reload_table()"><i class="fa fa-refresh fa-fw"></i> Refresh</a>
    </div>
    <div class="panel-body">
      <div id="table">
            <?php $this->load->view('gudang/masuk_barang/table_header'); ?>
      </div>
    </div>
</div>

<div class="modal fade" id="modal-tambah-masuk">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Form Tambah Invoice</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-tambah-invoice" method="post">
            <div class="alert alert-danger" style="display:none" id="peringatan-gagal">

            </div>
            <input type="hidden" name="id" id="id">
            <div class="form-group" id="form-group-supplier">
                <label for="">Supplier</label>
                <select class="form-control" name="supplier" id="supplier" onchange="genNoINV($('#supplier').val())" required>
                    <option value="">-- Pilih Salah Satu -- </option>
                    <option value="1">Daya</option>
                    <option value="2">Non-Daya</option>
                </select>
            </div>
            <div class="form-group" id="form-group-supplier">
              <label for="">No.Urut</label>
              <input type="text" class="form-control" id="no_urut" placeholder="" name="nomor_invoice" readonly="">
            </div>
            <div class="form-group">
                <label for="">No.Faktur</label>
                <input type="text" class="form-control" placeholder="Nomor Faktur" name="nomor_faktur" required id="nomor_faktur">
            </div>
            <div class="form-group">
                <label for="">Tgl.Terima</label>
                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" required>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group"><label for="">Tgl.Faktur</label>
                    <input type="date" class="form-control" name="tanggal_faktur" id="tanggal_faktur" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group"><label for="">Tgl.Jatuh Tempo</label>
                    <input type="date" class="form-control" name="tanggal_jt" id="tanggal_jt" required>
                </div>
              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" name="tambah_invoice" id="tambah_invoice_btn" class="btn btn-primary btn-sm">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-bayar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Form Bayar Faktur</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form-1">
          <div class="form-group">
            <label for="">No.Invoices</label>
            <input type="text" class="form-control" name="nomor_invoice" placeholder="" readonly="">
          </div>
          <div class="form-group">
            <label for="">Tanggal Bayar</label>
            <input type="date" class="form-control" name="tanggal_pembayaran" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Jumlah Bayar</label>
            <input type="number" class="form-control" name="jumlah" placeholder="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveBayar()"><i class="fa fa-save fa-fw"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>
  $('#datepicker1*').datepicker({
      format: 'dd-mm-yyyy',
      showOtherMonths: true,
      selectOtherMonths: true
  });

  setInterval(function(){
      $('.alert').hide('slow');
      peringatan(false,'');
  },5000);


  $('#form-tambah-invoice').on('submit',function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var id = $('#id').val();
      if (id == "") {
          $.ajax({
              url: '<?= base_url('gudang/Masuk_Barang/tambah_header')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data) {
                  if(data.status){
                      redirect();
                  }
              }
          })
      }else{
          $.ajax({
              url: '<?= base_url('gudang/Masuk_Barang/edit_header')?>',
              dataType: 'JSON',
              type: 'POST',
              data: formData,
              success: function(data) {
                  if(data.status){
                      reload_table();
                  }
              }
          })
      }

  })

  $('#tanggal_faktur').on('change',function() {
      var tgl_faktur = $(this).val();
      $.ajax({
          url: '<?= base_url('gudang/Masuk_Barang/cek_tanggal')?>',
          dataType: 'JSON',
          type: 'POST',
          data: {'tgl': tgl_faktur},
          success: function(data) {
              $('#tanggal_jt').val(data.tanggal_jt);
          }
      })
  })

  $('#nomor_faktur').on('keyup',function(){
      var nomor_faktur = $(this).val();
      $.ajax({
          url: '<?= base_url('gudang/Masuk_Barang/cek_nomorfaktur')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {'nomor_faktur': nomor_faktur},
          success: function(data) {
              if (data.status) {
                  peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Nomor faktur ini sudah ada </p>');
              }else{
                  peringatan(false,'');
              }
          }
      })
  })


  $('#tombol-tambah').on('click',function(event) {
      $('#id').val('');
      $('#form-tambah-invoice')[0].reset();
      $('#form-group-supplier*').show();
      $('#modal-tambah-masuk').modal('show');
        $.ajax({
          url: '<?= base_url('gudang/Masuk_Barang/generate_nourut')?>',
          dataType: 'JSON',
          type: 'GET',
          success: function(data) {
            $('[name="nomor_invoice"]').val(data.no);
          }
        })
  })

  function redirect() {
    var id = $('[name="nomor_invoice"]').val();
    window.location="<?= base_url('gudang/Masuk_Barang/update_detail_masuk?id=')?>"+id;
  }

  function genNoINV(kdsupplier) {
    $.ajax({
      url: '<?= base_url('gudang/Masuk_Barang/generate_nourut')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'kode': kdsupplier},
      success: function(data){
         $('[name="nomor_invoice"]').val(data.noinv);
      }
    })
  }

  function modalBayar(nomor,jumlah) {
    $('#modal-bayar').modal('show');
    $('[name="nomor_invoice"]').val(nomor);
    $('[name="jumlah"]').val(jumlah);
  }

  function hapusData(id,jumlah) {
    if (jumlah > 0) {
        peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf anda tidak diperkenankan untuk menghapus data ini!</p>');
    }else{
        var alert = confirm('Apakah anda yakin?');
        if (alert) {
            $.ajax({
                url: '<?= base_url('gudang/Masuk_Barang/hapus_header')?>',
                dataType: 'JSON',
                type: 'POST',
                data: {'id': id},
                success: function(data) {
                    if (data.status) {
                        reload_table();
                    }
                }
            })
        }
    }
  }

  function saveBayar() {
    var formData = $('#form-1').serialize();
    $.ajax({
      url: '<?= base_url('gudang/Masuk_Barang/bayar_faktur')?>',
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

  function modalEdit(id,no_urut,nomor_faktur,tanggal_masuk,tanggal_faktur,tanggal_jt,supplier) {
      $('#modal-tambah-masuk').modal('show');
      $('#form-group-supplier').hide();
      $('#id').val(id);
      $("#supplier").val(supplier);
      $('#no_urut').val(no_urut);
      $('#nomor_faktur').val(nomor_faktur);
      $('#tanggal_masuk').val(tanggal_masuk);
      $('#tanggal_faktur').val(tanggal_faktur);
      $('#tanggal_jt').val(tanggal_jt);
      $('#nomor_faktur').focus();
  }

  function peringatan(status,kind,pesan) {
      if (status) {
          $('#peringatan-'+kind).show().html(pesan);
          $('#tambah_invoice_btn').attr('disabled',true);
      }else{
          $('#peringatan'+kind).hide();
          $('#tambah_invoice_btn').removeAttr('disabled');
      }
  }
</script>
