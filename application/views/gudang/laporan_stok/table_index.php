<table class="table table-condensed table-bordered table-hover" id="example1">
    <thead>
    <tr>
        <th>No</th>
        <th>Nomor Part</th>
        <th>Nama Part</th>
        <th>Jenis Part</th>
        <th>Qty</th>
        <th>Awal</th>
        <th>Masuk</th>
        <th>Retur Masuk</th>
        <th>Keluar</th>
        <th>Retur Keluar</th>
        <th>Akhir</th>
        <th>Het</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
        <?php $no=1;$qty=array();$awal=array();$akhir=array();$masuk=array();$keluar=array();$rm=array();$rk=array();$het=array();$total=array();foreach($items as $item):?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $item->nomor_part?></td>
                <td><?= $item->nama_part ?></td>
                <td align="center">
                <?php
                        switch ($item->jenis_part) {
                            case "O":
                                echo "Oli";
                                break;
                            case "S":
                                echo "Sparepart";
                                break;
                            case "A":
                                echo "Apparel";
                                break;
                        }
                ?>
                </td>
                <td align="center"><?= $qty[]=$item->qty ?></td>
                <td align="center"><?= $awal[]=$item->STOK_AWAL ?></td>
                <td align="center"><?= $masuk[]=$item->QTY_IN ?></td>
                <td align="center"><?= $rm[]=$item->QTY_RM ?></td>
                <td align="center"><?= $keluar[]=$item->QTY_OUT ?></td>
                <td align="center"><?= $rk[]=$item->QTY_RK ?></td>
                <td align="center"><?= $akhir[]=$item->STOK_AKHIR ?></td>
                <td align="right"><?= toRP($het[]=$item->harga_jual) ?></td>
                <td align="right"><?= toRP($total[]=$item->TOTAL) ?></td>
            </tr>
        <?php $no++;endforeach;?>

    </tbody>
</table>
<div class="well well-sm">
    <tr>
        Total QTY : <strong><?= array_sum($qty)?></strong>, Total Stok Awal : <strong><?= array_sum($awal)?></strong>, Total QTY Masuk : <strong><?= array_sum($masuk)?></strong>, Total QTY Retur Masuk : <strong><?= array_sum($rm)?></strong>, Total QTY Keluar : <strong><?= array_sum($keluar)?></strong>, Total QTY Retur Keluar : <strong><?= array_sum($rk)?></strong>, Total QTY Akhir : <strong><?= array_sum($akhir)?></strong>, HET : <strong><?= toRP(array_sum($het))?></strong>, Total HET :  <strong><?= toRP(array_sum($total))?></strong>
    </tr>    
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#example1').DataTable();
    })
</script>