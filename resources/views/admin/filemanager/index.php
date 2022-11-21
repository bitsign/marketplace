<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <iframe width="100%" height="800" frameborder="0" src="<?php echo base_url();?>assets/admin/plugins/filemanager/dialog.php?type=0&lang=hu_HU"> </iframe>
</div>
</div>
</div>
</div>
</div>
