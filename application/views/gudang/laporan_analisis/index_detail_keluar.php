<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Detail Keluar <small><?= $header->nomor_part ?></small></h4>
            <div class="row">
                <div class="col-md-2">
                    <ul>
                        <li><strong>Nomor Part</strong></li>
                        <li><strong>Nama Part</strong></li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <ul>
                        <li><?= $header->nomor_part ?></li>
                        <li><?= $header->nama_part ?></li>
                    </ul>
                </div>
            </div>
            <hr>
            <table class="table table-condensed table-bordered table-hover" id="example1">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No.Keluar</th>
                    <th>Nomor SA</th>
                    <th>Jenis Keluar</th>
                    <th>Tanggal Keluar</th>
                    <th>Qty</th>
                </tr>
                </thead>
                <tdbody>
                    <?php $no=1;foreach($items as $item) {?>

                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td align="center"><strong><?= $item->nomor_keluar?></strong></td>
                            <td align="center"><strong><?= $item->nomor_sa?></strong></td>
                            <td align="center"><?= $item->jenis_keluar == '1'?'NSC':'NJB' ?></td>
                            <td align="center"><?= $item->tanggal_keluar ?></td>
                            <td align="center"><span class="text-mutted"><strong><?= $item->qty ?></strong></span></td>
                        </tr>
                    <?php $no++;}?>
                </tdbody>
            </table>
        </div>
        <div class="panel-footer">
                <a href="<?= base_url('gudang/Laporan_Analisis')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/sweetalert-master/dist/sweetalert.min.js')?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#example1').DataTable();
    })
</script>