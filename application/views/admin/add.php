    <form class="form-post" method="post">

        <div class="form-group">
            <input class="form-control input-lg" type="text" placeholder="Title" value="<?php echo ($title? $title: ""); ?>" name="title">
        </div>

        <div class="form-group">
            <div id="editor"></div>
        </div>

        <div class="form-group">
            <textarea class="form-control" id="markdown" rows="30" name="markdown"><?php echo ($markdown? $markdown: ""); ?></textarea>
        </div>
        <hr/>

        <div class="form-group">
            <label for="published">Publish Date</label>
            <input type="date" class="form-control inline" value="<?php echo ($published ? $published : ""); ?>" name="published">
        </div>

        <button class="btn btn-primary" type="submit" name="submit" value="Submit">Save</button>

    </form>

    <script>
        window.onload = function() {
            document.getElementById('markdown').style.display = 'none';
            var editor = new EpicEditor({
                container:'editor',
                basePath:'<?php echo base_url(); ?>assets/css/admin/epiceditor',
                textarea: 'markdown',
                theme: {
                    base: '/themes/base/epiceditor.css',
                    preview: '/themes/preview/bartik.css',
                    editor: '/themes/editor/epic-dark.css'
                },
                clientSideStorage: false
            }).load();
        }
    </script>