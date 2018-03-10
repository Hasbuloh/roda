<h4>Pengelolaan Retur Barang Keluar</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    Data Retur Barang Keluar
  </div>
  <div class="panel-body">
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
<script type="text/javascript">
$(document).ready(function(){
  reload();
})
function reload() {
  $('#table').load('<?= base_url('kepala/Retur_Keluar/indexTable')?>');
}
</script>
