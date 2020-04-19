<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      
      <!-- Meta, title, CSS, favicons, etc. -->
      
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=550">

      <title>Dashboard</title>
      <!-- Bootstrap -->
      <link href="<?= base_url('admin_assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="<?= base_url('admin_assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
      <!-- Data Tables -->
      <link href="<?= base_url('admin_assets/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet">
      <link href="<?= base_url('admin_assets/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- Custom Theme Style -->
      <link href="<?= base_url('admin_assets/css/custom.min.css'); ?>" rel="stylesheet">
      <link href="<?= base_url('admin_assets/css/custom.css'); ?>" rel="stylesheet">
<!-- include summernote css/js-->
<link href="<?= base_url('admin_assets/dist/summernote.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<!-- include libries(jQuery, bootstrap) -->
<script src="<?= base_url('admin_assets/js/jquery.js'); ?>"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<?= $content; ?>
</body>
</html>
