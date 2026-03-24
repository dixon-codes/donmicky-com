<?php
// ── Security bootstrap ──
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/linkpage/form_security.php';

// Determine which section to show from URL: ?action=buy or ?action=sell
$action = isset($_GET['action']) ? $_GET['action'] : 'buy';
$preselectedProperty = isset($_GET['property']) ? htmlspecialchars($_GET['property']) : '';

// Load mail helper once at the top
$mailReady = false;
$mailConfigPath = __DIR__ . '/linkpage/mail_config.php';
if (file_exists($mailConfigPath)) {
    require_once $mailConfigPath;
    $mailReady = true;
}

// ---- Process BUY form ----
$buyMsg = '';
if (isset($_POST['send-buy'])) {
    // Security checks
    if (!verifyCsrf()) {
        $buyMsg = '<p class="alert alert-danger">Invalid request (CSRF). Please refresh and try again.</p>';
    } elseif (isHoneypotTripped()) {
        $buyMsg = ''; // Silent drop – bot submission
    } elseif (isRateLimited('buy')) {
        $buyMsg = '<p class="alert alert-warning">Too many submissions. Please wait a while before trying again.</p>';
    } else {
        // Sanitize inputs
        $fromName = sanitizeName($_POST['fullName'] ?? '');
        $from     = sanitizeEmail($_POST['email'] ?? '');
        $tel      = sanitizePhone(($_POST['phone_code'] ?? '+255') . ' ' . ($_POST['phone'] ?? ''));
        $prop     = sanitizeText($_POST['property'] ?? '', 100);
        $notes    = sanitizeMessage($_POST['notes'] ?? '', 1000);

        // Validate required fields
        if (!$fromName || !$from || !$tel || !$prop) {
            $buyMsg = '<p class="alert alert-danger">Please fill in all required fields with valid information.</p>';
        } elseif ($mailReady) {
            $body = "
              <html><body style='font-family:Arial,sans-serif;font-size:16px;'>
              <h2 style='color:#e9383f;'>New Buy Application &ndash; Donmicky Real Estate</h2>
              <p><b>Property:</b> {$prop}</p>
              <p><b>Name:</b> {$fromName}</p>
              <p><b>Email:</b> {$from}</p>
              <p><b>Phone:</b> {$tel}</p>
              <p><b>Notes:</b> {$notes}</p>
              </body></html>";
            $result = sendMail("Buy Application &ndash; {$prop}", $body, $from, $fromName);
            if ($result === true) {
                $buyMsg = '<p class="alert alert-success">Thank you, ' . $fromName . '! Your application for <strong>' . $prop . '</strong> has been received. We will contact you shortly.</p>';
            } else {
                $buyMsg = '<p class="alert alert-danger">Unable to send application. Please try again later.</p>';
            }
        } else {
            $buyMsg = '<p class="alert alert-warning">Mail is not configured yet. Please contact us directly.</p>';
        }
    }
}

// ---- Process SELL form ----
$sellMsg = '';
if (isset($_POST['send-sell'])) {
    // Security checks
    if (!verifyCsrf()) {
        $sellMsg = '<p class="alert alert-danger">Invalid request (CSRF). Please refresh and try again.</p>';
    } elseif (isHoneypotTripped()) {
        $sellMsg = ''; // Silent drop – bot submission
    } elseif (isRateLimited('sell')) {
        $sellMsg = '<p class="alert alert-warning">Too many submissions. Please wait a while before trying again.</p>';
    } else {
        // Sanitize inputs
        $fromName = sanitizeName($_POST['fullName'] ?? '');
        $from     = sanitizeEmail($_POST['email'] ?? '');
        $tel      = sanitizePhone(($_POST['phone_code'] ?? '+255') . ' ' . ($_POST['phone'] ?? ''));
        $location = sanitizeText($_POST['location'] ?? '', 150);
        $desc     = sanitizeMessage($_POST['desc'] ?? '', 2000);
        $price    = sanitizeText($_POST['price'] ?? 'Not specified', 50);

        // Validate required fields
        if (!$fromName || !$from || !$tel || !$location || !$desc) {
            $sellMsg = '<p class="alert alert-danger">Please fill in all required fields with valid information.</p>';
        } elseif ($mailReady) {
            $body = "
              <html><body style='font-family:Arial,sans-serif;font-size:16px;'>
              <h2 style='color:#e9383f;'>New Sell Listing &ndash; Donmicky Real Estate</h2>
              <p><b>Name:</b> {$fromName}</p>
              <p><b>Email:</b> {$from}</p>
              <p><b>Phone:</b> {$tel}</p>
              <p><b>Property Location:</b> {$location}</p>
              <p><b>Asking Price:</b> {$price}</p>
              <p><b>Description:</b><br>{$desc}</p>
              </body></html>";
            $result = sendMail("Sell Listing &ndash; {$location}", $body, $from, $fromName);
            if ($result === true) {
                $sellMsg = '<p class="alert alert-success">Thank you, ' . $fromName . '! Your property listing has been received. We will contact you shortly.</p>';
            } else {
                $sellMsg = '<p class="alert alert-danger">Unable to send listing. Please try again later.</p>';
            }
        } else {
            $sellMsg = '<p class="alert alert-warning">Mail is not configured yet. Please contact us directly.</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Donmicky Real Estate Developers – Buy / Sell Property</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="buy sell property Tanzania Dar es Salaam" name="keywords" />
  <meta content="Buy or sell property with Donmicky Real Estate Developers." name="description" />

  <!-- Favicon -->
  <link href="img/icon.png" rel="icon" />

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
      color: #e9383f;
    }
    .btn.btn-primary, .btn.btn-outline-primary:hover { color: #fff; }
    .btn-new { background: #e9383f; color: #fff; }
    .btn-new:hover { background: #b93e44; color: #fff; }

    .page-header {
      background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)), url(img/page-header-bg.png) center center no-repeat;
      background-size: cover;
    }

    /* Action Tabs */
    .action-tabs {
      display: flex;
      gap: 0;
      border-radius: 8px;
      overflow: hidden;
      border: 2px solid #e9383f;
      max-width: 340px;
      margin: 0 auto 40px;
    }
    .action-tab-btn {
      flex: 1;
      padding: 12px 0;
      border: none;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      background: #fff;
      color: #e9383f;
      transition: background 0.2s, color 0.2s;
    }
    .action-tab-btn.active {
      background: #e9383f;
      color: #fff;
    }
    .action-tab-btn:hover:not(.active) {
      background: #fde8e8;
    }

    /* Property cards for Buy tab */
    .prop-card {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.10);
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
      border: 2px solid transparent;
    }
    .prop-card:hover, .prop-card.selected {
      transform: translateY(-5px);
      box-shadow: 0 8px 28px rgba(233,56,63,0.2);
      border-color: #e9383f;
    }
    .prop-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }
    .prop-card-body {
      background: #fff;
      padding: 16px;
      border-top: 3px solid #e9383f;
    }
    .prop-card-body h5 { font-weight: 700; color: #222; margin-bottom: 4px; }
    .prop-card-body p { color: #888; font-size: 0.9rem; margin: 0; }
    .prop-badge { background: #e9383f; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }

    /* Buy form section */
    #buy-form-section {
      margin-top: 36px;
      padding: 30px;
      border-radius: 8px;
      background: #faf2f2;
      border-left: 5px solid #e9383f;
      display: none;
    }
    #buy-form-section.show { display: block; }

    /* Panels */
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Form field contrast fixes ── */
    .form-floating > .form-control {
      background-color: #fff !important;
      border: 1.5px solid #c8c8c8 !important;
      color: #1a1a1a !important;
      border-radius: 6px;
    }
    .form-floating > .form-control:focus {
      border-color: #e9383f !important;
      box-shadow: 0 0 0 3px rgba(233,56,63,.15) !important;
      outline: none;
    }
    .form-floating > .form-control[readonly] {
      background-color: #f0f0f0 !important;
      color: #555 !important;
    }
    .form-floating > label {
      color: #666;
    }
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
      color: #e9383f;
    }
    /* Keep buy-form-section background slightly lighter for contrast */
    #buy-form-section {
      background: #fff3f3 !important;
    }

    /* ── Phone group (country code selector + number input) ── */
    .phone-group {
      display: flex;
      gap: 8px;
      align-items: stretch;
    }
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
      -webkit-appearance: auto;
      appearance: auto;
    }
    .phone-code-select:focus {
      border-color: #e9383f !important;
      box-shadow: 0 0 0 3px rgba(233,56,63,.15) !important;
      outline: none;
    }
    .phone-input-wrap { flex: 1; }

    /* ── Name field subtle hint styling ── */
    .form-control:invalid:not(:placeholder-shown) {
      border-color: #e9383f !important;
    }
  </style>
</head>

<body>

  <!-- Topbar Start -->
  <?php require 'linkpage/topbar.php'; ?>
  <!-- Topbar End -->

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
    <div class="container">
      <?php require "linkpage/logo.php"; ?>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-3 py-lg-0">
          <a href="./" class="nav-item nav-link">Home</a>
          <a href="order" class="nav-item nav-link active">Buy / Sell</a>
          <a href="about" class="nav-item nav-link">About Us</a>
          <a href="contact" class="nav-item nav-link">Contact Us</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Page Header Start -->
  <div class="container">
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
      <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4">Buy / Sell Property</h1>
        <nav aria-label="breadcrumb animated slideInDown">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a class="text-white" href="./">Home</a></li>
            <li class="breadcrumb-item text-primary active" aria-current="page">Buy / Sell</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- Page Header End -->


  <!-- Main Content Start -->
  <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">

      <!-- Tab Switcher -->
      <div class="action-tabs">
        <button class="action-tab-btn <?php echo $action !== 'sell' ? 'active' : ''; ?>" id="tab-buy-btn" onclick="switchTab('buy')">
          <i class="fa fa-home me-2"></i>Buy
        </button>
        <button class="action-tab-btn <?php echo $action === 'sell' ? 'active' : ''; ?>" id="tab-sell-btn" onclick="switchTab('sell')">
          <i class="fa fa-tag me-2"></i>Sell
        </button>
      </div>


      <!-- ===== BUY TAB ===== -->
      <div class="tab-panel <?php echo $action !== 'sell' ? 'active' : ''; ?>" id="panel-buy">

        <div class="text-center mb-4">
          <h4 style="font-family:'Poppins',sans-serif; font-weight:700;">Available Properties</h4>
          <p class="text-muted">Click on a property to apply and buy.</p>
        </div>

        <div class="row g-4 justify-content-center">

          <!-- Sinza Card -->
          <div class="col-md-5">
            <div class="prop-card <?php echo $preselectedProperty === 'Sinza' ? 'selected' : ''; ?>" onclick="selectProperty('Sinza', this)">
              <img src="img/property-sinza.jpg" alt="House in Sinza" />
              <div class="prop-card-body">
                <span class="prop-badge">For Sale</span>
                <h5 class="mt-2">Residential House – Sinza</h5>
                <p><i class="fa fa-map-marker-alt me-2 text-danger"></i>Sinza, Dar es Salaam</p>
              </div>
            </div>
          </div>

          <!-- Mbezi Card -->
          <div class="col-md-5">
            <div class="prop-card <?php echo $preselectedProperty === 'Mbezi' ? 'selected' : ''; ?>" onclick="selectProperty('Mbezi', this)">
              <img src="img/property-mbezi.jpg" alt="House in Mbezi" />
              <div class="prop-card-body">
                <span class="prop-badge">For Sale</span>
                <h5 class="mt-2">Residential House – Mbezi</h5>
                <p><i class="fa fa-map-marker-alt me-2 text-danger"></i>Mbezi, Dar es Salaam</p>
              </div>
            </div>
          </div>

        </div>

        <!-- Buy Application Form (appears after card click) -->
        <div id="buy-form-section" class="wow fadeIn <?php echo $preselectedProperty ? 'show' : ''; ?>">
          <h5 style="font-family:'Poppins',sans-serif; font-weight:700; color:#e9383f;" class="mb-3">
            <i class="fa fa-file-alt me-2"></i>Application Form — <span id="selected-prop-label"><?php echo $preselectedProperty ?: ''; ?></span>
          </h5>

          <?php echo $buyMsg; ?>

          <form action="order?action=buy" method="POST">
            <?php echo csrfField(); ?>
            <?php echo honeypotField(); ?>
            <input type="hidden" name="property" id="property-input" value="<?php echo $preselectedProperty; ?>" required />
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control border-0 bg-light" id="buyName" name="fullName"
                    placeholder="Full Name" autocomplete="name"
                    pattern="[\p{L}\s'\-]{2,100}" title="Letters only – no numbers or symbols"
                    required />
                  <label for="buyName">Full Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="email" class="form-control border-0 bg-light" id="buyEmail" name="email" placeholder="Email" required />
                  <label for="buyEmail">Email Address</label>
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
                    <input type="tel" class="form-control border-0 bg-light" id="buyPhone" name="phone"
                      placeholder="Phone number" inputmode="numeric"
                      pattern="[0-9\s]{4,15}" title="Digits only, e.g. 0712 345 678"
                      autocomplete="tel-national" required />
                    <label for="buyPhone">Phone Number</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control border-0 bg-light" id="buyPropDisplay" value="<?php echo $preselectedProperty; ?>" placeholder="Property" readonly />
                  <label for="buyPropDisplay">Selected Property</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control border-0 bg-light" id="buyNotes" name="notes" placeholder="Additional notes" style="height:100px;"></textarea>
                  <label for="buyNotes">Additional Notes (optional)</label>
                </div>
              </div>
              <div class="col-12">
                <button class="btn btn-new py-3 px-5 wow bounceIn" data-wow-delay="300ms" name="send-buy" type="submit">
                  <i class="fa fa-paper-plane me-2"></i>Submit Application
                </button>
              </div>
            </div>
          </form>
        </div>

      </div>
      <!-- BUY TAB END -->


      <!-- ===== SELL TAB ===== -->
      <div class="tab-panel <?php echo $action === 'sell' ? 'active' : ''; ?>" id="panel-sell">

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="border-start border-5 border-primary ps-4 mb-4">
              <h6 class="text-body text-uppercase mb-2">List Your Property</h6>
              <h4 class="mb-0" style="font-family:'Poppins',sans-serif; font-weight:700;">I Want to Sell My Property</h4>
            </div>
            <p class="text-muted mb-4">Fill in the form below and our team will get in touch to help you sell your property at the best price.</p>

            <?php echo $sellMsg; ?>

            <form action="order?action=sell" method="POST">
              <?php echo csrfField(); ?>
              <?php echo honeypotField(); ?>
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control border-0 bg-light" id="sellName" name="fullName"
                      placeholder="Full Name" autocomplete="name"
                      pattern="[\p{L}\s'\-]{2,100}" title="Letters only – no numbers or symbols"
                      required />
                    <label for="sellName">Full Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" class="form-control border-0 bg-light" id="sellEmail" name="email" placeholder="Email" required />
                    <label for="sellEmail">Email Address</label>
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
                      <input type="tel" class="form-control border-0 bg-light" id="sellPhone" name="phone"
                        placeholder="Phone number" inputmode="numeric"
                        pattern="[0-9\s]{4,15}" title="Digits only, e.g. 0712 345 678"
                        autocomplete="tel-national" required />
                      <label for="sellPhone">Phone Number</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control border-0 bg-light" id="sellLocation" name="location" placeholder="Property Location" required />
                    <label for="sellLocation">Property Location</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control border-0 bg-light" id="sellPrice" name="price" placeholder="Asking Price (TZS)" />
                    <label for="sellPrice">Asking Price (TZS)</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control border-0 bg-light" id="sellDesc" name="desc" placeholder="Describe your property" style="height:130px;" required></textarea>
                    <label for="sellDesc">Description of the Property</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-new py-3 px-5 wow bounceIn" data-wow-delay="300ms" name="send-sell" type="submit" style="float:right;">
                    <i class="fa fa-paper-plane me-2"></i>Submit Listing
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
      <!-- SELL TAB END -->

    </div>
  </div>
  <!-- Main Content End -->


  <!-- Footer Start -->
  <?php require "linkpage/footer.php"; ?>
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
  <script src="js/main.js"></script>

  <script>
    function switchTab(tab) {
      document.getElementById('panel-buy').classList.toggle('active', tab === 'buy');
      document.getElementById('panel-sell').classList.toggle('active', tab === 'sell');
      document.getElementById('tab-buy-btn').classList.toggle('active', tab === 'buy');
      document.getElementById('tab-sell-btn').classList.toggle('active', tab === 'sell');
    }

    function selectProperty(name, cardEl) {
      // Deselect all
      document.querySelectorAll('.prop-card').forEach(c => c.classList.remove('selected'));
      // Select clicked
      cardEl.classList.add('selected');
      // Update hidden inputs & display
      document.getElementById('property-input').value = name;
      document.getElementById('buyPropDisplay').value = name;
      document.getElementById('selected-prop-label').textContent = name;
      // Show form
      var section = document.getElementById('buy-form-section');
      section.classList.add('show');
      section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Auto-show form if property pre-selected via URL
    <?php if ($preselectedProperty): ?>
    document.addEventListener('DOMContentLoaded', function() {
      var section = document.getElementById('buy-form-section');
      if (section) section.classList.add('show');
    });
    <?php endif; ?>
  </script>

</body>
</html>
