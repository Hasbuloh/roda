<div class="row">
    <div class="col-md-12">
        <h4>Masuk Barang</h4>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Masuk Barang</h3>
            </div>
            <div class="panel-body">
                <div id="table">

                </div>
            </div>
            <div class="panel-footer">

            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script>
    $(document).ready(function(){
        reload();
    })

    function reload() {
        $('#table').load('<?= base_url('kepala/Masuk_Barang/table_masuk')?>');
    }

 
  
</script>
