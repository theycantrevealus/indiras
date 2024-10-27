<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CSS Assets -->
  <?php include './header-css.php' ?>

  <link rel="stylesheet" href="./assets/libs/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
  <div class="preloader">
    <img src="./assets/images/logos/logo-only.jpeg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
            <div class="card mb-0">
              <div class="card-body">
                <a href="login.php" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                  <img src="./assets/images/logos/logo.jpeg" width="100%"/>
                </a>
                <form action="#" id="form-login">
                  <input hidden class="form-control" id="request" name="request" value="login" placeholder="">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username / Email</label>
                    <input required type="email" class="form-control" id="username" name="email" aria-describedby="emailHelp" placeholder="">
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" class="form-control" id="password" name="password">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <button class="btn btn-sm btn-transparent text-primary fw-medium" >Lupa
                      Password ?</a>
                  </div>
                  <button id="btnLogin" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Masuk</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php include './script.php' ?>  

<script src="./assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>

<script>
  let salesData = localStorage.getItem(`user_cred`);
  // check cred if exists
  if (salesData) {
    window.location.replace("order-data.php");
  }

  $("#form-login").submit(function() {
    const apiUrl = "<?=  $API_URL[$APP_ENV] . $API_ENDPOINT[$APP_ENV]['login'] ?>";

    $.ajax({
      type: "POST",
      url: apiUrl,
      data: $("#form-login").serialize(),
      dataType: "JSON",
      success: function (response) {
        if (response.response_result == 1 && response.userData.jabatan == "1faa60c3-9522-40ef-97f1-1c94b8d85c50") {
          response.userData['token'] =  response.response_token;
         
          localStorage.setItem(`user_cred`, JSON.stringify(response.userData));
          window.location.replace("order-data.php");
        } else {
          Swal.fire({
            type: "error",
            title: "Upss...",
            text: response.response_message,
          });
        }
      }
    });

    return false;
  });

</script>

<?php include './footer.php' ?>