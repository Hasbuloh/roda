<h4>Halaman Setting <small>Gudang</small></h4>
<hr>
<div class="container-fluid">

<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#user" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user fa-fw"></i> Pengguna</a>
        </li>
        <li role="presentation">
            <a href="#het" aria-controls="tab" role="tab" data-toggle="tab"><i class="fa fa-wrench fa-fw"></i> Update Harga</a>
        </li>
        <li role="presentation">
            <a href="#fast" aria-controls="tab" role="tab" data-toggle="tab"><i class="fa fa-wrench fa-fw"></i> Update Fast Moving</a>
        </li>
        <li role="presentation">
            <a href="#rak" aria-controls="tab" role="tab" data-toggle="tab"><i class="fa fa-wrench fa-fw"></i> Update Rak</a>
        </li>
        <li role="presentation">
            <a href="#awal" aria-controls="tab" role="tab" data-toggle="tab"><i class="fa fa-wrench fa-fw"></i> Upload Stok Awal</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
         <div role="tabpanel" class="tab-pane active" id="user">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-7">
                            <div class="row" id="profil">
                            <div class="col-md-6">
                                    <img src="<?= base_url('gambar/')?><?= $user->foto != ""?$user->foto:'lindsey.jpg';?>" class="img img-thumbnail img-responsive" alt="">
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><strong><i class="fa fa-user fa-fw"></i> Nama</strong></td><td><?= $user->nama ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fa fa-gender fa-fw"></i> Tanggal Lahir</strong></td><td><?= $user->tgl_lahir ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fa fa-gender fa-fw"></i> Jenis Kelamin</strong></td><td><?= $user->jenis_kelamin == 'L'?'Laki-laki':'Perempuan';?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fa fa-gender fa-fw"></i> Bagian</strong></td><td><span class="badge"><?= $user->bagian ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="alert alert-info" style="display:none;" id="peringatan-update-profil">
                                
                            </div>
                            <form role="form" id="form-update-profil" method="POST" enctype="multipart/form-data">
                                <legend>Update Data Pengguna</legend>
                            
                                <div class="form-group">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="nama">
                                </div>
                            
                                <div class="form-group">
                                    <label for="">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir">
                                </div>

                                <div class="form-group">
                                    <label for="">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                        <option value="">-- Salah Satu --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept=".jpg">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" name="username" class="form-control" id="username">
                                </div>

                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <div class="form-group">
                                <button type="submit" name="update_user" id="update_user_btn" class="btn btn-info btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
                                </div>
                            </form>
                            
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="het">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info" id="peringatan-update-het" style="display:none">

                                </div>
                                <form method="post" role="form" id="form-update-het" enctype="multipart/form-data">
                                    <legend>Update Kenaikan Het</legend>
                                    <div class="form-group">
                                            <label for="">File (Excel)</label>
                                            <input type="file" name="excel_het_file" id="excel_het_file" required accept=".xlsx" class="form-control">
                                    </div>
                                    <div class="form-group">
                                            <button type="submit" name="import_excel_het" id="import_excel_het_btn" class="btn btn-primary btn-sm"><i class="fa fa-upload fa-fw"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="fast">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info peringatan-fast-moving" style="display: none;">

                                </div>
                               <form role="form">
                                    <legend>Update Angka Fast Moving</legend>
                                   <div class="form-group">
                                    <label for="">Angka Fast Moving</label>
                                    <?php $data = $this->db->query("SELECT * FROM tbl_klasifikasi")->row() ?>
                                    <input type="number" name="angka" class="form-control" placeholder="<?= $data->jumlah ?>">
                                   </div>
                                   <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="setFastMoving()"><i class="fa fa-save fa-fw"></i> Simpan</button>
                                   </div>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="awal">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="alert alert-info" id="peringatan-upload-stok" style="display: none;">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum quas corporis reprehenderit itaque, error assumenda quo, placeat blanditiis perferendis tempora minus eos beatae. Architecto tenetur praesentium tempore consectetur fuga vitae!</p>
                            </div>
                            <form role="form" method="post" id="form-stok-awal" enctype="multipart/form-data">
                                    <legend>Upload Stok Awal</legend>
                                    <div class="form-group">
                                        <label for="">File (Excel)</label>
                                        <input type="file" class="form-control" id="excel_stok_file" name="excel_stok_file" required accept=".xlsx" placeholder="Input field">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="import_excel_stok" id="import_excel_stok_btn" class="btn btn-primary btn-sm"><i class="fa fa-upload fa-fw"></i> Upload</button>
                                    </div>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="rak">
          <div class="row">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-info" id="peringatan-update-rak" style="display:none;">

                    </div>
                    <form role="form" id="form-update-rak" method="post" enctype="multipart/form-data">
                      <legend>Form Update Rak</legend>
                      <div class="form-group">
                        <label for="">File (Excel)</label>
                        <input type="file" required accept=".xlsx" name="excel_rak_file" id="excel_rak_file" placeholder="Masukan File Excel" class="form-control">
                      </div>
                      <div class="form-group">
                        <button type="submit" name="import_excel_rak" id="import_excel_rak_btn" class="btn btn-primary btn-sm"><i class="fa fa-upload fa-fw"></i> Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script>

     $(function(){
        $.ajax({
            url: '<?= base_url('gudang/Setting/ambil_user') ?>',
            dataType: 'JSON',
            success: function(data) {
                $("#nama").val(data.nama);
                $("#tgl_lahir").val(data.tgl_lahir);
                $("#jenis_kelamin").val(data.jenis_kelamin);
                $("#username").val(data.username);
                $("#password").val(data.password);
            }
        })
    })

    $('#form-update-profil').on('submit',function(event){
        event.preventDefault();
        $.ajax({
            url: '<?= base_url('gudang/Setting/update_user') ?>',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#update_user_btn').attr('disabled',true);
                $('#update_user_btn').html('<i class="fa fa-refresh fa-fw"></i> Menyimpan ..');
            },
            success: function(data) {
                $('#peringatan-update-profil').show().html('<i class="fa fa-warning fa-fw"></i> Profil Berhasil Diperbaharui');
                $('#update_user_btn').html('Selesai');
                $('#update_user_btn').attr('disabled',false);
                $('#update_user_btn').html('<i class="fa fa-save fa-fw"></i> Simpan');
                $('#profil').load('<?= base_url('gudang/setting/load_profil')?>');
                $('#foto').val('');
            }
        })
    })

    setInterval(function(){
        $('.alert').hide('slow');
    },5000);

    $('#form-update-rak').on('submit',function(event) {
      event.preventDefault();
      $.ajax({
        url: '<?= base_url('gudang/Barang/update_rak')?>',
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('#import_excel_rak_btn').attr('disabled',true);
            $('#import_excel_rak_btn').html('<i class="fa fa-refresh fa-fw"></i> Memproses ..');
        },
        success: function(data) {
            $('#form-update-rak')[0].reset();
            $('#import_excel_rak_btn').attr('disabled',false);
            $('#import_excel_rak_btn').html('Update Selesai');
            $('#peringatan-update-rak').show().html('<p><i class="fa fa-warning fa-fw"></i> Update Rak Berhasil</p>');
            $('#import_excel_rak_btn').html('<i class="fa fa-upload fa-fw"></i> Update');
        }
      })
    })

    $('#form-update-het').on('submit',function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?= base_url('gudang/Barang/update_het');?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#import_excel_het_btn').attr('disabled',true);
                $('#import_excel_het_btn').html('<i class="fa fa-refresh fa-fw"></i> Memproses ..');
            },
            success: function(data) {
                $('#form-update-het')[0].reset();
                $('#import_excel_het_btn').attr('disabled',false);
                $('#import_excel_het_btn').html('Update Selesai');
                $('#peringatan-update-het').show().html('<p><i class="fa fa-warning fa-fw"></i> Update Kenaikan Het Berhasil</p>');
                $('#import_excel_het_btn').html('<i class="fa fa-upload fa-fw"></i> Update');
            }

        })
    })

    $('#form-stok-awal').on('submit',function(event) {
        event.preventDefault();
        // $('#peringatan-upload-stok').show().html('sdasdadsa');
        $.ajax({
            url: '<?= base_url('gudang/Barang/stok_awal'); ?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#import_excel_stok_btn').attr('disabled',true);
                $('#import_excel_stok_btn').html('<i class="fa fa-refresh fa-fwa"></i> Memproses ..');
            },
            success: function(data) {
                $('#peringatan-upload-stok').show().html('<p><i class="fa fa-warning fa-fw"></i> Entry Stok Awal Berhasil, Data ('+data.jumlah+')</p>');
                $('#form-stok-awal')[0].reset();
                $('#import_excel_stok_btn').attr('disabled',false);
                $('#import_excel_stok_btn').html('Update Selesai');
                // $('#peringatan-upload-stok').show();
                $('#import_excel_stok_btn').html('<i class="fa fa-upload fa-fw"></i> Upload');
            }
        })
    })

    function setFastMoving() {
        $.ajax({
          url: '<?= base_url('gudang/Barang/setting_fast_moving') ?>',
          dataType: 'JSON',
          type: 'POST',
          data: {'jumlah': $('[name="angka"]').val(),'id': 1},
          success: function(data) {
            if (data.status) {
                    $('.peringatan-fast-moving').show().html('<p><i class="fa fa-warning fa-fw"></i> Update Angka Berhasil</p>');
                    $('[name="angka"]').attr('placeholder',data.jumlah)
                }
              }
        })
    }

</script>
