    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Detail Keluar <small><?= $header->nomor_invoice ?></small></h4>
                <div class="row">
                    <div class="col-md-2">
                        <ul>
                            <li><strong>No.Faktur</strong></li>
                            <li><strong>Tgl.Faktur</strong></li>
                            <li><strong>Tgl.Jatuh Tempo</strong></li>
                            <li><strong>Supplier</strong></li>
                            <li><strong>Status</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <ul>
                            <li><?= $header->nomor_faktur ?></li>
                            <li><?= $header->tanggal_faktur ?></li>
                            <li><?= $header->tanggal_jt ?></li>
                            <li>
                                <?= $header->supplier == 1 ? 'Daya Adi Cipta': 'Non-Daya';?>
                            </li>
                            <li>
                                <?= $header->status_bayar == TRUE ? 'Dibayar' : 'Belum Dibayar';?>
                            </li>
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
             <a href="<?= base_url('kepala/Masuk_Barang')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
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
