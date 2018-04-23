<div class="panel panel-default">
    <div class="panel-heading">
       <a href="<?= base_url('gudang/Pemesanan')?>"><i class="fa fa-arrow-circle-o-left fa-fw"></i> Kembali</a> | <a href="<?= base_url('gudang/pemesanan/cetak_nota?id='.$this->input->get('id') )?>" target="_blank"><i class="fa fa-print fa-fw"></i> Cetak</a>
    </div>
    <div class="panel-body">
      <h4>Detail Pemesanan <small><?= $header->nopo ?></small></h4>
      <div class="well well-sm">
          Tanggal <strong><?= $header->tanggal ?></strong><br> Supplier <strong><?= $header->supplier == 1 ? 'Daya Adi Cipta':'Non-Daya'; ?></strong>
      </div>
      <hr>
      <table class="table table-condensed table-hover table-bordered" id="example1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>No.Part</th>
                  <th>Nama Part</th>
                  <th>HET</th>
                  <th>Qty</th>
                  <th>Disc1</th>
                  <th>Disc2</th>
                  <th>Netto</th>
                  <th>Subtotal</th>
                  <th>Hapus</th>
              </tr>
          </thead>
          <tbody>
            <?php if(count($items) != 0): ?>
              <?php $totalqty=array();$total=array();$total1=array();$no=1;foreach($items as $item):?>
              <tr>
                  <td style="text-align:center"><?= $no ?></td>
                  <td><?= $item->nomor_part ?></td>
                  <td> <?= $item->nama_part ?></td>
                  <td align="right"><?= toRp($item->harga_jual) ?></td>
                  <td align="center"><?= $totalqty[] = $item->qty ?></td>
                  <td align="center"><?= $item->disc1 ?></td>
                  <td align="center"><?= $item->disc2 ?></td>
                  <td align="right"><?php
                    echo toRP($total1[]= $item->harga_beli);
                  ?></td>
                  <td align="right">
                    <?php

                    echo toRP($total[] = $item->harga_beli*$item->qty);
                    ?>
                  </td>
                  <td style="text-align:center"><a href="javascript:void(0)" onclick="hapus('<?= $this->input->get('id')?>',<?= $item->id ?>)"><i class="fa fa-trash fa-fw"></i></a></td>
              </tr>
              <?php $no++;endforeach;?>
            <?php else: ?>
              <tr>
                <td colspan="7"><p>Belum Ada Item Untuk Pemesanan Ini</p></td>
              </tr>
            <?php endif; ?>
      </tbody>
      </table>
      <div class="well well-sm">
          <strong>QTY : </strong> <?php echo array_sum($totalqty) ?>,
          <strong>Total :</strong><?php echo toRP(array_sum($total)) ?>
      </div>
    </div>
</div>



<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#example1').DataTable();
    })
</script>
