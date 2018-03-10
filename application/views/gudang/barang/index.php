<h4>Pengelolaan Barang</h4>
<hr>
<div class="alert alert-success daya-update" style="display:none;">

</div>

<div class="panel panel-default">
  <div class="panel-heading">

    <div class="row">

      <div class="col-md-4">
        <a href="javascript:void(0)" class="btn btn-default btn-md" onclick="showModal()"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Stok Barang | <a href="javascript:void(0)" class="text text-success" onclick="reload_table()"><i class="fa fa-refresh fa-fw"></i> Refresh</a>
      </div>

    </div>

  </div>
  <div class="panel-body">
    <div id="table">
      <?php $this->load->view('gudang/barang/table') ?>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-id">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success peringatan-berhasil" style="display:none">

        </div>
        <div class="alert alert-danger peringatan-gagal" style="display:none">

        </div>
        <form role="form" method="POST" id="form-tambah-barang">
          <input type="hidden" name="id">
          <div class="form-group">
            <label for="">Nomor</label>
            <input type="text" class="form-control" placeholder="Nomor Part" name="nomor_part" required id="nomor_part">
          </div>
          <div class="form-group">
            <label for="">Nama</label>
            <input type="text" class="form-control" placeholder="Nama Part" name="nama_part" required id="nama_part">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Jenis</label>
                <select name="jenis_part" class="form-control" required>
                  <option value="">-- Pilih Salah Satu --</option>
                  <option value="S">Sparepart</option>
                  <option value="O">Oli</option>
                  <option value="A">Apparel</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label for="">Qty</label>
              <input type="number" class="form-control" placeholder="Qty" name="qty" min="0" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="">HET Rp.</label>
            <input type="number" class="form-control" placeholder="Harga Eceran Tertinggi" name="harga_jual" min="0"  id="het" onkeyup="disc()" required step=".01">
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Disc 1</label>
                <input style="text-align: center;" type="number" class="form-control" placeholder="Discount 1" name="disc1" id="disc1" onkeyup="disc()" value="0" min="0" step=".01">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Disc 2</label>
                <input style="text-align: center;" type="number" class="form-control" placeholder="Discount 2" name="disc2" id="disc2" onkeyup="disc()" value="0" min="0" step=".01">
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group danger">
                    <label for="">Netto</label>
                    <input type="text" id="netto" class="form-control" name="harga_beli" id="netto" readonly="" required>
                </div>
            </div>
          </div>
          <input type="hidden" id="setdisc1">
          <input type="hidden" id="setdisc2">
          <div class="form-group">
            <label for="">Rak Penyimpanan</label>
            <input type="text" class="form-control" placeholder="Rak" min="0" name="no_rak" id="no_rak">
          </div>

      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
        <button type="submit" name="tambah_item" id="tambah_item_btn" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script>
  var netto,het,disc1,disc2=0;
  var status = true;

  setInterval(function(){
      $('.alert').hide('slow');
      $('#tambah_item_btn').removeAttr('disabled');
  },5000);

  $('#form-tambah-barang').on('submit',function(event) {
       event.preventDefault();
       if (status) {
           var formData = $(this).serialize();
           $.ajax({
               url: '<?= base_url('gudang/barang/edit')?>',
               dataType: 'JSON',
               type: 'POST',
               data: formData,
               success: function(data){
                   if(data.status){
                       //  alert('data');
                       reload_table();
                       peringatan(1,'berhasil','<p><i class="fa fa-check fa-fw"></i> Data berhasil disimpan</p>');
                       $('#form-tambah-barang')[0].reset();
                   }
               }
           });
       }
  })

  $('#nomor_part').on('blur',function() {
      var nomor = $(this).val();
      $.ajax({
          url: '<?= base_url('gudang/Barang/cek_nomor_part')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {'nomor_part': nomor},
          success: function(data) {
              if (data.status > 0) {
                  status = false;
                  peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Nomor Part Ini Sudah Ada</p>');
              }
          }
      })
  })

  function peringatan(aktif,kind,pesan) {
      if (aktif) {
          $('#tambah_item_btn').attr('disabled','TRUE');
          $('.peringatan-'+kind).show('400').html(pesan);
      }else{
          $('#tambah_item_btn').removeAttr('disabled');
          $('.peringatan-'+kind).hide('400').html('');
      }
  }

  function showModal(id,nomor,nama,jenis_part,qty,hrg_jual,hrg_beli,disc1,disc2,no_rak,status) {
    $('.peringatan').attr('style','display:none');
    if (id == null) {
      $('#modal-id').modal('show');
      $('.modal-title').text('Form Tambah Barang');
      $('#form [name]').val('');
      $('[name="qty"]').val('0');
      $('#disc1').val('0');
      $('#disc2').val('0');
    }else{
      if (status == 0) {
        $('[name="qty"]').attr('readonly','TRUE');
      }else{
        $('[name="qty"]').removeAttr('readonly');
      }
      $('#modal-id').modal('show');
      $('.modal-title').text('Form Edit Barang');
      $('[name="id"]').val(id)
      $('[name="nomor_part"]').val(nomor);
      $('[name="nama_part"]').val(nama);
      $('[name="qty"]').val(qty);
      $('[name="harga_jual"]').val(hrg_jual);
      $('[name="harga_beli"]').val(hrg_beli);
      $('[name="disc1"]').val(disc1);
      $('[name="disc2"]').val(disc2);
      $('[name="jenis_part"]').val(jenis_part);
      $('[name="no_rak"]').val(no_rak);
    }
  }

  function hapus(id,nama) {
      swal({
        title: "Apakah anda yakin untuk menghapus "+nama+"?",
        text: "Tidak mungkin untuk mengembalikan data yang dihapus",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya Hapus ini",
        closeOnConfirm: false
      },
      function(){
        $.ajax({
          url: '<?= base_url('gudang/barang/hapus')?>',
          data: {'id': id},
          dataType: 'JSON',
          type: 'POST',
          success: function(data){
              if (data.status) {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                reload_table();
              }
          }
        })
      });
  }


 function disc() {
      het = $('#het').val();
      disc1 = $('#disc1').val();
      disc2 = $('#disc2').val();
      netto = het - (het * disc1 / 100);
      netto = netto - (netto * disc2 /100);

      $('#netto').val(netto);
 }

</script>
