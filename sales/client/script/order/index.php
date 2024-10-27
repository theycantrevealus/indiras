<script type="text/javascript">
    $(function(){
        var tablePegawai = $("#table-order").DataTable({
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            bPaginate: true,
            lengthMenu: [[20, 50, -1], [20, 50, "All"]],
            serverMethod: "POST",
            "ajax":{
                url: __HOSTAPI__ + "/Order",
                type: "POST",
                data: function(d) {
                    d.request = "get_order_backend";
                },
                headers:{
                    Authorization: "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>
                },
                dataSrc:function(response) {
                    var finalData = response.response_package.response_data;


                    response.draw = parseInt(response.response_package.response_draw);
                    response.recordsTotal = response.response_package.recordsTotal;
                    response.recordsFiltered = response.response_package.recordsTotal;

                    return finalData;
                }
            },
            language: {
                search: "",
                searchPlaceholder: "Nomor Order"
            },
            autoWidth: false,
            "bInfo" : false,
            aaSorting: [[2, "asc"]],
            "columnDefs":[
                {"targets":0, "className":"dt-body-left"}
            ],
            "columns" : [
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<div class=\"btn-group wrap_content\" role=\"group\" aria-label=\"Basic example\">" +
                            "<button class=\"btn btn-info btn-sm\">" +
                            "<span><i class=\"fa fa-eye\"></i> Detail</span>" +
                            "</button>" +
                            "</div>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<b class=\"wrap_content text-info\">" + row.kode + "</b>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span class=\"wrap_content\">" + row.tanggal + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return row.toko_nama;
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span class=\"wrap_content\">" + row.rute_nama + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span class=\"wrap_content\">" + row.sales_nama + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<span class=\"wrap_content\">" + row.divisi_nama + "</span>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "";
                    }
                },
            ]
        });

        $("body").on("click", ".btn-delete-pegawai", function(){
            var id = $(this).attr("id").split("_");
            id = id[id.length - 1];

            var conf = confirm("Hapus pegawai?");
            if(conf) {
                $.ajax({
                    url:__HOSTAPI__ + "/Pegawai/pegawai/" + id,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                    },
                    type:"DELETE",
                    success:function(resp) {
                        tablePegawai.ajax.reload();
                    }
                });
            }
        });

        $("body").on("click", ".btn-reset-password", function () {
            var id = $(this).attr("id").split("_");
            id = id[id.length - 1];

            Swal.fire({
                title: 'Ubah Password?',
                text: 'Password baru akan diaplikasi pada login selanjutnya. Semua client yang login dengan akun ini akan logout secara otomatis',
                showDenyButton: true,
                confirmButtonText: `Ya`,
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: __HOSTAPI__ + "/Pegawai",
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        type: "POST",
                        data: {
                            request: "reset_password",
                            uid: id
                        },
                        success:function(response) {
                            var parser = response.response_package.response_result;
                            if(parser > 0) {
                                Swal.fire(
                                    "Ubah Password",
                                    response.response_package.response_message,
                                    "success"
                                ).then((result) => {
                                    push_socket(__ME__, "reset_password", id, "Akun ini telah di reset", "warning");
                                });
                            } else {
                                Swal.fire(
                                    "Ubah Password",
                                    response.response_package.response_message,
                                    "error"
                                ).then((result) => {
                                    //
                                });
                            }
                        },
                        error: function (response) {
                            //
                        }
                    });
                }
            });
        });

        var generated_data = [];

        $("#btn-import").click(function () {
            $("#form-import").modal("show");
            return false;
        });

        $('#upload_csv').on('submit', function(event) {
            event.preventDefault();
            $("#csv_file_data").html("<h6 class=\"text-center\">Load Data...</h6>");
            var formData = new FormData(this);
            formData.append("request", "master_pegawai_import_fetch");
            $.ajax({
                url: __HOSTAPI__ + "/Pegawai",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                },
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    var data = response.response_package;
                    generated_data = data.row_data;
                    $("#csv_file_data").html("");
                    var thead = "";
                    if(data.column)
                    {
                        thead += "<tr>";
                        for(var count = 0; count < data.column.length; count++)
                        {
                            thead += "<th>"+data.column[count]+"</th>";
                        }
                        thead += "</tr>";
                    }
                    var table_view = document.createElement("TABLE");
                    $(table_view).append("<thead class=\"thead-dark\">" + thead + "</thead>");
                    $("#csv_file_data").append(table_view);

                    for(var rKey in data.row_data) {
                        var regexEmail = data.row_data[rKey].email.replace(new RegExp(/(\.)|( )/g), "_");
                        data.row_data[rKey].email = regexEmail;
                    }

                    $(table_view).addClass("table table-bordered table-striped table-responsive").DataTable({
                        data:data.row_data,
                        columns : data.column_builder
                    });

                    $("#upload_csv")[0].reset();
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });


        $("#import_data").click(function () {
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
                        url: __HOSTAPI__ + "/Pegawai",
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        type: "POST",
                        data: {
                            request: "proceed_import_pegawai",
                            data_import:generated_data
                        },
                        success:function(response)
                        {
                            console.log(response);
                            var html = "Imported : " + response.response_package.success_proceed + "<br />";
                            $("#csv_file_data").html(html);
                            $("#form-import").modal("hide");
                            tablePegawai.ajax.reload();
                            $("#import_data").removeAttr("disabled");
                            $("#csv_file").removeAttr("disabled");
                        },
                        error: function (response) {
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

<div id="form-import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-large-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-large-title">Import Pegawai</h5>
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
                                    <div id="csv_file_data" class="table-responsive"></div>
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