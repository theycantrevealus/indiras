
<script>

  let salesData = localStorage.getItem(`user_cred`);
  if (!salesData) {
    window.location.replace("login.php");
  }

  salesData = JSON.parse(salesData);
  $(document).ready(function () {
    $("#pegawai_nama").html(salesData.kode);
    $("#pegawai_jabatan").html(salesData.jabatan);
  })
  
</script>