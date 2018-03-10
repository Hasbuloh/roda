<table class="table table-condensed table-hover table-bordered" id="example1">
<thead>
	<tr>
		<th>No</th>
		<th>No.Opname</th>
		<th>Tanggal</th>
        <th>Jumlah</th>
        <th>Detail</th>
        <th>Update</th>
	</tr>
</thead>
<tbody>
	<?php
	$no=1;foreach ($items as $item) {
	?>
		<tr>
			<td align="center"><?= $no?></td>
			<td align="center"><strong><?= $item->nomor?></strong></td>
			<td align="center"><?= $item->tanggal?></td>
            <td align="center">
                <?php
                $data = $this->db->query("SELECT COUNT(id_barang) AS 'jumlah' FROM tbl_opname WHERE nomor='{$item->nomor}'")->row();
                echo $data->jumlah;
                ?>
            </td>
            <td align="center">
            	<a href="#"><i class="fa fa-search fa-fw"></i></a>
            </td>
            <td align="center">
                <?php if($item->status == FALSE):?>
                    <span><i class="fa fa-lock fa-fw"></i></span>
                <?php else:?>
                    <a href="javascript:void(0)" onclick="updateStatus('<?= $item->nomor ?>')"><i class="fa fa-lock fa-fw"></i></a>
                <?php endif;?>
            </td>
		</tr>
	<?php
	$no++;
	}
	?>
</tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('#example1').DataTable({
			 "columnDefs": [
		    { "orderable": false, "targets":[
		        0
		    ]}
   		 ]
	})
});
</script>
