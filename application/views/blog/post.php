<section class="post">
        <article>
                <h1 class="title"><?php echo $entry['title']; ?></h1>
                <p class="meta">Posted <?php echo date('NS F Y', strtotime($entry['published']));?></p>
                <?php echo $entry['html']; ?>
        </article>

</section>