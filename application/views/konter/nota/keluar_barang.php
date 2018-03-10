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
      width: 70%;
      padding: 2px;
      /*position: static;*/
    }
    .right {
      float: right;
      width: 30%;
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
      margin: 60px 0px 10px;
      border-color: #fff;
      height: 0.5px;
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
            <td><strong>NOTA KELUAR BARANG</strong></td>
          </tr>
          <tr>
            <td>No. <strong><?= $this->input->get('id');?></strong></td>
          </tr>
        </table>
    </div>

    <hr class="garis">

	  <div class="content">
	  	<table width="200">
	  		<tr>
	  			<td><strong>No.SA</strong></td><td><?= $header->nomor_sa ?></td>
	  		</tr>
	  		<tr>
	  			<td><strong>No.Polisi</strong></td><td><?= $header->nomor_polisi ?></td>
	  		</tr>
	  		<tr>
	  			<td><strong>Nama</strong></td><td><?= $header->nama ?></td>
	  		</tr>
	  	</table>
	  	<br>
      <table class="table-item">
        <thead>
          <tr>
            <th class="short">No</th>
            <th style="text-align:center" class="normal">No.Part</th>
            <th style="text-align:center" class="normal" width="200px">Nama Part</th>
            <th style="text-align:right" class="normal">Harga</th> 
            <th style="text-align:center" class="normal">Qty</th>
            <th style="text-align:right" class="normal">Subtotal</th>
          </tr>
        </thead>
        <tbody>
        	<!-- <?php print_r($items)?> -->
         	<?php $total=array();$no=1;foreach ($items as $item): ?>
         		<tr>
         			<td align="center"><?= $no ?></td>
         			<td align="center"><?= $item->nomor_part ?></td>
         			<td align="center"><?= $item->nama_part ?></td>
         			<td align="right"><?= $item->harga_jual ?></td>
         			<td align="center"><?= $item->qty ?></td>
         			<td align="right"><?= $total[]=$item->harga_jual * $item->qty ?></td>
         		</tr>
         	<?php $no++;endforeach ?>
         		<tr>
         			<td colspan="5" align="center"><strong>Total</strong></td>
         			<td align="right"><span style="text-align: left;"><strong>Rp. </strong></span><?php echo toRP(array_sum($total))?></td>
         		</tr>
        </tbody>
      </table>
	  </div>
    </div>
</body>
</html>
