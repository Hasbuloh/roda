<h4>Daftar Barang</h4>
<hr>
<div class="alert alert-success daya-update" style="display:none;">

</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-calendar-o fa-fw"></i> Tabel Data Barang</h3>
    </div>
    <div class="panel-body">
        <div class="panel panel-default" id="daya-update" style="display:none">
            <div class="panel-heading">
                <h3 class="panel-title">Daya Update</h3>
            </div>
            <div class="panel-body">
                <form role="form" id="form1" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="">File Excel</label>
                        <input type="file" class="form-control" placeholder="Input file .xls" required="" name="userfile">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="dayaUpdate()">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="table">
            <?php $this->load->view('konter/barang/table')?>
        </div>
    </div>
</div>



