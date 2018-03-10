<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$title.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table class="table table-condensed table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>
		<th>Klasifikasi</th>
		<th>Stok Awal</th>
		<th>Mutasi Masuk</th>
		<th>Mutasi Keluar</th>
		<th>Stok Akhir</th>
	</tr>
</thead>
<tbody>
	<?php error_reporting(0);$no=1;$awal=array();$masuk=array();$akhir=array();foreach($items as $item): ?>
        <?php error_reporting(0);$query_akhir = $this->db->query("select tbl_stok.jenis_part,SUM(tbl_pembelian.qty*tbl_stok.harga_beli) AS 'mutasi_masuk' from tbl_pembelian inner join tbl_stok on tbl_pembelian.id_barang = tbl_stok.id where tbl_stok.jenis_part = '{$item->jenis_part}' AND DATE_FORMAT(tbl_pembelian.tanggal_masuk,'%m-%Y') = '{$item->tanggal}' group by tbl_stok.jenis_part")->row();
        // print_r($query_awal);

        ?>

        <?php error_reporting(0);$query_awal = $this->db->query("select tbl_stok.jenis_part,SUM(tbl_keluar.qty*tbl_stok.harga_beli) AS 'mutasi_keluar' from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id where tbl_stok.jenis_part = '{$item->jenis_part}' AND DATE_FORMAT(tbl_keluar.tanggal_keluar,'%m-%Y') = '{$item->tanggal}' group by tbl_stok.jenis_part")->row();
        // print_r($query_awal);
        ?>
		<tr>
			<td align="center"><?= $no ?></td>
			<td align="center">
				<?php
				switch ($item->jenis_part) {
					case 'A':
						echo "Apparel";
						break;
					case 'S':
						echo "Sparepart";
						break;
					case 'O':
						echo "Oli";
						break;

					default:
						echo "Undifined";
						break;
				}
				?>
			</td>
			<td align="right"><span style="float:left"><strong>
                <?php echo toRP($awal[]=$item->stok_akhir+$query_awal->mutasi_keluar-$query_akhir->mutasi_masuk)?>
            </td>
			<td align="right"><span style="float:left"><strong>
                <?php   echo $query_akhir->mutasi_masuk == ""?"0":toRP($masuk[]=$query_akhir->mutasi_masuk);?>
			</td>
			<td align="right"><span style="float:left"><strong>
                <?php echo $query_awal->mutasi_keluar == ""?"0":toRP($keluar[]=$query_awal->mutasi_keluar);?>
			</td>
			<td align="right"><span style="float:left"><strong>
                <?= toRP($akhir[]=$item->stok_akhir) ?>
			</td>
		</tr>
	<?php $no++;endforeach;?>
	<tr>
		<td colspan="2" align="center"><strong>Total</strong></td>
		<td align="right"><?php echo toRP(array_sum($awal)) ?></td>
		<td align="right"><?php echo toRP(array_sum($masuk)) ?></td>
		<td align="right"><?php echo toRP(array_sum($keluar)) ?></td>
		<td align="right"><?php echo toRP(array_sum($akhir)) ?></td>
	</tr>
</tbody>
</table>
