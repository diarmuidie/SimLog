<h1>Cache:</h1>

<form class="form-post" method="post">
    <button class="btn btn-danger" type="submit" name="purge" value="purge">Purge Cache</button>
</form>

<ul class="well">
    <?php if (isset($caches)) { foreach ($caches as $cache) { ?>
        <li><a href="<?php echo $cache['uri']; ?>"><?php echo $cache['uri']; ?></a> (<b>C:</b><?php echo date('F j, Y, g:i a', $cache['modified']);?> <b>E:</b><?php echo date('F j, Y, g:i a', $cache['expire']);?>)</li>
    <?php } } ?>
</ul>