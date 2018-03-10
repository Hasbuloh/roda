<h4>Pengelolaan Retur Barang Masuk</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="javascript:void(0)" onclick="showModal()" class="btn btn-link"><i class="fa fa-plus-circle fa-fw"></i> Tambah Retur Barang Masuk</a> | Data Retur Barang Masuk
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
            <div id="table">

            </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-id" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Form Tambah Retur</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-retur">
          <div class="form-group">
            <label for="">Supplier</label>
            <select class="form-control" name="supplier" id="supplier" onchange="generateNoRetur($('#supplier').val())">
              <option value="">-- Pilih Salah Satu --</option>
              <option value="1">Daya</option>
              <option value="2">Non-Daya</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">No.Retur</label>
            <input type="text" class="form-control" name="nomor_retur" placeholder="" readonly="">
          </div>
          <div class="form-group">
            <label for="">Tangga Retur</label>
            <input type="date" class="form-control" name="tanggal_retur" placeholder="" id="datePicker">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveData()">Simpan</button>
      </div>
    </div>
  </div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>

  $(document).ready(function(){
      reload();
  })


  function reload() {
    $('#table').load('<?= base_url('kepala/Retur_Masuk/tableIndex')?>');
  }

  function saveData() {
    var formData = $('#form-retur').serialize();
    $.ajax({
      url: '<?= base_url('kepala/Retur_Masuk/editHeader')?>',
      dataType: 'JSON',
      type: 'POST',
      data: formData,
      success: function(data) {
        if (data.status) {
          redirect();
        }
      }
    })
  }

  function generateNoRetur(idreture) {
    $.ajax({
      url: '<?= base_url('kepala/Retur_Masuk/generateNoRetur')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'kode': idreture},
      success: function(data) {
        $('[name="nomor_retur"]').val(data.noretur);
      }
    })
  }

  function redirect() {
      var id = $('[name="nomor_retur"]').val();
      window.location = '<?= base_url('kepala/Retur_Masuk/detailRetur?id=')?>'+id;
  }

</script>
