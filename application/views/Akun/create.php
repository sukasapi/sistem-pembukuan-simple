<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">
            <form id="data-form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Kategori</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Deskripsi</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="description">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tipe</label>
                    <div class="col-sm-10">
                    <select class="form-control" name="jenis">
                        <option selected disabled>pilih jenis akun</option>
                        <?php foreach ($this->typeJenis as $key => $value) :?>
                            <option value='<?=$key?>'><?=$value?></option>
                        <?php endforeach?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tipe</label>
                    <div class="col-sm-10">
                    <select class="form-control" name="tipe">
                    <option disabled selected>pilih tipe akun</option>
                        <?php foreach ($this->typeTipe as $key => $value) :?>
                            <option value='<?=$key?>'><?=$value?></option>
                        <?php endforeach?>
                    </select>
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" onclick="save()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("template/footer");?>
<script>
    $(document).ready(function() {
    });
    function save(){
        $.ajax({
            url : '<?=site_url('Akun/process_insert/');?>',
            type: "POST",
            data: {
                'data-form' :$("#data-form").serialize(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: "JSON",
            success: function(data)
            {
                window.location='<?=site_url('Akun')?>';
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });
    }
</script>