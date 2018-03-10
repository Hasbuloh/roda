<div class="alert alert-warning" id="peringatan-gagal" style="display: none;">

</div>
<table class="table table-condensed table-responsive table-bordered" id="example1">
  <thead>
  <tr>
      <th></th>
      <th></th>
      <th style="text-align:center;">No</th>
      <th style="text-align:center;">No.Faktur</th>
      <th style="text-align:center;">Masuk</th>
      <th style="text-align:center;">Jumlah</th>
      <th style="text-align:center;">Tanggal</th>
      <th style="text-align:center;">Jatuh Tempo</th>
      <th style="text-align:center;">Supplier</th>
      <th style="text-align:center;">Pembayaran</th>
      <th style="text-align: center;">Detail</th>
      <th style="text-align: center;">Update</th>
  </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $('#example1').DataTable({
            'ajax': '<?= base_url('gudang/Masuk_Barang/table_masuk')?>',
            'processing': true,
            'columns': [
                {className: 'no'},
                {className: 'no'},
                {className: 'no'},
                null,
                {className: 'no'},
                {className: 'jumlah'},
                {className: 'no'},
                {className: 'no'},
                {className: 'no'},
                {className: 'no'},
                {className: 'no'},
                {className: 'no'},
            ]
        })

    })

    function reload_table() {
        table.ajax.reload(null,false);
    }
</script>
