<h4>Pengelolaan Rak Penyimpanan</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="javascript:void(0)" class="btn btn-md btn-link" onclick="showModal()">Tambah <i class="fa fa-plus fa-fw"></i></a>
  </div>
  <div class="panel-body" id="table">

  </div>
</div>
<div class="modal fade" id="modal-id" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
              <div class="alert alert-success" style="display:none"></div>
        <form role="form" method="POST" id="form">
          <div class="form-group">
            <label for="">No.Rak</label>
            <input type="text" class="form-control" id="" placeholder="Masukan Nomor Rak" name="no_rak">
          </div>
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" placeholder="Masukan Deskripsi Rak"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="dataSave()">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script>
  $(document).ready(function(){
    $('#table').load('<?= base_url('gudang/rak/table')?>');
  })

  function showModal(id,no,des) {
    if(id == null) {
      $('#modal-id').modal('show');
      $('.modal-title').text('Form Tambah Rak');
      $('#form')[0].reset();
    }else{
      $('#modal-id').modal('show');
      $('.modal-title').text('Form Edit Rak');
      $('[name="no_rak"]').val(no);
      $('[name="deskripsi"]').val(des);
    }
  }

  function dataSave() {
    $('.alert').attr('style','display:yes');
    $('.alert').html('<p>Data Berhasil Disimpan</p>');
    setInterval(function(){
      $('.alert').hide('slow');
    },500);
    $('#table').load('<?= base_url('gudang/rak/table')?>');
  }
</script>
