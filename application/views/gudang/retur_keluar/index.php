<h4>Pengelolaan Retur Barang Keluar</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="#" class="btn btn-sm btn-default" id="tambah-btn"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Retur Barang Keluar | <a href="#" class="text text-success" id="refresh-btn"><i class="fa fa-refresh fa-fw"></i> Refresh</a>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
            <div id="table">
                <?php $this->load->view('gudang/retur_keluar/table_index')?>
            </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal Tambah Retur</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success peringatan-berhasil" style="display:none">

        </div>
        <div class="alert alert-danger peringatan-gagal" style="display:none">

        </div>
        <form role="form" method="POST" id="form-tambah-retur">
            <div class="form-group">
                <label for="">Nomor</label>
                <input type="text" class="form-control" name="nomor_retur" id="nomor_retur" placeholder="Nomor retur" readonly required>
            </div>
            <div class="form-group">
                <label for="">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal Retur" required>
            </div>
            <div class="form-group">
                <label for="">Nomor SA</label>
                <input type="nomor" class="form-control" id="autocomplete-nsc" placeholder="Nomor SA" required>
            </div>
            <div class="form-group">
                <label for="">Nomor Keluar</label>
                <input type="nomor" class="form-control" name="nomor_keluar" id="nomor_keluar" placeholder="Nomor Keluar" required readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
            <button type="submit" name="tambah_item" id="tambah_item_btn" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>

<script type="text/javascript">
    //Button trigger modal
    $('#tambah-btn').on('click',function(event) {
        event.preventDefault();
        $('#modal-tambah').modal('show');
        nomor_urut();
    })
    //button refresh table header
    $('#refresh-btn').on('click',function(event) {
        event.preventDefault();
        reload_table();
    })

    //fungsi jquery ketika form-tambah-retur di submit
    $('#form-tambah-retur').on('submit',function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        var form = $(this);

        $.ajax({
            url: '<?= base_url('gudang/Retur_Keluar/edit_header')?>',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            beforeSend: function() {
                $('#tambah_item_btn').attr('disabled',true).html("<i class='fa fa-refresh fa-fw'></i> Menyimpan ..");
            },
            success: function(data) {
                if (data.status) {
                    reload_table();
                }
            }
        })
    })

    //fungsi ketika mengetikan karakter nomor sa
    $('#autocomplete-nsc').autocomplete({
        serviceUrl: '<?= base_url('gudang/Retur_Keluar/autocomplete_nsc')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        noSuggestionNotice: 'No Result',
        onSelect: function (suggestion) {
            $('#autocomplete-nsc').val(suggestion.nama);
            $('#nomor_keluar').val(suggestion.nomor_keluar);
        },
        onSearchError: function() {
            console.log('error');
        }
    });


    //fungsi untuk membuat nomor retur otomatis
    function nomor_urut() {
        $.ajax({
            url: '<?= base_url('gudang/Retur_Keluar/generate_nourut')?>',
            type: 'POST',
            dataType: 'JSON',
            data: {'nomor_keluar': null},
            beforeSend: function() {
                $('#nomor_retur').attr('placeholder','Mohon Tunggu ..');
            },
            success: function(data) {
                $('#nomor_retur').val(data.noretur);
            }
        })
    }
    //Mengalihkan halaman ketika form di submit
    // function redirect() {
    //     var id = $('#nomor_retur').val()
    //     window.location = '<?= base_url('gudang/Retur_Keluar/update_detail_retur?id=')?>'+id;
    // }
</script>
