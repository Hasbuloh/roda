<h4>Laporan Opname</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Laporan Opname</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <label for="">Bulan</label>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <label for="">Item</label>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <label for="">No.Opname</label>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

      </div>
    </div>
    <div class="row">
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="form-group">
            <input type="month" class="form-control" name="bulan" id="bulan">
        </div>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="form-group">
          <select name="grup" id="grup" class="form-control">
            <option value="1">Semua</option>
            <option value="2">Selisih</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
          <?php $data = $this->db->query("SELECT nomor FROM tbl_headeropname")->result_object(); ?>
          <!-- <?php print_r($data) ?> -->
        <select name="nomor" id="nomor" class="form-control">
          <?php foreach ($data as $value): ?>
              <option value="<?= $value->nomor ?>"><?= $value->nomor ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-success btn-sm" name="button" id="cetak"><i class="fa fa-print fa-fw"></i> Cetak</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="table">

        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/autocomplete/jquery.easy-autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>

<script>
    var parameter = {'bulan':null,'grup':null,'nomor': null};
    var tableUrl = '<?= base_url('gudang/Laporan_Opname/table_index') ?>';

    $(document).ready(function() {
      reload();
    })

    $('#form').on('submit',function(e){
      e.preventDefault();
      var formData = $(this).serialize();
      alert(formData);
      $('#form')[0].reset();
      $('[name="nomor_part"]').focus();
    })

    function reload(p) {
      $('#table').load(tableUrl,p);
    }

    $('#grup').on('change',function(){
        parameter.grup = $(this).val();
        reload(parameter);
    })
    $('#bulan').on('change',function(){
        parameter.bulan = $(this).val();
        reload(parameter);
    })

    $('#nomor').on('change',function() {
        parameter.nomor = $(this).val();
        reload(parameter)
    })

    $('#cetak').on('click',function(){
      var grup = $('#grup').val();
      var bulan = $('#bulan').val();
      var nomor = $('#nomor').val();

      window.location = tableUrl+'_cetak?grup='+grup+'&bulan='+bulan+'&nomor='+nomor;
    })

</script>
