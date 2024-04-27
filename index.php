<?php
include('./components/head.php');

$active = 'home';
?>

<body class="landing-page">

  <?php include('./components/client_navi.php'); ?>

  <div id="home" class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" style="background-image: url('./assets/img/login.jpg');"></div>
    <div class="container banner-logo-container d-flex flex-column justify-content-center align-items-center">
      <img src="./assets/img/logo/logo-white.png" alt="">
      <button id="moreBtn" class="btn btn-outline-light btn-icon btn-round btn-lg top-bottom-margin-0">
        <i class="fa-solid fa-3x fa-circle-chevron-down"></i>
      </button>
    </div>
  </div>

  <div class="section section-about-us" id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-8 m-auto text-center">
          <h2 class="title">Who we are?</h2>
          <h5 class="description">Welcome to Malcolm Lismore Photography, where 
            every snapshot tells a story and every moment is captured with a passion for the natural world.
            Nestled in the stunning landscapes of Scotland's North West coast,
            Malcolm has honed his skills in photographing the raw, untamed beauty of nature and the intimate, cherished moments of human celebrations.</h5>
          <h5 class="description">Malcolm Lismore Photography talents extend beyond nature photography.
            He is also a seasoned photographer of life’s special moments.
            Whether it’s capturing the joy and romance of a wedding, the personality in a portrait,
            or the energy of a special event, Malcolm's photography ensures that your important memories
            are immortalized with beauty and precision.</h5>
          <h5 class="description">Thank you for visiting, and we look forward to capturing your story</h5>
        </div>
      </div>
      <div class="separator separator-primary"></div>
      <div class="section-story-overview">
        <div class="row">
          <div class="col-md-6">
            <div class="image-container image-left" style="background-image: url('./assets/img/image17.jpg')"></div>
            <div class="image-container" style="background-image: url('./assets/img/image6.jpg')"></div>
          </div>
          <div class="col-md-5">
            <div class="image-container image-right" style="background-image: url('./assets/img/image14.jpg')"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section section-gallery" id="gallery">
    <div class="container">
      <div class="row">
        <div class="col-md-8 m-auto text-center">
          <h2 class="title">Our Work</h2>
          <!-- <h5 class="description">View our latest work</h5> -->
          <button id="moreBtn" class="btn btn-primary btn-round btn-explore" onclick="window.location.href='./gallery.php'">
            Explore More
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 m-auto text-center">
          <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner" id="carousel"></div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section section-service" id="service">
    <div class="container">
      <div class="row">
        <div class="col-md-8 m-auto text-center">
          <h2 class="title">Our Services</h2>
          <h5 class="description">These are our standard packages. Place an enquiry to customise package to your need</h5>
          <!-- <button id="moreBtn" class="btn btn-primary btn-round btn-explore">
            Explore More
          </button> -->
        </div>
      </div>
      <div class="row row-cols-1 row-cols-md-3 g-4" id="homePackageList">
        <div class="col mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Package Name</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Package Price</h6>
              <p class="card-text">Package Info 4 lines max</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include('./components/footer-copyright.php');
  include('./components/external-js.php');
  ?>

  <script>
    function getGalleryImages() {
      $.ajax({
        url: "./controllers/gallery_controller.php",
        type: "POST",
        cache: false,
        data: {
          action: 'listHome'
        },
        success: function(data) {
          $('#carousel').html(data);
        }
      });
    }

    function getPackageImages() {
      $.ajax({
        url: "./controllers/package_controller.php",
        type: "POST",
        cache: false,
        data: {
          action: 'listHome'
        },
        success: function(data) {
          $('#homePackageList').html(data);
        }
      });
    }

    $(document).ready(function() {
      getGalleryImages();
      getPackageImages();
    });
  </script>

</body>

</html>