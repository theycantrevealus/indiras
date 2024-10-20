<script type="text/javascript">
    $(function(){
        var MODE = "tambah", selectedUID;
        var selectedSales = [];
        var selectedToko = [];

        var table = $("#table-rute").DataTable({
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
                    d.request = "get_rute";
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
                searchPlaceholder: "Cari Nama Rute"
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
                            "<button class=\"btn btn-info btn-sm btn-edit-rute\" id=\"rute_edit_" + row["id"] + "\">" +
                            "<span><i class=\"fa fa-pencil-alt\"></i> Edit</span>" +
                            "</button>" +
                            "<button id=\"rute_delete_" + row['id'] + "\" class=\"btn btn-danger btn-sm btn-delete-rute\">" +
                            "<span><i class=\"fa fa-trash\"></i> Hapus</span>" +
                            "</button>" +
                            "</div>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"nama_" + row["id"] + "\">" + row["nama"] + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"toko_" + row["id"] + "\">" + row["toko"].length + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span id=\"sales_" + row["id"] + "\">" + row["sales"].length + "</span>";
                    }
                },
            ]
        });

        $("body").on("click", ".btn-delete-rute", function(){
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];

            var conf = confirm("Hapus rute item?");
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

        $("body").on("click", ".btn-edit-rute", function() {
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];
            selectedUID = uid;
            MODE = "edit";

            alert(uid);

            $("#form-tambah").modal("show");
            $("#modal-large-title").html("Edit Rute");
            return false;
        });

        $("#tambah-rute").click(function() {
            $("#form-tambah").modal("show");
            MODE = "tambah";
            $("#modal-large-title").html("Tambah Rute");

        });



        $("#txt_toko").select2({
            minimumInputLength: 2,
            "language": {
                "noResults": function() {
                    return "Toko tidak ditemukan";
                }
            },
            ajax: {
                dataType: "json",
                headers: {
                    "Authorization": "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>,
                    "Content-Type": "application/json",
                },
                url: __HOSTAPI__ + "/Lokasi/get_all_toko",
                type: "GET",
                data: function(term) {
                    return {
                        search: term.term
                    };
                },
                cache: true,
                processResults: function(response) {
                    var data = response.response_package.response_data;
                    return {
                        results: $.map(data, function(item) {
                            var colorSet = "#808080";
                            return {
                                "id": item.id,
                                "text": "<div style=\"color:" + colorSet + " !important;\">" + item.kode + " - " + item.nama + "</div>",
                                "html": "<div class=\"select2_item_stock\">" +
                                    "<div style=\"color:" + colorSet + " !important;\">" + item.kode + " - " + item.nama + "</div>" +
                                    "</div>",
                                "title": item.nama,
                                "alamat": item.alamat,
                                "kode": item.kode,
                                alamat_provinsi_parse: item.alamat_kecamatan_parse,
                                alamat_kabupaten_parse: item.alamat_kecamatan_parse,
                                alamat_kecamatan_parse: item.alamat_kecamatan_parse,
                                alamat_kelurahan_parse: item.alamat_kelurahan_parse,
                            }
                        })
                    };
                }
            },
            placeholder: "Cari Toko",
            selectOnClose: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return data.html;
            },
            templateSelection: function(data) {
                return data.text;
            }
        }).on("select2:select", function(e) {
            var data = e.params.data;
        });

        $("#btn_tambah_toko").click(function () {
            var tokoID = $("#txt_toko").select2('data');
            if(tokoID[0]) {

                if(!selectedToko.find(o => o.id === tokoID[0].id)) {
                    selectedToko.push({
                        id: tokoID[0].id,
                        kode: tokoID[0].kode,
                        name: tokoID[0].title,
                        alamat: tokoID[0].alamat,
                        alamat_provinsi_parse: tokoID[0].alamat_kecamatan_parse,
                        alamat_kabupaten_parse: tokoID[0].alamat_kecamatan_parse,
                        alamat_kecamatan_parse: tokoID[0].alamat_kecamatan_parse,
                        alamat_kelurahan_parse: tokoID[0].alamat_kelurahan_parse,
                    });

                    accumulateToko();
                }
            }
        });

        accumulateToko();

        function accumulateToko(){
            $("#table-toko tbody tr").remove();
            // tableSales.find("TR").remove();
            if(selectedToko.length > 0) {
                selectedToko.map(function(data) {

                    var rowTables = document.createElement("TR");
                    var colKode = document.createElement("TD");
                    var colName = document.createElement("TD");
                    var colAlamat = document.createElement("TD");
                    var colProvinsi = document.createElement("TD");
                    var colKabupaten = document.createElement("TD");
                    var colKecamatan = document.createElement("TD");
                    var colKelurahan = document.createElement("TD");

                    var colAction = document.createElement("TD");
                    var btnDeleteSales = document.createElement("BUTTON");
                    $(btnDeleteSales).addClass("btn btn-danger btn-sm btn-delete-toko").html("<span><i class=\"fa fa-trash\"></i></span>").attr({
                        "id": "toko-" + data.id
                    });
                    $(colKode).html(data.kode);
                    $(colName).html(data.name);
                    $(colAlamat).html(data.alamat);
                    $(colProvinsi).html(data.alamat_provinsi_parse);
                    $(colKabupaten).html(data.alamat_kabupaten_parse);
                    $(colKecamatan).html(data.alamat_kecamatan_parse);
                    $(colKelurahan).html(data.alamat_kelurahan_parse);

                    $(colAction).append(btnDeleteSales);
                    $(rowTables).append(colKode);
                    $(rowTables).append(colName);
                    $(rowTables).append(colAlamat);
                    $(rowTables).append(colProvinsi);
                    $(rowTables).append(colKabupaten);
                    $(rowTables).append(colKecamatan);
                    $(rowTables).append(colKelurahan);
                    $(rowTables).append(colAction);

                    $("#table-toko tbody").append(rowTables);
                });
            } else {
                $("#table-toko tbody").append("<tr><td colspan='4'>No Data</td></tr>");
            }
        }

        $("body").on("click", ".btn-delete-toko", function () {
            var uid = $(this).attr("id").split("-");
            uid = uid[uid.length - 1];
            selectedToko = selectedToko.filter(item => item.id != uid);
            accumulateToko();
        });




        $("#txt_sales").select2({
            minimumInputLength: 2,
            "language": {
                "noResults": function() {
                    return "Sales tidak ditemukan";
                }
            },
            ajax: {
                dataType: "json",
                headers: {
                    "Authorization": "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>,
                    "Content-Type": "application/json",
                },
                url: __HOSTAPI__ + "/Pegawai/get_all_pegawai",
                type: "GET",
                data: function(term) {
                    return {
                        search: term.term
                    };
                },
                cache: true,
                processResults: function(response) {
                    var data = response.response_package.response_data;
                    return {
                        results: $.map(data, function(item) {
                            var colorSet = "#808080";

                            return {
                                "id": item.uid,
                                "text": "<div style=\"color:" + colorSet + " !important;\">" + item.nama + "</div>",
                                "html": "<div class=\"select2_item_stock\">" +
                                    "<div style=\"color:" + colorSet + " !important;\">" + item.nama + "</div>" +
                                    "</div>",
                                "title": item.nama
                            }
                        })
                    };
                }
            },
            placeholder: "Cari Sales",
            selectOnClose: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return data.html;
            },
            templateSelection: function(data) {
                return data.text;
            }
        }).on("select2:select", function(e) {
            var data = e.params.data;
            // refreshData(myNewChart, $("#actionType option:selected").val(), data.id);
            // LogList.ajax.reload();
        });

        $("#btn_tambah_sales").click(function () {
            var salesID = $("#txt_sales").select2('data');

            if(salesID[0] && salesID[0].id.toLowerCase() !== 'all') {

                if(!selectedSales.find(o => o.id === salesID[0].id)) {
                    selectedSales.push({
                        id: salesID[0].id,
                        name: salesID[0].title
                    });

                    accumulateSales();
                }
            }

        });

        function accumulateSales(){
            $("#table-sales tbody tr").remove();
            // tableSales.find("TR").remove();
            selectedSales.map(function(data) {

                var rowTables = document.createElement("TR");
                var colName = document.createElement("TD");
                var colAction = document.createElement("TD");
                var btnDeleteSales = document.createElement("BUTTON");
                $(btnDeleteSales).addClass("btn btn-danger btn-sm btn-delete-sales").html("<span><i class=\"fa fa-trash\"></i></span>").attr({
                    "id": "sales-" + data.id
                });
                $(colName).html(data.name);
                $(colAction).append(btnDeleteSales);
                $(rowTables).append(colName);
                $(rowTables).append(colAction);

                $("#table-sales tbody").append(rowTables);
            });
        }















        $("#btnSubmit").click(function() {
            var hari = $("#txt_hari").val();
            var week_no = $("input[name=txt_no_hari]:checked");
            var selectedWeek = []
            week_no.each(function(){
                selectedWeek.push(this.value)
            });

            if(selectedWeek.length > 0 && selectedSales.length > 0 && selectedToko.length > 0) {
                var form_data = {};
                if(MODE == "tambah") {
                    form_data = {
                        "request": "tambah_rute",
                        "hari": hari,
                        "week_no": selectedWeek.join("-"),
                        "sales": selectedSales,
                        "toko": selectedToko
                    };
                } else {
                    form_data = {
                        "request": "edit_rute",
                        "id": selectedUID,
                        "hari": hari,
                        "week_no": selectedWeek.join("-"),
                        "sales": selectedSales,
                        "toko": selectedToko
                    };
                }

                console.log(form_data);

                $.ajax({
                    async: false,
                    url: __HOSTAPI__ + "/Lokasi",
                    data: form_data,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                    },
                    type: "POST",
                    success: function(response){
                        console.log(response);
                        $("#form-tambah").modal("hide");
                        table.ajax.reload();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
        });

        function resetSelectBox(selector, name){
            $("#"+ selector +" option").remove();
            var opti_null = "<option value='' selected disabled>Pilih "+ name +" </option>";
            $("#" + selector).append(opti_null);
        }

    });
</script>

<div id="form-tambah" class="modal fade" role="dialog" aria-labelledby="modal-large-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-large-title">Tambah Rute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
<!--                    <div class="col-lg-4">-->
<!--                        <div class="form-group col-md-12">-->
<!--                            <label for="txt_no_skp">Nama Rute:</label>-->
<!--                            <input type="text" class="form-control" id="txt_nama" />-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-lg-3">
                        <div class="form-group col-md-12">
                            <label for="txt_no_skp">Hari:</label>
                            <select class="form-control" id="txt_hari">
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jum'at</option>
                                <option value="6">Sabtu</option>
                                <option value="7">Minggu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="form-group col-md-12">
                            <label for="txt_no_skp">Nomor Hari:</label>
                            <div class="row">
                                <?php
                                for($noHari = 1; $noHari <=4; $noHari++) {
                                    ?>
                                    <div class="col-lg-1">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" value="<?php echo $noHari; ?>" id="txt_no_hari_<?php echo $noHari; ?>" name="txt_no_hari" aria-label="Checkbox for following text input">
                                                </div>
                                            </div>
                                            <input type="text"  class="form-control" aria-label="Text input with checkbox" value="<?php echo $noHari; ?>" disabled />
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <hr />
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="txt_no_skp">Pilih Toko:</label>
                                <select class="form-control" id="txt_toko"></select>
                            </div>
                        </div>
                        &nbsp;<button type="button" class="btn btn-primary" id="btn_tambah_toko">Tambah Toko</button>
                        <hr />
                        <table class="table table-padding largeDataType" id="table-toko">
                            <thead class="thead-dark">
                            <tr>
                                <th class="wrap_content">Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th class="wrap_content">Aksi</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group col-md-6">
                            <label for="txt_no_skp">Pilih Sales:</label>
                            <select class="form-control" id="txt_sales"></select>
                        </div>
                        &nbsp;<button type="button" class="btn btn-primary" id="btn_tambah_sales">Tambah Sales</button>
                        <hr />
                        <table class="table table-padding largeDataType" id="table-sales">
                            <thead class="thead-dark">
                            <tr>
                                <th>Nama</th>
                                <th class="wrap_content">Aksi</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>