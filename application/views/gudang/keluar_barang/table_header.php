<div class="alert alert-warning" style="display:none;" id="peringatan-gagal">
</div>
<table class="table table-bordered table-condensed table-responsive" id="example1">
<thead>
  <tr>
    <th></th>
    <th></th>
    <th style="text-align:center">No</th>
    <th style="text-align:center">No.Keluar</th>
    <th style="text-align:center">No.Polisi</th>
    <th style="text-align:center">No.Sa</th>
    <th style="text-align:center">Tanggal</th>
    <th style="text-align:center">Nama</th>
    <th style="text-align:center">Item</th>
    <th style="text-align:center">Total</th>
    <th style="text-align: center">Detail</th>
    <th style="text-align:center">Update</th>
  </tr>
</thead>
<tbody>

</tbody>
</table>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
    var table;
  $(document).ready(function(){
    table = $('#example1').DataTable({
        'ajax': '<?= base_url('gudang/Keluar_Barang/table_keluar')?>',
        'processing': true,
        'columns': [
            {className: 'no'},
            {className: 'no'},
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
        ]
    });
  })

  function reload_table() {
      table.ajax.reload(null,false);
  }
</script>
