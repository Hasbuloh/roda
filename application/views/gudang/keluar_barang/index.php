<h4>Pengelolaan Barang Keluar</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <a href="javascript:void(0)" class="btn btn-default btn-md" id="tombol-tambah"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Keluar Barang | <a href="javascript:void(0)" class="text text-success" onclick="reload_table()"><i class="fa fa-refresh fa-fw"></i> Refresh</a>
  </div>
  <div class="panel-body" id="table">
        <?php $this->load->view('gudang/keluar_barang/table_header')?>
  </div>
</div>
<div class="modal fade" id="modal-tambah-keluar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Tambah Keluar Barang</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="peringatan-gagal" style="display:none">

        </div>
        <div class="alert alert-success" id="peringatan-berhasil" style="display:none">

        </div>
        <form role="form" method="POST" id="form-tambah-keluar">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="">Nomor Urut</label>
            <input type="text" class="form-control" name="nomor_keluar" id="nomor_keluar" placeholder="Otomatis Terisi" readonly="">
          </div>
          <div class="form-group" id="form-group-jenis">
            <label for="">Jenis Keluar</label>
            <select class="form-control" name="jenis" id="jenis" onchange="generateNoKeluar($('#jenis').val())" required autofocus="">
              <option value="">-- Pilih Salah Satu --</option>
              <option value="1">NSC</option>
              <option value="2">NJB</option>
            </select>
          </div>
          <div class="form-group" id="form-group-nomorsa">
            <label for="">Nomor SA</label>
            <input type="text" class="form-control" placeholder="Masukan Nomor SA" name="nomor_sa" required id="nomor_sa">
          </div>
          <div class="form-group" id="form-group-nomorpolisi">
            <label for="">Nomor Polisi</label>
            <input type="text" class="form-control" name="nomor_polisi" placeholder="Masukan Nomor Polisi" id="nomor_polisi">
          </div>
          <div class="form-group">
            <label for="">Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukan Nama" required id="nama">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" name="tambah_keluar" id="tambah_keluar_btn"><i class="fa fa-save fa-fw"></i>Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/bsautocomplete/jquery.autocomplete.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script>

    setInterval(function(){
        $('.alert').hide('slow');
        peringatan(false,'');
    },5000);

    $('#tombol-tambah').on('click',function() {
        $('#id').val('');
        $('#form-tambah-keluar')[0].reset();
        $('#modal-tambah-keluar').modal('show');
        $('#form-group-jenis').show();
        $('#jenis').focus();
        $.ajax({
            url: '<?= base_url('gudang/Keluar_Barang/generate_nourut')?>',
            dataType: 'JSON',
            type: 'GET',
            success: function(data) {
                $('[name="nomor_keluar"]').val(data.no);
            }
        })
    });

    $('#form-tambah-keluar').on('submit',function(event) {
        var formData = $(this).serialize();
        event.preventDefault();
        var id = $('#id').val();
        if (id == "") {
            $.ajax({
                url: '<?= base_url('gudang/Keluar_Barang/tambah_header') ?>',
                dataType: 'JSON',
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data.status) {
                        if (data.status) {
                            redirect($('[name="nomor_keluar"]').val());
                        }else{
                            peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf Nomor Urut Atau Nomor SA Sudah Ada</p>');
                            $("#form-tambah-keluar")[0].reset();
                        }
                    }

                }
            })
        }else{
            $.ajax({
               url: '<?= base_url('gudang/Keluar_Barang/edit_header') ?>',
               dataType: 'JSON',
               type: 'POST',
               data: formData,
               success: function(data) {
                   if(data.status) {
                       peringatan(true,'berhasil','<p><i class="fa fa-check-circle-o fa-fw"></i> Perubahan data disimpan</p>');
                       reload_table();
                   }
               }
            })
        }

    })

    $('#nomor_polisi').autocomplete({
        serviceUrl: '<?= base_url('gudang/Keluar_Barang/autocomplete_nomor_polisi')?>',
        dataType: 'JSON',
        noCache: true,
        type: 'POST',
        noSuggestionNotice: 'No Result',
        onSelect: function (suggestion) {
            $('#nama').val(suggestion.nama);
        },
        onSearchError: function() {
            console.log('error');
        }
    });

    $('#jenis').on('change',function(){
      var jenis = $(this).val();
      if (jenis == 2) {
          $('#form-group-nomorsa').show();
          $('#form-group-nomorpolisi').show();
          $('#nomor_polisi').attr('required',true);
          $('#nomor_sa').attr('required',true);
      }else{
          $('#form-group-nomorsa').hide();
          $('#form-group-nomorpolisi').hide();
          $('#nomor_polisi').removeAttr('required');
          $('#nomor_sa').removeAttr('required');
      }
    })

    function redirect(id) {
      window.location = '<?= base_url('gudang/Keluar_Barang/update_detail_keluar?id=')?>'+id;
    }

    function generateNoKeluar(idkeluar) {
        $.ajax({
            url: '<?= base_url('gudang/Keluar_Barang/generate_nourut')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'kode': idkeluar },
            success: function(data) {
                $('[name="nomor_keluar"]').val(data.nokel);
            }
        })
    }

    function modalEdit(id,nomor_keluar,nomor_sa,nomor_polisi,nama,jenis) {
        $('#modal-tambah-keluar').modal('show');
        $('#id').val(id);
        $('#nomor_keluar').val(nomor_keluar).attr('readonly',true);
        $('#nomor_sa').val(nomor_sa);
        $('#nomor_polisi').val(nomor_polisi);
        $('#nama').val(nama);
        $('#jenis').val(jenis);
        $('#form-group-jenis').hide();
        if (jenis = 1) {
            $('#nomor_sa').removeAttr('required');
            $('#nomor_polisi').removeAttr('required');
        }else{
            $('#nomor_sa').attr('required',true);
            $('#nomor_polisi').attr('required',true);
        }
    }


    function hapusData(id,jumlah) {
        if (jumlah > 0) {
            peringatan(true,'gagal','<p><i class="fa fa-warning fa-fw"></i> Maaf anda tidak diperkenankan untuk menghapus data ini! </p>');
        }else{
            var alert = confirm('Apakah anda yakin?');
            if (alert) {
                $.ajax({
                    url: '<?= base_url('gudang/Keluar_Barang/hapus')?>',
                    dataType: 'JSON',
                    type: 'POST',
                    data: {'id': id},
                    success: function(data) {
                        reload_table();
                    }
                })
            }
        }
    }

    function peringatan(aktif,kind,pesan) {
        if (aktif) {
            $('#peringatan-'+kind).show('400').html(pesan);
        }else{
            $('#peringatan-'+kind).hide('400').html('');
        }
    }

</script>
