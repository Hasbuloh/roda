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
var dataPointsA=[];
$(document).ready(function() {
  $.ajax({
    url: '<?= base_url('gudang/Grafik_Penjualan/grafik')?>',
    dataType: 'JSON',
    type: 'GET',
    success: function(response) {
      for (var i=0;i<response.length;i++){
        dataPointsA.push({
          label: response[i].label,
          y: response[i].y
        })
      }
    }
  });
});

window.onload = function () {
  //console.log(dataPointsA);

  // alert(data[0].item)
  // alert(json_parse(data));
	var chart = new CanvasJS.Chart("chartContainer", {
		theme: "light2",//theme1
		title:{
			text: "Basic Column Chart - CanvasJS"
		},
		animationEnabled: false,   // change to true
		data: [
		{
			// Change type to "bar", "area", "spline", "pie",etc.
			type: "column",
			dataPoints: dataPointsA
		}
		]
	});
	chart.render();
}
</script>
