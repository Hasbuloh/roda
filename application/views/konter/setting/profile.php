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