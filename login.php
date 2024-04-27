<?php
include('./components/head.php');
?>

<body class="login-page sidebar-collapse">

  <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="#" rel="tooltip" target="_blank">
          <b>Malcolm Lismore Photography</b>
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar top-bar"></span>
          <span class="navbar-toggler-bar middle-bar"></span>
          <span class="navbar-toggler-bar bottom-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="#" target="_blank">
              <i class="fab fa-twitter"></i>
              <p class="d-lg-none d-xl-none">Twitter</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="#" target="_blank">
              <i class="fab fa-facebook-square"></i>
              <p class="d-lg-none d-xl-none">Facebook</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="#" target="_blank">
              <i class="fab fa-instagram"></i>
              <p class="d-lg-none d-xl-none">Instagram</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" style="background-image:url(./assets/img/login.jpg)"></div>
    <div class="content">
      <div class="container d-flex justify-content-center">
        <div class="col-md-4 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form class="form" method="post" action="./controllers/login-controller.php">
              <div class="card-header text-center">
                <div class="login logo-container">
                  <img src="./assets/img/logo/logo-white.png" alt="">
                </div>
              </div>
              <div class="card-body login-card-body">
                <div class="input-group no-border input-lg">
                  <input type="text" id="email" name="email" require class="form-control" placeholder="Email...">
                </div>
                <div class="input-group no-border input-lg">
                  <input type="password" id="password" name="password" require placeholder="Password..." class="form-control" />
                </div>
              </div>
              <div class="card-footer login-card-footer d-grid gap-2 text-center">
                <?php
                if (isset($_GET['error'])) {
                  echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                }
                ?>
                <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">LogIn</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include('./components/footer-copyright.php');
  include('./components/external-js.php');
  ?>

</body>

</html>