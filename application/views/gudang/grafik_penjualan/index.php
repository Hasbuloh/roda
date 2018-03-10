<h4>Grafik Penjualan</h4>
<hr>
<div class="panel panel-default">
  <div class="panel-heading">
    <p class="panel-title">Grafik Penjualan</p>
  </div>
  <div class="panel-body">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium atque inventore nihil, numquam illum enim distinctio, molestias voluptates unde labore maiores a mollitia, quo, consequuntur fugiat magni quis quas odit.
    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
  </div>
</div>
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/canvas/jquery.canvasjs.min.js')?>"></script>
<script type="text/javascript">
var data = (function(){
  $.ajax({
    url: '<?= base_url('gudang/Grafik_Penjualan/grafik')?>',
    dataType: 'JSON',
    type: 'GET',
    success: function(data) {
      data = data;
    }
  });
  return data;
})();

window.onload = function () {
  // alert(data[0].item)
  // alert(json_parse(data));
	var chart = new CanvasJS.Chart("chartContainer", {
		theme: "theme2",//theme1
		title:{
			text: "Basic Column Chart - CanvasJS"
		},
		animationEnabled: false,   // change to true
		data: [
		{
			// Change type to "bar", "area", "spline", "pie",etc.
			type: "spline",
			dataPoints: [
				{ label: "apple",  y: 10  },
				{ label: "orange", y: 15  },
				{ label: "banana", y: 25  },
				{ label: "mango",  y: 30  },
				{ label: "grape",  y: 28  }
			]
		}
		]
	});
	chart.render();
}
</script>
