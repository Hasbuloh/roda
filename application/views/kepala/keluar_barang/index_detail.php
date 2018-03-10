<div class="container">
<div class="panel panel-default">
    <div class="panel-body">
        <h4>Detail Keluar <small><?= $header->nomor_keluar ?></small></h4>
        <div class="row">
            <div class="col-md-2">
                <ul>
                    <li><strong>Tgl.Keluar</strong></li>
                    <li><strong>Nama</strong></li>
                    <li><strong>Jenis</strong></li>
                    <li><strong>No.Sa</strong></li>
                    <li><strong>No.Polisi</strong></li>
                </ul>
            </div>
            <div class="col-md-5">
                <ul>
                    <li><?= $header->tanggal ?></li>
                    <li><strong><?= $header->nama ?></strong></li>
                    <li><?= $header->jenis == 1 ? 'NSC' : 'NJB';?></li>
                    <li><strong><?= $header->nomor_sa ?></strong></li>
                    <li><strong><?= $header->nomor_polisi?></strong></li>
                </ul>
            </div>
        </div>
        <hr>
        <table class="table table-condensed table-bordered table-hover" id="example1">
            <thead>
            <tr>
                <th>No</th>
                <th>Nomor Part</th>
                <th>Nama Part</th>
                <th>HET</th>
                <th>Disc1</th>
                <th>Disc1</th>
                <th>Netto</th>
                <th>Qty</th>
            </tr>
            </thead>
            <tdbody>
                <?php $no=1;foreach($items as $item) {?>

                    <tr>
                        <td align="center"><?= $no ?></td>
                        <td align="center"><strong><?= $item->nomor_part ?></strong></td>
                        <td align="center"><strong><?= $item->nama_part ?></strong></td>
                        <td align="right"><span style="float:left"><strong>Rp. </strong></span><?= toRP($item->harga_jual) ?></td>
                        <td align="center"><?= $item->disc1 ?></td>
                        <td align="center"><?= $item->disc2 ?></td>
                        <td align="right"><span style="float:left"><strong>Rp. </strong></span><?= toRP($item->harga_beli) ?></td>
                        <td align="center"><span class="text-mutted"><strong><?= $item->qty ?></strong></span></td>
                    </tr>
                    <?php $no++;}?>
            </tdbody>
        </table>
    </div>
    <div class="panel-footer">
     <a href="<?= base_url('kepala/Keluar_Barang')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
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