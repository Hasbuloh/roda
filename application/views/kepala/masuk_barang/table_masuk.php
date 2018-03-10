<table class="table table-condensed table-responsive table-bordered" id="example1">
    <thead>
    <tr>
        <th style="text-align:center;">No</th>
        <th style="text-align:center;">Faktur</th>
        <th style="text-align:center;">Masuk</th>
        <th style="text-align:center;">Jumlah</th>
        <th style="text-align:center;">Tanggal Faktur</th>
        <th style="text-align:center;">Jatuh Tempo</th>
        <th style="text-align:center;">Supplier</th>
        <th style="text-align:center;">Status</th>
        <th style="text-align: center;">Detail</th>
        <th style="text-align: center;">Update</th>
    </tr>
    </thead>
    <tbody>
   
    </tbody>
</table>

<script type="text/javascript">
    var table;
    $(document).ready(function() {
        table = $('#example1').DataTable({
            'ajax' : '<?= base_url('kepala/Masuk_Barang/table_masuk1')?>',
            'processing': true,
            'columns': [
                    {className: 'no'},
                    {className: 'no'},
                    {className: 'total'},
                    {className: 'jumlah'},
                    {className: 'total'},
                    {className: 'total'},
                    {className: 'total'},
                    {className: 'total'},
                    {className: 'total'},
                    {className: 'total'},
            ]
        });
    })

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function updateStatus(id) {
        var konfir = confirm('Apakah anda yakin?');
        if (konfir) {
          $.ajax({
            url: '<?= base_url('kepala/Masuk_Barang/update_status')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(e) {
                if (e.status) {
                    reload();
                }
            }
          })
        }
    }

</script>
