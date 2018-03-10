<h4><i class="fa fa-calendar fa-fw"></i> Opname</h4>
<hr>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Opname</h3>
	</div>
	<div class="panel-body">
		<div id="table">
			
		</div>
	</div>
	<div class="panel-footer">
		
	</div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		reload();
	})
	function reload() {
		$('#table').load('<?= base_url('kepala/Opname/table_index')?>');
	}

	function updateStatus (id) {
		$.ajax({
			url: '<?= base_url('kepala/Opname/update_status')?>',
			dataType: 'JSON',
			type: 'POST',
			data: {'id': id},
			success: function(data){
				if (data.status) {
					reload();
				}else{
					alert('Kesalahan Jaringan');
				}
			}
		})
	}
</script>