<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>">Diarmuid.ie</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo ($this->uri->segment(2)=="" ? 'active' : ''); ?>"><a href="<?php echo base_url() ;?>admin/">Published </a></li>
                <li class="<?php echo ($this->uri->segment(2)=="draft" ? 'active' : ''); ?>"><a href="<?php echo base_url() ;?>admin/draft">Draft</a></li>
                <li class="<?php echo ($this->uri->segment(2)=="add" ? 'active' : ''); ?>"><a href="<?php echo base_url() ;?>admin/add">Add Post</a></li>
                <li class="<?php echo ($this->uri->segment(2)=="media" ? 'active' : ''); ?>"><a href="<?php echo base_url() ;?>admin/media">Media</a></li>
                <li class="<?php echo ($this->uri->segment(2)=="cache" ? 'active' : ''); ?>"><a href="<?php echo base_url() ;?>admin/cache">Cache</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
