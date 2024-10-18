<script type="text/javascript">
    $(function(){
        var MODE = "tambah", selectedUID;
        var table = $("#table-toko").DataTable({
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            bPaginate: true,
            lengthMenu: [
                [20, 50, -1],
                [20, 50, "All"]
            ],
            serverMethod: "POST",
            "ajax": {
                url: __HOSTAPI__ + "/Lokasi",
                type: "POST",
                data: function(d) {
                    d.request = "get_toko";
                },
                headers: {
                    Authorization: "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>
                },
                dataSrc: function(response) {
                    var returnedData = [];
                    if (response == undefined || response.response_package == undefined) {
                        returnedData = [];
                    } else {
                        returnedData = response.response_package.response_data;
                    }
                    console.log(returnedData);

                    response.draw = parseInt(response.response_package.response_draw);
                    response.recordsTotal = response.response_package.recordsTotal;
                    response.recordsFiltered = response.response_package.recordsFiltered;

                    return returnedData;
                }
            },
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Cari Nama Toko"
            },
            "columns" : [
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<h5 class=\"autonum\">" + row.autonum + "</h5>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<div class=\"btn-group wrap_content\" role=\"group\" aria-label=\"Basic example\">" +
                            "<button class=\"btn btn-info btn-sm btn-edit-toko\" id=\"toko_edit_" + row["id"] + "\">" +
                            "<span><i class=\"fa fa-pencil-alt\"></i> Edit</span>" +
                            "</button>" +
                            "<button id=\"toko_delete_" + row['id'] + "\" class=\"btn btn-danger btn-sm btn-delete-toko\">" +
                            "<span><i class=\"fa fa-trash\"></i> Hapus</span>" +
                            "</button>" +
                            "</div>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "[<span koordinat=\"" + row["koordinat"] + "\" id=\"kode_" + row["id"] + "\">" + row["kode"] + "</span>]<span id=\"nama_" + row["id"] + "\">" + row["nama"] + "</span><br /><span id=\"alamat_" + row["id"] + "\">" + row["alamat"] + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"provinsi_" + row["id"] + "\" data-parse=\"" + row["provinsi"] + "\">" + row["alamat_provinsi_parse"] + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"kabupaten_" + row["id"] + "\" data-parse=\"" + row["kabupaten"] + "\">" + row["alamat_kabupaten_parse"] + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"kecamatan_" + row["id"] + "\" data-parse=\"" + row["kecamatan"] + "\">" + row["alamat_kecamatan_parse"] + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"kelurahan_" + row["id"] + "\" data-parse=\"" + row["kelurahan"] + "\">" + row["alamat_kelurahan_parse"] + "</span>";
                    }
                },
            ]
        });

        $("body").on("click", ".btn-delete-toko", function(){
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];

            var conf = confirm("Hapus toko item?");
            if(conf) {
                $.ajax({
                    url:__HOSTAPI__ + "/Lokasi/" + uid,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                    },
                    type:"DELETE",
                    success:function(response) {
                        console.log(response)
                        table.ajax.reload();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
        });

        $("body").on("click", ".btn-edit-toko", function() {
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];
            selectedUID = uid;
            MODE = "edit";
            $("#txt_nama").val($("#nama_" + uid).html());
            $("#txt_kode").val($("#kode_" + uid).html());
            $("#txt_alamat").val($("#alamat_" + uid).html());
            $("#txt_koordinat").val($("#kode_" + uid).attr("koordinat").trim());

            var provinsi = $("#provinsi_" + uid).attr("data-parse");
            var kabupaten = $("#kabupaten_" + uid).attr("data-parse");
            var kecamatan = $("#kecamatan_" + uid).attr("data-parse");
            var kelurahan = $("#kelurahan_" + uid).attr("data-parse");

            loadSelected("alamat_provinsi", 'provinsi', '', provinsi);
            loadSelected("alamat_kabupaten", 'kabupaten', provinsi, kabupaten);
            loadSelected("alamat_kecamatan", 'kecamatan', kabupaten, kecamatan);
            loadSelected("alamat_kelurahan", 'kelurahan', kecamatan, kelurahan);

            $("#form-tambah").modal("show");
            $("#modal-large-title").html("Edit Toko");
            return false;
        });

        $("#tambah-toko").click(function() {
            loadWilayah('alamat_provinsi', 'provinsi', 0, 'Provinsi');
            $("#form-tambah").modal("show");
            MODE = "tambah";
            $("#modal-large-title").html("Tambah Toko");

        });

        $("#btnSubmit").click(function() {
            var nama = $("#txt_nama").val();
            var kode = $("#txt_kode").val();
            var alamat = $("#txt_alamat").val();
            var koordinat = $("#txt_koordinat").val();
            var provinsi = $("#alamat_provinsi").val();
            var kabupaten = $("#alamat_kabupaten").val();
            var kecamatan = $("#alamat_kecamatan").val();
            var kelurahan = $("#alamat_kelurahan").val();

            if(nama != "") {
                var form_data = {};
                if(MODE == "tambah") {
                    form_data = {
                        "request": "tambah_toko",
                        "nama": nama,
                        "kode": kode,
                        "alamat": alamat,
                        "koordinat": koordinat,
                        "provinsi": provinsi,
                        "kabupaten": kabupaten,
                        "kecamatan": kecamatan,
                        "kelurahan": kelurahan
                    };
                } else {
                    form_data = {
                        "request": "edit_toko",
                        "uid": selectedUID,
                        "nama": nama,
                        "kode": kode,
                        "alamat": alamat,
                        "koordinat": koordinat,
                        "provinsi": provinsi,
                        "kabupaten": kabupaten,
                        "kecamatan": kecamatan,
                        "kelurahan": kelurahan
                    };
                }

                $.ajax({
                    async: false,
                    url: __HOSTAPI__ + "/Lokasi",
                    data: form_data,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                    },
                    type: "POST",
                    success: function(response){
                        $("#txt_nama").val("");
                        $("#form-tambah").modal("hide");
                        table.ajax.reload();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
        });

        $("#alamat_provinsi").on('change', function(){
            var id = $(this).val();

            loadWilayah('alamat_kabupaten', 'kabupaten', id, 'Kabupaten / Kota');
            resetSelectBox('alamat_kecamatan', "Kecamatan");
            resetSelectBox('alamat_kelurahan', "Kelurahan");
        });

        $("#alamat_kabupaten").on('change', function(){
            var id = $(this).val();

            loadWilayah('alamat_kecamatan', 'kecamatan', id, 'Kecamatan');
            resetSelectBox('alamat_kelurahan', "Kelurahan");
        });

        $("#alamat_kecamatan").on('change', function(){
            var id = $(this).val();

            loadWilayah('alamat_kelurahan', 'kelurahan', id, "Kelurahan");
        });

        function loadWilayah(selector, parent, id, name){

            resetSelectBox(selector, name);

            $.ajax({
                url:__HOSTAPI__ + "/Wilayah/"+ parent +"/" + id,
                type: "GET",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                },
                success: function(response){
                    var MetaData = response.response_package.response_data;

                    if (MetaData != ""){
                        for(i = 0; i < MetaData.length; i++){
                            var selection = document.createElement("OPTION");

                            $(selection).attr("value", MetaData[i].id).html(MetaData[i].nama);
                            $("#" + selector).append(selection);
                        }
                    }

                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function loadSelected(selector, parent, id, params){
            $.ajax({
                url:__HOSTAPI__ + "/Wilayah/"+ parent +"/" + id,
                type: "GET",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                },
                success: function(response){
                    var MetaData = response.response_package.response_data;

                    if (MetaData !== undefined){
                        for(i = 0; i < MetaData.length; i++){
                            var selection = document.createElement("OPTION");

                            $(selection).attr("value", MetaData[i].id).html(MetaData[i].nama);
                            if (MetaData[i].id == params) {
                                $(selection).attr("selected",true);
                                $("#" + selector).val(MetaData[i].id);
                                //$("#" + selector).trigger('change');
                            };

                            $("#" + selector).append(selection);
                        }
                    }

                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function resetSelectBox(selector, name){
            $("#"+ selector +" option").remove();
            var opti_null = "<option value='' selected disabled>Pilih "+ name +" </option>";
            $("#" + selector).append(opti_null);
        }

        $(".select2").select2({});

    });
</script>

<div id="form-tambah" class="modal fade" role="dialog" aria-labelledby="modal-large-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md bg-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-large-title">Tambah Toko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Kode Toko:</label>
                    <input type="text" class="form-control" id="txt_kode" />
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Nama Toko:</label>
                    <input type="text" class="form-control" id="txt_nama" />
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Provinsi:</label>
                    <select class="form-control select2" id="alamat_provinsi"></select>
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Kabupaten:</label>
                    <select class="form-control select2" id="alamat_kabupaten"></select>
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Kecamatan:</label>
                    <select class="form-control select2" id="alamat_kecamatan"></select>
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Kelurahan:</label>
                    <select class="form-control select2" id="alamat_kelurahan"></select>
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Koordinat:</label>
                    <input type="text" class="form-control" id="txt_koordinat" />
                </div>
                <div class="form-group col-md-12">
                    <label for="txt_no_skp">Alamat:</label>
                    <textarea class="form-control" id="txt_alamat"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>