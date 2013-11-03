<h1>Cache:</h1>

<form class="form-post well" method="post">
    <button class="btn btn-danger" type="submit" name="purge" value="all">Purge All</button>
</form>

<form class="form-post well" method="post">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>URI</th>
                <th>Created</th>
                <th>Expiring</th>
                <th>Purge?</th>
            </tr>
        </thead>
        <tbody>
        <?php if (isset($caches)) {
            foreach ($caches as $key => $cache) { ?>
                <tr>
                    <td><a href="<?php echo $cache['uri']; ?>"><?php echo $cache['uri']; ?></a></td>
                    <td nowrap><?php echo date('F j, Y, g:i a', $cache['modified']); ?></td>
                    <td nowrap><?php echo ($_SERVER['REQUEST_TIME'] >= $cache['expire']) ? "Expired" : date('F j, Y, g:i a', $cache['expire']); ?></td>
                    <td nowrap><button class="btn btn-xs btn-danger" type="submit" name="purge" value="<?php echo $cache['uri']; ?>">Purge</button></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</form>