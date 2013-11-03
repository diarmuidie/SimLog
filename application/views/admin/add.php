<form class="form-post" method="post">

    <div class="form-group">
        <input class="form-control input-lg" type="text" placeholder="Title"
               value="<?php echo($title ? $title : ""); ?>" name="title">
    </div>

    <div class="well">
        <div class="form-group">
            <div id="editor"></div>
            <textarea id="markdown" rows="30" name="markdown"><?php echo($markdown ? $markdown : ""); ?></textarea>
            <p class="help-block"><a href="http://daringfireball.net/projects/markdown/syntax">Syntax help</a></p>
        </div>
    </div>

    <div class="well">
        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" class="form-control input-lg" value="" data-role="tagsinput" name="tags"/>
        </div>
        <div class="form-group">
            <label for="published">Publish Date</label>
            <input type="date" class="form-control inline" value="<?php echo($published ? $published : ""); ?>"
                   name="published">
        </div>
    </div>

    <div class="well">
        <button class="btn btn-primary" type="submit" name="submit" value="Submit">Save</button>
    </div>
</form>

<script>
    window.onload = function () {
        document.getElementById('markdown').style.display = 'none';
        var editor = new EpicEditor({
            container: 'editor',
            basePath: '<?php echo base_url(); ?>assets/css/admin/epiceditor',
            textarea: 'markdown',
            theme: {
                base: '/themes/base/epiceditor.css',
                preview: '/themes/preview/bartik.css',
                editor: '/themes/editor/epic-dark.css'
            },
            clientSideStorage: false
        }).load();

        var elt = $("input[name='tags']");
        elt.tagsinput('input').typeahead({
            prefetch: '<?php echo base_url(); ?>admin/tags_list'
        }).bind('typeahead:selected', $.proxy(function (obj, datum) {
                this.tagsinput('add', datum.value);
                this.tagsinput('input').typeahead('setQuery', '');
            }, elt));
    }
</script>