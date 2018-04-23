<table class="table table-condensed table-hover table-bordered" id="example1">
<thead>
  <tr>
    <th>No</th>
    <th>Nomor Part</th>
    <th>Nama Part</th>
    <th>Fisik</th>
    <th>Nomor Rak</th>
  </tr>
</thead>
<tbody>

</tbody>
</table>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/autocomplete/jquery.easy-autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>

<script type="text/javascript">
    var table;

    $(function(){
        table = $('#example1').DataTable({
            'ajax': '<?= base_url('gudang/Opname/table_detail?id='.$this->input->get('id')) ?>',
            'processing': true,
            'columns': [
                {className: 'no'},
                {className: 'total'},
                {className: 'total'},
                {className: 'total'},
                {className: 'total'},
            ]
        });
    })

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function HapusItem(id) {
        var notif = confirm('Apakah anda yakin?');
        if (notif) {
            $.ajax({
                url: '<?= base_url('gudang/Opname/hapus_detail')?>',
                dataType: 'JSON',
                type: 'POST',
                data: {'id': id},
                success: function(data) {
                    if (data.status) {
                        reload_table();
                    }else{
                        alert('Coba Lagi');
                    }
                }
            })
        }
    }

    function Simpan() {
        var id = '<?= $this->input->get('id')?>';
        $.ajax({
            url: '<?= base_url('gudang/Opname/update_status')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(data)
            {
                if(data.status) {
                    Redirect();
                }else{
                    alert('Coba Lagi');
                }
            }
        })
    }

    function Redirect() {
        window.location = '<?= base_url('gudang/Opname')?>';
    }
</script>
