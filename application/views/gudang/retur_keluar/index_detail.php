<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" role="form" id="form-tambah-item">
                    <legend class="text text-danger"><i class="fa fa-pencil fa-fw"></i> Inputkan Barang</legend>
                    <input type="hidden" name="nomor_retur" id="nomor_retur" value="<?= $this->input->get('id') ?>">
                    <input type="hidden" name="nomor_keluar" id="nomor_keluar" value="<?= $header->nomor_keluar ?>">
                    <input type="hidden" name="id_barang" id="barang">
                    <input type="hidden" name="qty_keluar" id="qty_keluar">
                    <input type="hidden" name="harga_jual" >
                    <input type="hidden" name="tanggal" id="tanggal" value="<?= $header->tanggal_nonformat ?>">
                    <div class="form-group">
                        <label for="">Nomor</label>
                        <input type="text" name="nomor_part" id="autocomplete-nomor" placeholder="Masukan Nomor Part" class="form-control" required/>
                        <div id="selection"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama_part" id="autocomplete-nama" placeholder="Masukan Nama Part" class="form-control" required/>
                        <div id="selection"></div>
                    </div>
                    <div class="alert alert-danger" id="peringatan-gagal" style="display: none;">

                    </div>
                    <div class="alert alert-success" id="peringatan-berhasil" style="display: none;">

                    </div>
                    <div class="form-group">
                        <label for="">Qty</label>
                        <input type="number" class="form-control" name="qty" id="jumlah_retur" required="" placeholder="Jumlah Retur">
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" class="form-control" placeholder="Keterangan Retur" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block btn-md" name="tambah_item" id="tambah_item_btn"><i class="fa fa-plus fa-fw"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?= base_url('gudang/Retur_Barang')?>"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a> | <a href="javascript:void(0)" class="text text-danger" onclick="Simpan('<?= $this->input->get('id') ?>')"><i class="fa fa-save fa-w"></i> Simpan</a> | <a href="<?= base_url('gudang/Retur_Barang/cetakBerita?id=').$this->input->get('id') ?>" target="_blank" class="text text-warning"><i class="fa fa-print fa-fw"></i> Cetak</a>
            </div>
            <div class="panel-body">
                <h4>Detail Retur Keluar <small><?= $this->input->get('id') ?></small></h4>
                <div class="well well-sm">
                    Tanggal <strong><?= $header->tanggal ?></strong>, Nomor SA <strong><?= $header->nomor_sa?></strong>, No.Polisi <strong><?= $header->nomor_polisi ?></strong>, Nama <strong><?= $header->nama ?></strong>
                </div>
                <div id="table">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
    var nomor_keluar = $('#nomor_keluar').val();
    $('#autocomplete-nomor').autocomplete({
        serviceUrl: '<?= base_url('gudang/Retur_Keluar/autocomplete_nomor')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        params: {'param': nomor_keluar},
        noSuggestionNotice: 'No Result',
        onSelect: function (suggestion) {
            $('#autocomplete-nama').val(suggestion.nama_part);
            $('#id_barang').val(suggestion.id);
            $('#harga').val(suggestion.harga_jual);
            $('#qty_keluar').val(suggestion.qty);
        },
        onSearchError: function() {
            console.log('error');
        }
    });

    $('#autocomplete-nama').autocomplete({
        serviceUrl: '<?= base_url('gudang/Retur_Keluar/autocomplete_nama')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        params: {'param': nomor_keluar},
        noSuggestionNotice: 'No Result',
        onSelect: function (suggestion) {
            $('#autocomplete-nomor').val(suggestion.nomor_part);
            $('#id_barang').val(suggestion.id);
            $('#harga').val(suggestion.harga_jual);
            $('#qty_keluar').val(suggestion.qty);
        },
        onSearchError: function() {
            console.log('error');
        }
    });

    $("#form-tambah-item").on('submit',function(event) {
        event.preventDefault();
        var qty_keluar = $('#qty_keluar').val();
        var qty_retur = $('#jumlah_retur').val();
        if (qty_keluar < qty_retur) {
            peringatan(true,'gagal','<i class="fa fa-warning fa-fw"></i> Jumlah retur melebihi jumlah pembelian');
        }
    })

    //javascript native
    function peringatan(status,kind,pesan) {
        if (status) {
            $('#peringatan-'+kind).show('400').html(pesan);
        }else{
            $('#peringatan-'+kind).hide('400').html('');
        }
    }

    setInterval(function(){
        $('.alert').hide('slow');
        peringatan(false,'');
    },8000);

</script>