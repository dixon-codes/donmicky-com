<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Donmicky Real Estate Developers</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="real estate, property, Tanzania, Dar es Salaam, buy, sell, house" name="keywords" />
  <meta content="Donmicky Real Estate Developers – Find affordable, quality houses with reliable internet access in Tanzania." name="description" />

  <!-- Favicon -->
  <link href="img/icon.jpeg" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
  <style type="text/css">
    .navbar .navbar-nav .nav-link:hover,
    .navbar .navbar-nav .nav-link.active {
      color: #ec1c25;
    }

    .btn.btn-primary,
    .btn.btn-outline-primary:hover {
      color: #fff;
    }

    .btn-new {
      background: #ed1b24;
      color: #fff;
    }

    .btn-new:hover {
      background: #b93e44;
      color: #fff;
    }

    /* Property Cards */
    .property-card {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.12);
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-decoration: none;
      display: block;
    }

    .property-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .property-card img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .property-card:hover img {
      transform: scale(1.05);
    }

    .property-card-body {
      background: #fff;
      padding: 18px 20px;
      border-top: 3px solid #ed1b24;
    }

    .property-card-body h5 {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      color: #222;
      margin-bottom: 4px;
    }

    .property-card-body p {
      color: #777;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }

    .property-badge {
      display: inline-block;
      background: #ed1b24;
      color: #fff;
      font-size: 0.75rem;
      padding: 3px 10px;
      border-radius: 20px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .section-title {
      border-left: 5px solid #ed1b24;
      padding-left: 16px;
      margin-bottom: 30px;
    }
    .section-title h6 {
      text-transform: uppercase;
      color: #999;
      letter-spacing: 1px;
      margin-bottom: 4px;
    }
    .section-title h2 {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      color: #222;
    }
    /* Hero Carousel: vertically centre the caption overlay */
    #header-carousel .carousel-item {
      position: relative;
    }
    #header-carousel .carousel-item img {
      width: 100%;
      height: 600px;
      object-fit: cover;
    }
    #header-carousel .carousel-caption {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background: rgba(0,0,0,0.45);
      padding: 20px;
    }
    #header-carousel .carousel-caption > .container {
      width: 100%;
      text-align: center;
    }
    @media (max-width: 576px) {
      #header-carousel .carousel-item img { height: 350px; }
      #header-carousel .carousel-caption h1 { font-size: 1.6rem !important; }
    }
  </style>
</head>

<body>

  <!-- Topbar Start -->
  <?php require 'linkpage/topbar.php'; ?>
  <!-- Topbar End -->

  <?php require 'linkpage/navbar.php'; ?>


  <!-- Carousel Start -->
  <div class="container mb-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <div class="carousel-item active">
          <img class="w-100" src="img/carousel-hero-1.png" alt="Donmicky Real Estate" />
          <div class="carousel-caption">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                  <h5 class="text-light text-uppercase mb-3 animated slideInDown">
                    Welcome to Donmicky Real Estate Developers
                  </h5>
                  <h1 class="display-2 text-light mb-3 animated slideInDown">
                    YOUR TRUSTED PARTNER IN PROPERTY
                  </h1>
                  <p class="fs-4 text-light mb-4 animated slideInDown">
                    Affordable, Quality houses with internet
                  </p>
                  <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="order?action=buy" class="btn btn-new py-3 px-5">Buy a Property</a>
                    <a href="order?action=sell" class="btn btn-outline-light py-3 px-5">Sell a Property</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <img class="w-100" src="img/carousel-hero-2.png" alt="Properties in Tanzania" />
          <div class="carousel-caption">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                  <h5 class="text-light text-uppercase mb-3 animated slideInDown">
                    Welcome to Donmicky Real Estate Developers
                  </h5>
                  <h1 class="display-2 text-light mb-3 animated slideInDown">
                    FIND YOUR DREAM HOME IN TANZANIA
                  </h1>
                  <p class="fs-4 text-light mb-4 animated slideInDown">
                    Affordable, Quality houses with internet
                  </p>
                  <a href="order?action=buy" class="btn btn-new py-3 px-5">View Properties</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  </div>
  <!-- Carousel End -->


  <!-- About / Intro Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
            <img class="position-absolute w-100 h-100" src="img/page-header-bg.png" alt="Donmicky Real Estate" style="object-fit: cover;" />
          </div>
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="border-start border-5 border-primary ps-4 mb-4">
              <h6 class="text-body text-uppercase mb-2">Our Company</h6>
              <h1 class="display-6 mb-0">Donmicky Real Estate Developers</h1>
            </div>
            <h5 class="text-primary mb-4">Affordable, Quality houses with internet</h5>
            <p>Donmicky Real Estate Developers is a trusted property company based in Dar es Salaam, Tanzania. We specialize in providing families and professionals with affordable, high-quality homes that come fully equipped with reliable internet access.</p>
            <p>Whether you are looking to purchase your perfect modern living space or sell your property at the best price, our team is here to guide you every step of the way.</p>
            <div class="mt-4">
              <div class="row g-4">
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.1s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Quality Properties</h6>
                </div>
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.3s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Transparent Pricing</h6>
                </div>
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.5s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Fast Process</h6>
                </div>
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.7s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Trusted Agents</h6>
                </div>
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.9s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Prime Locations</h6>
                </div>
                <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="1.1s">
                  <i class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"></i>
                  <h6 class="mb-0">Local Expertise</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About / Intro End -->


  <!-- Available Properties Start -->
  <div class="container-xxl py-5" style="background: #f8f9fa;">
    <div class="container">
      <div class="section-title wow fadeInUp" data-wow-delay="0.1s">
        <h6>Available Now</h6>
        <h2>Our Properties</h2>
      </div>
      <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">Click on any property below to apply and buy.</p>

      <div class="row g-4">

        <!-- Property 1: Sinza -->
        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
          <a href="order?action=buy&property=Sinza" class="property-card">
            <img src="img/property-sinza.jpg" alt="House in Sinza" />
            <div class="property-card-body">
              <span class="property-badge mb-2">For Sale</span>
              <h5 class="mt-2">Residential House – Sinza</h5>
              <p><i class="fa fa-map-marker-alt me-2 text-danger"></i>Sinza, Dar es Salaam</p>
              <span class="btn btn-new btn-sm px-4">Apply to Buy &rarr;</span>
            </div>
          </a>
        </div>

        <!-- Property 2: Mbezi -->
        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.4s">
          <a href="order?action=buy&property=Mbezi" class="property-card">
            <img src="img/property-mbezi.jpg" alt="House in Mbezi" />
            <div class="property-card-body">
              <span class="property-badge mb-2">For Sale</span>
              <h5 class="mt-2">Residential House – Mbezi</h5>
              <p><i class="fa fa-map-marker-alt me-2 text-danger"></i>Mbezi, Dar es Salaam</p>
              <span class="btn btn-new btn-sm px-4">Apply to Buy &rarr;</span>
            </div>
          </a>
        </div>

      </div>
    </div>
  </div>
  <!-- Available Properties End -->


  <!-- CTA Section Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="container"><hr></div>
      <div class="row g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
        <div class="col-lg-10">
          <p class="fs-5 mb-4" style="color:#333;">Ready to make a move? Whether you want to buy a home or sell your property, we are here to help.</p>
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="order?action=buy" class="btn btn-new py-3 px-5">
              <i class="fa fa-home me-2"></i>I Want to Buy
            </a>
            <a href="order?action=sell" class="btn btn-outline-danger py-3 px-5">
              <i class="fa fa-tag me-2"></i>I Want to Sell
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- CTA Section End -->


  <!-- Footer Start -->
  <?php require 'linkpage/footer.php'; ?>
  <!-- Footer End -->

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-new btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="js/main.js"></script>
</body>

</html>