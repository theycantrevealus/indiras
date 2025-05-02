  <!-- Import Js Files -->
  <script src="./assets/js/vendor.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="./assets/js/theme/app.init.js"></script>
  <script src="./assets/js/theme/theme.js"></script>
  <script src="./assets/js/theme/app.min.js"></script>
  <script src="./assets/js/theme/sidebarmenu.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="./assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

  <script>

    function getMetodeBayar(strId) {
      if (strId == '1') {
        return "C.O.D";
      }

      if (strId == '2') {
        return "0 - 7 Hari";
      }

      if (strId == '3') {
        return "7 - 14 Hari";
      }

      return "";
    }

    function parseResponse(jsonData) {
      return {
        ...jsonData.response_package 
      }
    }

  </script>