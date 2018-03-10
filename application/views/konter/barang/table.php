<table class="table table-condensed tabel-hover table-bordered table-responsive" id="example1">
    <thead>
    <tr>
        <th>No</th>
        <th>Nomor Part</th>
        <th>Nama</th>
        <th>Qty</th>
        <th>Jenis</th>
        <th>Klasifikasi</th>
        <th>SOD</th>
        <th>HET</th>
        <th>Jumlah</th>
        <th>Disc1</th>
        <th>Disc2</th>
        <th>Net</th>
        <th>Jumlah</th>
        <th>Rak</th>
    </tr>
    </thead>
    <tbody>


    </tbody>
</table>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/maskmoney/jquery.maskMoney.min.js');?>"></script>
<script>
    var table;

    $(function(){
        table = $('#example1').DataTable({
            'ajax': '<?= base_url('konter/barang/table_barang')?>',
            'processing': true,
        })
    })

</script>