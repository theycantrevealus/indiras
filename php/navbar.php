<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Order App</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Menu</a></li>
        <li><a href="order.php">Order</a></li>
        <li><a href="sales.php">Sales</a></li>
          <?php
            if($_SESSION['authority'] === 'ADM') {
          ?>
          <li>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                  <li><a href="authority.php">Authority</a></li>
                  <li><a href="account.php">Account</a></li>
              </ul>
          </li>
        <li>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintenace <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li><a href="product.php">Products</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="category.php">Category</a></li>
              <li><a href="supplier.php">Supplier</a></li>
          </ul>
        </li>
                <?php
            }
          ?>
          <li>
              <a href="logout.php">Logout</a>
          </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>