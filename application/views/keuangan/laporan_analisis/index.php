<h4>Laporan Analisis</h4>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Laporan Analisis</h4>
    </div>
    <div class="panel-body">
    <div class="row" style="text-align:left;">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label for="">Pilih Laporan</label>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label for="">Kategori Barang</label>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label for="">Tanggal Awal <small class="text-danger">(Bulan/Tanggal/Tahun)</small></label>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label for="">Tanggal Akhir <small class="text-danger">(Bulan/Tanggal/Tahun)</small></label>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label for="">Urut Berdasar</label>
        </div>
    </div>
	<div class="row">
    <form action="" method="POST" role="form">



            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <select class="form-control" name="jenis" id="jenis">
                    <option value="0">Stok Barang</option>
                    <option value="1">Barang Keluar</option>
                    <option value="2">Barang Masuk</option>
                    <option value="3">Tidak Bermutasi</option>
                </select>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <select class="form-control" name="kategori" id="kategori">
                  <option value="">-- Pilih Salah Satu --</option>
                  <option value="A">Apparel</option>
                  <option value="O">Oli</option>
                  <option value="S">Sparepart</option>
                  <option value="">Semua</option>
                </select>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                    <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal">
                </div>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                    <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir">
                </div>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <select class="form-control" name="urutan" id="urutkan">
                <option value="">-- Pilih Salah Satu --</option>
                <option value="1">Quantity Terbanyak</option>
                <option value="2">Jumlah Terbesar</option>
                </select>
            </div>
    </form>
   </div>



    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            	<a href="#" class="btn btn-success btn-sm" id="cetak"><i class="fa fa-print fa-fw"></i> Export Excel</a>
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
    <div class="panel-footer">

    </div>
</div>


<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>

var parameter = {'jenis':null,'awal':null,'akhir':null,'kategori':null,'urut':null};
var tableUrl = "<?= base_url('keuangan/Laporan_Analisis/stok_barang')?>";

$(document).ready(function(){
    parameter.awal = $('#awal').val();
    reload(parameter);
})

Date.prototype.toDateInputValue = (function() {
      var local = new Date(this);
      local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
      return local.toJSON().slice(0,10);
});

document.getElementById('awal').value = new Date().toDateInputValue();

function reload(p) {
    $('#table').load(tableUrl,p);
}

function cetak(p) {

}

$('#jenis').on('change',function(){
    var jenis = $(this).val();
    if (jenis == 0) {
        tableUrl = "<?= base_url('keuangan/Laporan_Analisis/stok_barang')?>";
        enable_input();
    }
    else if (jenis == 1) {
        tableUrl = "<?= base_url('keuangan/Laporan_Analisis/keluar_barang')?>";
        enable_input();
    }else if (jenis == 2) {
        tableUrl = "<?= base_url('keuangan/Laporan_Analisis/masuk_barang')?>";
        enable_input();
    }else{
        tableUrl = "<?= base_url('keuangan/Laporan_Analisis/tidak_bermutasi')?>";
        enable_input();
    }
    reload();
})

$('#kategori').on('change',function(){
    parameter.kategori = $(this).val();
    reload(parameter);
})

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

$('#urutkan').on('change',function(){
    parameter.urut = $(this).val();
    reload(parameter);
})

$('#cetak').on('click',function(){
  var jenis = $('#jenis').val();
  var awal = $('#awal').val();
  var akhir = $('#akhir').val();
  var kategori = $('#kategori').val();
  var nomor = $('#nomor_part').val()
  var urut = $('#urutkan').val();
  window.location = tableUrl+'_cetak'+"?awal="+awal+"&akhir="+akhir+"&kategori="+kategori+"&jenis="+jenis+"&urut="+urut;
})

function disabled_input() {
  $('#awal,#akhir,#nomor_part,#urutkan,#kategori').attr('disabled','TRUE');
}

function enable_input() {
  $('#awal,#akhir,#nomor_part,#urutkan,#kategori').removeAttr('disabled');
}
</script>
