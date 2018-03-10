
    <h3>Detail Retur Barang <small><?= $this->input->get('id')?></small></h3>
    <div class="row">
      <div class="col-md-1">
        <ul>
          <li><strong>Nama</strong></li>
          <li><strong>Tanggal</strong></li>
        </ul>
      </div>
      <div class="col-md-3">
        <ul>
          <li><?= $persons->nama ?></li>
          <li><?= $persons->tanggal ?></li>
        </ul>
      </div>
    </div>
    <hr>
    <table class="table table-condensed table-bordered table-hover table-responsive" id="example1">
    <thead>
      <tr>
        <th style="text-align:center;">No</th>
        <th colspan="2">Deskripsi Item</th>
        <th>QTY</th>
        <th>Disc</th>
        <th>HET</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <!-- <?php print_r($items) ?> -->
      <?php $totalqty=array();$totalnetto=array();$totalharga=array();$no=1;foreach ($items as $item): ?>
        <tr>
          <td align="center"><?= $no ?></td>
          <td><?= $item->nomor_part?></td>
          <td><?= $item->nama_part?></td>
          <td align="center"><span class="badge"><?= $totalqty[]=$item->qty ?></span></td>
          <td align="center">
      
          </td>
          <td align="right">
          </td>
          <td align="right">
          </td>
        </tr>
      <?php $no++;endforeach; ?>
        <tr>
          <td colspan="3" align="center"><strong>Total</strong></td>
          <td align="center"><strong><?= array_sum($totalqty)?></strong></td>
          <td colspan="1"></td>
          <td></td>
          <td align="right"><span style="float:left;">Rp. </span><strong><?= toRP(array_sum($totalharga))?></strong></td>
        </tr>
    </tbody>
    </table>
  </div>
