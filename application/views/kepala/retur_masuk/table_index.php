<table class="table table-condensed table-bordered" id="example1">
    <thead>
      <tr>
        <th>No</th>
        <th>No.Retur</th>
        <th>Tanggal Retur</th>
        <th>Tanggal Penggantian</th>
        <th>Item</th>
        <th>Total</th>
        <th>Detail</th>
        <th>Cetak</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1;foreach ($items as $key => $item): ?>
        <tr>
<!--            --><?php //print_r($item);?>
          <td align="center"><?= $no ?></td>
          <td align="center">
              <strong><?= $item->nomor_retur ?></strong>
          </td>
          <td align="center"><?= $item->tanggal_retur ?></td>
          <td align="center"><?= $item->tanggal_penggantian==NULL ? '<span class="text-danger">Belum ada penggantian</span>':$item->tanggal_penggantian; ?></td>
          <?php $data = $this->db->query("SELECT SUM(qty) AS 'qty',SUM(harga*qty) AS 'jumlah' FROM tbl_retur WHERE nomor_retur = '{$item->nomor_retur}'")->row() ?>
          <td align="center"><?= $data->qty?></td>
          <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP($data->jumlah)?></strong></td>
          <td align="center">
            <a href="<?= base_url('kepala/Retur_Masuk/detail_retur?id='.$item->nomor_retur )?>"><i class="fa fa-search fa-fw"></i></a>
          </td>
          <td align="center"><a href="<?= base_url('kepala/Retur_Masuk/cetakBerita?id=').$item->nomor_retur ?>" target="_blank" class="btn btn-link btn-xs"><i class="fa fa-print fa-fw"></i></a></td>
            <td align="center">
                <?php if($item->status == (bool) FALSE):?>
                    <span><i class="fa fa-lock fa-fw"></i></span>
                <?php else:?>
                    <a href="javascript:void(0)" onclick="updateStatus('<?= $item->nomor_retur ?>')"><i class="fa fa-lock fa-fw"></i></a>
                <?php endif;?>
            </td>
        </tr>
      <?php $no++;endforeach; ?>
    </tbody>
</table>
</div>

<div class="modal fade" id="modal-penggantian" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Modal Penggantian Retur</h4>
      </div>
      <div class="modal-body">
        <form class="" role="form" id="form">
          <div class="form-group">
            <label for="">No.Retur</label>
            <input type="text" class="form-control" name="nomor_retur" readonly="">
          </div>
          <div class="form-group">
            <label for="">Tanggal Penggantian</label>
            <input type="text" class="form-control" name="tanggal" id="datepicker1" placeholder="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="simpanPenggantian()" data-dismiss="modal"><i class="fa fa-save fa-fw"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>
    $('#datepicker1*').datepicker({
        format: 'dd-mm-yyyy',
        showOtherMonths: true,
        selectOtherMonths: true
    });

  $(document).ready(function(){
    $('#example1').DataTable();
  })

  function showModal() {
    $('#modal-id').modal('show');
    $('#form-retur')[0].reset();
    document.getElementById('datePicker').valueAsDate = new Date();
    $.ajax({
      url: '<?= base_url('kepala/Retur_Masuk/generateNoRetur')?>',
      dataType: 'JSON',
      type: 'GET',
      success: function(data) {
        $('[name="nomor_retur"]').val(data.no)
      }
    })
  }

  function modalDetail() {
    $('#modal-detail').modal('show');
  }

  function penggantian(nomor) {
    $('[name="nomor_retur"]').val(nomor);
    $('#modal-penggantian').modal('show');
  }

  function simpanPenggantian() {
    var formData = $('#form').serialize();
    $.ajax({
      url: '<?= base_url('kepala/Retur_Masuk/bayar_penggantian')?>',
      dataType: 'JSON',
      type: 'POST',
      data: formData,
      success: function(data) {
        if (data.status) {
          reload();
        }
      }
    })
  }

  function updateStatus(id) {
    $.ajax({
      url: '<?= base_url('kepala/Retur_Masuk/update_status_1')?>',
      dataType: 'JSON',
      type: 'POST',
      data: {'id': id},
      success: function(e) {
        if (e.status) {
          reload();
        }else{
          alert('Kesalahan Jaringan');
        }
      }
    })
  }

</script>
