<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <div class="table-responsive">
        <?php echo form_open('')?>
            <div class="col-md-6">
                <?php echo form_dropdown('category_id',$categories,$this->input->post('category_id'),'class="form-control select2" id="categories" style="width:100%" onchange="this.form.submit();"');?>
            </div>
        <?php echo form_close()?>
        <?php if(!empty($products)){?>
            <table class="table table-hover table-striped product_sortable">
                <thead>
                    <tr>
                        <th>Sorrendezés</th>
                        <th>Termék neve</th>
                        <th>Sorrend</th>
                    </tr>
                </thead>
                <tbody>
                <?php $rows = 0;
                foreach ($products as $p)
                {
                    ?>
                    <tr id="item-<?php echo $p['id'] ?>#<?php echo $p['category_id'] ?>">
                        <td><a class="handle1 btn btn-primary btn-xs"><i class="bi bi-arrow-down-up"></i></a></td>
                        <td><?php echo '<a href="'.base_url().'admin/products/product_form/'.$p['id'].'">'.$p['name'].'</a>';?></td>
                        <td><?php echo $p['sort']?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        <?php }else{?>
        <div class="col-md-12">Válassz kategóriát!</div>
        <?php } ?>
    </div>
</div>
</div>
</div>
</div>
</div>
