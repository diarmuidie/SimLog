<h1>Cache:</h1>

<form class="form-post" method="post">
    <button class="btn btn-danger" type="submit" name="purge" value="all">Purge All</button>
</form>

<ul class="well">
    <form class="form-post" method="post">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
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
                        <td><?php echo $key + 1 ?></td>
                        <td><a href="<?php echo $cache['uri']; ?>"><?php echo $cache['uri']; ?></a></td>
                        <td nowrap><?php echo date('F j, Y, g:i a', $cache['modified']); ?></td>
                        <td nowrap><?php echo date('F j, Y, g:i a', $cache['expire']); ?></td>
                        <td nowrap><button class="btn btn-xs btn-danger" type="submit" name="purge" value="<?php echo $cache['uri']; ?>">Purge</button></td>
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
    </form>

</ul>