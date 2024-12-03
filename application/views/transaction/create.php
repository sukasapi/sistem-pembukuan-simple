<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-offset-2">
            <div class="card">
                <div class="card-body">
                    <form id="data-form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Akun</label>
                            <div class="col-sm-12">
                            <select class="form-control" name="category_id">
                                <?php foreach ($akun as $key) :?>
                                    <option value='<?=$key['akun_id']?>'>[<?=$key['jenis']."-".$key['tipe']?>] <?=$key['name']?></option>
                                <?php endforeach?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nominal</label>
                            <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                </div>
                                <input type="number" class="form-control" name="nominal">
                                <div class="input-group-append">
                                <span class="input-group-text" id="inputGroupAppend">,00</span>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Deskripsi</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows='6' name="description"></textarea>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-offset-2 col-sm-12">
                        <button type="button" onclick="save()" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
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
            url : '<?=site_url($this->pageInfo['table_base'] . '/process_insert/');?>',
            type: "POST",
            data: {
                'data-form' :$("#data-form").serialize(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: "JSON",
            success: function(data)
            {
                window.location='<?=site_url($this->pageInfo['table_base']);?>';
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });
    }
</script>