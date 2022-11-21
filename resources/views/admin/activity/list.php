<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?> lista</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <div class="table-responsive">
        <?php echo $table ?>
        <a href="<?php echo base_url('admin/activity/delete') ?>" class="btn btn-danger">Tevékenységek törlése</a>
    </div>
    <?php echo $this->pagination->create_links(); ?>
</div>
</div>
</div>
</div>
</div>
