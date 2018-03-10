<h4>Laporan Stok</h4>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Laporan Stok</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3"><label for="">Awal</label></div>
            <div class="col-md-3"><label for="">Akhir</label></div>
            <div class="col-md-3"><label for="">Klasifikasi</label></div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="date" name="bulan" id="awal" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="date" name="bulan" id="akhir" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="klasifikasi" id="klasifikasi" class="form-control">
                        <option value="">-- Pilih Satu --</option>
                        <option value="A">Apparel</option>
                        <option value="O">Oli</option>
                        <option value="S">Sparepart</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <a href="#" class="btn btn-sm btn-success" id="cetak"><i class="fa fa-print fa-fw"></i> Cetak</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="table">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>
    var param = {'awal': null,'akhir': null,'klasifikasi': null};
    var url = '<?= base_url('gudang/Laporan_Stok/table_stok')?>';

    function reload(p) {
        $('#table').load(url,p);
    }

    $('#awal').on('change',function(){
        param.awal = $(this).val();
        reload(param);
    })

    $('#akhir').on('change',function(){
        param.akhir = $(this).val();
        reload(param);
    })

    $('#klasifikasi').on('change',function(){
        param.klasifikasi = $(this).val();
        reload(param);
    })

    $('#cetak').on('click',function(){
    	var awal = $('#awal').val();
    	var akhir = $('#akhir').val();
    	var klasifikasi = $('#klasifikasi').val();
      	window.location = url+'_cetak'+"?awal="+awal+"&akhir="+akhir+"&klasifikasi="+klasifikasi;
    })
</script>
