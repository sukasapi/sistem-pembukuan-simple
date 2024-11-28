<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-offset-2 my-4">
            <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <button class="btn btn-primary" id="btAdd"> <i class="fas fa-fw fa-plus"></i>Tambah User</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table"></table>
                </div>
            </div>
          
        </div>
    </div>
</div>
<!-- MODAL --> 

<div class="modal fade" id="mdAdd" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-2">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" class="form-control" placeholder="nama pengguna" id="nama">
                </div>
                <div class="form-group mb-2">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="username yang digunakan untuk login" id="username">
                </div>
                <div class="form-group mb-2">
                    <label for="password">Kata Kunci</label>
                    <input type="password" id="password" placeholder="jika tidak disi maka password default 123456" class="form-control" id="password">
                </div>
                <div class="form-group mb-2">
                    <label for="role">Otorisasi</label>
                    <select name="role" id="role" class="form-control">
                        <option disabled selected value="">Pilih otorisasi user</option>
                        <?php foreach ($this->Urole as $key => $value) :?>
                            <option value='<?=$key?>'><?=$value?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btSimpan">Tambah Pengguna</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="token" name="token">
                <div class="form-group mb-2">
                    <label for="namaedit">Nama</label>
                    <input type="text" id="namaedit" class="form-control" placeholder="nama pengguna" id="namaedit">
                </div>
                <div class="form-group mb-2">
                    <label for="usernameedit">Username</label>
                    <input type="text" disabled  id="usernameedit" class="form-control" placeholder="username yang digunakan untuk login" id="usernameedit">
                </div>
                <div class="form-group mb-2">
                    <label for="passwordedit">Kata Kunci</label>
                    <input type="passwordedit" id="passwordedit" placeholder="jika tidak disi maka password tidak diganti" class="form-control" id="passwordedit">
                </div>
                <div class="form-group mb-2">
                    <label for="roleedit">Otorisasi</label>
                    <select name="roleedit" id="roleedit" class="form-control">
                        <option disabled selected value="">Pilih otorisasi user</option>
                        <?php foreach ($this->Urole as $key => $value) :?>
                            <option value='<?=$key?>'><?=$value?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btUpdate" >Ubah Pengguna</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL -->
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
                url: '<?=site_url('user/get_datatable');?>',
                data: {
                    'server_side': serverSide,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                type: 'POST',
            },
            columns: [
                {
                    data: 'nama',
                    title: 'Nama',
                },
                {
                    data: 'login',
                    title: 'Username',
                },
                {
                    data: 'role',
                    title: 'Otoritas',
                },
                {
                    data: 'registered',
                    title: 'Tanggal',
                },
                {
                    data: 'status',
                    title: 'Status',
                },
                {
                    data: 'action',
                    title: '',
                },
            ]
        });

        
    }

    $("#btAdd").on("click",function(e){
        $("#mdAdd").modal("show");
    })

    $("#btAdd").on("click",function(e){
        $("#mdAdd").modal("show");
    })

    $("#btSimpan").on("click",function(e){
       var dataInsert=new FormData();
       var addUrl='<?=base_url('User/process_insert')?>';
       
       dataInsert.append("nama",$("#nama").val());
       dataInsert.append("username",$("#username").val());
       dataInsert.append("password",$("#password").val());
       dataInsert.append("role",$("#role").val());

       $.ajax({
                url : addUrl,
                method: 'POST',
                data: dataInsert,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $(this).attr("disabled",true);
                    console.log('proses sedang berjalan');  
                },
                success: function(data) {
                    var resp=JSON.parse(data);
                    if(resp.stat=="ok"){
                        alert(resp.msg);
                        init_datatable(); 
                        clearinput();  
                        $("#mdAdd").modal("hide"); 
                    }else{
                        alert(resp.msg);
                        clearinput();  
                        $("#mdAdd").modal("hide"); 
                    }
                    $(this).removeAttr("disabled");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Message: ' + textStatus + ' , HTTP: ' + errorThrown );
                },
            })

    })

    $("#bfilter").on('click',function(e){
        e.preventDefault();
        var jenis=$("#jenis").val();
        var tipe=$("#tipe").val();
        $("#jenis").val(jenis);
        $("#tipe").val(tipe);
        init_datatable();

    })

   $('#datatable').on( "click", ".btnHapus", function(){
        var dataUpdate=new FormData();
        var updateUrl='<?=base_url('User/update_status')?>';
        var token=$(this).data('kode');
        dataUpdate.append("kode",token);
        dataUpdate.append("status","0");
        
        $.ajax({
                url : updateUrl,
                method: 'POST',
                data: dataUpdate,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                
                },
                success: function(data) {
                    var resp=JSON.parse(data);
                    if(resp.stat=="ok"){
                        alert(resp.msg);
                        init_datatable(); 
                    }else{
                        alert(resp.msg);
                    }
                 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Message: ' + textStatus + ' , HTTP: ' + errorThrown );
                },
            })
  
   });

   $('#datatable').on( "click", ".btnAktif", function(){
        var dataUpdate=new FormData();
        var updateUrl='<?=base_url('User/update_status')?>';
        var token=$(this).data('kode');
        dataUpdate.append("kode",token);
        dataUpdate.append("status","1");
        
        $.ajax({
                url : updateUrl,
                method: 'POST',
                data: dataUpdate,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                
                },
                success: function(data) {
                    var resp=JSON.parse(data);
                    if(resp.stat=="ok"){
                        alert(resp.msg);
                        init_datatable(); 
                    }else{
                        alert(resp.msg);
                    }
                 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Message: ' + textStatus + ' , HTTP: ' + errorThrown );
                },
            })
  
   });

   $('.btUpdate').on( "click", function(e){
       var dataUpdate=new FormData();
       var updateUrl='<?=base_url('User/process_update')?>';
       
       dataUpdate.append("nama",$("#namaedit").val());
       dataUpdate.append("kode",$("#token").val());
       dataUpdate.append("username",$("#usernameedit").val());
       dataUpdate.append("password",$("#passwordedit").val());
       dataUpdate.append("role",$("#roleedit").val());

       $.ajax({
                url : updateUrl,
                method: 'POST',
                data: dataUpdate,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $(this).attr("disabled",true);
                    console.log('proses sedang berjalan');  
                },
                success: function(data) {
                    var resp=JSON.parse(data);
                    if(resp.stat=="ok"){
                        alert(resp.msg);
                        init_datatable(); 
                        clearinput();  
                        $("#mdEdit").modal("hide"); 
                    }else{
                        alert(resp.msg);
                        clearinput();  
                        $("#mdEdit").modal("hide"); 
                    }
                    $(this).removeAttr("disabled");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Message: ' + textStatus + ' , HTTP: ' + errorThrown );
                },
            })
   })


   $('#datatable').on( "click", ".btnEdit", function(){
        var token=$(this).data('kode');
        $("#mdEdit").modal("show");
        getdata(token);
   })

   function getdata(kode){
       var dataget=new FormData();
       var addUrl='<?=base_url('User/get_data')?>';
       dataget.append("kode",kode);
       $.ajax({
                url : addUrl,
                method: 'POST',
                data: dataget,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    var resp=JSON.parse(data);
                   if(resp.stat=="ok"){
                    var dt=resp.data[0];
                    console.log(dt.nama_user)
                    $("#namaedit").val(dt.nama_user);
                    $("#usernameedit").val(dt.login_user);
                    $("#passwordedit").val('');
                    $("#roleedit").val(dt.role);
                    $("#token").val(dt.token);
                   }else{
                    alert(resp.msg);
                   }
                }
       })

   }

   function clearinput(){
        $("#nama").val('');
        $("#username").val('');
        $("#password").val('');
        $("#role").val('');
   }

    
  
</script>