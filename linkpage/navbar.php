<?php
// Get just the last segment of the URI (works on any subdirectory depth)
$currentPath = strtok($_SERVER['REQUEST_URI'], '?'); // strip query string
$currentPath = basename($currentPath);                // e.g. "about" or "about.php"
$currentPath = preg_replace('/\.php$/i', '', $currentPath); // strip .php extension

// "index" and "" both map to home
if ($currentPath === 'index' || $currentPath === '') $currentPath = '';

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
        <a href="about" class="nav-item nav-link<?php echo navActive('about', $currentPath); ?>">About Us</a>
        <a href="order" class="nav-item nav-link<?php echo navActive('order', $currentPath); ?>">Buy or Sell</a>
        <a href="contact" class="nav-item nav-link<?php echo navActive('contact', $currentPath); ?>">Contact Us</a>
      </div>
    </div>
  </div>
</nav>
<!-- Navbar End -->
