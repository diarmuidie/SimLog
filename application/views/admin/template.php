<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/admin/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/admin/custom.css" rel="stylesheet">

    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->

    <script src="<?php echo base_url(); ?>assets/js/admin/epiceditor.min.js"></script>

</head>

<body>

    <div class="container main">

        <?php echo $navbar; ?>

        <?php if(isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

        <?php echo $content; ?>

    </div>

</body>
</html>