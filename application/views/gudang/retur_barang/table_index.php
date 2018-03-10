<table class="table table-condensed table-bordered" id="example1">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th>No</th>
        <th>No.Retur</th>
        <th>Tanggal Retur</th>
        <th>Tanggal Penggantian</th>
        <th>Item</th>
        <th>Total</th>
        <th>Penggantian</th>
        <th>Cetak</th>
        <th>Detail</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
</table>
</div>

<div class="modal fade" id="modal-penggantian" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Modal Penggantian Retur</h4>
      </div>
      <div class="modal-body">
        <form class="" role="form" id="form">
          <div class="form-group">
            <label for="">No.Retur</label>
            <input type="text" class="form-control" name="nomor_retur" readonly="">
          </div>
          <div class="form-group">
            <label for="">Tanggal Penggantian</label>
            <input type="date" class="form-control" name="tanggal" placeholder="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="simpanPenggantian()" data-dismiss="modal"><i class="fa fa-save fa-fw"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>
  var table;
  $(document).ready(function(){
    table = $('#example1').DataTable({
      'ajax': '<?= base_url('gudang/Retur_Barang/table_retur') ?>',
      'processing': true,
      'columns': [
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'jumlah'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
          {className: 'no'},
      ]
    });
  })

  function reload_table() {
    table.ajax.reload(null,false);
  }

  function showModal() {
    $('#modal-id').modal('show');
    $('#form-retur')[0].reset();
    document.getElementById('datePicker').valueAsDate = new Date();
    $.ajax({
      url: '<?= base_url('gudang/Retur_Barang/generateNoRetur')?>',
      dataType: 'JSON',
      type: 'GET',
      success: function(data) {
        $('[name="nomor_retur"]').val(data.no)
      }
    })
  }

  function modalDetail() {
    $('#modal-detail').modal('show');
  }

  function penggantian(nomor) {
    $('[name="nomor_retur"]').val(nomor);
    $('#modal-penggantian').modal('show');
  }

  function simpanPenggantian() {
    var formData = $('#form').serialize();
    $.ajax({
      url: '<?= base_url('gudang/Retur_Barang/bayar_penggantian')?>',
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

</script>
