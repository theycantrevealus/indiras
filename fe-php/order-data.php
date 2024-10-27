<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
                  <h4 class="fw-semibold mb-8">Daftar Toko</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="order-data.php">Order</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Daftar Order</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
            <div class="col-sm-12 text-start">
              <a id="addRow" href="order-customer-divisi.php" class="btn btn-primary">
                <i class="ti ti-plus fs-4"></i>Tambah
              </a>
            </div>
          <br />
          <div class="datatables"> 
            <div class="card">
              <div class="card-body">
                <div class="col-md-12">
                  <div class="col-sm-12 text-end">
                    <button id="btnSearch" href="order-customer-detail.php" class="btn btn-warning">
                      <i class="ti ti-search fs-4"></i>Cari Toko 
                    </button>
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <h5>Daftar Toko: </h5>
                  <hr />
                  <div id="list-view">

                  </div>
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

      <div class="modal fade" id="modal-search" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
          <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
              <h4 class="modal-title" id="myLargeModalLabel">
                Cari Toko 
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="col-md-12 mb-2 row">
                  <label for="customer-rute" class="col-md-12 col-form-label">Rute</label>
                  <div class="col-md-12">
                    <select class="form-control" id="customer-rute"></select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12 mb-3 row">
                  <label for="customer-search" class="col-md-12 col-form-label">Kata kunci pencarian</label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" id="customer-search" placeholder="Ketikkan kata kunci...">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnSubmitSearch" class="btn btn-success waves-effect text-start" data-bs-dismiss="modal">
                Cari!
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      <div>
        
    </div>
  </div>


<div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>

<!-- This Page JS -->
<script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="./assets/libs/select2/dist/js/select2.min.js"></script>

<?php include './auth_check.php' ?>

<script>

  let apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['toko_list'] ?>";

  $("#btnSearch").click(function() {
    $("#modal-search").modal("show");
  });

  $("#btnSubmitSearch").click(function() {
    const rute = $("#customer-rute").val();
    const params = $("#customer-search").val();

    refreshToko(rute, params);
    $("#modal-search").modal("hide");
  });

  $(`#customer-rute`).select2({
    dropdownParent: $("#modal-search"),
    placeholder: "Pilih rute...", 
    ajax: {
      url: "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['rute_select'] ?>",
      dataType: "json",
      delay: 250,
      beforeSend: function(request) {
        request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
      },
      data: function (params) {
        return {
          params: params.term, // search term
          page: params.page,
        };
      },
      processResults: function (response, params) {
        const result = parseResponse(response);
        console.log(result);
        params.page = params.page || 1;

        return {
          results: result.response_data,
          pagination: params.page,
        };
      },
    },
    // minimumInputLength: 1
  });

  refreshToko();

  function refreshToko(rute = "", params = "") { 
    const ruteData = $("#customer-rute").select2('data');

    if (rute != "") {
      rute = `&rute=${rute}`;
    }

    $.ajax({
      type: "GET",
      url: apiUrl + `?params=${params}`,
      dataType: "JSON",
      beforeSend: function(request) {
        request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
      },
      success: function (response) {
        let parseData = parseResponse(response);
        console.log

        let html = "";
        parseData.response_data.forEach(function(item) {
          html += `
              <a href="order-customer-divisi.php?customer_id=${item.id_toko}&rute=${item.nama_rute}&rute_id=${item.id_rute}" class="btn btn-rounded btn-outline-info d-flex w-100 d-block text-primary p-3">
                 <div class="col-md-12 text-start">
                    <h4 class="card-title mb-1 text-dark">${item.nama_toko}</h4>
                    <hr />
                    <div>
                      <span class="fs-2 d-flex align-items-center text-dark">
                        <i class="ti ti-send text-primary fs-3 me-1"></i> ${item.nama_rute}
                      </span>
                      <span class="fs-2 d-flex align-items-center text-dark">
                        <i class="ti ti-map-pin text-danger fs-3 me-1"></i> ${item.alamat}
                      </span>
                    </div>
                  </div>   
              </a>
            &nbsp;
           `;
        });
        
        if (parseData.response_value == 0) {
          html = "Data tidak ditemukan";
        }

        $("#list-view").html(html);
      }
    });
  }

</script>

<?php include './footer.php' ?>