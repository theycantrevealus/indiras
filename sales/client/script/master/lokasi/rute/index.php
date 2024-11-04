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
                    console.clear();
                    console.log(response.response_package.response_data);
                    var returnedData = [];
                    if (response == undefined || response.response_package == undefined) {
                        returnedData = [];
                    } else {
                        returnedData = response.response_package.response_data;
                    }

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
                        return "<span meta='" + JSON.stringify(row["toko"]) + "' id=\"toko_" + row["id"] + "\">" + row["toko"].length + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span meta='" + JSON.stringify(row['sales']) + "' id=\"sales_" + row["id"] + "\">" + row["sales"].length + "</span>";
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

        // EDIT TOKO
        $("body").on("click", ".btn-edit-rute", function() {
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];
            selectedUID = uid;
            MODE = "edit";


            var hari = $("#nama_" + uid).html().trim().split(" ");
            var hariVal = $("#txt_hari option:contains(\"" +  hari[0] + "\")").attr('value');
            var hariSplit = hari[1].split("-");
            $("#txt_hari").val(hariVal);


            selectedToko = [];
            var listToko = JSON.parse($("#toko_" + uid).attr('meta'));
            listToko.map(function(e) {
                selectedToko.push({
                    id: e.toko,
                    kode: e.kode,
                    name: e.nama,
                    alamat: e.alamat,
                    alamat_provinsi_parse: e.alamat_kecamatan_parse,
                    alamat_kabupaten_parse: e.alamat_kecamatan_parse,
                    alamat_kecamatan_parse: e.alamat_kecamatan_parse,
                    alamat_kelurahan_parse: e.alamat_kelurahan_parse,
                })
            });

            accumulateToko();


            selectedSales = [];
            var listSales = JSON.parse($("#sales_" + uid).attr('meta'));

            listSales.map(function(e) {
                selectedSales.push({
                    id: e.sales,
                    name: e.nama
                })
            });

            accumulateSales();

            $("input[name=txt_no_hari]").each(function () {
                $(this).prop("checked", false);
            });


            $("input[name=txt_no_hari]").each(function () {
                if(hariSplit.indexOf($(this).attr("value")) >= 0) {
                    $(this).prop("checked", true);
                }
            });

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
                if(!selectedToko.find(o => parseInt(o.id) === parseInt(tokoID[0].id))) {
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

        accumulateSales();

        function accumulateSales(){
            $("#table-sales tbody tr").remove();
            // tableSales.find("TR").remove();
            if(selectedSales.length > 0) {
                selectedSales.map(function(data) {

                    var rowTables = document.createElement("TR");
                    var colName = document.createElement("TD");
                    var colAction = document.createElement("TD");
                    var btnDeleteSales = document.createElement("BUTTON");
                    $(btnDeleteSales).addClass("btn btn-danger btn-sm btn-delete-sales").html("<span><i class=\"fa fa-trash\"></i></span>").attr({
                        "id": "sales_" + data.id
                    });
                    $(colName).html(data.name);
                    $(colAction).append(btnDeleteSales);
                    $(rowTables).append(colName);
                    $(rowTables).append(colAction);

                    $("#table-sales tbody").append(rowTables);
                });
            } else {
                $("#table-sales tbody").append("<tr><td colspan='2'>No Data</td></tr>");
            }
        }

        $("body").on("click", ".btn-delete-sales", function () {
            var uid = $(this).attr("id").split("_");
            uid = uid[uid.length - 1];

            selectedSales = selectedSales.filter(item => item.id != uid);
            accumulateSales();
        });















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

        $("#btn-import").click(function() {
            $("#form-import").modal("show");
        });

        $('#upload_csv').on('submit', function(event) {
            event.preventDefault();
            $("#csv_file_data").html("<h6 class=\"text-center\">Load Data...</h6>");
            var formData = new FormData(this);
            formData.append("request", "master_inv_import_fetch");
            $.ajax({
                url: __HOSTAPI__ + "/Inventori",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                },
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    var data = response.response_package;
                    generated_data = data.row_data;
                    $("#csv_file_data").html("");
                    var thead = "";
                    if (data.column) {
                        thead += "<tr>";
                        for (var count = 0; count < data.column.length; count++) {
                            thead += "<th>" + data.column[count] + "</th>";
                        }
                        thead += "</tr>";
                    }
                    var table_view = document.createElement("TABLE");
                    $(table_view).append("<thead class=\"thead-dark\">" + thead + "</thead>");
                    $("#csv_file_data").append(table_view);
                    $(table_view).addClass("table table-bordered table-striped").DataTable({
                        data: data.row_data,
                        columns: data.column_builder
                    });

                    $("#upload_csv")[0].reset();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });

        $("#import_data").click(function() {
            Swal.fire({
                title: 'Proses import data?',
                showDenyButton: true,
                confirmButtonText: `Ya`,
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#csv_file_data").html("<h6 class=\"text-center\">Importing...</h6>");
                    $("#import_data").attr("disabled", "disabled");
                    $("#csv_file").attr("disabled", "disabled");
                    $.ajax({
                        url: __HOSTAPI__ + "/Lokasi",
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        type: "POST",
                        data: {
                            request: "proceed_import",
                            data_import: generated_data,
                            super: "farmasi"
                        },
                        success: function(response) {
                            console.clear();
                            console.log(response.response_package);
                            var html = "Imported : " + response.response_package.success_proceed + "<br />";
                            /*html += "Imported : " + response.response_package.success_proceed + "<br />";
                            html += "Imported : " + response.response_package.success_proceed + "<br />";*/

                            var failedData = response.response_package.failed_data;
                            console.log(failedData);
                            var failedResult = document.createElement("table");
                            $(failedResult).addClass("table").append("<thead class=\"thead-dark\">" +
                                "<tr>" +
                                "<th>Nama</th>" +
                                "<th>Kategori</th>/tr></thead><tbody></tbody>");

                            $("#csv_file_data").html(html).append(failedResult);
                            $(failedResult).DataTable({
                                data: failedData,
                                columns: [{
                                    data: "nama"
                                },
                                    {
                                        data: "kategori"
                                    },
                                ]
                            });

                            table.ajax.reload();
                            $("#import_data").removeAttr("disabled");
                            $("#csv_file").removeAttr("disabled");
                        },
                        error: function(response) {
                            $("#csv_file_data").html(response);
                            console.log(response);
                        }
                    });
                } else if (result.isDenied) {
                    //
                }
            });
        });

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
                                <option value="5">Jumat</option>
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

<div id="form-import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-large-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-large-title">Import Rute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-large bg-white d-flex align-items-center">
                                <h5 class="card-header__title flex m-0">CSV</h5>
                                <form id="upload_csv" method="post" enctype="multipart/form-data">
                                    <input type="file" name="csv_file" id="csv_file" accept=".csv" />
                                    <input type="submit" name="upload" id="upload" value="Upload" class="btn btn-info" />
                                </form>
                            </div>
                            <div class="card-body tab-content">
                                <div class="tab-pane active show fade">
                                    <div id="csv_file_data" style="min-height: 200px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="import_data">Import</button>
            </div>
        </div>
    </div>
</div>