<table class="table table-condensed table-hover table-bordered" id="example1">
<thead>
	<tr>
        <th></th>
        <th></th>
		<th>No</th>
		<th>No.Opname</th>
		<th>Tanggal</th>
        <th>Item</th>
        <th>Qty</th>
        <th>Laporan</th>
        <th>Detail</th>
        <th>Update</th>
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
    table =	$('#example1').DataTable({
             "ajax": '<?= base_url('gudang/Opname/table_opname')?>',
             "processing": true,
			 "columns": [
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
	})
});

function reload_table() {
    table.ajax.reload(null,false);
}

</script>
