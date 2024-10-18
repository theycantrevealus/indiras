<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<?php 

$customerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null; 

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
          <div class="datatables"> 
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <div class="col-md-12 row">   
                    <div class="mb-2 col-md-6">
                      <select class="select2-data-ajax form-control" id="item-pick"></select>
                    </div>
                    <div class="col-md-2">
                      <button id="tambah-item" class="btn btn-primary mb-2">
                        <i class="ti ti-plus fs-4"></i>Tambah
                      </button>
                    </div>
                  </div> 
                </div>
                <div class="table-responsive mt-3">
                  <table id="order-item-table" class="table w-100 table-sm table-bordered display text-nowrap">
                    <thead>
                      <!-- start row -->
                      <tr>
                        <th width="40%">Item</th>
                        <th>Satuan Besar</th>
                        <th>Satuan Tengah</th>
                        <th>Aksi</th>
                      </tr>
                      <!-- end row -->
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- end Row selection and deletion (single row) -->
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
          <button type="button" class="btn btn-success waves-effect text-start" data-bs-dismiss="modal">
            Pesan!
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
      <!-- /.modal-dialog -->
  <div>

<div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>  

<!-- This Page JS -->
<script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="./assets/libs/select2/dist/js/select2.min.js"></script>

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

  /**
   * GET CUSTOMER
   */
  if (`<?= $customerId ?>` == "") {
    $(`#customer-name`).select2({
      placeholder: "Pilih toko...",
      ajax: {
        url: "./sample_data/customer-search.json",
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
      minimumInputLength: 1
    });

    $('#customer-name').on('select2:select', function (e) {
      const dataRes = e.params.data;
      $("#customer-alamat").val(dataRes.alamat);
      $("#customer-rute").val(dataRes.rute);
    });
  } else {
    const apiUrl = `./sample_data/customer-search-by-id.json`; // ?customer_id=`<?= $customerId ?>`;

    $.ajax({
      type: "GET",
      url: apiUrl,
      dataType: "JSON",
      success: function (response) {
        $("#customer-name").val(response.nama);
        $("#customer-alamat").val(response.alamat);
        $("#customer-rute").val(response.rute);
      }
    });
  }

  let orderItemsId = [];
  let orderItemsAll = [];

  let counter = 0;
  $("#tambah-item").click(function() {
    let itemSelected = $("#item-pick").select2('data');
    if (itemSelected.length == 0) {
      alert('Pilih item lebih dulu...');
      return false;
    }

    itemSelected = itemSelected[0];

    // check item is already exists
    const index = orderItemsId.indexOf(`${itemSelected.id}`);
    if (index !== -1) {
      alert('Item sudah ada pada daftar order');
      return false;
    }

    orderItemsId.push(itemSelected.id);
    orderItemsAll.push(itemSelected);

    counter += 1;
    const htmlAdd = `<tr>
      <td><div class="mb-4">${itemSelected.text}</div></td>
      <td>
        <div class="col-md-12 row">   
          <div class="col-md-12">
            <input class="form-control form-control-sm satuan_besar" data-id-item="${itemSelected.id}" type="number">
          </div>
          <label class="col-md-4">&nbsp; ${itemSelected.satuan_besar}</label>
        </div>
      </td>
      <td>
        <div class="col-md-12 row"> 
          <div class="col-md-12">
            <input class="form-control form-control-sm satuan_tengah" data-id-item="${itemSelected.id}" "type="number">
          </div>
          <label class="col-md-4">&nbsp; ${itemSelected.satuan_tengah}</label>
        </div>
      </td>
      <td>
        <button class="btn btn-sm btn-danger delete-order" data-item-id="${itemSelected.id}">
          <i class="ti ti-trash fs-4"></i>
        </button>
      </td>
    </tr>`;

    $("#order-item-table > tbody:last-child").append(htmlAdd);
    $("#item-pick").select2("val", "");
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

  $(`#item-pick`).select2({
    placeholder: "Pilih item...",
    ajax: {
      url: "./sample_data/order-item-search.json",
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
    minimumInputLength: 1
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

  $("#btnSubmit").click(function() {
    let toko = $("#customer-name").select2('data');
    if (toko.length == 0) {
      alert('Pilih toko lebih dahulu...');
      return false;
    }

    let metodeBayar = $("#customer-payment-method").select2('data');
    if (metodeBayar.length == 0) {
      alert('Pilih metode bayar lebih dahulu...');
      return false;
    }

    if (orderItemsId.length == 0) {
      alert('Pesanan kosong, isi item terlebih dahulu...');
      return false;
    }

    $("#confirm_toko").html(toko[0].text);
    $("#confirm_rute").html(toko[0].rute);
    $("#confirm_alamat").html(toko[0].alamat);
    $("#confirm_pembayaran").html(metodeBayar[0].text);
    
    $('.satuan_besar').each(function(i, obj) {
      const itemId = $(this).data("id-item");
      console.log(itemId);
      const jlh = $(this).val();
      for (let i = 0; i < orderItemsAll.length; i++) {
        if (orderItemsAll[i].id == itemId) {
          orderItemsAll[i].jlh_satuan_besar = jlh;
          orderItemsAll[i].satuan_besar_text = '-';

          if (jlh != '' && jlh != '0') {
            orderItemsAll[i].satuan_besar_text = `${jlh} ${orderItemsAll[i].satuan_besar}`;
          }
          break;
        }
      }
    });

    $('.satuan_tengah').each(function(i, obj) {
      const itemId = $(this).data("id-item");
      const jlh = $(this).val();
      for (let i = 0; i < orderItemsAll.length; i++) {
        if (orderItemsAll[i].id == itemId) {
          orderItemsAll[i].jlh_satuan_tengah = jlh; 
          orderItemsAll[i].satuan_tengah_text = '-';

          if (jlh != '' && jlh != '0') {
            orderItemsAll[i].satuan_tengah_text = `${jlh} ${orderItemsAll[i].satuan_tengah}`;
          }
          break;
        }
      }
    });
    console.log(orderItemsAll);

    let html = "";
    for(let i = 0; i < orderItemsAll.length; i++) {
      html += `<tr>
        <td>${orderItemsAll[i].text}</td>
        <td>${orderItemsAll[i].satuan_besar_text}</td>
        <td>${orderItemsAll[i].satuan_tengah_text}</td>
      </tr>`;
    }

    $("#order-item-confirm-table tbody").html(html);
    $("#modal-confirm").modal("show");
  });

</script>

<?php include './footer.php' ?>