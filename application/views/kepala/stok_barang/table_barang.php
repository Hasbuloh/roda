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
            <th>Net</th>
            <th>Jumlah</th>
            <th>Rak</th>
            <th>Edit</th>
            <th>Hapus</th>
            <th>Unlock</th>
        </tr>
    </thead>
    <tbody>

   
    </tbody>
</table>

<div class="modal fade" id="modal-id">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success peringatan" style="display:none">
        </div>
        <form role="form" method="POST" id="form">
          <input type="hidden" name="id">
          <div class="form-group">
            <label for="">No.Part</label>
            <input type="text" class="form-control" placeholder="Nomor Part" name="nomor_part" required="">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="">Nama</label>
            <input type="text" class="form-control" placeholder="Nama Part" name="nama_part" required="">
            <span class="help-block"></span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Jenis Part</label>
                <select name="jenis_part" class="form-control">
                  <option value="">-- Pilih Salah Satu --</option>
                  <option value="S">Sparepart</option>
                  <option value="O">Oli</option>
                  <option value="A">Apparel</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label for="">Qty</label>
              <input type="number" class="form-control" placeholder="Qty" name="qty">
              <span class="help-block"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="">HET Rp.</label>
            <input type="text" class="form-control" placeholder="Harga Eceran Tertinggi" name="harga_jual" min="0"  id="het" onkeyup="disc()">
            <span class="help-block"></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Discount 1 %</label>
                <input type="number" class="form-control" placeholder="Discount 1" name="disc1" id="disc1" onkeyup="disc()" value="0" min="0">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Discount 2 %</label>
                <input type="number" class="form-control" placeholder="Discount 2" name="disc2" id="disc2" onkeyup="disc()" value="0" min="0">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
          <input type="hidden" id="setdisc1">
          <input type="hidden" id="setdisc2">
          <div class="form-group danger">
            <label for="">Netto</label>
            <input type="text" id="netto" class="form-control" name="harga_beli" id="netto" readonly="">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="">Rak Penyimpanan</label>
            <input type="text" class="form-control" placeholder="Rak" min="0" name="no_rak">
            <span class="help-block"></span>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="dataSave()">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-setting">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal Setting Fast Moving</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-setting">
          <div class="form-group">
            <label for="">Setting Jumlah</label>
            <input type="number" class="form-control" name="jumlah">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveSetting()"><i class="fa fa-save fa-fw"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>


<script>
    var table;

    $(function(){
            table = $('#example1').DataTable({
            'ajax': '<?= base_url('kepala/Stok_Barang/table_barang')?>',
            'processing': true,
        })    
    })
    

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }
</script>