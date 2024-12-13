<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-offset-2">
            <div class="card" style="background-color:#dff9fb">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="">All</option>
                                <option value="in">Pemasukan</option>
                                <option value="out">Pengeluaran</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jenis</label>
                            <select class="form-control" name="tipe" id="tipe">
                                <option value="">All</option>
                                <option value="program">Program</option>
                                <option value="rutin">Rutin</option>
                            </select>
                        </div>
                        <button id="bfilter" class="float-right btn btn-primary btn-rounded" >filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-offset-2 my-4">
            <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <a href='<?=base_url('Akun/create')?>' class="btn btn-primary"> <i class="fas fa-fw fa-plus"></i>Tambah Akun</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table"></table>
                </div>
            </div>
          
        </div>
    </div>
</div>
<?php $this->load->view("template/footer");?>
<script>
    $(document).ready(function() {
        init_datatable();
    });

    function init_datatable(jenis,tipe) {
        var serverSide = true;

        $('#datatable').DataTable({
            serverSide: serverSide,
            destroy: true,
            searching: false,
            ordering: false,
            ajax: {
                url: '<?=site_url('Akun/get_datatable');?>',
                data: {
                    'server_side': serverSide,
                    'filter': $("#filter-form").serialize(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                type: 'POST',
            },
            columns: [
                {
                    data: 'nama',
                    title: 'Akun',
                },
                {
                    data: 'description',
                    title: 'Deskripsi',
                },
                {
                    data: 'jenis',
                    title: 'Jenis',
                },
                {
                    data: 'akun_induk',
                    title: 'Akun Induk',
                },
                {
                    data: 'tipe',
                    title: 'Tipe',
                },
                {
                    data: 'action',
                    title: '',
                },
            ]
        });

        
    }

    $("#bfilter").on('click',function(e){
        e.preventDefault();
        var jenis=$("#jenis").val();
        var tipe=$("#tipe").val();
        $("#jenis").val(jenis);
        $("#tipe").val(tipe);
        init_datatable();

    })

   $('#datatable').on( "click", ".update-status", function(){
        $id = $(this).data('id');
        $status = $(this).data('status');
        //alert($status);
        $.ajax({
                url : '<?=site_url('Akun/update_status/');?>',
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
    
  
</script>