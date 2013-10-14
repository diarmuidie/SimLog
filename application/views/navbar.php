<?php if ($this->uri->segment(1)=="") { ?>
    <header class="home clearfix">
        <div class="logo">
            <!--<img src="https://secure.gravatar.com/avatar/6058fd1ccb544cc5c12b5b21880086bc?s=100" alt="diarmuid"/>-->
            <img src="<?php echo base_url(); ?>diarmuid.jpg" width="100px" height="100px" alt="diarmuid"/>
            <h1>Diarmuid.ie</h1>
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo base_url();?>" class="<?php echo ($this->uri->segment(1)=="" ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo base_url();?>blog" class="<?php echo ($this->uri->segment(1)=="blog" ? 'active' : ''); ?>">Blog</a></li>
                <li><a href="<?php echo base_url();?>projects" class="<?php echo ($this->uri->segment(1)=="projects" ? 'active' : ''); ?>">Projects</a></li>
                <li><a href="<?php echo base_url();?>contact" class="<?php echo ($this->uri->segment(1)=="contact" ? 'active' : ''); ?>">Contact</a></li>
            </ul>
        </nav>
    </header>
<?php } else { ?>
    <header class="sub clearfix">
        <a href="<?php echo base_url(); ?>"><h1>Diarmuid.ie</h1></a>
        <nav>
            <ul>
                <li><a href="<?php echo base_url();?>" class="<?php echo ($this->uri->segment(1)=="" ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo base_url();?>blog" class="<?php echo ($this->uri->segment(1)=="blog" ? 'active' : ''); ?>">Blog</a></li>
                <li><a href="<?php echo base_url();?>projects" class="<?php echo ($this->uri->segment(1)=="projects" ? 'active' : ''); ?>">Projects</a></li>
                <li><a href="<?php echo base_url();?>contact" class="<?php echo ($this->uri->segment(1)=="contact" ? 'active' : ''); ?>">Contact</a></li>
            </ul>
        </nav>
    </header>
<?php } ?>