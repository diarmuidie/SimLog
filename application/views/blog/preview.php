<section class="post">
<article>
                <h1 class="title"><?php echo $entry['title']; ?></h1>
                <p class="meta">Posted <?php echo date('jS F Y', strtotime($entry['published']));?></p>
                <?php echo $entry['html']; ?>
        </article>

        <div class="tags">
            <p>Tags:</p>
            <ul>
                <?php if ($tags) { foreach ($tags as $tag) { ?>
                <li><?php echo $tag['tag']; ?></li>
                <?php } } ?>
            </ul>
        </div>

        <div id="disqus_thread"></div>
        <script type="text/javascript">
        </script>
        <noscript>Please enable JavaScript to view the comments.</noscript>

</section>