<h1>Draft Posts:</h1>
<table class="table table-hover well">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Publish on</th>
        <th>Edited</th>
        <th>Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($entries)) {
        foreach ($entries as $key => $entry) { ?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><a href="<?php echo base_url(); ?>admin/edit/<?php echo $entry['id']; ?>"><?php echo $entry['title']; ?></a></td>
                <td nowrap><?php echo ($entry['published'] !== null)? date('F j, Y, g:i a', strtotime($entry['published'])) : ''; ?></td>
                <td nowrap><?php echo date('F j, Y, g:i a', strtotime($entry['edited'])); ?></td>
                <td nowrap><a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>admin/edit/<?php echo $entry['id']; ?>">Edit</a></td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>