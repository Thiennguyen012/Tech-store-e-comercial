<?php
session_start();
require 'components/header.php';
require 'db/connect.php';
// navbar
include 'components/navbar.php'
?>

<!-- Content -->
<div id="main-content">
  <?php
  include 'module/main-content/main-content.php';
  ?>
</div>
<!-- About Us -->
<!-- Contact -->
<?php
include 'components/footer.php'
?>