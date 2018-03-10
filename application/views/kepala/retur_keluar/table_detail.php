<div class="container">
<div class="panel panel-default">
    <div class="panel-body">
        <h4>Detail Retur Barang Masuk <small><strong><?= $header->nomor_retur ?></strong></small></h4>
        <div class="row">
            <div class="col-md-3">
                <ul>
                    <li><strong>Tgl.Retur</strong></li>
                    <li><strong>Supplier</strong></li>
                    <li><strong>Status Penggantian</strong></li>
                    <li><strong>Total</strong></li>
                </ul>
            </div>
            <div class="col-md-5">
                <ul>
                    <li><?= $header->tanggal_retur ?></li>
                    <li><?= $header->supplier == 1 ? 'Daya Adi Cipta':'Non-Daya'; ?></li>
                    <li><?= $header->status_bayar == TRUE ? 'Diganti':'Belum Diganti'; ?></li>
                    <li>Rp. <strong><?= toRP($header->jumlah)?></strong></li>
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
            <tbody>
                <?php $no=1;foreach ($items as $item): ?>
                    <tr>
                        <td align="center"><?= $no;?></td>
                        <td align="center"><strong><?= $item->nomor_part ?></strong></td>
                        <td align="center"><strong><?= $item->nama_part ?></strong></td>
                        <td align="right"><?= toRP($item->harga_jual) ?></td>
                        <td align="center"><?= $item->disc1 ;?></td>
                        <td align="center"><?= $item->disc2 ;?></td>
                        <td align="right"><?= toRP($item->harga_beli) ;?></td>
                        <td align="center"><?= $item->qty ;?></td>
                    </tr>
                <?php $no++;endforeach ?>
            </tbody>
        </table>
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