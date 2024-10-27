<script type="text/javascript">
    $(function(){
        function getDateRange(target) {
            var rangeLaporan = $(target).val().split(" to ");
            if(rangeLaporan.length > 1) {
                return rangeLaporan;
            } else {
                return [rangeLaporan, rangeLaporan];
            }
        }

        var selectedToko = '';
        var selectedDivisi = '';
        var selectedOrder = 0;
        var tableOrder = $("#table-order").DataTable({
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
                    d.toko = selectedToko;
                    d.divisi = selectedDivisi;
                    d.from = getDateRange("#range_order")[0];
                    d.to = getDateRange("#range_order")[1];
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
            "rowCallback": function ( row, data, index ) {
                const status_color = ['info', 'warning', 'danger', 'success'];
                // console.log(data);
                // if(data.status === 0) {
                //     $("td", row).addClass("bg-danger-custom text-danger");
                // }
                $("td", row).addClass(`bg-${status_color[parseInt(data.status)]}-custom`);
            },
            "columns" : [
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<div class=\"btn-group wrap_content\" role=\"group\" aria-label=\"Basic example\">" +
                            "<button class=\"btn btn-info btn-sm order_detail\" id=\"detail_order_" + row["id"] + "\">" +
                            "<span><i class=\"fa fa-eye\"></i> Detail</span>" +
                            "</button>" +
                            "</div>";
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        return "<b class=\"wrap_content\">" + row.kode + "</b>";
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
                        const detail = row['detail'];
                        var total = 0;
                        for(const a in detail) {
                            total += parseFloat(detail[a].qty);
                        }
                        return total;
                    }
                },
                {
                    "data" : null, render: function(data, type, row, meta) {
                        const status = ['Baru', 'Pending', 'Cancel', 'Done'];
                        const status_color = ['info', 'warning', 'danger', 'success'];
                        return "<div class=\"badge badge-custom-caption badge-" + status_color[parseInt(row['status'])] + "\">" + status[parseInt(row['status'])] + "</div>";
                    }
                },
            ]
        });

        $("body").on("click", ".order_detail", function () {
            var id = $(this).attr("id").split("_");
            id = id[id.length - 1];
            selectedOrder = id;
            reloadDetail(id)
        });



        $("#range_order").change(function() {
            if(
                !Array.isArray(getDateRange("#range_order")[0]) &&
                !Array.isArray(getDateRange("#range_order")[1])
            ) {
                tableOrder.ajax.reload();
            }
        });

        $("#txt_divisi").select2({
            minimumInputLength: 2,
            "language": {
                "noResults": function() {
                    return "Divisi tidak ditemukan";
                }
            },
            ajax: {
                dataType: "json",
                headers: {
                    "Authorization": "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>,
                    "Content-Type": "application/json",
                },
                url: __HOSTAPI__ + "/Inventori/select2_supplier",
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
                                "text": "<di    v style=\"color:" + colorSet + " !important;\">" + item.kode + " - " + item.nama + "</div>",
                                "html": "<div class=\"select2_item_stock\">" +
                                    "<div style=\"color:" + colorSet + " !important;\">" + item.kode + " - " + item.nama + "</div>" +
                                    "</div>",
                                "title": item.nama,
                                "kode": item.kode,
                            }
                        })
                    };
                }
            },
            placeholder: "Cari Divisi",
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
            selectedDivisi = data.id;
            tableOrder.ajax.reload();
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
            selectedToko = data.id;
            tableOrder.ajax.reload();
        });

        function reloadDetail(id) {
            $.ajax({
                url:__HOSTAPI__ + "/Order/order_detail/" + id,
                async:false,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                },
                type:"GET",
                success:function(response) {
                    const status = ['Baru', 'Pending', 'Cancel', 'Done'];
                    const status_color = ['info', 'warning', 'danger', 'success'];
                    const metode_bayar = ['COD', 'Cicil 7 Hari', 'Cicil 14 Hari'];
                    data = response.response_package;
                    console.log(data);
                    $("#order_no").text(data.kode).addClass("text-info");
                    $("#order_tanggal").text("(" + data.tanggal + ")");
                    $("#order_status").text(status[parseInt(data.status)]).addClass(`badge-${status_color[parseInt(data.status)]}`);
                    $("#order_toko").text(data.toko_nama);
                    $("#order_toko_alamat").text(data.alamat);
                    $("#order_toko_lokasi").text(`${data.alamat_provinsi}, ${data.alamat_kabupaten}, ${data.alamat_kecamatan}, ${data.alamat_kelurahan}`);
                    $("#order_sales").text(data.sales_nama);
                    $("#order_rute").text(data.rute_nama);
                    $("#order_metode").text(metode_bayar[parseInt(data.metode_bayar)]);
                    $("#order_cancel").text(data.pegawai_cancel ?? '-');
                    $("#order_pending").text(data.pegawai_pending ?? '-');
                    $("#order_done").text(data.pegawai_done ?? '-');

                    $("#order_detail tbody tr").remove();
                    for(const a in data.detail) {
                        $("#order_detail tbody").append("<tr>" +
                            "<td>" + data.detail[a].nama_barang + "</td>" +
                            "<td>" + data.detail[a].qty + "</td>" +
                            "<td>" + data.detail[a].nama_satuan + "</td>" +
                            "<td>" + data.detail[a].type.toUpperCase() + "</td>" +
                            "</tr>");
                    }

                    if(parseInt(data.status) === 0) { // New
                        $("#btn_done").show();
                        $("#btn_cancel").show();
                        $("#btn_pending").show();
                    } else if(parseInt(data.status) === 1 || parseInt(data.status) === 0) { // Pending
                        $("#btn_done").show();
                        $("#btn_cancel").show();
                        $("#btn_pending").hide();
                    } else if(parseInt(data.status) === 2) { // Cancel
                        $("#btn_done").hide();
                        $("#btn_cancel").hide();
                        $("#btn_pending").hide();
                    } else if(parseInt(data.status) === 3) { // Done
                        $("#btn_done").hide();
                        $("#btn_cancel").hide();
                        $("#btn_pending").hide();
                    }

                    $("#form-detail-order").modal("show");
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        $("body").on("click", "#btn_done", function () {
            Swal.fire({
                title: "Selesaikan order?",
                showDenyButton: true,
                confirmButtonText: "Ya",
                denyButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        async: false,
                        url:__HOSTAPI__ + "/Order",
                        type: "POST",
                        data: {
                            request: "order_done",
                            status: 3,
                            order: selectedOrder,
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        success: function(response) {
                            $("#form-detail-order").modal("hide");
                            console.log(response);
                            selectedOrder = 0;
                            Swal.fire(
                                "Update Status",
                                "Order berhasil diupdate",
                                "success"
                            ).then((result) => {
                                tableOrder.ajax.reload();
                            });
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });

        $("body").on("click", "#btn_cancel", function () {
            Swal.fire({
                title: "Selesaikan order?",
                showDenyButton: true,
                confirmButtonText: "Ya",
                denyButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        async: false,
                        url:__HOSTAPI__ + "/Order",
                        type: "POST",
                        data: {
                            request: "order_cancel",
                            status: 2,
                            order: selectedOrder,
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        success: function(response) {
                            $("#form-detail-order").modal("hide");
                            console.log(response);
                            selectedOrder = 0;
                            Swal.fire(
                                "Update Status",
                                "Order berhasil diupdate",
                                "success"
                            ).then((result) => {
                                tableOrder.ajax.reload();
                            });
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });

        $("body").on("click", "#btn_pending", function () {
            Swal.fire({
                title: "Selesaikan order?",
                showDenyButton: true,
                confirmButtonText: "Ya",
                denyButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        async: false,
                        url:__HOSTAPI__ + "/Order",
                        type: "POST",
                        data: {
                            request: "order_pending",
                            status: 1,
                            order: selectedOrder,
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "Bearer " + <?php echo json_encode($_SESSION["token"]); ?>);
                        },
                        success: function(response) {
                            $("#form-detail-order").modal("hide");
                            console.log(response);
                            selectedOrder = 0;
                            Swal.fire(
                                "Update Status",
                                "Order berhasil diupdate",
                                "success"
                            ).then((result) => {
                                tableOrder.ajax.reload();
                            });
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });
    });
</script>

<div id="form-detail-order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-large-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-large-title">Order Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-large bg-white d-flex align-items-center">
                                <h5 class="card-header__title flex m-0"><span id="order_no">[ORD/xxx/xxx/xxx]</span> <span id="order_tanggal">[TANGGAL ORDER]</span></h5>
                                <div class="badge badge-custom" id="order_status">[STATUS]</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="form-mode table">
                                            <tr>
                                                <td class="wrap_content">Toko</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_toko">[NAMA TOKO]</b><br />
                                                    <b id="order_toko_alamat">[ALAMAT TOKO]</b><br />
                                                    <b id="order_toko_lokasi">[LOKASI TOKO]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="wrap_content">Sales</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_sales">[NAMA SALES]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="wrap_content">Rute</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_rute">[NAMA RUTE]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="form-mode table">
                                            <tr>
                                                <td class="wrap_content">Metode Pembayaran</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_metode">[METODE PEMBAYARAN]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="wrap_content">Dipending Oleh</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_pending">[PEGAWAI PENDING]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="wrap_content">Dicancel Oleh</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_cancel">[PEGAWAI CANCEL]</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="wrap_content">Diproses Oleh</td>
                                                <td class="wrap_content">:</td>
                                                <td>
                                                    <b id="order_done">[PEGAWAI PROSES]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped" id="order_detail">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Item</th>
                                                    <th class="wrap_content">Qty</th>
                                                    <th class="wrap_content">Satuan</th>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_done">Done</button>
                <button type="button" class="btn btn-warning" id="btn_pending">Pending</button>
                <button type="button" class="btn btn-danger" id="btn_cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>