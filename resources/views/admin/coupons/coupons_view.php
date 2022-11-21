<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Kuponkód</th>
                    <th>Kedvezmény</th>
                    <th>Limit / Felhasználva</th>
                    <th>Aktív</th>
                    <th>Kezdet</th>
                    <th>Lejárat</th>
                    <th class="text-right">Műveletek</th>
                </tr>
            </thead>
            <tbody>
            <?php if($coupons)
            {?>
                <?php foreach ($coupons as $c)
                {
                    $coupon_limit = ($c['limit_per_coupon'] > 0) ? $c['limit_per_coupon'] . ' db' : 'Nincs';
                    $coupon_used  = $this->coupons_model->get_coupon_used($c['id']);
                    $used_label   = $coupon_used < $coupon_limit? 'bg-success': ($coupon_used == $coupon_limit? 'bg-warning':'bg-danger');
                    $expired_label = $c['expire']>date('Y-m-d')?'bg-success':'bg-warning';
                    ?>
                    <tr>
                        <td><?php echo $c['name'];?></td>
                        <td><?php echo $c['code'];?></td>
                        <td><?php echo $c['discount'];?> <?php echo $c['type'] == 0 ? '%' : 'érték';?></td>
                        <td><?php echo '<span class="badge '.$used_label.'">'.$coupon_limit . ' / ' . $coupon_used . ' db</span>'?></td>
                        <td><?php echo $c['active'] == 1 ? "<span class='badge bg-success'>Aktív</span>" : "<span class='badge bg-danger'>Inaktív</span>";?></td>
                        <td><?php echo $c['start'] ? $c['start'] : 'Nincs';?></td>
                        <td><?php echo '<span class="badge '.$expired_label.'">'.($c['expire'] ? $c['expire'] : 'Nincs').'</span>';?></td>
                        <td>
                            <div class="btn-group" style="float:right">
                                <a class="btn btn-primary btn-xs" title="Szerkeszt" href="<?php echo base_url(); ?>admin/coupons/coupons_form/<?php echo $c['id'];?>"><i class="bi bi-tools"></i></a>
                                <a class="btn btn-danger btn-xs" title="Töröl" href="<?php echo base_url(); ?>admin/coupons/delete/<?php echo $c['id'];?>" onclick="return confirm('Biztos hogy törlöd ezt a kupont?');"><i class="bi bi-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {?>
            <tr>
                <td colspan="8">Nincs kupon</td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
</div>
