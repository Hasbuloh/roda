<div class="row">
    <div class="col-md-12">
        <h4>Stok Barang</h4>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">   
        <a href="javascript:void(0)" class="btn btn-default btn-md" onclick="showModal()"><i class="fa fa-plus-circle fa-fw"></i> Tambah</a> | Data Stok Barang Stok Barang</h3>
            </div>
            <div class="panel-body">
                <div id="table">
                    <?php $this->load->view('kepala/stok_barang/table_barang') ?>
                </div>
            </div>
            <div class="panel-footer">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function showModal(id,nomor,nama,jenis_part,qty,hrg_jual,hrg_beli,disc1,disc2,rak,status) {
$('.peringatan').attr('style','display:none');
    if (id == null) {
        $('#modal-id').modal('show');
        $('.modal-title').text('Form Tambah Barang');
        $('#form [name]').val('');
        $('[name="qty"]').val('0');
        $('#disc1').val('0');
        $('#disc2').val('0');
    }else{
        $('#modal-id').modal('show');
        $('.modal-title').text('Form Edit Barang');
        $('[name="id"]').val(id)
        $('[name="nomor_part"]').val(nomor);
        $('[name="nama_part"]').val(nama);
        $('[name="qty"]').val(qty);
        $('[name="harga_jual"]').val(hrg_jual);
        $('[name="harga_beli"]').val(hrg_beli);
        $('[name="disc1"]').val(disc1);
        $('[name="disc2"]').val(disc2);
        $('[name="jenis_part"]').val(jenis_part);
        $('[name="no_rak"]').val(rak);
    }
}

function dataSave() {
    var formData = $('#form').serialize();
    $.ajax({
         url: '<?= base_url('kepala/Stok_Barang/edit')?>',
         dataType: 'JSON',
         type: 'POST',
         data: formData,
         success: function(data){
           if(data.status){
            //  alert('data');
            $('.peringatan').attr('style','display:yes');
            $('.peringatan').text('Data Berhasil Disimpan');
            setInterval(function(){
              $('.peringatan').hide('slow');
            },500);
            reload_table();
           }else{
            for (var i = 0; i < data.inputerror.length; i++)
            {
                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
            }
           }
         }
    })
}

 function disc() {
      het = $('#het').val();
      disc1 = $('#disc1').val();
      disc2 = $('#disc2').val();

      netto = het - (het * disc1 / 100);

      netto = netto - (netto * disc2 /100);

      $('#netto').val(netto);
     // alert(het)
 }

 function unlock(id) {
    var tanya = confirm('Apakah anda yakin?');
    if (tanya) {
        $.ajax({
            url: '<?= base_url('kepala/Stok_Barang/unlock_barang')?>',
            dataType: 'JSON',
            type: 'POST',
            data: {'id': id},
            success: function(data) {
                if (data.status) {
                    reload_table();
                }
            }
        })
    }
 }

function hapus(id,nama) {
  swal({
    title: "Apakah anda yakin untuk menghapus "+nama+"?",
    text: "Tidak mungkin untuk mengembalikan data yang dihapus",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya Hapus ini",
    closeOnConfirm: false
  },
  function(){
    $.ajax({
      url: '<?= base_url('kepala/Stok_Barang/hapus')?>',
      data: {'id': id},
      dataType: 'JSON',
      type: 'POST',
      success: function(data){
          if (data.status) {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
            reload_table();
          }
      }
    })
  });
}

</script>
