<h4>Pengelolaan Pemesanan</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="javascript:void(0)" class="btn btn-default btn-md" onclick="showModal()"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Pemesanan | <a href="javascript:void(0)" class="text text-success" onclick="reload_table()"><i class="fa fa-refresh fa-fw"></i> Refresh</a>
  </div>
  <div class="panel-body" id="table_po">
    <?php $this->load->view('gudang/pemesanan/table_header')?>
  </div>
</div>

<div class="modal fade" id="modal-purchase-order" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Form Tambah Pemesanan</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-tambah-purchase-order" method="post">
        <div class="form-group">
            <label for="">Supplier</label>
            <select class="form-control" name="supplier" id="supplier" onchange="genNoPO($('#supplier').val())" required>
              <option value="">-- Pilih Salah Satu --</option>
              <?php foreach ($supplier as $key => $value): ?>
                <option value="<?= $value->id ?>"><?= $value->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">No.PO</label>
            <input type="text" class="form-control" name="nopo" id="nomor_po" readonly="" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" name="tambah_item" id="tambah_item_btn"><i class="fa fa-save fa-fw"></i> Simpan</button>
       </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/autocomplete/jquery.easy-autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script>

  $('#form-tambah-purchase-order').on('submit',function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      var id = $('#nomor_po').val();
      $.ajax({
          url: '<?= base_url('gudang/pemesanan/tambah_header')?>',
          dataType: 'JSON',
          type: 'POST',
          data: formData,
          success: function(data) {
              if (data.status) {
                  redirect(id);
              }
          }
      })
  })

  function showModal() {
    $('#modal-purchase-order').modal('show');
  }

  function genNoPO(kdsupplier) {
    $.ajax({
      url: '<?= base_url('gudang/pemesanan/generate_nourut')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'kode': kdsupplier},
      success: function(data){
         $('[name="nopo"]').val(data.nopo);
      }
    })
  }

  function hapusData(id,item) {
      if (item > 0) {
          peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf anda tidak bisa menghapus data ini!</p>');
      }else{
          alert = confirm('Apakah anda yakin?');
          if (alert) {
              $.ajax({
                  url: '<?= base_url('gudang/Pemesanan/hapus_header')?>',
                  dataType: 'JSON',
                  type: 'POST',
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
  function loadDataPerPO(nopo) {
    $('[name="nomor_po"]').val(nopo);
    $('#table').load('<?= base_url('gudang/pemesanan/table?nopo=')?>'+nopo, function() {
        $('.nopo').text('Data item untuk Nomor PO : '+nopo);
    });
  }

  function redirect(id) {
      window.location = '<?= base_url('gudang/Pemesanan/update_detail_pesan?id=')?>'+id;
  }

</script>
