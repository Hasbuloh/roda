<table class="table table-bordered table-condensed table-responsive" id="example1">
    <thead>
    <tr>
        <th width="7%">No</th>
        <th>No.Part</th>
        <th width="10%">Nama</th>
        <th>Qty</th>
        <th>Jenis</th>
        <th>Klasifikasi</th>
        <th>SOD</th>
        <th>HET</th>
        <th>Jumlah</th>
        <th>Disc 1</th>
        <th>Disc 2</th>
        <th>Net</th>
        <th>Jumlah Netto</th>
        <th>Rak</th>
        <th></th>
        <th></th>
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
    'ajax': '<?= base_url('gudang/Barang/table_barang')?>',
    'processing': true,
    'columns': [
      {className: 'no'},
      null,
      null,
      {className: 'total'},
      {className: 'total'},
      null,
      {className: 'total'},
      {className: 'jumlah'},
      {className: 'jumlah'},
      {className: 'total'},
      {className: 'total'},
      {className: 'jumlah'},
      {className: 'jumlah'},
      null,
      {className: 'tombol'},
      {className: 'tombol'},
    ]
  });
})

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}
</script>
