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
              <table id="" class="w-100 table-sm display text-nowrap">
                <tbody>
                  <tr>
                    <th width="10%">ID</th>
                    <th>:</th>
                    <th><span id="id_history" class="badge text-bg-success">12345ASASDA</span></th>
                  </tr>
                  <tr>
                    <th width="10%">Toko</th>
                    <th>:</th>
                    <th id="confirm_toko"> UD Test 123</th>
                  </tr>
                  <tr>
                    <th>Divisi</th>
                    <th>:</th>
                    <th id="divisi">Perfetti Van Melle </th>
                  </tr>
                  <tr>
                    <th>Rute</th>
                    <th>:</th>
                    <th id="confirm_rute">Rute 123</th>
                  </tr>
                  <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <th id="confirm_alamat">Jl. Lima puluh gang 123</th>
                  </tr>
                  <tr>
                    <th>Pembayaran</th>
                    <th>:</th>
                    <th id="confirm_pembayaran">Tunai</th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <h5>Daftar Pesanan: </h5>
          <hr />
          <div id="history-item-detail">
            <div class="col-md-12 mb-2">
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
            </div>
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


</script>

<?php include './footer.php' ?>