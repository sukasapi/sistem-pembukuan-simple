<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-title">Filter Pencarian</div>
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Akun</label>
                                    <select class="form-control" name="akun" id="akun">
                                        <?php 
                                            foreach($induk as $i){
                                                if($idakun==$i['akun_id']){
                                                    echo "<option selected value='".$i['akun_id']."'>".$i['name'] ." (".$i['description'].")"."</option>";
                                                }else{
                                                    echo "<option value='".$i['akun_id']."'>".$i['name'] ." (".$i['description'].")"."</option>";
                                                }
                                             
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label>Mulai</label>
                                    <input type="date" placeholder="Start" class="form-control" data-date-format="dd-mm-yyyy" name="range_start" id="range_start">
                                </div>
                            </div>
                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label>Selesai</label>
                                    <input type="date" placeholder="End" class="form-control" data-date-format="dd-mm-yyyy" name="range_end"  id="range_end">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                        </div>
                    </form>
                    <div class="row">
                            <div class="col-12 mb-2">
                                <button id="bsearch" class="btn btn-primary btn-block btn-rounded">Filter</button>
                            </div>
                        </div>
                </div>
            </div>
      
           
        </div>
        <div class="col-12 my-2">
            <div class="card mb-4">
                    <div class="row mb-4 p-4 text-center">
                        <div class="col-4 col-xs-12">
                            <h4>NOMOR AKUN</h4>
                            <p class="akun"></p>
                        </div>
                        <div class="col-4 col-xs-12">
                            <h4>DESKRIPSI</h4>
                            <p  class="deskakun"></p>
                        </div>
                        <div class="col-4 col-xs-12">
                            <h4>ANGGARAN</h4>
                            <p class="total_anggaran"></p>
                        </div>
                    </div>
            </div>
            <div class="card">
                 
                    <?php if($_SESSION['role']=="admin" ||$_SESSION['role']=="kasir"){
                        ?>
                            <div class="card-header">
                                <div class="float-right">
                                    <button class="btn btn-info" id="btAdd"> <i class="fas fa-fw fa-plus"></i>Tambah Transaksi</button>
                                </div>
                            </div>
                        <?php
                    }else{

                    }
                    ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-stripe">

                            <tfoot>
                                <tr>
                                    <td colspan=4><h4><strong>TOTAL :</strong></h4></td>
                                    <td></td>
                                    <td colspan=3></td>
                                </tr>
                            </tfoot>
                        </table>
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
        init_anggaran();
    });

    function init_datatable() {
        var serverSide = true;
        
        $('#datatable').DataTable({
            serverSide: serverSide,
            destroy: true,
            searching: false,
            ordering: false,
            ajax: {
                url: '<?=base_url("Report/get_databyakun");?>',
                data: {
                    'server_side': serverSide,
                    'filter': $("#filter-form").serialize(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                complete: function (data) {
                    },
                type: 'POST'
            },
            columns: [
                {
                    data: 'no',
                    title: 'No',
                },
                {
                    data: 'tanggal_transaksi',
                    title: 'Tanggal',
                },
                {
                    data: 'akun',
                    title: 'Akun',
                },
               
                {
                    data: 'tipe',
                    title: 'Tipe',
                },
                {
                    data: 'deskripsi',
                    title: 'Deskripsi',
                },
                {
                    data: 'nominal',
                    title: 'Nominal',
                },
                {
                    data: 'tanggal_lpj',
                    title: 'LPJ',
                },
                {
                    data: 'action',
                    title: '',
                },
            ],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? convertstring(i)
                        : typeof i === 'number'
                        ? i
                        : 0;
                };

                 // Total over all pages
                totaltransaksi = api
                    .column(5)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                 // Update footer
                 api.column(5).footer().innerHTML ="<h3>"+rupiah(totaltransaksi)+"</h3>";
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '10%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '5%', targets: 4 },
                { width: '20%', targets: 5 },
                { width: '20%', targets: 5 },

            ]
        });
    }
    
    $('#datatable').on( "click", ".update-status", function(){
        $id = $(this).data('id');
        $status = $(this).data('status');
        //alert($status);
        $.ajax({
                url : '<?=base_url("Transaction/update_status");?>',
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

    $('#datatable').on( "click", ".viewLPJ", function(){
       var kodetran=$(this).data('token');
       var urlview='<?=base_url('transaction/viewLPJ/')?>'+kodetran;
       window.open(urlview,'_blank');
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

    $("#bsearch").on("click",function(e){
       getfilter();
       init_datatable();
    })

    $("#btAdd").on("click",function(e){
        var goTrans='<?=base_url('transaction/create')?>';
        window.location.replace(goTrans);
    })

    function getfilter(){
        var tipe=$("#tipe").val();
        var jenis=$("#jenis").val();
        var start=$("#range_start").val();
        var end=$("#range_end").val();

        $("#tipe").val(tipe);
        $("#jenis").val(jenis);
        $("#range_start").val(start);
        $("#range_end").val(end);
    }


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

    function convertstring(rpString){
         // Remove the currency symbol and any whitespace
            const cleanedString = rpString.replace(/Rp\s+/g, '').trim();
            
            // Remove the thousands separators (periods)
            const withoutThousands = cleanedString.replace(/\./g, '');
            
            // Replace the comma with a dot
            const decimalString = withoutThousands.replace(',', '.');
            
            // Parse to float and then convert to integer
            const intValue = Math.floor(parseFloat(decimalString));
            
            return intValue;
        
        return intValue;
     }

     function rupiah(value) {
        // Convert the integer to a string
        let strValue = value.toString();
        
        // Split the string into integer and decimal parts
        let integerPart = strValue; // Assuming no decimal part for integer input
        let decimalPart = '00'; // Default decimal part

        // Add thousands separators (periods)
        let formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Combine the integer and decimal parts
        return `Rp. ${formattedInteger},${decimalPart}`;
    }

    function rupiah(value) {
        // Convert the integer to a string
        let strValue = value.toString();
        
        // Split the string into integer and decimal parts
        let integerPart = strValue; // Assuming no decimal part for integer input
        let decimalPart = '00'; // Default decimal part

        // Add thousands separators (periods)
        let formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Combine the integer and decimal parts
        return `Rp. ${formattedInteger},${decimalPart}`;
    }

    function init_anggaran(){
        var formanggaran= new FormData();
        formanggaran.append("akun",$("#akun").val());
        formanggaran.append("start",$("#range_start").val());
        formanggaran.append("end",$("#range_end").val());
        var urlanggaran='<?=base_url('Report/get_anggaran')?>';
        $.ajax({
            url: urlanggaran,
            type: "POST",
            data:  formanggaran,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
              
            },
            success: function(response)
            {
                var resp=JSON.parse(response);
                $(".total_anggaran").html(rupiah(resp.data.data[0]['total_anggaran']));
                $(".deskakun").html(resp.data.data[0]['des_akun']);
                $(".akun").html(resp.data.data[0]['nama_akun']);
                
             }
        })

    }
 

</script>