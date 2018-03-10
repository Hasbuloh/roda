<h4>Laporan Pembelian</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i>Laporan Pembelian</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-2">
            <label for="">Bulan</label>
        </div>
        <div class="col-md-2">
            <label for="">Pembayaran</label>
        </div>
		<div class="col-md-2">
            <label for="">Supplier</label>
		</div>
        <div class="col-md-2">
            <label for="">Faktur <small class="text-danger">(Perbulan)</small></label>
        </div>
        <div class="col-md-2">

        </div>
    </div>
     <div class="row">
        <div class="col-md-2">
	        <div class="form-group">
                <input type="month" name="bulan" class="form-control" id="bulan">
            </div>
        </div>
        <div class="col-md-2">
    	     <div class="form-group">
	        	<select name="pembayaran" id="pembayaran" class="form-control">
	        		<option value="">-- Pilih Salah Satu --</option>
	        		<option value="1">Dibayar</option>
	        		<option value="0">Belum Dibayar</option>
	        	</select>
	        </div>
        </div>
		<div class="col-md-2">
			<div class="form-group">
				<select name="supplier" id="supplier" class="form-control">
					<option value="">-- Pilih Salah Satu --</option>
					<option value="1">Daya Adi Cipta</option>
					<option value="2">Non-Daya</option>
				</select>
			</div>
		</div>
         <div class="col-md-2">
             <div class="form-group">
                 <input type="month" class="form-control" id="tgl_faktur">
             </div>
         </div>
         <div class="col-md-2">

         </div>
        <div class="col-md-2">
        	<button class="btn btn-sm btn-success" id="cetak"><i class="fa fa-print fa-fw"></i> Cetak</button>
        </div>
    </div>
      <div class="row">
          <div class="col-md-2">
              <label for="">Tgl.Awal <small class="text-danger">(Bulan/Tanggal/Tahun)</small></label>
          </div>
          <div class="col-md-2">
              <label for="">Tgl.Akhir <small class="text-danger">(Bulan/Tanggal/Tahun)</small></label>
          </div>
      </div>
      <div class="row">
          <div class="col-md-2">
              <div class="form-group">
                  <input type="date" id="terima_awal" id="terima_awal" class="form-control">
              </div>
          </div>
          <div class="col-md-2">
              <div class="form-group">
                  <input type="date" id="terima_akhir" id="terima_akhir" class="form-control">
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
<script type="text/javascript">
    var param = {'bulan':null,'pembayaran':null,'supplier':null,'terima': {'awal':null,'akhir':null}, 'faktur': null};
    var tableUrl = "<?= base_url('gudang/Laporan_Pembelian/table_index')?>";

    $(document).ready(function(){
        reload(param);
    })

    function reload(p) {
        $('#table').load(tableUrl,p);
    }

    $('#pembayaran').on('change',function(){
        param.pembayaran = $(this).val();
        reload(param);
    })

    $('#bulan').on('change',function(){
        param.bulan = $(this).val();
        reload(param);
    })

    $('#supplier').on('change',function(){
        param.supplier = $(this).val();
        reload(param);
    })

    $('#terima_awal').on('change',function () {
        param.terima.awal = $(this).val();
        reload(param);
    })

    $('#terima_akhir').on('change',function() {
        param.terima.akhir = $(this).val();
        reload(param);
    })

    $('#tgl_faktur').on('change',function() {
        param.faktur = $(this).val();
        reload(param);
    })


    $('#cetak').on('click',function(){
        var bulan = $('#bulan').val();
        var pembayaran = $('#pembayaran').val();
        var tahun = $('#tahun').val();
        var supplier = $('#supplier').val();
        var awal = $('#terima_awal').val();
        var akhir = $('#terima_akhir').val();
        var faktur = $('#tgl_faktur').val();

        window.location = tableUrl+'_cetak?bulan='+bulan+'&tahun='+tahun+'&pembayaran='+pembayaran+'&supplier='+supplier+'&awal='+awal+'&akhir='+akhir+'&faktur='+faktur;
    })

</script>
