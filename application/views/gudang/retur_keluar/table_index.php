<table class="table table-condensed table-bordered table-hover" id="example1">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th>No</th>
        <th>No.Retur</th>
        <th>No.Keluar</th>
        <th>Tanggal</th>
        <th>Item</th>
        <th>Jumlah</th>
        <th>Cetak</th>
        <th>Lihat</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
</table>
</div>


<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        table = $('#example1').DataTable({
            'ajax': '<?= base_url('gudang/Retur_Keluar/table_retur')?>',
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
                {className: 'no'},
                {className: 'no'},
            ]
        });
    })

    function reload_table() {
        table.ajax.reload(null,false);
    }


</script>
