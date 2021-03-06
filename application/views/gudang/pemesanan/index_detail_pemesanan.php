    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Detail Pemesanan <small><?= $header->nopo ?></small></h4>
                <div class="well well-md">
                    Tanggal <strong><?= $header->tanggal_pesan ?></strong>, Supplier <strong><?= $header->supplier == 1 ? 'Daya Adi Cipta':'Non-Data';?></strong>
                </div>
                <table class="table table-condensed table-bordered table-hover" id="example1">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Part</th>
                        <th>Nama Part</th>
                        <th>Qty</th>
                        <th>HET</th>
                        <th>Disc1</th>
                        <th>Disc1</th>
                        <th>Netto</th>
                    </tr>
                    </thead>
                    <tdbody>
                        <?php $no=1;foreach($items as $item) {?>

                            <tr>
                                <td align="center"><?= $no ?></td>
                                <td align="center"><strong><?= $item->nomor_part ?></strong></td>
                                <td align="center"><strong><?= $item->nama_part ?></strong></td>
                                <td align="center"><span class="text-mutted"><strong><?= $item->qty ?></strong></span></td>
                                <td align="right"><span style="float:left"><strong>Rp. </strong></span><?= toRP($item->harga_jual) ?></td>
                                <td align="center"><?= $item->disc1 ?></td>
                                <td align="center"><?= $item->disc2 ?></td>
                                <td align="right"><span style="float:left"><strong>Rp. </strong></span><?= toRP($item->harga_beli) ?></td>
                            </tr>
                            <?php $no++;}?>
                    </tdbody>
                </table>
            </div>
            <div class="panel-footer">
             <a href="<?= base_url('gudang/Pemesanan')?>" class="btn btn-link"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a>
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
