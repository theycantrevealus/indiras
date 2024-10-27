<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<?php 

$customerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null; 
$rute = isset($_GET['rute']) ? $_GET['rute'] : null;
$ruteId = isset($_GET['rute_id']) ? $_GET['rute_id'] : null;  

?>

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
          <div class="col-sm-12 text-start">
            <a id="addRow" href="order-data.php" class="btn btn-danger">
              <i class="ti ti-arrow-left fs-4"></i>Kembali
            </a>
          </div>
          <hr />
          <div class="card bg-warning-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Daftar Divisi</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="order-data.php">Order</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Daftar Divisi</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <h5>Toko : <span id="toko-nama"></span></h5>
          <hr />
          <div class="datatables"> 
            <div class="card">
              <div class="card-body">
                <div class="col-md-12">
                  <div class="col-sm-12 text-end">
                    <button id="btnSearch" href="order-customer-detail.php" class="btn btn-warning">
                      <i class="ti ti-search fs-4"></i>Cari Divisi 
                    </button>
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <h5>Daftar Divisi: </h5>
                  <hr />
                  <div id="list-view" class="col-md-12 row">

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
                Cari Divisi 
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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

  $("#btnSearch").click(function() {
    $("#modal-search").modal("show");
  });

  $("#btnSubmitSearch").click(function() {
    const params = $("#customer-search").val();

    refreshDivisi(params);
    $("#modal-search").modal("hide");
  });

  if (`<?= $customerId ?>` == "") {
    $("#toko-nama").text("Belum dipilih");
  } else {
    const apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['toko_detail'] ?>";

    $.ajax({
      type: "GET",
      url: apiUrl + `/<?= $customerId ?>`,
      dataType: "JSON",
      beforeSend: function(request) {
        request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
      },
      success: function (response) {
        const parseData = parseResponse(response);
        $("#toko-nama").text(parseData.response_data.nama);
      }
    });
  }

  refreshDivisi();

  function refreshDivisi(params = "") { 
    let apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['supplier_list'] ?>";

    $.ajax({
      type: "GET",
      url: apiUrl + `?params=${params}`,
      dataType: "JSON",
      beforeSend: function(request) {
        request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
      },
      success: function (response) {
        let parseData = parseResponse(response);

        let html = ""; 
        parseData.response_data.forEach(function(item) {
          html += `
            <div class="col-md-4 mb-3">
              <a href="order-customer-detail.php?divisi_id=${item.id ?? item.uid}&customer_id=<?= $customerId ?>&rute=<?= $rute ?>&rute_id=<?= $ruteId ?>" class="btn btn-rounded btn-outline-warning d-flex w-100 d-block text-primary p-3">
                 <div class="col-md-12 text-start">
                    <h4 class="card-title mb-1 text-dark">${item.nama}</h4>
                  </div>   
                </a>
              </div>
           `;
        });
        
        if (parseData.response_data.length == 0) {
          html = "Data tidak ditemukan";
        }

        $("#list-view").html(html);
      }
    });
  }

</script>

<?php include './footer.php' ?>