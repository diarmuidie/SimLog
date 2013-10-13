<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/normalize.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
    <![endif]-->
</head>
<body>

<div class="header-container">
    <?php if ($this->uri->segment(1)=="") { ?>
    <header class="home clearfix">
        <div class="logo">
            <!--<img src="https://secure.gravatar.com/avatar/6058fd1ccb544cc5c12b5b21880086bc?s=100" alt="diarmuid"/>-->
            <img src="<?php echo base_url(); ?>diarmuid.jpg" width="100px" height="100px" alt="diarmuid"/>
            <h1>Diarmuid.ie</h1>
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo base_url();?>" class="<?php echo ($this->uri->segment(1)=="" ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo base_url();?>blog" class="<?php echo ($this->uri->segment(1)=="blog" ? 'active' : ''); ?>">Blog</a></li>
                <li><a href="<?php echo base_url();?>projects" class="<?php echo ($this->uri->segment(1)=="projects" ? 'active' : ''); ?>">Projects</a></li>
                <li><a href="<?php echo base_url();?>contact" class="<?php echo ($this->uri->segment(1)=="contact" ? 'active' : ''); ?>">Contact</a></li>
            </ul>
        </nav>
    </header>
    <?php } else { ?>
    <header class="sub clearfix">
        <a href="<?php echo base_url(); ?>"><h1>Diarmuid.ie</h1></a>
        <nav>
            <ul>
                <li><a href="<?php echo base_url();?>" class="<?php echo ($this->uri->segment(1)=="" ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo base_url();?>blog" class="<?php echo ($this->uri->segment(1)=="blog" ? 'active' : ''); ?>">Blog</a></li>
                <li><a href="<?php echo base_url();?>projects" class="<?php echo ($this->uri->segment(1)=="projects" ? 'active' : ''); ?>">Projects</a></li>
                <li><a href="<?php echo base_url();?>contact" class="<?php echo ($this->uri->segment(1)=="contact" ? 'active' : ''); ?>">Contact</a></li>
            </ul>
        </nav>
    </header>
    <?php } ?>
</div>

<div class="main-container<?php echo ($this->uri->segment(1)!==""?" ".$this->uri->segment(1):"");?>">
    <div class="main wrapper clearfix">

        <?php echo $content; ?>

    </div> <!-- #main -->
</div> <!-- #main-container -->

<div class="footer-container">
    <footer class="wrapper">
        <?php echo $footer;?>
    </footer>
</div>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-2.0.3.min.js"><\/script>')</script>-->

<!--<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_gat._anonymizeIp'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src='//www.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
</script>-->
</body>
</html>
