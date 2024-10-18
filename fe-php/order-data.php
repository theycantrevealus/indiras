<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="./assets/css/styles.css" />
  
  <!-- Data Table -->
  <link rel="stylesheet" href="./assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />

  <title>Modernize Bootstrap Admin</title>
</head>

<body class="link-sidebar">
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
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
                  <h4 class="fw-semibold mb-8">Daftar Order</h4>
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
          <div class="datatables"> 
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <div class="text-end">
                    <button id="addRow" class="btn btn-primary mb-2">
                      <i class="ti ti-plus fs-4"></i>&nbsp; Tambah
                    </button>
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <table id="order-table" class="table table-striped w-100 table-bordered display text-nowrap">
                    <thead>
                      <!-- start row -->
                      <tr>
                        <th>Toko</th>
                        <th>Rute</th>
                        <th>Alamat</th>
                        <th>#</th>
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

<div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>  

<script>

  const apiUrl = "./sample_data/order-data.json";

  $("#order-table").DataTable({
    processing: true,
    select: true,
    order : [],
    "ajax": {
        "url": apiUrl,
        "type":"GET",
        "error": function(e) {
            console.log(e);
        },
        dataSrc: function(response) {
            return response.data;
        }
    },
    "columns" : [ 
        {
            "data" : null, render: function(data, type, row, meta) {
                return row["nama"];
            }
        },
        {
            "data" : null,  className: 'text-right',
            render: function(data, type, row, meta) {
                return row["rute"];
            }
        },
        {
            "data" : null,  className: 'text-center',
            render: function(data, type, row, meta) {
                return row["alamat"];
            }
        },
        {
            "data" : null,  className: 'text-center',
            render: function(data, type, row, meta) {
                return `<button class="btn btn-sm btn-warning view-order">
                      <i class="ti ti-eye fs-4"></i>&nbsp; Order
                    </button>`;
            }
        }
    ]
  });

</script>

<?php include './footer.php' ?>