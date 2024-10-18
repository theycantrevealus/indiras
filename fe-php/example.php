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
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Basic Table</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./main/index.html">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Basic Table</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="./assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card w-100 position-relative overflow-hidden">
            <div class="px-4 py-3 border-bottom">
              <h4 class="card-title mb-0">Basic Table</h4>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">User</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Project Name</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Team</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Budget</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Sunil Joshi</h6>
                            <span class="fw-normal">Web Designer</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal fs-4">Elite Admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="text-bg-secondary text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            S
                          </a>
                          <a href="javascript:void(0)" class="text-bg-danger text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            D
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success">Active</span>
                      </td>
                      <td>
                        <h6 class="fs-4 fw-semibold mb-0">$3.9k</h6>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Arlene McCoy</h6>
                            <span class="fw-normal">Project Manager</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal fs-4">Real Homes WP Theme</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="text-bg-primary text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            A
                          </a>
                          <a href="javascript:void(0)" class="text-bg-warning text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            X
                          </a>
                          <a href="javascript:void(0)" class="text-bg-secondary text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            N
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                      </td>
                      <td>
                        <h6 class="fs-4 fw-semibold mb-0">$24.5k</h6>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-6.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Christopher Jamil</h6>
                            <span class="fw-normal">Project Manager</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal fs-4">MedicalPro WP Theme</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="text-bg-danger text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            X
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary">Completed</span>
                      </td>
                      <td>
                        <h6 class="fs-4 fw-semibold mb-0">$12.8k</h6>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-4.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Evelyn Pope</h6>
                            <span class="fw-normal">Frontend Engineer</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal fs-4">Hosting Press HTML</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="text-bg-primary text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            Y
                          </a>
                          <a href="javascript:void(0)" class="text-bg-danger text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            X
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success">Active</span>
                      </td>
                      <td>
                        <h6 class="fs-4 fw-semibold mb-0">$2.4k</h6>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Micheal Doe</h6>
                            <span class="fw-normal">Content Writer</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal fs-4">Hosting Press HTML</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="text-bg-secondary text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            S
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-danger-subtle text-danger">Cancel</span>
                      </td>
                      <td>
                        <h6 class="fs-4 fw-semibold mb-0">$9.3k</h6>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">User</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Project Name</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Users</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-10.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Olivia Rhye</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Xtreme admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-4.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary">active</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Barbara Steele</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Adminpro admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-5.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-3.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-danger-subtle text-danger">cancel</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Leonard Gordon</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Monster admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-3.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary">active</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-4.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Evelyn Pope</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Materialpro admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-3.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-5.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success">pending</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Tommy Garza</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Elegant admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-5.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-6.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-danger-subtle text-danger">cancel</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-6.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">James Smith</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">Modernize admin</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                          <a href="javascript:void(0)">
                            <img src="./assets/images/profile/user-4.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white" width="39" height="39">
                          </a>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success">pending</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Customer</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Email Address</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Teams</h6>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Olivia Rhye</h6>
                            <span class="fw-normal">@rhye</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-circle fs-3"></i>active
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">olivia@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-primary">Design</span>
                          <span class="badge text-bg-secondary">Product</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Barbara Steele</h6>
                            <span class="fw-normal">@steele</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge text-bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-clock-hour-4 fs-3"></i>offline
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">steele@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-secondary">Product</span>
                          <span class="badge text-bg-danger">Operations</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Leonard Gordon</h6>
                            <span class="fw-normal">@gordon</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-circle fs-3"></i>active
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">olivia@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-primary">Finance</span>
                          <span class="badge text-bg-success">Customer Success</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-4.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Evelyn Pope</h6>
                            <span class="fw-normal">@pope</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge text-bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-clock-hour-4 fs-3"></i>offline
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">steele@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-danger">Operations</span>
                          <span class="badge text-bg-primary">Design</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Tommy Garza</h6>
                            <span class="fw-normal">@garza</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-circle fs-3"></i>active
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">olivia@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-secondary">Product</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-6.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">James Smith</h6>
                            <span class="fw-normal">@vasquez</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-success-subtle text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                          <i class="ti ti-circle fs-3"></i>active
                        </span>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">steele@ui.com</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge text-bg-success">Customer Success</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Invoice</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Customer</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Progress</h6>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3066</h6>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                          <i class="ti ti-check fs-4"></i>paid
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Olivia Rhye</h6>
                            <span class="fw-normal">olivia@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">60%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3067</h6>
                      </td>
                      <td>
                        <span class="badge bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
                          <i class="ti ti-x fs-4"></i>cancelled
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Barbara Steele</h6>
                            <span class="fw-normal">steele@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">30%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3068</h6>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                          <i class="ti ti-check fs-4"></i>paid
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Leonard Gordon</h6>
                            <span class="fw-normal">olivia@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">45%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3069</h6>
                      </td>
                      <td>
                        <span class="badge bg-secondary-subtle text-secondary d-inline-flex align-items-center gap-1">
                          <i class="ti ti-arrow-back-up fs-4"></i>refunded
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-4.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Evelyn Pope</h6>
                            <span class="fw-normal">teele@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 37%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">37%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3070</h6>
                      </td>
                      <td>
                        <span class="badge bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
                          <i class="ti ti-x fs-4"></i>cancelled
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">Tommy Garza</h6>
                            <span class="fw-normal">olivia@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">87%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h6 class="fw-semibold mb-0">INV-3071</h6>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                          <i class="ti ti-check fs-4"></i>paid
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/profile/user-6.jpg" class="rounded-circle" width="40" height="40" />
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">James Smith</h6>
                            <span class="fw-normal">olivia@ui.com</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="progress text-bg-light w-100 h-4">
                            <div class="progress-bar" role="progressbar" aria-label="Example 4px high" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <span class="fw-normal">32%</span>
                        </div>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive border rounded-4">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Authors</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Courses</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Users</h6>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/blog/blog-img1.jpg" class="rounded-2" width="42" height="42" />
                          <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Top Authors</h6>
                            <span class="fw-normal">Successful Fellas</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-danger-subtle text-danger">Angular</span>
                          <span class="badge bg-primary-subtle text-primary">PHP</span>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">4300 Users</p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/blog/blog-img2.jpg" class="rounded-2" width="42" height="42" />
                          <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Popular Authors</h6>
                            <span class="fw-normal">Most Successful</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-primary-subtle text-primary">Bootstrap</span>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">1200 Users</p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/blog/blog-img3.jpg" class="rounded-2" width="42" height="42" />
                          <div class="ms-3">
                            <h6 class="fw-semibold mb-1">New Users</h6>
                            <span class="fw-normal">Awesome Users</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-success-subtle text-success">Reactjs</span>
                          <span class="badge bg-danger-subtle text-danger">Angular</span>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">2000 Users</p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/blog/blog-img4.jpg" class="rounded-2" width="42" height="42" />
                          <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Active Customers</h6>
                            <span class="fw-normal">Best Customers</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-primary-subtle text-primary">Bootstrap</span>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">1500 Users</p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="./assets/images/blog/blog-img5.jpg" class="rounded-2" width="42" height="42" />
                          <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Bestseller Theme</h6>
                            <span class="fw-normal">Amazing Templates</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span class="badge bg-danger-subtle text-danger">Angular</span>
                          <span class="badge bg-success-subtle text-success">Reactjs</span>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">9500 Users</p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-trash"></i>Delete
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      <script>
  function handleColorTheme(e) {
    document.documentElement.setAttribute("data-color-theme", e);
  }
</script>
      <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="icon ti ti-settings fs-7"></i>
      </button>

      <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            Settings
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body h-n80" data-simplebar>
          <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary rounded-2" for="light-layout">
              <i class="icon ti ti-brightness-up fs-7 me-2"></i>Light
            </label>

            <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary rounded-2" for="dark-layout">
              <i class="icon ti ti-moon fs-7 me-2"></i>Dark
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="ltr-layout">
              <i class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR
            </label>

            <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="rtl-layout">
              <i class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

          <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
            <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="BLUE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="AQUA_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PURPLE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="GREEN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="CYAN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center" onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="vertical-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="vertical-layout">
                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical
              </label>
            </div>
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="horizontal-layout">
                <i class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal
              </label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="boxed-layout">
              <i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed
            </label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="full-layout">
              <i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full
            </label>
          </div>

          <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <a href="javascript:void(0)" class="fullsidebar">
              <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="full-sidebar">
                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full
              </label>
            </a>
            <div>
              <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar" autocomplete="off" />
              <label class="btn p-9 btn-outline-primary" for="mini-sidebar">
                <i class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse
              </label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="card-layout" id="card-with-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-with-border">
              <i class="icon ti ti-border-outer fs-7 me-2"></i>Border
            </label>

            <input type="radio" class="btn-check" name="card-layout" id="card-without-border" autocomplete="off" />
            <label class="btn p-9 btn-outline-primary" for="card-without-border">
              <i class="icon ti ti-border-none fs-7 me-2"></i>Shadow
            </label>
          </div>
        </div>
      </div>
    </div>

    <!--  Search Bar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-1">
          <div class="modal-header border-bottom">
            <input type="search" class="form-control fs-3" placeholder="Search here" id="search" />
            <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
              <i class="ti ti-x fs-5 ms-3"></i>
            </a>
          </div>
          <div class="modal-body message-body" data-simplebar="">
            <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
            <ul class="list mb-0 py-2">
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Modern</span>
                  <span class="text-muted d-block">/dashboards/dashboard1</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Dashboard</span>
                  <span class="text-muted d-block">/dashboards/dashboard2</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Contacts</span>
                  <span class="text-muted d-block">/apps/contacts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Posts</span>
                  <span class="text-muted d-block">/apps/blog/posts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Detail</span>
                  <span class="text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Shop</span>
                  <span class="text-muted d-block">/apps/ecommerce/shop</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Modern</span>
                  <span class="text-muted d-block">/dashboards/dashboard1</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Dashboard</span>
                  <span class="text-muted d-block">/dashboards/dashboard2</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Contacts</span>
                  <span class="text-muted d-block">/apps/contacts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Posts</span>
                  <span class="text-muted d-block">/apps/blog/posts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Detail</span>
                  <span class="text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black">
                <a href="javascript:void(0)">
                  <span class="d-block">Shop</span>
                  <span class="text-muted d-block">/apps/ecommerce/shop</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!--  Shopping Cart -->
    <div class="offcanvas offcanvas-end shopping-cart" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header justify-content-between py-4">
        <h5 class="offcanvas-title fs-5 fw-semibold" id="offcanvasRightLabel">
          Shopping Cart
        </h5>
        <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
      </div>
      <div class="offcanvas-body h-100 px-4 pt-0" data-simplebar>
        <ul class="mb-0">
          <li class="pb-7">
            <div class="d-flex align-items-center">
              <img src="./assets/images/products/product-1.jpg" width="95" height="75" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
              <div>
                <h6 class="mb-1">Supreme toys cooker</h6>
                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                  <div class="input-group input-group-sm w-50">
                    <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success" type="button" id="add1">
                      -
                    </button>
                    <input type="text" class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="1" />
                    <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add" type="button" id="addo2">
                      +
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="pb-7">
            <div class="d-flex align-items-center">
              <img src="./assets/images/products/product-2.jpg" width="95" height="75" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
              <div>
                <h6 class="mb-1">Supreme toys cooker</h6>
                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                  <div class="input-group input-group-sm w-50">
                    <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success" type="button" id="add2">
                      -
                    </button>
                    <input type="text" class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add2" value="1" />
                    <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add" type="button" id="addon34">
                      +
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="pb-7">
            <div class="d-flex align-items-center">
              <img src="./assets/images/products/product-3.jpg" width="95" height="75" class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
              <div>
                <h6 class="mb-1">Supreme toys cooker</h6>
                <p class="mb-0 text-muted fs-2">Kitchenware Item</p>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <h6 class="fs-2 fw-semibold mb-0 text-muted">$250</h6>
                  <div class="input-group input-group-sm w-50">
                    <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success" type="button" id="add3">
                      -
                    </button>
                    <input type="text" class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add3" value="1" />
                    <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add" type="button" id="addon3">
                      +
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="align-bottom">
          <div class="d-flex align-items-center pb-7">
            <span class="text-dark fs-3">Sub Total</span>
            <div class="ms-auto">
              <span class="text-dark fw-semibold fs-3">$2530</span>
            </div>
          </div>
          <div class="d-flex align-items-center pb-7">
            <span class="text-dark fs-3">Total</span>
            <div class="ms-auto">
              <span class="text-dark fw-semibold fs-3">$6830</span>
            </div>
          </div>
          <a href="./main/eco-checkout.html" class="btn btn-outline-primary w-100">Go to shopping cart</a>
        </div>
      </div>
    </div>
  </div>

  <div class="dark-transparent sidebartoggler"></div>

<?php include './script.php' ?>  


<?php include './footer.php' ?>