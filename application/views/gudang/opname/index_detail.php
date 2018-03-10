<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form role="form" method="post" id="form-tambah-item">
                    <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i>Inputkan Barang</legend>
                    <div class="alert alert-danger" id="peringatan-gagal" style="display: none;">

                    </div>
                    <div class="alert alert-success" id="peringatan-berhasil" style="display: none;">

                    </div>
                    <input type="hidden" name="id_barang" id="id_barang">
                    <input type="hidden" name="nomor" value="<?= $this->input->get('id')?>">
                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                    <input type="hidden" name="qty_teori" id="qty">
                    <div class="form-group">
                        <label for="">Nomor</label>
                        <input type="text" name="nomor_part" id="autocomplete-nomor" placeholder="Masukan Nomor Part" class="form-control" required/>
                        <div id="selection"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama_part" id="autocomplete-nama" placeholder="Masukan Nama Part" class="form-control" required readonly="" />
                        <div id="selection"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Qty Fisik</label>
                        <input type="number" class="form-control" name="qty_fisik" id="qty_fisik" required placeholder="Masukan QTY">
                    </div>
                    <div class="form-group">
                        <label for="">No.Rak</label>
                        <input type="text" class="form-control" name="nomor_rak" id="nomor_rak" required placeholder="Masukan Nomor Rak">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="tambah_item" id="tambah_item_btn" class="btn btn-block btn-info btn-md"><i class="fa fa-plus fa-fw"></i> Tambah</button>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <a href="<?= base_url('gudang/Opname')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                        <h4>Detail Opname <small><?= $this->input->get('id') ?></small></h4>
                <div class="well well-sm">
                    Tanggal <strong><?= $header->tanggal ?></strong>
                </div>
                <hr>
                <div id="table">
                    <?php $this->load->view('gudang/opname/table_detail')?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>

<script>
    $(document).ready(function() {
      $('#autocomplete-nomor').focus();
    })

    setInterval(function(){
        $('.alert').hide('slow');
        peringatan(false,'');
    },5000);

    $('#autocomplete-nomor').autocomplete({
        serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nomor')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        noSuggestionNotice: 'No Result',
        showNoSuggestionNotice: true,
        onSelect: function (suggestion) {
            $('#autocomplete-nama').val(suggestion.nama_part);
            $('#id_barang').val(suggestion.id);
            $('#qty').val(suggestion.qty);
            $('#nomor_rak').val(suggestion.nomor_rak);
        },
        onSearchError: function() {
            console.log('error');
        }
    });

    $('#autocomplete-nama').autocomplete({
        serviceUrl: '<?= base_url('gudang/Barang/autocomplete_nama')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        noSuggestionNotice: 'No Result',
        onSelect: function (suggestion) {
            $('#autocomplete-nomor').val(suggestion.nomor_part);
            $('#id_barang').val(suggestion.id);
            $('#qty').val(suggestion.qty);
            $('#nomor_rak').val(suggestion.nomor_rak);
        },
        onSearchError: function() {
            console.log('error');
        }
    });

    $('#form-tambah-item').on('submit',function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var qty = $('#qty_fisik').val();
        if (qty < 1) {
            peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Qty tidak boleh 0</p>');
            reload_table();
            $('#qty_fisik').focus();
        }else{
            $.ajax({
                url: '<?= base_url('gudang/Opname/insert_detail')?>',
                dataType: 'JSON',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        reload_table();
                        $('#form-tambah-item')[0].reset();
                        $('#autocomplete-nomor').focus();
                    }else{
                        peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Item ini sudah ada!</p>');
                        $('#form-tambah-item')[0].reset();
                        $('#autocomplete-nomor').focus();
                    }
                }
            })
        }
    })

    function peringatan(aktif,kind,pesan) {
        if (aktif) {
            $('#peringatan-'+kind).show().html(pesan);
            $('#tambah_item_btn').attr('disabled',true);
        }else{
            $('#peringatan-'+kind).hide().html('');
            $('#tambah_item_btn').removeAttr('disabled');
        }
    }

</script>
