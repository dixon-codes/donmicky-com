<?php
// Auto-detect active page from the request URI
$currentPath = strtok($_SERVER['REQUEST_URI'], '?'); // strip query string
$currentPath = trim($currentPath, '/');

// Normalise: "index.php" and "" both map to home
if ($currentPath === 'index.php') $currentPath = '';

function navActive(string $page, string $current): string {
    return $page === $current ? ' active' : '';
}
?>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
  <div class="container">
    <?php require __DIR__ . '/logo.php'; ?>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto py-3 py-lg-0">
        <a href="./" class="nav-item nav-link<?php echo navActive('', $currentPath); ?>">Home</a>
        <a href="order" class="nav-item nav-link<?php echo navActive('order', $currentPath); ?>">Buy / Sell</a>
        <a href="about" class="nav-item nav-link<?php echo navActive('about', $currentPath); ?>">About Us</a>
        <a href="contact" class="nav-item nav-link<?php echo navActive('contact', $currentPath); ?>">Contact Us</a>
      </div>
    </div>
  </div>
</nav>
<!-- Navbar End -->
