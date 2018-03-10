<h4>Laporan Mutasi Stok</h4>
<hr>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Laporan Mutasi Stok</h3>
	</div>
	<div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <label for="">No.Part</label>
            </div>
            <div class="col-md-2">
                <label for="">Tgl.Awal</label>
            </div>
            <div class="col-md-2">
                <label for="">Tgl.Akhir</label>
            </div>
            <div class="col-md-2">
                <label for="">Klasifikasi</label>
            </div>
        </div>
		<div class="row">
			<div class="col-md-2">
			  <div class="form-group">
			    <input type="text" class="form-control" id="nomor_part" placeholder="">
			  </div>
			</div>
			<div class="col-md-2">
			  <div class="form-group">
			    <input type="date" class="form-control" id="awal" placeholder="">
			  </div>
			</div>
			<div class="col-md-2">
			  <div class="form-group">
			    <input type="date" class="form-control" id="akhir" placeholder="">
			  </div>
			</div>
            <div class="col-md-2">
                <div class="form-group">
                    <select name="klasifikasi" class="form-control" id="klasifikasi">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="O">Oli</option>
                        <option value="S">Sparepart</option>
                        <option value="A">Apparel</option>
                    </select>
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
<script>
var parameter = {'nomor':null,'awal':null,'akhir':null,'klasifikasi':null};
var tableUrl = "<?= base_url('gudang/Laporan_Mutasi/table_index')?>";

$(document).ready(function(){
    reload(parameter);
})

function reload(p) {
    $('#table').load(tableUrl,p);
}

$('#awal').on('change',function(){
    parameter.awal = $(this).val();
    reload(parameter);
})

$('#akhir').on('change',function(){
    parameter.akhir = $(this).val();
    reload(parameter);
})

$('#nomor_part').on('keyup',function(){
    parameter.nomor = $(this).val();
    reload(parameter);
})
$('#klasifikasi').on('change',function(){
    parameter.klasifikasi = $(this).val();
    reload(parameter);
})

$('#cetak').on('click',function(){
    var nomor = $('#nomor_part').val();
    var awal = $('#awal').val();
    var akhir = $('#akhir').val();
    var jenis = $('#klasifikasi').val();
    window.location = tableUrl+"_cetak"+"?nomor="+nomor+"&awal="+awal+"&akhir="+akhir+"&klasifikasi="+jenis;
})
</script>

