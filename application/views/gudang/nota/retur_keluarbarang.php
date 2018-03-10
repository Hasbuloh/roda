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
      margin-top: 0px;
      /*position: absolute;*/
      overflow: auto;
      margin-bottom: 20px;
    }
    #outtable{
      padding:0 50px;
       border:1px solid #e3e3e3;
      width:100%;
      border-radius: 5px;
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
    .text {
      font-size: 12px;
    }
    .item {
      width: 250px;
    }
    .footer>.footer-right{
      float: right;
      margin-top:40px;
    }
    .table {
      width: 100%;
    }
    .garis{
      border-color: #fff;
      height: 0.5px;
      margin: 60px 0px 10px;
    }
    ul{
      list-style:none;
    }
    ul>li{
      float:left;
      padding: 0px 80px;
    }
    #k-1{
      padding:0px 100px 0px 0px;
    }
  </style>
</head>
<body>
  <!-- In production server. If you choose this, then comment the local server and uncomment this one-->
  <!-- <img src="<?php // echo $_SERVER['DOCUMENT_ROOT']."/media/dist/img/no-signal.png"; ?>" alt=""> -->
  <!-- In your local server -->
    <div class="left">
    <table>
      <tr>
        <td><strong>CV. RODA MAS AUTO LESTARI</strong></td>
      </tr>
      <tr>
        <td>JL.RAYA SUKABUMI NO.75 CIANJUR JAWA BARAT ID</td>
      </tr>
    </table>
    </div>
    <div class="right">
        <table>
          <tr>
            <td><strong>NOTA RETUR BARANG</strong></td>
          </tr>
          <tr>
            <td>No. <strong><?= $this->input->get('id');?></strong></td>
          </tr>
        </table>
    </div>

    <hr class="garis">

	  <div class="content">
      <table class="table-item">
        <thead>
          <tr>
            <th class="short">NO</th>
            <th colspan="2"style="text-align:center;width:250px">DESKRIPSI ITEM</th>
            <th style="text-align:center" class="normal">NO.KELUAR</th>
            <th style="text-align:center" class="normal">HET</th>
            <th style="text-align:center" class="normal">NET</th> 
            <th style="text-align:center" class="normal">QTY</th>
            <th style="text-align:center" class="normal">DISC1</th>
            <th style="text-align:center" class="normal">DISC1</th>
            <th style="text-align:center" class="normal">SUBTOTAL</th>
            <th class="normal">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1;$totalqty=array();$total=array();foreach ($items as $item): ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= $item['nomor_part']?></td>
              <td><?= $item['nama_part']?></td>
              <td align="center"><?= $item['nomor_keluar']?></td>
              <td align="right"><strong><?= toRP($item['harga_jual'])?></strong></td>
              <td>
                <strong><?= toRP($item['harga_beli'])?></strong>
              </td>
              <td align="center"><?= $totalqty[]=$item['qty']?></td>
              <td align="center"> 
                <?= $item['disc1'] ?>
              </td>
              <td align="center">
                 <?= $item['disc2'] ?>
              </td>
              <td align="right">
                <strong><?= toRP($total[]=$item['harga_jual'] * $item['qty'])?></strong>
              </td>
              <td><?= $item['keterangan']?></td>
            </tr>
          <?php $no++;endforeach; ?>
            <tr>
              <td colspan="5" align="center"><strong>Total</strong></td>
              <td></td>
              <td align="center"><strong><?= array_sum($totalqty)?></strong></td>
              <td></td>
              <td align="right">
               
              </td>
              <td align="right"><strong>
                <?= toRP(array_sum($total))?>
              </strong></td>
              <td></td>
            </tr>
        </tbody>
      </table>
	  </div>
    <div class="footer">
      <?php $tanggal = $this->db->query("SELECT DATE_FORMAT(NOW(),'%d %M %Y') AS 'sekarang'")->row()?>
      <div class="footer-right"><strong>Cianjur</strong>, <?= $tanggal->sekarang ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="margin-left:50px;">Penerima</p>
      </div>
      <div style="margin-top:150px;">
        <ul>
          <li>
          <p><span id="k-1">(</span><span id="k-2">)</span></p>
          <p style="margin-left:13px;">Part Inventory</p>
          </li>
          <li>
          <p><span id="k-1">(</span><span id="k-2">)</span></p>
          <p style="margin-left:12px;">Kepala Bengkel</p>
          </li>
          <li>
          <p><span id="k-1">(</span><span id="k-2">)</span></p>
          <p style="margin-left:20px;">Konsumen</p>
          </li>
        </ul>
      </div>
    </div>
</body>
</html>
