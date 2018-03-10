<h4>Halaman Setting <small>Keuangan</small></h4>
<hr>
<div class="container-fluid">

<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#user" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user fa-fw"></i> Pengguna</a>
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
    </div>
</div>

</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script>
    $(function(){
        $.ajax({
            url: '<?= base_url('konter/Setting/ambil_user') ?>',
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
            url: '<?= base_url('konter/Setting/update_user') ?>',
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
                $('#profil').load('<?= base_url('konter/setting/load_profil')?>');
                $('#foto').val('');
            }
        })
    })

    setInterval(function(){
        $('.alert').hide('slow');
    },1000);

</script>