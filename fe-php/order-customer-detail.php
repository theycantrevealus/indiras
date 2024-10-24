<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<?php 

$customerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : ""; 

?>

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CSS Assets -->
  <?php include './header-css.php' ?>
  
  <!-- Data Table -->
  <link rel="stylesheet" href="./assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />

  <link rel="stylesheet" href="./assets/libs/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="./assets/libs/sweetalert2/dist/sweetalert2.min.css">

</head>

<body class="link-sidebar">
  <!-- Preloader --> 
  <?php include './preloader.php' ?>

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <?php include "./sidebar.php" ?>
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php include "./header.php" ?>
      <!--  Header End -->

      <!-- Sidebar navigation-->
      <?php include "./sidebar-nav.php" ?>
      <!-- End Sidebar navigation -->
    
      <div class="body-wrapper">
        <div class="container-fluid">
        <div class="col-sm-12 text-start">
          <a href="order-customer-divisi.php?customer_id=<?= $_GET['customer_id'] ?>" class="btn btn-danger">
            <i class="ti ti-arrow-left fs-4"></i>Kembali
          </a>
        </div>
        <hr />
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
          <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Customer Detail Order</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./main/index.html">Order</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Daftar Order</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <h4 class="card-title mb-3">Data Customer</h4> -->
              <form>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6 mb-3 row">
                      <label for="customer-name" class="col-md-4 col-form-label">Sales</label>
                      <div class="col-md-8">
                        <input disabled class="form-control" type="text" id="sales-id" value="">
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="col-md-12">
                    <div class="col-md-12 mb-2 row">
                      <label for="customer-name" class="col-md-2 col-form-label">Toko</label>
                      <div class="col-md-10">
                        <?php 
                          if ($customerId) {
                            echo '<input hidden class="form-control" type="text" id="customer-id" disabled>';
                            echo '<input class="form-control" type="text" id="customer-name" disabled>';
                          } else {
                            echo '<select class="form-control" id="customer-name"></select>';
                          }
                        ?>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-12 mb-2 row">
                        <label for="customer-name" class="col-md-2 col-form-label">Rute</label>
                        <div class="col-md-4">
                          <input class="form-control" type="text" id="customer-rute" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-12 mb-3 row">
                        <label for="customer-alamat" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" id="customer-alamat" disabled>
                        </div>
                      </div>
                    </div>
                    <hr />
                    <div class="col-md-12">
                      <div class="col-md-12 mb-3 row">
                        <label for="customer-alamat" class="col-md-2 col-form-label">Metode Bayar</label>
                        <div class="col-md-4">
                          <select class="form-control" id="customer-payment-method"></select>
                        </div>
                      </div>
                    </div>
                    <hr />
                    <div class="datatables"> 
                      <div class="mb-2">
                        <div class="col-md-12 row">   
                          <div class="col-md-12">
                            <button type="button" id="tambah-item" class="btn btn-primary mb-2">
                              <i class="ti ti-plus fs-4"></i>Tambah Item
                            </button>
                          </div>
                        </div> 
                      </div>
                      <hr />
                      <h6>Daftar Pesanan: </h6>
                      <div class="table-responsive mt-3">
                        <div id="list-item-order">

                        </div>
                      </div>
                      <!-- end Row selection and deletion (single row) -->
                    </div>
                    <hr /> 
                    <div class="col-md-12 text-end">
                      <div class="mt-3 mt-md-0">
                        <button type="button" id="btnSubmit" class="btn btn-success hstack gap-6">
                          <i class="ti ti-send fs-4"></i>
                          Submit Order
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
        function handleColorTheme(e) {
          document.documentElement.setAttribute("data-color-theme", e);
        }
      </script>
    </div>
  </div>

  <div class="modal fade" id="modal-confirm" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            Konfirmasi Pesanan 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table id="" class="w-100 table-sm display text-nowrap">
            <tbody>
              <tr>
                <th width="10%">Toko</th>
                <th>:</th>
                <th id="confirm_toko"></th>
              </tr>
              <tr>
                <th>Rute</th>
                <th>:</th>
                <th id="confirm_rute"></th>
              </tr>
              <tr>
                <th>Alamat</th>
                <th>:</th>
                <th id="confirm_alamat"></th>
              </tr>
              <tr>
                <th>Pembayaran</th>
                <th>:</th>
                <th id="confirm_pembayaran"></th>
              </tr>
            </tbody>
          </table>
          <div class="table-responsive mt-3">
            <table id="order-item-confirm-table" class="table w-100 table-sm table-bordered display text-nowrap">
              <thead>
                <!-- start row -->
                <tr>
                  <th width="40%">Item</th>
                  <th>Satuan<br /> Besar</th>
                  <th>Satuan<br /> Tengah</th>
                </tr>
                <!-- end row -->
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSubmitPesanan" class="btn btn-success waves-effect text-start">
            Pesan!
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-tambah-item" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            Pilih item 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <div class="col-md-12 mb-3 row">
              <label for="customer-search" class="col-md-12 col-form-label">Cari</label>
              <div class="col-md-12">
                <input class="form-control" type="text" id="customer-search" placeholder="Ketikkan kata kunci...">
              </div>
            </div>
          </div>
          <div class="col-md-12 row" id="list-order-pick">

          </div>
          <!-- <table id="order-item-pick-table" class="table w-100 table-sm table-bordered display text-nowrap">
            <thead>
              <tr>
                <th width="40%">Item</th>
                <th>Satuan<br /> Besar</th>
                <th>Satuan<br /> Tengah</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table> -->
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
      <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="modal-tambah-item-konfirm" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            Pilih item 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input hidden type="text" id="id-konfirm-item">
          <div class="col-md-12">
            <div class="col-md-12 mb-2 row">
              <label for="konfirm-nama-item" class="col-md-2 col-form-label">Nama Item</label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="konfirm-nama-item" disabled>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12 mb-2 row">
              <label for="konfirm-satuan-besar" class="col-md-2 col-form-label">Satuan Besar</label>
              <div class="col-md-12 input-group">
                <input class="form-control" type="number" id="konfirm-satuan-besar" aria-describedby="caption-konfirm-satuan-besar">
                <span class="input-group-text" id="caption-konfirm-satuan-besar"></span>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12 mb-3 row">
              <label for="konfirm-satuan-tengah" class="col-md-2 col-form-label">Satuan Tengah</label>
              <div class="col-md-12 input-group">
                <input class="form-control" type="number" id="konfirm-satuan-tengah" aria-describedby="caption-konfirm-satuan-tengah">
                <span class="input-group-text" id="caption-konfirm-satuan-tengah"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSubmitKonfirm" class="btn btn-success waves-effect text-start" data-bs-dismiss="modal">
            Simpan
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
      <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="modal-tambah-item-konfirm-edit" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel">
            Edit item 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input hidden type="text" id="id-konfirm-item-edit">
          <div class="col-md-12">
            <div class="col-md-12 mb-2 row">
              <label for="konfirm-nama-item" class="col-md-2 col-form-label">Nama Item</label>
              <div class="col-md-4">
                <input class="form-control" type="text" id="konfirm-nama-item-edit" disabled>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12 mb-2 row">
              <label for="konfirm-satuan-besar" class="col-md-2 col-form-label">Satuan Besar</label>
              <div class="col-md-12 input-group">
                <input class="form-control" type="number" id="konfirm-satuan-besar-edit" aria-describedby="caption-konfirm-satuan-besar">
                <span class="input-group-text" id="caption-konfirm-satuan-besar-edit"></span>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12 mb-3 row">
              <label for="konfirm-satuan-tengah" class="col-md-2 col-form-label">Satuan Tengah</label>
              <div class="col-md-12 input-group">
                <input class="form-control" type="number" id="konfirm-satuan-tengah-edit" aria-describedby="caption-konfirm-satuan-tengah">
                <span class="input-group-text" id="caption-konfirm-satuan-tengah-edit"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnHapusItemOrder" class="btn btn-danger waves-effect text-start">
            Hapus Item!
          </button>
          <button type="button" id="btnSubmitKonfirmUpdate" class="btn btn-success waves-effect text-start">
            Simpan
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
      <!-- /.modal-dialog -->
  </div>

<div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>  

<!-- This Page JS -->
<script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="./assets/libs/select2/dist/js/select2.min.js"></script>

<script src="./assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>

<?php include './auth_check.php' ?>

<script>

  $("#sales-id").val(salesData.kode);

  const apiUrl = "./sample_data/order-item-list.json";
  const orderItem = localStorage.getItem(`order_item_cust_` + `<?= $customerId ?>`);

  if (orderItem) {
    const listItem = JSON.parse(orderItem);

    listItem.forEach(function(item) {
    });
  }

  let customerId = `<?= $customerId ?>`;

  /**
   * GET CUSTOMER
   */
  if (customerId == "") {
    $(`#customer-name`).select2({
      placeholder: "Pilih toko...",
      ajax: {
        url: "./sample_data/customer-search.json",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            params: params.term, // search term
            page: params.page,
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;

          return {
            results: data.data,
            pagination: params.page,
          };
        },
      },
      minimumInputLength: 1
    });

    $('#customer-name').on('select2:select', function (e) {
      const dataRes = e.params.data;
      $("#customer-alamat").val(dataRes.alamat);
      $("#customer-rute").val(dataRes.rute);
    });
  } else {
    const apiUrl = `./sample_data/customer-search-by-id.json`;

    $.ajax({
      type: "GET",
      url: apiUrl + `?customer_id=${customerId}`,
      dataType: "JSON",
      success: function (response) {
        $("#customer-name").val(response.data.nama);
        $("#customer-alamat").val(response.data.alamat);
        $("#customer-rute").val(response.data.rute);
      }
    });
  }

  let orderItemsId = [];
  let orderItemsAll = [];

  let counter = 0;
  $("#tambah-item").click(function() {
    $("#modal-tambah-item").modal("show");

    const apiSearch = `./sample_data/order-item-list.json`;
    $.ajax({
      type: "GET",
      url: apiSearch,
      dataType: "JSON",
      success: function (response) {
        let html = "";
        response.data.forEach(function(item) {
          html += `
            <div class="col-md-4 mb-2">
              <button class="btn btn-rounded btn-outline-info d-flex w-100 d-block text-primary p-2 tambah-item-detail" data-item-id="${item.id}" data-item-name="${item.nama}" data-satuan-besar="${item.satuan_besar}" data-satuan-tengah="${item.satuan_tengah}">
                 <div class="col-md-12 text-start">
                    <h4 class="card-title mb-1 text-dark">${item.nama}</h4>
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <span class="fs-2 d-flex align-items-center text-dark">
                              <i class="ti ti-package text-primary fs-3 me-1"></i>Satuan Besar
                            </span>
                          </td>
                          <td>
                            <span class="fs-2 d-flex align-items-center text-dark">
                              : &nbsp; <b> ${item.satuan_besar} </b>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="fs-2 d-flex align-items-center text-dark">
                              <i class="ti ti-briefcase text-warning fs-3 me-1"></i>Satuan Tengah
                            </span>
                          </td>
                          <td>
                            <span class="fs-2 d-flex align-items-center text-dark">
                              : &nbsp; <b> ${item.satuan_tengah} </b>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>   
                </button>
              </div>
          `;
        });

        $("#list-order-pick").html(html);
      }
    });
  });

  $("#list-order-pick").on('click', '.tambah-item-detail', function() {
    const namaItem = $(this).data("item-name");
    const satuanBesar = $(this).data("satuan-besar");
    const satuanTengah = $(this).data("satuan-tengah");
    const itemId = $(this).data("item-id");

    // check item is already exists
    const index = orderItemsId.indexOf(`${itemId}`);
    if (index !== -1) {
      Swal.fire(
        "Gagal!",
        "Item sudah ada pada daftar order, silahkan edit jika ingin mengubah jumlah pesanan...",
        "error"
      );
      return false;
    }

    $("#konfirm-satuan-besar").val("");
    $("#konfirm-satuan-tengah").val("");
    $("#konfirm-nama-item").val(namaItem);
    $("#caption-konfirm-satuan-besar").html(satuanBesar);
    $("#caption-konfirm-satuan-tengah").html(satuanTengah);
    $("#id-konfirm-item").val(itemId);
    $("#modal-tambah-item-konfirm").modal("show");
  });

  $(`#customer-payment-method`).select2({
    placeholder: "Pilih pembayaran...",
    ajax: {
      url: "./sample_data/payment-method-search.json",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        return {
          results: data.items,
          pagination: params.page,
        };
      },
    },
  });

  $("#order-item-table tbody").on('click', '.delete-order', function() {
    const itemId = $(this).data('item-id');
    const index = orderItemsId.indexOf(`${itemId}`);
    if (index !== -1) {
      orderItemsId.splice(index, 1);
    }

    for (let i = 0; i < orderItemsAll.length; i++) {
      if (orderItemsAll[i].id == itemId) {
        orderItemsAll.splice(i, 1);
      }
    }

    $(this).parent().parent().remove();
  });

  $("#btnSubmitKonfirm").click(function() {
    const itemId = $("#id-konfirm-item").val();
    let satuanBesar = $("#konfirm-satuan-besar").val();
    let satuanTengah = $("#konfirm-satuan-tengah").val();
    const namaItem = $("#konfirm-nama-item").val();
    const satuanBesarName = $("#caption-konfirm-satuan-besar").text();
    const satuanTengahName = $("#caption-konfirm-satuan-tengah").text();

    if (satuanBesar == "" && satuanTengah == "") {
      Swal.fire(
        "Perhatian!",
        'Isi jumlah pesanan pada satuan besar atau tengah...',
        "warning"
      );
      return false;
    }

    // check item is already exists
    const index = orderItemsId.indexOf(`${itemId}`);
    if (index !== -1) {
      Swal.fire(
        "Gagal!",
        "Item sudah ada pada daftar order, silahkan edit jika ingin mengubah jumlah pesanan...",
        "error"
      );
      return false;
    }

    satuanBesar = satuanBesar ?? 0;
    satuanTengah = satuanTengah ?? 0;

    orderItemsId.push(itemId);
    orderItemsAll.push({
      id: itemId,
      nama: namaItem, 
      satuan_besar: satuanBesarName,
      satuan_tengah: satuanTengahName,
      jlh_satuan_besar: satuanBesar,
      jlh_satuan_tengah: satuanTengah,
      text_satuan_besar: `${satuanBesar} ${satuanBesarName}`,
      text_satuan_tengah: `${satuanTengah} ${satuanTengahName}`,
    });

    $("#modal-tambah-item-konfirm").modal("hide");
    $("#modal-tambah-item").modal("hide");

    Swal.fire(
      "Berhasil!",
      "Item berhasil ditambahkan",
      "success"
    );

    reloadItem();
    return false;
  });

  $("#btnSubmit").click(function() {

    let metodeBayar = $("#customer-payment-method").select2('data');
    if (metodeBayar.length == 0) {
      Swal.fire(
        "Perhatian!",
        'Pilih metode bayar lebih dahulu...',
        "warning"
      );
      return false;
    }
    $("#confirm_pembayaran").html(metodeBayar[0].text);

    if (orderItemsId.length == 0) {
      Swal.fire(
        "Perhatian!",
        'Pesanan kosong, isi item terlebih dahulu...',
        "warning"
      );
      return false;
    }

    if (customerId == "") {
      let toko = $("#customer-name").select2('data');
      if (toko.length == 0) {
        Swal.fire(
          "Perhatian!",
          'Pilih toko lebih dahulu...',
          "warning"
        );
        return false;
      }

      $("#confirm_toko").html(toko[0].text);
      $("#confirm_rute").html(toko[0].rute);
      $("#confirm_alamat").html(toko[0].alamat);
      $("#confirm_pembayaran").html(metodeBayar[0].text);
    } else {
      $("#confirm_toko").html($("#customer-name").val());
      $("#confirm_rute").html($("#customer-rute").val());
      $("#confirm_alamat").html($("#customer-alamat").val());
    }

    customerId = $("#customer-name").val();

    let html = "";
    orderItemsAll.forEach(function(item) {
      html += `<tr>
        <td>${item.nama}</td>
        <td>${item.text_satuan_besar}</td>
        <td>${item.text_satuan_tengah}</td>
      </tr>`;
    });
    
    $("#order-item-confirm-table tbody").html(html);
    $("#modal-confirm").modal("show");

    $(this).prop("disabled", true);
    $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`);
  });

  $('#modal-confirm').on('hidden.bs.modal', function (e) {
    $("#btnSubmit").prop("disabled", false);
    $("#btnSubmit").html(`<i class="ti ti-send fs-4"></i>Submit Order`);
  });

  $("#btnSubmitPesanan").click(function() {
    const apiPost = './sample_data/submit-order-success.json'; 
    $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mohon tunggu...`);

    setTimeout(function() {
      const payload = {
        customer_id: customerId,
        divisi_id: `<?= $_GET['divisi_id'] ?>`,
        metode_bayar: $(`#customer-payment-method`).val(),
        order_list: orderItemsAll,
      };

      $.ajax({
        type: "POST",
        url: apiPost,
        data: payload,
        dataType: "JSON", 
        success: function (response) {
          if (response.status == 'success') {
            $("#modal-confirm").modal("hide");
            
            Swal.fire({
              title: "Pesanan berhasil dibuat!",
              text: "Lanjutkan order di toko ini?",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Ya, lanjut!",
              cancelButtonText: "Tidak",
              closeClick: false,
              allowOutsideClick: false
            }).then((result) => {
              if (!result.value) {
                window.location.href = 'order-data.php';
              } else { 
                window.location.href = `order-customer-divisi.php?customer_id=${customerId}`;
              }
            }); 
            
          } else {
            Swal.fire(
              "Gagal!",
              'Gagal membuat pesanan...',
              "error"
            );

            $("#modal-confirm").modal("hide");
            $("#btnSubmitPesanan").html(`Pesan!`);
          }
        }
      });
      
      return false;
    }, 1000);

    return false;
  });

  $("#btnSubmitKonfirmUpdate").click(function () {
    const itemId = $("#id-konfirm-item-edit").val();
    let satuanBesar = $("#konfirm-satuan-besar-edit").val();
    let satuanTengah = $("#konfirm-satuan-tengah-edit").val();
    const namaItem = $("#konfirm-nama-item-edit").val();
    const satuanBesarName = $("#caption-konfirm-satuan-besar-edit").text();
    const satuanTengahName = $("#caption-konfirm-satuan-tengah-edit").text();

    if (satuanBesar == "" && satuanTengah == "") {
      Swal.fire(
        "Perhatian!",
        'Isi jumlah pesanan pada satuan besar atau tengah...',
        "warning"
      );
      return false;
    }

    satuanBesar = satuanBesar ?? 0;
    satuanTengah = satuanTengah ?? 0;
    
    let itemIndexSelect = -1;
    itemsSelect = orderItemsAll.filter((data, index) => {
      if (data.id == itemId) {
        itemIndexSelect = index;
        return data;
      }
    });
    orderItemsAll[itemIndexSelect].jlh_satuan_besar = satuanBesar;
    orderItemsAll[itemIndexSelect].jlh_satuan_tengah = satuanTengah;
    orderItemsAll[itemIndexSelect].text_satuan_besar = `${satuanBesar} ${itemsSelect[0].satuan_besar}`;
    orderItemsAll[itemIndexSelect].text_satuan_tengah = `${satuanTengah} ${itemsSelect[0].satuan_tengah}`;

    $("#modal-tambah-item-konfirm-edit").modal("hide");
    Swal.fire(
      "Berhasil!",
      "Item berhasil diubah...",
      "success"
    );

    reloadItem();
    return false;
  });

  $("#btnHapusItemOrder").click(function() {
    const itemId = $("#id-konfirm-item-edit").val();

    const index = orderItemsId.indexOf(`${itemId}`);
    if (index > -1) {
      Swal.fire({
        title: "Perhatian",
        text: "Yakin hapus data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.value) {
          orderItemsId.splice(index, 1);

          for (let i = 0; i < orderItemsAll.length; i++) {
            if (orderItemsAll[i].id == itemId) {
              orderItemsAll.splice(i, 1);
            }
          }

          Swal.fire(
            "Sukses!",
            'Berhasil menghapus pesanan...',
            "success"
          );

          $("#modal-tambah-item-konfirm-edit").modal("hide");
          reloadItem();
          console.log(orderItemsId);
          console.log(orderItemsAll);
        }
      });
      return false;
    }
  });

  function reloadItem() {
    let html = "";
    orderItemsAll.forEach(function(item) {
      html += `
        <div class="col-md-4 mb-2">
          <button onClick="popUpEdit(this.id)" id="item-id-${item.id}" type="button" class="btn btn-rounded btn-outline-success d-flex w-100 d-block text-primary p-2 order-tambah-item-detail">
              <div class="col-md-12 text-start">
                <h4 class="card-title mb-1 text-dark">${item.nama}</h4>
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <span class="fs-2 d-flex align-items-center text-dark">
                          <i class="ti ti-package text-primary fs-3 me-1"></i>Satuan Besar
                        </span>
                      </td>
                      <td>
                        <span class="fs-2 d-flex align-items-center text-dark">
                          : &nbsp; <b> ${item.text_satuan_besar} </b>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fs-2 d-flex align-items-center text-dark">
                          <i class="ti ti-briefcase text-warning fs-3 me-1"></i>Satuan Tengah
                        </span>
                      </td>
                      <td>
                        <span class="fs-2 d-flex align-items-center text-dark">
                          : &nbsp; <b> ${item.text_satuan_tengah} </b>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>   
            </button>
          </div>
      `;
    });

    $("#list-item-order").html(html);
  }

  function popUpEdit(e) {
    const itemId = e.replace('item-id-','');
    let itemDetail = orderItemsAll.filter(i => i.id == itemId);

    itemDetail = itemDetail[0];
    $("#konfirm-satuan-besar-edit").val(itemDetail.jlh_satuan_besar);
    $("#konfirm-satuan-tengah-edit").val(itemDetail.jlh_satuan_tengah);
    $("#konfirm-nama-item-edit").val(itemDetail.nama);
    $("#caption-konfirm-satuan-besar-edit").html(itemDetail.satuan_besar);
    $("#caption-konfirm-satuan-tengah-edit").html(itemDetail.satuan_tengah);
    $("#id-konfirm-item-edit").val(itemId);
    $("#modal-tambah-item-konfirm-edit").modal("show");
  }

</script>

<?php include './footer.php' ?>