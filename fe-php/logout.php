
<?php include './auth_check.php' ?>

<script>

  if (salesData) {
    localStorage.removeItem(`user_cred`);
    window.location.replace("login.php");
  }
  
</script>