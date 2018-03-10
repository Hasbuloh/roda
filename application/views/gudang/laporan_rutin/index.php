<h4>Laporan Rutin</h4>
<hr>
<div class="panel panel-default">
<div class="panel-heading">
	<h3 class="panel-title">Laporan Rutin <i class="fa fa-calendar-o fa-fw"></i></h3>
</div>
<div class="panel-body">
<div class="row">
	<div class="col-md-2">
		<label for="jenis">Jenis Mutasi</label>
	</div>
	<div class="col-md-2">
		<label for="periode">Periode</label>
	</div>
	<div class="col-md-2" id="bulan">
		<label for="">Tanggal Awal</label>
	</div>
	<div class="col-md-2" id="bulan">
		<label for="">Tanggal Akhir</label>
	</div>
	<div class="col-md-2" id="hari" style="display:none">
		<label for="">Tanggal</label>
	</div>
	<div class="col-md-2">
		
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<select name="jenis" id="jenis" class="form-control">
				<option value="">-- Pilih Jenis Mutasi --</option>
				<option value="1">Barang Masuk</option>
				<option value="2">Barang Keluar</option>
			</select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<select name="periode" id="periode" class="form-control">
				<option value="1">Bulanan</option>
				<option value="2">Harian</option>
			</select>
		</div>
	</div>
	<div class="col-md-2" id="bulan">
		<div class="form-group">
			<input type="date" class="form-control" id="awal" name="awal">
		</div>
	</div>
	<div class="col-md-2" id="bulan">
		<div class="form-group">
			<input type="date" class="form-control" id="akhir" name="akhir">
		</div>
	</div>
	<div class="col-md-2" id="hari" style="display:none;">
		<div class="form-group">
			<input type="date" class="form-control" id="tanggal" name="tanggal">
		</div>
	</div>
	
	<div class="col-md-2">
		<div class="form-group">
			<button class="btn btn-success btn-sm" id="cetak"><i class="fa fa-print fa-fw"></i> Cetak</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
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
<script type="text/javascript">
	var tableUrl = "<?= base_url('gudang/Laporan_Rutin/table_index_masuk') ?>";
	var param = {'tanggal':null,'awal':null,'akhir':null};
	$(document).ready(function(){
		reload(param);
	})
	
	function reload(p) {
		$('#table').load(tableUrl,p);
	}
	
	$('#periode').on('change',function(){
		var periode = $(this).val();
		
		if (periode == 2) {
			$('#bulan*').hide(400);
			$('#hari*').show(400);
		}else{
			$('#bulan*').show(400);
			$('#hari*').hide(400);
		}
	})
	
	$('#jenis').on('change',function(){
		var jenis = $(this).val();
		
		if (jenis == 1) {
			tableUrl = "<?= base_url('gudang/Laporan_Rutin/table_index_masuk') ?>";
		}else{
			tableUrl = "<?= base_url('gudang/Laporan_Rutin/table_index_keluar') ?>";
		}
		
		reload(param);
	})

    $('#tanggal').on('change',function () {
        var tanggal = $(this).val();
        param.tanggal = tanggal;
        reload(param);
    })

    $('#awal').on('change',function () {
        param.awal = $(this).val();
        reload(param);
    })

    $('#akhir').on('change',function () {
        param.akhir = $(this).val();
        reload(param);
    })

    $('#cetak').on('click',function() {
        var awal = $('#awal').val();
        var akhir = $('#akhir').val();
        var tanggal = $('#tanggal').val();
        window.location = tableUrl+'_cetak'+"?awal="+awal+"&akhir="+akhir+"&tanggal="+tanggal;
    })
	
</script>
