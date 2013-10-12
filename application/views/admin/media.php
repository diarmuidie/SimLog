<h1>Published Posts:</h1>

<ul>
    <?php foreach ($files as $file) { ?>
        <li><a href="<?php echo base_url(); ?>media/<?php echo $file; ?>"><?php echo $file; ?></a></li>
    <?php } ?>
</ul>