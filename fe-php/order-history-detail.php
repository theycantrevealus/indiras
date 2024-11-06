<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<?php 

$historyId = isset($_GET['history_id']) ? $_GET['history_id'] : ""; 

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
          <a href="order-history.php" class="btn btn-danger">
            <i class="ti ti-arrow-left fs-4"></i>Kembali
          </a>
        </div>
        <hr />
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
          <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Detail Riwayat</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./main/index.html">Riwayat Pemesanan</a>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <h4 class="card-title mb-3">Data Customer</h4> -->
              <table id="" class="w-100 table-sm display">
                <tbody>
                  <tr>
                    <th width="10%">Kode</th>
                    <th>:</th>
                    <th style="word-wrap: break-word;"><mark><span id="id_history" class="p-1"> - </span></mark></th>
                  </tr>
                  <tr>
                    <th width="10%">Toko</th>
                    <th>:</th>
                    <th id="confirm_toko"> - </th>
                  </tr>
                  <tr>
                    <th>Divisi</th>
                    <th>:</th>
                    <th id="divisi"> - </th>
                  </tr>
                  <tr>
                    <th>Rute</th>
                    <th>:</th>
                    <th id="confirm_rute"> - </th>
                  </tr>
                  <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <th id="confirm_alamat"> - </th>
                  </tr>
                  <tr>
                    <th>Pembayaran</th>
                    <th>:</th>
                    <th id="confirm_pembayaran"> - </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <h5>Daftar Pesanan: </h5>
          <hr />
          <div id="history-item-detail">
            <!-- <div class="col-md-12 mb-2">
              <button onClick="popUpEdit(this.id)" id="item-id-${item.id}" type="button" class="btn btn-rounded btn-outline-success d-flex w-100 d-block text-primary p-2 order-tambah-item-detail">
                <div class="col-md-12 text-start">
                  <h4 class="card-title mb-1 text-dark">Coki Coki Coklat</h4>
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
                            : &nbsp; <b> 1 Kardus </b>
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
                            : &nbsp; <b> 4 Box </b>
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>   
              </button>
            </div> -->
          </div>
        </div>

        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4 col-md-12" id="list-order-pick">
        
        </div>
        
      </div>
      <script>
        function handleColorTheme(e) {
          document.documentElement.setAttribute("data-color-theme", e);
        }
      </script>
    </div>
  </div>

<div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>  

<!-- This Page JS -->
<script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="./assets/libs/select2/dist/js/select2.min.js"></script>

<script src="./assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>

<?php include './auth_check.php' ?>

<script>
  const paymentMethod = {
    "1": "C.O.D",
    "2": "0 - 7 Hari",
    "3": "7 - 14 Hari"
  };

  const apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['order'] ?>";

  $.ajax({
    type: "GET",
    url: `${apiUrl}/order_detail/<?= $historyId ?>`,
    dataType: "JSON",
    beforeSend: function(request) {
      request.setRequestHeader("Authorization", `Bearer ${salesData.token}`); <?php //salesData can check at auth_check.php ?>
    },
    success: function (response) {
      let parseData = parseResponse(response);

      $("#id_history").html(parseData.kode);
      $("#divisi").html(parseData.divisi_nama);
      $("#confirm_toko").html(parseData.toko_nama);
      $("#divisi").html(parseData.divisi_nama);
      $("#confirm_rute").html(parseData.rute_nama); 
      $("#confirm_alamat").html(parseData.alamat);
      $("#confirm_pembayaran").html(paymentMethod[`${parseData.metode_bayar}`]);

      let html = "";
      parseData.detail.forEach(function(item) {
        html += `<div class="col-md-12 mb-2">
          <button type="button" class="btn btn-rounded btn-outline-success d-flex w-100 d-block text-primary p-2 order-tambah-item-detail">
            <div class="col-md-12 text-start">
              <h4 class="card-title mb-1 text-dark">${item.nama_barang}</h4>
              <table>
                <tbody>
                  <tr>
                    <td>
                      <span class="fs-2 d-flex align-items-center text-dark">
                        <i class="ti ti-package text-primary fs-3 me-1"></i>Satuan ${item.type} 
                      </span>
                    </td>
                    <td>
                      <span class="fs-2 d-flex align-items-center text-dark">
                        : &nbsp; <b> ${item.qty} ${item.nama_satuan} </b>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>   
          </button>
        </div>`;

      });

      if (parseData.detail.length == 0) {
        html = "Data pesanan kosong";
      }

      $("#history-item-detail").html(html);
    }
  });

</script>

<?php include './footer.php' ?>