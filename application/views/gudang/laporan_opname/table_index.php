<table class="table table-condensed table-hover table-bordered" id="example1">
<thead>
  <tr>
    <th style="text-align:center;">No</th>
    <th style="text-align:center;">No.Part</th>
    <th style="text-align:center;">Nama Part</th>
    <th style="text-align:center;">Teori</th>
    <th style="text-align:center;">Fisik</th>
    <th>Keluar</th>
    <th>Masuk</th>
    <th>Retur Masuk</th>
    <th>Retur Keluar</th>
    <th style="text-align:center;">Rak</th>
    <th style="text-align:center;">Tanggal</th>
  </tr>
</thead>
<tbody>
<?php $no=1;foreach ($items as $item): ?>
  <tr>
    <td align="center"><?= $no?></td>
    <td><?= $item->nomor_part?></td>
    <td><?= $item->nama_part ?></td>
    <td align="center"><?= $item->teori?></td>
    <td align="center"><?= $item->fisik?></td>
    <td><?= $item->keluar ?></td>
    <td><?= $item->masuk ?></td>
    <td><?= $item->retur_masuk ?></td>
    <td><?= $item->retur_keluar ?></td>
    <td align="center"><span class="label label-info"><strong><?= $item->no_rak ?></strong></span></td>
    <td align="center"><?= $item->tanggal?></td>
  </tr>
<?php $no++;endforeach; ?>
</tbody>
</table>
<!-- <script type="text/javascript">
$(document).ready(function(){
	$('#example1').DataTable();
})
</script> -->
