<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-md-7 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <div class="table-responsive">
        <table class="table table-striped" id="datatable">
        <thead>
            <tr>
                <th>Kód</th>
                <th>Érték</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($stngs))
        {
            foreach ($stngs as $s)
            {
                ?>
                <tr>
                    <td><?php echo $s['key'];?></td>
                    <td><?php echo $s['value'];?></td>
                    <td>
                        <div class="btn-group" style="float:right">

                            <a class="btn btn-primary btn-xs edit_text" title="Módosít" href="<?php echo base_url('admin/texts/texts_list/edit/'.$s['id'])?>"><i class="bi bi-tools"></i></a>
                            <a class="btn btn-danger btn-xs" title="Töröl" href="<?php // echo base_url('admin/texts/texts_list/delete/'.$s['id']); ?>" onclick="return confirm('Biztos hogy törlöd ezt a szöveget?');" disabled><i class="bi bi-trash"></i></a>
                        </div>
                    </td>

                </tr>
                <?php
            }
        }else{?>
        Nincs beállítás
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
<div class="col-md-5 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php if($edit === true){?>
    <?php echo form_open(base_url().'admin/texts/texts_list/update/'.$post['id'],'class="form-horizontal" role="form" id="texts_form"');?>
    <?php }else{?>
        <?php echo form_open(base_url().'admin/texts/texts_list/add/0','class="form-horizontal" role="form" id="texts_form"');?>
    <?php } ?>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kód <code>*</code></label>
        <div class="col-lg-8">
            <input name="key" type="text" value="<?php echo $post['key']?>" class="form-control" placeholder="Kód">
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Érték</label>
        <div class="col-lg-8">
            <textarea name="value" class="form-control"><?php echo $post['value']?></textarea>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Leírás</label>
        <div class="col-lg-8">
            <textarea name="description" class="form-control"><?php echo $post['description']?></textarea>
        </div>
    </div>
    <hr />
    <div class="row mb-2">
        <div class="col-lg-offset-2 col-lg-9">
            <button type="submit" class="btn btn-primary"><?php if($edit === false){?>Feltölt<?php }else{?>Módosít<?php } ?></button>
            <?php if($edit === true){?>
                <a href="<?php echo base_url().'admin/texts/texts_list' ?>" class="btn btn-danger">Mégsem</a>
            <?php } ?>
        </div>
    </div>
    <?php echo form_close();?>
</div>
</div>
</div>
</div>
</div>
