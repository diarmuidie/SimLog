<h1>Media:</h1>

<form class="form-post well" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile" name="userfile">
    </div>

    <button class="btn btn-primary" type="submit" name="upload" value="upload">Upload</button>

</form>

<ul>
    <?php foreach ($files as $file) { ?>
        <li>
            <a href="<?php echo $file['url'] ?>"><?php echo $file['filename']; ?></a>
            (<?php echo $file['url'] ?>)
            <?php echo(isset($file['original']))? '(<a href="' . base_url() . '/media/' . $file['original'] . '">Orig</a>)' : ""; ?>
            <?php echo(isset($file['2x']))? '(<a href="' . base_url() . '/media/' . $file['2x'] . '">2x</a>)' : ""; ?>
        </li>
    <?php } ?>
</ul>