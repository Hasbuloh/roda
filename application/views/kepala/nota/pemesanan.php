<!DOCTYPE html>
<html>
<head>
  <title>Report Table</title>
  <style type="text/css">
    body{
      font-family: arial,'Times New Roman';
      font-size: 14px;
      padding: 5px;
    }
    .header-top{
      text-align: center;
      font-weight: 20px;
      font-weight: bold;
      /*position: relative;*/
    }
    .left{
      float: left;
      width: 50%;
      padding: 2px;
      /*position: static;*/
    }
    .right {
      float: right;
      width: 50%;
      padding: 2px;
      /*position: static;
      overflow: hidden;*/
    }
    .content{
      margin-top: 150px;
      /*position: absolute;*/
      overflow: auto;
    }

    .short{
      width: 20px;
    }
    .table-item{
      border-collapse: collapse;
      width: 100%;
    }
    /*.normal{
      width: 150px;
    }*/
    /*table{
      border-collapse: collapse;
      font-family: arial;
    }*/
    .table-item thead th{
      text-align: left;
      padding: 5px;
    }
    .table-item tbody td{
      border-top: 1px solid #e3e3e3;
      padding: 5px;
    }
  </style>
</head>
<body>
  <!-- In production server. If you choose this, then comment the local server and uncomment this one-->
  <!-- <img src="<?php // echo $_SERVER['DOCUMENT_ROOT']."/media/dist/img/no-signal.png"; ?>" alt=""> -->
  <!-- In your local server -->
	<div id="outtable">
    <div class="header-top">
      <p><u><strong>PURCHASE ORDER</strong></u></p>
      <p><strong>NO : <?= $this->input->get('id')?></strong></p>
    </div>
    <div class="left">
        <table>
          <tr>
            <td>Perusahaan</td>
            <td>:</td>
            <td>PT. DAYA ADICIPTA MOTORA (PSD)</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Jl. RAYA CIBEUREUM NO.26 BANDUNG JAWA BARAT 40384</td>
          </tr>
          <tr>
            <td>Ph/Fax</td>
            <td>:</td>
            <td>+62 22 603 7495</td>
          </tr>
          <tr>
            <td>Contact</td>
            <td>:</td>
            <td>+62 22 605 1033</td>
          </tr>
        </table>
    </div>
    <div class="right">
        <table>
          <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= $tanggal->tanggal ?></td>
          </tr>
          <tr>
            <td>Tagihan Kepada</td>
            <td>:</td>
            <td>CV. RODA MAS AUTO LESTARI</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>JL.RAYA SUKABUMI NO.75 CIANJUR JAWA BARAT ID</td>
          </tr>
          <tr>
            <td>Ph/Fax</td>
            <td>:</td>
            <td>02832832</td>
          </tr>
          <tr>
            <td>Contact</td>
            <td>:</td>
            <td></td>
          </tr>
        </table>
      </div>
	  <div class="content">
      <table class="table-item">
        <thead>
          <tr>
            <th class="short">NO</th>
            <th colspan="2"style="text-align:center;width:250px">DESKRIPSI ITEM</th>
            <th class="normal">HET</th>
            <th class="normal">QTY</th>
            <th class="normal">DISC1</th>
            <th class="normal">DISC2</th>
            <th class="normal">NETTO</th>
            <th class="normal">SUBTOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; ?>
          <?php $total_item=array();$total= array();foreach($items->result_array() as $item): ?>
            <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $item['nomor_part']; ?></td>
            <td><?php echo $item['nama_part']; ?></td>
            <td align="right"><?php echo toRP($item['harga_jual'])?></td>
            <td align="center"><?php echo $total_item[] = $item['qty']; ?></td>
            <td><?= $item['disc1']?></td>
            <td><?= $item['disc2']?></td>
            <td><?= toRP($item['harga_beli']) ?></td>
            <td align="right"><?php $total[] = $item['qty']*$item['harga_beli']; echo toRP($item['qty']*$item['harga_beli']) ?></td>
            </tr>
          <?php $no++; ?>
          <?php endforeach; ?>
          <tr>
            <td colspan="4" align="center"><strong>Total</strong></td>
            <td align="center"><strong><?= array_sum($total_item)?></strong></td>
            <td colspan="3"></td>
            <td align="right"><span style="float:left;">Rp. </span><strong><?php echo toRP(array_sum($total))?></strong></td>
          </tr>
          <tr>
            <td colspan="3">
              Catatan :
            </td>
            <td colspan="2">Dengan Hormat</td>
          </tr>
        </tbody>
      </table>
	  </div>
	 </div>
</body>
</html>
