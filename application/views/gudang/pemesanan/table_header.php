<div class="alert alert-warning" id="peringatan-gagal" style="display:none;">

</div>
<table class="table table-bordered table-condensed" id="example1">
      <thead>
        <tr>
            <th></th>
            <th></th>
              <th style="text-align:center;">No</th>
              <th style="text-align:center;">No.PO</th>
              <th style="text-align:center;">Tanggal</th>
              <th style="text-align:center;">Item</th>
              <th style="text-align:center;">Total</th>
              <th style="text-align:center;">Supplier</th>
              <th style="text-align:center;">Cetak</th>
              <th style="text-align:center;">Detail</th>
            <th style="text-align: center">Update</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

    <!-- modal detail pemesanan -->
    <div class="modal fade" id="detail-pemesanan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Detail Pemesanan</h4>
          </div>
          <div class="modal-body" id="body-detail-pemesanan">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-sign-out fa-fw"></i> Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal pemesanan berakhir -->

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script>
    var table;
  $(document).ready(function(){
    table = $('#example1').DataTable({
        'ajax': '<?= base_url('gudang/Pemesanan/table_pesan')?>',
        'processing': true,
        'columns': [
            {className: 'no'},
            {className: 'no'},
            {className: 'no'},
            {className: 'no'},
            {className: 'no'},
            {className: 'total'},
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

  setInterval(function(){
      $('.alert').hide('slow');
      $('#tambah_item_btn').removeAttr('disabled');
  },5000);


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
