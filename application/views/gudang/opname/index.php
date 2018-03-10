<h4>Stock Opname</h4>
<hr>
<div class="panel panel-default">
<div class="panel-heading">
    <a href="javascript:void(0)" class="btn btn-sm btn-default" onclick="modalTambah()"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Opname | <a href="#" class="text text-success"><i class="fa fa-refresh fa-fw"></i>Refresh</a>
</div>
<div class="panel-body">
<div class="row">
	<div class="col-md-12">
        <div class="alert alert-warning" id="peringatan-gagal" style="display: none;">

        </div>
		<div id="table">
            <?php $this->load->view('gudang/opname/table_header') ?>
		</div>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="modal-tambah-opname" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Tambah Opname Baru</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="peringatan-gagal" style="display: none;">

        </div>
        <form role="form" id="form-tambah-opname" method="post">
        	<div class="form-group">
        		<label for="">Nomor</label>
        		<input type="text" name="nomor" id="nomor" class="form-control" readonly="">
        	</div>

        	<div class="form-group">
        		<label for="">Tanggal</label>
        		<input type="date" name="tanggal" id="tanggal" class="form-control" required>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" name="tambah_opname" id="tambah_opname_btn" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script type="text/javascript">

function modalTambah() {
	$('#modal-tambah-opname').modal('show');
	$.ajax({
		url: '<?= base_url('gudang/Opname/generate_nomor')?>',
		dataType: 'json',
		type: 'get',
		success: function(response) {
			$('#nomor').val(response.nomor_opname);
		}
	})
}

$('#form-tambah-opname').on('submit',function(event){
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '<?= base_url('gudang/Opname/insert_header')?>',
        dataType: 'JSON',
        type: 'POST',
        data: formData,
        success: function(response){
            if (response.status) {
                redirect();
            }else{
                peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Nomor urut ini sudah ada!</p>');
            }
        }
    })
})

function redirect() {
    var id = $('#nomor').val();
    window.location = '<?= base_url('gudang/Opname/update_item_opname?id=') ?>'+id;
}

function peringatan(aktif,kind,pesan) {
    if (aktif) {
        $('#peringatan-'+kind).show().html(pesan);
    }else{
        $('#peringatan-'+kind).hide().html('');
    }
}

function hapusData(id,jumlah) {
    if (jumlah > 0) {
        peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf data ini tidak bisa dihapus!</p>');
    }else{
        var alert = confirm('Apakah anda yakin?');
        if (alert) {
            $.ajax({
                url: '<?= base_url('gudang/Opname/hapus_header')?>',
                type: 'POST',
                dataType: 'JSON',
                data: {'id': id},
                success: function(data) {
                    if (data.status) {
                        reload_table();
                    }
                }
            })
        }
    }
}

</script>
