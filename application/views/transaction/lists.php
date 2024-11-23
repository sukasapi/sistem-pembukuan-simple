<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            <form id="filter-form" class="form-inline">
                <div class="form-group">
                    <label>Tipe</label>
                    <select class="form-control" name="type" onchange="return init_datatable()">
                        <option value="">Semua</option>
                        <option value="in">Pemasukan</option>
                        <option value="out">Pengeluaran</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" placeholder="Start" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="range_start" onblur="return init_datatable()">
                    <input type="text" placeholder="End" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="range_end" onblur="return init_datatable()">
                </div>
            </form>
           
        </div>
        <div class="col-12 my-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-stripe"></table>
                    </div>
                </div>
            </div>
           
        </div>
    </div>

   
    <div class="modal fade" id="mdUploadLPJ" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Upload File LPJ</h5>
                    <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"><i class='fas fa-close' aria-hidden='true'></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-infob-4 m">
                                <p> File yang diperbolehkan untuk diupload adalah PDF.</p>
                                <p> Periksa kembali format file yang akan diupload agar proses upload berhasil</p>
                            </div>
                            <input type="hidden" id="kodetransaksi" value="">
                            <input type="file" name="lpj" id="lpj" class="form-control"> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal"><i class='fas fa-close' aria-hidden='true'></i></button>
                <button class="btn btn-primary" id="btuploadLPJ" type="button"><i class='fa fa-upload' aria-hidden='true'></i></button></div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("template/footer");?>
<script>
    $(document).ready(function() {
        init_datatable();
    });

    function init_datatable() {
        var serverSide = true;
        $('#datatable').DataTable({
            serverSide: serverSide,
            destroy: true,
            searching: false,
            ordering: false,
            ajax: {
                url: '<?=site_url($this->pageInfo['table_base'] . '/get_datatable/');?>',
                data: {
                    'server_side': serverSide,
                    'filter': $("#filter-form").serialize(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                type: 'POST'
            },
            columns: [
                {
                    data: 'create_date',
                    title: 'Tanggal',
                },
                {
                    data: 'nominal',
                    title: 'Nominal',
                },
                {
                    data: 'category_type',
                    title: 'Tipe',
                },
                {
                    data: 'category_name',
                    title: 'Kategori',
                },
                {
                    data: 'description',
                    title: 'Deskripsi',
                },
                {
                    data: 'action',
                    title: '',
                },
            ]
        });
    }

    $('#datatable').on( "click", ".update-status", function(){
        $id = $(this).data('id');
        $status = $(this).data('status');
        //alert($status);
        $.ajax({
                url : '<?=site_url($this->pageInfo['table_base'] . '/update_status/');?>',
                type: "POST",
                data: {
                        id: $id,
                        status: $status,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                dataType: "JSON",
                success: function(data)
                {
                    init_datatable();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : ' + errorThrown);
                }
        });
    });

    $('#datatable').on( "click", ".uploadLPJ", function(){
        $('#mdUploadLPJ').modal("show");
        var kodetran=$(this).data('token');
        $("#kodetransaksi").val(kodetran);

    })

    $("#lpj").on('change',function(e){
        var filename = $(this).val();
        var extension = filename.replace(/^.*\./, '');

        if(extension.toLowerCase()!='pdf'){
            alert("Format yang diperbolehkan adalah .pdf");
            $(this).val('');
            $('#btuploadLPJ').attr('disabled',true);
        }else{
            $('#btuploadLPJ').removeAttr('disabled'); 
        }

    })

    $("#btuploadLPJ").on('click',function(e){
        var filename=$("#lpj").get(0);
        var kodetransaksi=$('#kodetransaksi').val();
        uploadLPJ(filename,kodetransaksi);
    })


    function uploadLPJ(input,kode){
        var urlupload='<?=base_url('transaction/upload_lpj')?>';
        var myFormData = new FormData();
        myFormData.append('kodetransaksi',kode);
        myFormData.append('lpj', input.files[0]);

        $.ajax({
            url: urlupload,
            type: "POST",
            data:  myFormData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
              
            },
            success: function(response)
            {
                var resp=JSON.parse(response);
                console.log(resp.stat);         
                if(resp.stat=="ok"){
                    alert(resp.msg);
                    init_datatable();
                    $("#lpj").val(''); 
                    $('#mdUploadLPJ').modal("hide");
                   
                }else{
                    alert(resp.msg);
                    windowlocation.reload();
                }
              
            }
        })  
    }
 

</script>