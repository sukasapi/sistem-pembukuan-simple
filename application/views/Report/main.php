<div class="container-fluid">
    <div class="row mb-2 ">
            <div class="col-12 col-sm-12">
                <div class="form-inline float-right">
                        <div class="form-group mr-4">
                            <select name="tipe" id="tipe" class="form-control">
                                <option disabled selected value="">Pilih Tipe Laporan</option>
                                <?php 
                                    foreach($tipe as $t){
                                        echo "<option value='".$t."'>".$t."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mr-4">
                            <select name="tahun" id="tahun" class="form-control">
                            <option disabled selected value="">Pilih Tahun Laporan</option>
                            <?php 
                                foreach(stok_tahun(10) as $th){
                                    echo "<option value='".$th."'>".$th."</option>";
                                }
                            ?>
                            </select>
                        </div>
                    <button id="bfilter" class="btn btn-primary">Filter</button>
                </div>
            </div>
    </div>
    <div class="row mb-2">
        <div class='col-12 my-2'>
            <div class='card bg-white' style='border-radius:20px'>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="trAnggaran">

                                <tfoot>
                                    <tr>
                                        <td colspan=3> <strong>TOTAL :</strong></td>
                                        
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     function init_datatable(tipe,tahun) {
        var serverSide = true;
        $('#trAnggaran').DataTable({
            serverSide: serverSide,
            destroy: true,
            searching: false,
            ordering: false,
            ajax: {
                url: '<?=base_url('Report/get_data')?>',
                type: 'POST',
                data: {
                    'server_side': serverSide,
                    'tahun':tahun,
                    'tipe':tipe,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
            },
            columns: [
                {
                    data: 'no',
                    title: 'No',
                },
                {
                    data: 'akun',
                    title: 'Nama Akun',
                },
                {
                    data: 'deskripsi',
                    title: 'deskripsi',
                },
                {
                    data: 'anggaran',
                    title: 'Anggaran',
                },
                {
                    data: 'transaksi',
                    title: 'Transaksi',
                },
                {
                    data: 'sisa',
                    title: 'Saldo',
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
                totalanggaran = api
                    .column(3)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                totaltransaksi = api
                    .column(4)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                totalsisa = api
                    .column(5)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
                 // Update footer
                 api.column(3).footer().innerHTML =rupiah(totalanggaran);
                 api.column(4).footer().innerHTML =rupiah(totaltransaksi);
                 api.column(5).footer().innerHTML =rupiah(totalsisa);
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '15%', targets: 1 },
                { width: '35%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '15%', targets: 4 },
                { width: '15%', targets: 5 },

            ]
                
        });
     }

     $("#bfilter").on("click",function(e){
        init_datatable($("#tipe").val(),$("#tahun").val());
     })

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

    $("#trAnggaran").on("click",".bdetail",function(){
        var tokenakun=$(this).data("token");
        var urlgo='<?=base_url('Report/transaction_detail_report/')?>'+tokenakun;
        window.location.replace(urlgo);
    })

    $(document).ready(function(e){
        var tipe=$("#tipe").val();
        var tahun=$("#tahun").val();
        $("#tipe").val(tipe);
        $("#tahun").val(tahun);
        init_datatable();
    })
</script>