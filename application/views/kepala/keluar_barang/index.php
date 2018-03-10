<h4>Pengelolaan Rak Penyimpanan</h4>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
       Data Keluar Barang
    </div>
    <div class="panel-body" id="table">
        <?php $this->load->view('kepala/keluar_barang/table_index'); ?>
    </div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script>


    function Unlock(id) {
        var warn = confirm('Apakah anda yakin?');
        $.ajax({
            url: '<?= base_url('kepala/Keluar_Barang/update_status')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(data) {
                if (data.status) {
                    reload();
                }else{
                    alert('Kesalahan Jaringan, Coba Lagi');
                }
            }
        })
    }

</script>
