<div class="panel-body">
    <form role="form" id="form1" enctype="multipart/form-data" method="post" action="<?= base_url('gudang/Test/unformated')?>" accept-charset="utf-8">
        <div class="form-group">
            <label for="">File Excel</label>
            <input type="file" class="form-control" placeholder="Input file .xls" required="" name="userfile">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="kirim">
        </div>
    </form>
</div>