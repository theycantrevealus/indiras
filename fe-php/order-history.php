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
                  <h4 class="fw-semibold mb-8">Riwayat Pesanan</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="order-data.php">Riwayat Pesanan</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Daftar Riwayat</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="datatables"> 
            <div class="card">
              <div class="card-body">
                <div class="col-md-12">
                  <div class="col-sm-12 text-end">
                    <button id="btnSearch" href="order-customer-detail.php" class="btn btn-warning">
                      <i class="ti ti-search fs-4"></i>Cari Riwayat 
                    </button>
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <h5>Daftar Riwayat: </h5>
                  <hr />
                  <div id="list-view" class="col-md-12">
                    
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
              <div class="col-md-12 row">
                <div class="col-md-6 mb-2 row">
                  <label for="customer-tgl-awal" class="col-md-12 col-form-label">Tanggal Awal</label>
                  <div class="col-md-12">
                    <input class="form-control" id="customer-tgl-awal" type="date" value="<?= date("Y-m-d") ?>" />
                  </div>
                </div>
                <div class="col-md-6 mb-2 row">
                  <label for="customer-tgl-akhir" class="col-md-12 col-form-label">Tanggal Akhir</label>
                  <div class="col-md-12">
                    <input class="form-control" id="customer-tgl-akhir" type="date" value="<?= date("Y-m-d") ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12 mb-2 row">
                  <label for="customer-toko" class="col-md-12 col-form-label">Toko</label>
                  <div class="col-md-12">
                    <select class="form-control" id="customer-toko"></select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12 mb-2 row">
                  <label for="customer-divisi" class="col-md-12 col-form-label">Divisi</label>
                  <div class="col-md-12">
                    <select class="form-control" id="customer-divisi"></select>
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

  let apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['history_list'] ?>";

  $("#btnSearch").click(function() {
    $("#modal-search").modal("show");
  });

  $("#btnSubmitSearch").click(function() {
    const params = $("#customer-search").val();

    refreshHistory(params);
    $("#modal-search").modal("hide");
  });

  $(`#customer-toko`).select2({
    dropdownParent: $("#modal-search"),
    placeholder: "Pilih toko...", 
    ajax: {
      url: "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['toko_search'] ?>",
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
        params.page = params.page || 1;

        return {
          results: result.response_data,
          pagination: params.page,
        };
      },
    },
    minimumInputLength: 1
  });

  $(`#customer-divisi`).select2({
    dropdownParent: $("#modal-search"),
    placeholder: "Pilih divisi...", 
    ajax: {
      url: "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['supplier_list'] ?>",
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
        const mapData = result.response_data.map(function(item) {
          item.text = item.nama;
          item.id = item.uid;
          return item;
        });

        params.page = params.page || 1;

        return {
          results: mapData,
          pagination: params.page,
        };
      },
    },
    minimumInputLength: 1
  });

  refreshHistory();

  function refreshHistory(params = "") {
    const payload = {
      request : "get_order_backend",
      search : { value: params },
      toko : $("#customer-toko").val(),
      divisi : $("#customer-divisi").val(),
      from : $("#customer-tgl-awal").val(),
      to : $("#customer-tgl-akhir").val(),
      start : 0,
      length : 50,
      draw : 1,
    };

    $.ajax({
      type: "POST",
      url: apiUrl,
      data: payload,
      dataType: "JSON",
      beforeSend: function(request) {
        request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
      },
      success: function (response) {
        let parseData = parseResponse(response);
       
        let html = "";
        parseData.response_data.forEach(function(item) {
          html += `
            <a href="order-history-detail.php?history_id=${item.id}" class="btn btn-rounded btn-outline-warning w-100 d-block text-primary p-2 col-md-12">
              <div class="col-md-12 text-start">
                <div class="col-md-12 text-end mb-1">
                  <span class="fs-1 badge rounded-pill text-bg-warning">${item.tanggal}</span>
                </div>
                <h4 class="card-title text-dark ms-2">${item.toko_nama}</h4>
                <hr />
                <div class="ms-2">
                  <span class="fs-3 d-flex align-items-center text-dark">Divisi : ${item.divisi_nama}
                  </span>
                  <span class="fs-2 d-flex align-items-center text-dark">Metode bayar : ${getMetodeBayar(item.metode_bayar)} 
                  </span>
                  <span class="fs-2 d-flex align-items-center text-dark">Rute : ${item.rute_nama} 
                  </span>
                </div>
              </div>   
            </a>
            &nbsp;
           `;
        });
        
        if (parseData.response_result == 0) {
          html = "Data tidak ditemukan";
        }

        $("#list-view").html(html);
      }
    });
  }

</script>

<?php include './footer.php' ?>