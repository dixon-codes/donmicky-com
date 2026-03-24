<?php
// ── Security bootstrap ──
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/linkpage/form_security.php';
require_once __DIR__ . '/linkpage/mail_config.php';

$contactMsg = '';
if (isset($_POST['send-message'])) {
    if (!verifyCsrf()) {
        $contactMsg = '<p style="text-align:center;margin-top:10px;padding:10px;border-radius:4px;color:#c4160a;background:#ffe5e3;">Invalid request. Please refresh and try again.</p>';
    } elseif (isHoneypotTripped()) {
        $contactMsg = ''; // Silent drop – bot submission
    } elseif (isRateLimited('contact')) {
        $contactMsg = '<p style="text-align:center;margin-top:10px;padding:10px;border-radius:4px;color:#856404;background:#fff3cd;">Too many messages. Please wait a while before trying again.</p>';
    } else {
        $fromName = sanitizeName($_POST['fullName'] ?? '');
        $from     = sanitizeEmail($_POST['email'] ?? '');
        $subject  = sanitizeText($_POST['subject'] ?? '', 150);
        $message1 = sanitizeMessage($_POST['message'] ?? '', 2000);
        $tel      = sanitizePhone(($_POST['phone_code'] ?? '+255') . ' ' . ($_POST['phone'] ?? ''));

        if (!$fromName || !$from || !$subject || !$message1) {
            $contactMsg = '<p style="text-align:center;margin-top:10px;padding:10px;border-radius:4px;color:#c4160a;background:#ffe5e3;">Please fill in all fields with valid information (valid email required).</p>';
        } else {
            $body = "
              <html><body style='font-family:Arial,sans-serif;font-size:16px;'>
              <h2 style='color:#e9383f;'>New Contact Message – Donmicky Real Estate</h2>
              <p><b>Name:</b> {$fromName}</p>
              <p><b>Email:</b> {$from}</p>
              <p><b>Phone:</b> {$tel}</p>
              <p><b>Subject:</b> {$subject}</p>
              <p><b>Message:</b><br>{$message1}</p>
              </body></html>
            ";
            $result = sendMail("Contact: {$subject}", $body, $from, $fromName);
            if ($result === true) {
                $contactMsg = '<p style="text-align:center;background:#f0efed;color:#555;margin-top:10px;padding:10px;border-radius:4px;">Dear ' . $fromName . ', thanks for getting in touch! We will respond shortly.</p>';
            } else {
                $contactMsg = '<p style="text-align:center;margin-top:10px;padding:10px;border-radius:4px;color:#c4160a;background:#ffe5e3;">Unable to send message. Please try again later.</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Donmicky Real Estate Developers – Contact Us</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="contact, real estate, Tanzania, Dar es Salaam" name="keywords" />
    <meta content="Get in touch with Donmicky Real Estate Developers. We are here to help you buy or sell property in Tanzania." name="description" />

    <!-- Favicon -->
    <link href="img/icon.png" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

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
          color: #e9383f;
      }

      .btn.btn-primary,
      .btn.btn-outline-primary:hover {
          color: #fff;
      }

      .btn-new{
        background: #e9383f;
        color: #fff;
      }
      .btn-new:hover{
        background: #f44a4f;
        color: #fff;
      }
      .page-header {
          background: linear-gradient(rgba(0, 0, 0, .65), rgba(0, 0, 0, .65)), url(img/page-header-bg.png) center center no-repeat;
          background-size: cover;
      }

      /* ── Form field contrast ── */
      .form-floating > .form-control {
        background-color: #fff !important;
        border: 1.5px solid #c8c8c8 !important;
        color: #1a1a1a !important;
        border-radius: 6px;
      }
      .form-floating > .form-control:focus {
        border-color: #e9383f !important;
        box-shadow: 0 0 0 3px rgba(233,56,63,.15) !important;
      }
      .form-floating > label { color: #666; }
      .form-floating > .form-control:focus ~ label,
      .form-floating > .form-control:not(:placeholder-shown) ~ label { color: #e9383f; }

      /* ── Phone group ── */
      .phone-group { display: flex; gap: 8px; align-items: stretch; }
      .phone-code-select {
        flex: 0 0 130px;
        border: 1.5px solid #c8c8c8 !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        color: #1a1a1a !important;
        font-size: 0.83rem;
        font-family: 'Roboto', sans-serif;
        padding: 6px 8px;
        cursor: pointer;
      }
      .phone-code-select:focus {
        border-color: #e9383f !important;
        box-shadow: 0 0 0 3px rgba(233,56,63,.15) !important;
        outline: none;
      }
      .phone-input-wrap { flex: 1; }
      .form-control:invalid:not(:placeholder-shown) { border-color: #e9383f !important; }
    </style>
  </head>

  <body>
  

    <!-- Topbar Start -->
    <?php require'linkpage/topbar.php'; ?>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav
    class=" navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
    <div class="container">
    <?php require "linkpage/logo.php"; ?>
    <button
      type="button"
      class="navbar-toggler"
      data-bs-toggle="collapse"
      data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto py-3 py-lg-0">
         <a href="./" class="nav-item nav-link" style="">Home</a>
        <a href="about" class="nav-item nav-link">About Us</a>
        <a href="order" class="nav-item nav-link">Buy / Sell</a>
        <a href="contact" class="nav-item nav-link active">Contact Us</a>
       
      </div>
    </div>
    </div>
    
  </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container">
    <div
      class="container-fluid page-header py-5 mb-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4">
          Contact Us
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item">
              <a class="text-white" href="./">Home</a>
            </li>
            <li class="breadcrumb-item text-primary active" aria-current="page">
              Contact Us
            </li>
          </ol>
        </nav>
      </div>
    </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container">
    <div class="container-xxl py-5">
      <div class="container">
        <div class="row g-5">
          <div class="col-12">
                        <div class="row gy-4">
                            <div class="col-md-5 wow fadeIn" data-wow-delay="0.1s" style="padding-left:10px;">
                                <div class="d-flex align-items-center bg-redish rounded p-4" style="background: #faf2f2;">
                                    <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-map-marker-alt" style="color:#e9383f;"></i>
                                    </div>
                                    <span>P.O.BOX 105979<br>DAR ES SALAAM, TANZANIA</span>
                                </div>
                            </div>
                            <div class="col-md-3 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center bg-redish rounded p-4">
                                    <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-envelope-open" style="color:#e9383f;"></i>
                                    </div>
                                    <span>info@donmicky.co.tz</span>
                                </div>
                            </div>
                            <div class="col-md-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="d-flex align-items-center bg-redish rounded p-4">
                                    <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-phone-alt" style="color:#e9383f;"></i>
                                    </div>
                                    <span>
                                        <a href="tel:+255742118315" style="color:inherit; display:block;">+255 742 118 315</a>
                                        <a href="tel:+255712065662" style="color:inherit; display:block;">+255 712 065 662</a>
                                        <a href="tel:+447438390337" style="color:inherit; display:block;">+44 7438 390337</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
          <div
            class="col-lg-6 wow fadeInUp"
            data-wow-delay="0.1s"
            style="min-height: 450px"
          >
            <div class="position-relative h-100">
              <iframe class="position-relative w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.83318018763!2d39.25953187485981!3d-6.79014409320704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c74415c5a9d%3A0x8e1c3a7afed2ab2f!2sKasaba%20St%2C%20Dar%20es%20Salaam!5e0!3m2!1sen!2stz!4v1683813157615!5m2!1sen!2stz" frameborder="0"
                style="min-height: 450px; border: 0"
                allowfullscreen=""
                aria-hidden="false"
                tabindex="0"></iframe>
            </div>
          </div>
          <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
            <div class="border-start border-5 border-primary ps-4 mb-5">
              <h6 class="text-body text-uppercase mb-2">Contact Us</h6>
              <h1 class="display-6 mb-0">
                If You Have Any Query, Please Contact Us
              </h1>
            </div>
            <form action="contact" method="POST">
              <?php echo csrfField(); ?>
              <?php echo honeypotField(); ?>
              <div class="row g-3">
                <div class="col-md-12">
                  <?php echo $contactMsg; ?>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input
                      type="text"
                      class="form-control border-0 bg-light"
                      id="name"
                      placeholder="Your Name" name="fullName"
                      autocomplete="name"
                      pattern="[\p{L}\s'\-]{2,100}"
                      title="Letters only – no numbers or symbols"
                      required
                    />
                    <label for="name">Your Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input
                      type="email"
                      class="form-control border-0 bg-light"
                      id="email"
                      placeholder="Your Email" name="email"
                      autocomplete="email"
                      required
                    />
                    <label for="email">Your Email</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="phone-group">
                    <select name="phone_code" class="phone-code-select" aria-label="Country calling code">
                      <option value="+255" selected>TZ +255</option>
                      <option value="+254">KE +254</option>
                      <option value="+256">UG +256</option>
                      <option value="+250">RW +250</option>
                      <option value="+257">BI +257</option>
                      <option value="+27">ZA +27</option>
                      <option value="+44">GB +44</option>
                      <option value="+1">US +1</option>
                      <option value="+971">AE +971</option>
                      <option value="+91">IN +91</option>
                      <option value="+86">CN +86</option>
                      <option value="+49">DE +49</option>
                      <option value="+33">FR +33</option>
                    </select>
                    <div class="form-floating phone-input-wrap">
                      <input type="tel" class="form-control border-0 bg-light" id="contactPhone"
                        name="phone" placeholder="Phone number" inputmode="numeric"
                        pattern="[0-9\s]{4,15}" title="Digits only" autocomplete="tel-national" />
                      <label for="contactPhone">Phone (optional)</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input
                      type="text"
                      class="form-control border-0 bg-light"
                      id="subject"
                      placeholder="Subject" name="subject"
                      autocomplete="off"
                      maxlength="150"
                      required
                    />
                    <label for="subject">Subject</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea
                      class="form-control border-0 bg-light"
                      placeholder="Leave a message here"
                      id="message"
                      style="height: 150px" name="message" required
                    ></textarea>
                    <label for="message">Message</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-new py-3 px-5 wow bounceIn" data-wow-delay="600ms" name="send-message" type="submit">
                    Send Message
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <?php require"linkpage/footer.php"; ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-new btn-lg-square back-to-top"
      ><i class="bi bi-arrow-up"></i
    ></a>

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
