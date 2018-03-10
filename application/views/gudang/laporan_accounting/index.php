<h4>Laporan Accounting</h4>
<hr>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Laporan Stok Bulanan</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
			  			<label for="">Bulan</label>
			</div>
			<div class="col-md-2">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
			<div class="form-group">
					<input type="month" name="bulan" class="form-control" value="" id="bulan">
      </div>
			</div>
			<div class="col-md-2">
			  <button type="button" name="button" class="btn btn-success btn-sm" id="cetak"><i class="fa fa-print fa-fw"></i> Cetak</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="table">

				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer"></div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script>
var param = {'bulan': null};
var tableUrl = '<?= base_url('gudang/Laporan_Accounting/table_index')?>';
$(document).ready(function(){
	reload();
})

function reload() {
	$('#table').load(tableUrl,param);
}

$('#bulan').on('change',function(){
	param.bulan = $(this).val();
	reload();
})

$('#cetak').on('click',function(){
	var bulan = $('#bulan').val();
  window.location = tableUrl+'_cetak'+"?bulan="+bulan;
})
</script>
