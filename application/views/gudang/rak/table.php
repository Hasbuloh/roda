<table class="table table-bordered table-condensed" id="example1">
  <thead>
    <tr>
      <th style="text-align:center;width:60px;">No</th>
      <th>Nama Rak</th>
      <th style="text-align:center;width:100px;">Jumlah Item</th>
      <th>Deskripsi</th>
      <th style="text-align:center;width:100px;">Edit</th>
      <th style="text-align:center;width:100px;">Hapus</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1;foreach($items->result_object() as $item): ?>
      <tr>
        <td align="center"><?= $no ?></td>
        <td><a href="#"><?= $item->no_rak ?></a></td>
        <td align="center"><p class="label label-success">10</p></td>
        <td><?= $item->deskripsi ?></td>
        <td width="10%" align="center"><a href="javascript:void(0)" onclick="showModal(<?= $item->id ?>,'<?= $item->no_rak ?>','<?= $item->deskripsi ?>')"><i class="fa fa-pencil fa-fw text-warning"></i></a></td>
        <td width="10%" align="center"><a href="javascript:void(0)"><i class="fa fa-trash fa-fw text-danger"></i></a></td>
      </tr>
    <?php $no++;endforeach; ?>
  </tbody>
</table>
<script>
  $('#example1').DataTable();
</script>
