<h1>Media:</h1>

<form class="form-post well" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile" name="userfile">
    </div>

    <button class="btn btn-primary" type="submit" name="upload" value="upload">Upload</button>

</form>

<table class="table table-hover well">
    <thead>
    <tr>
        <th>Image</th>
        <th>Original</th>
        <th>Retina</th>
        <th>Markdown</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($files)) {
        foreach ($files as $key => $file) { ?>
            <tr>
                <td><a href="<?php echo $file['url'] ?>"><?php echo $file['filename']; ?></a></td>
                <td nowrap><?php echo(isset($file['original']))? '<a href="' . base_url() . '/media/' . $file['original'] . '">Original</a>' : ""; ?></td>
                <td nowrap><?php echo(isset($file['2x']))? '<a href="' . base_url() . '/media/' . $file['2x'] . '">Retina</a>' : ""; ?></td>
                <td>![<?php echo pathinfo($file['filename'], PATHINFO_FILENAME);?>](<?php echo $file['url'] ?>)</td>
                <td nowrap><a class="btn btn-danger btn-xs" href="#">Delete</a></td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>