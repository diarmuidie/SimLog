<section class="post">
        <article>
                <h1 class="title"><?php echo $entry['title']; ?></h1>
                <p class="meta">Posted <?php echo date('jS F Y', strtotime($entry['published']));?></p>
                <?php echo $entry['html']; ?>
        </article>

        <div id="disqus_thread"></div>
        <script type="text/javascript">
            var disqus_shortname = 'diarmuid'; // required: replace example with your forum shortname
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the comments.</noscript>

</section>