        <h1>Published Posts:</h1>

        <ul>
            <?php foreach ($entries as $entry) { ?>
                <li><a href="<?php echo base_url(); ?>admin/edit/<?php echo $entry['id']; ?>"><?php echo $entry['title']; ?></a></li>
            <?php } ?>
        </ul>
