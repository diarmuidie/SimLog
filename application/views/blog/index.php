<section>
    <ul class="postlist">
        <?php foreach($entries as $entry) { ?>
        <li><a href="<?php echo base_url() . 'blog/post/' . $entry['slug'];?>"><?php echo $entry['title']; ?></a></li>
        <?php } ?>
    </ul>
</section>