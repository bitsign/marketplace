<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <?php echo form_open('','class="form-horizontal" role="form" id="coupons_form"');?>
    <div class="row mb-2">
        <label class="col-lg-2 control-label">Név*</label>
        <div class="col-lg-8">
            <input name="name" type="text" value="<?php echo $post['name']; ?>" class="form-control" placeholder="Kupon neve">
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kuponkód*</label>
        <div class="col-lg-8">
            <input name="code" type="text" value="<?php echo empty($post['code']) ? strtoupper(substr(uniqid(), -10)) : $post['code']; ?>" class="form-control" placeholder="Kuponkód">
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kedvezmény típusa*</label>
        <div class="col-lg-8">
            <?php echo form_dropdown('type',array('0'=>'%','1'=>'Érték'),$post['type'],'class="form-select"') ?>
            <div class="help-block">A kupon kedvezményének típusa. Ha érték, akkor a <i>kedvezmény</i> mezőben megadott érték kerül levonásra a vásárlás összegéből.  Ha %, akkor a vásárlás összegéből számoljuk ki a levonásra kerülő összeget.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kedvezmény*</label>
        <div class="col-lg-8">
            <input name="discount" type="text" value="<?php echo $post['discount']; ?>" class="form-control" placeholder="Kedvezmény">
            <div class="help-block">A kedvezmény mértéke. Ha a típus százalék, akkor maxium 99.99. Ha tartalmaz tizedes jegyeket, akkor a tizedesvessző helyett pontot kell használni.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Minimum összeg</label>
        <div class="col-lg-8">
            <input name="minimum_order" type="text" value="<?php echo $post['minimum_order']; ?>" class="form-control" placeholder="Minimum összeg">
            <div class="help-block">A rendelés minimum összege ahhoz, hogy a fent megadott kedvezmény életbe lépjen. Üresen hagyva nem lesz figyelembe véve a vásárlás összege.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kezdő dátum</label>
        <div class="col-lg-8">
            <input name="start" type="text" value="<?php echo $post['start']; ?>" class="form-control datepicker">
            <div class="help-block">A kezdő dátum, amitől a kupon felhasználható. A kiválasztott napon 00:00:00-tól! Üresen hagyva a felviteltől számítva felhasználható.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Lejárat dátum</label>
        <div class="col-lg-8">
            <input name="expire" type="text" value="<?php echo $post['expire']; ?>" class="form-control datepicker">
            <div class="help-block">A végső dátum, ameddig a kupon felhasználható. A kiválasztott napon 00:00:00-ig! Tehát ha azt szeretnénk, hogy egy napig legyen felhasználható a kupon, akkor itt egy nappal későbbit kell megadni, mint a kezdő dátum. Üresen hagyva addig használható, amíg el nem éri a limitet (ha van).</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Felhasználható (összesen)</label>
        <div class="col-lg-8">
            <input name="limit_per_coupon" type="text" value="<?php echo $post['limit_per_coupon']; ?>" class="form-control" placeholder="Felhasználható (összesen)">
            <div class="help-block">A kupon hányszor használható fel összesen. Üresen hagyva (vagy 0) a lejáratig (ha van) akárhányszor felhasználható. Ha a lejárat dátuma és a darab limit is ki van töltve, akkor addig használható, amelyik először teljesül.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Vásárlónkénti felhasználhatóság</label>
        <div class="col-lg-8">
            <input name="limit_per_user" type="text" value="<?php echo $post['limit_per_user']; ?>" class="form-control" placeholder="Vásárlónkénti felhasználhatóság">
            <div class="help-block">Egy kupont egy felhasználó hány vásárláshoz használhat fel. Üresen hagyva (vagy 0) a lejáratig (ha van) akárhányszor.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kategóriák</label>
        <div class="col-lg-8">
            <?php echo form_multiselect('restrict_to_categories[]',$categories,!empty($post['restrict_to_categories']) ? unserialize($post['restrict_to_categories']):'','class="form-control select2"'); ?>
            <div class="help-block">Ha van beállítva kategória, akkor a kupon csak az adott kategóriában és alkategóriáiban lévő termékekre használható fel. A <kbd>CTRL</kbd> billentyű lenyomásával több kategória is kiválasztható.</div>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Aktív?</label>
        <div class="col-lg-8">
            <div class="radio">
            <label>
                <input type="radio" name="active" id="" value="1" <?php if($post['active'] == 1 || $post['id'] == ""){?>checked="checked"<?php }?>>
                Igen
            </label>
            </div>
            <div class="radio">
            <label>
                <input type="radio" name="active" id="" value="0" <?php if($post['active'] == 0 && $post['id'] != ""){?>checked="checked"<?php }?>>
                Nem
            </label>
            </div>
        </div>
    </div>
    <hr />
    <div class="row mb-2">
        <div class="col-lg-offset-2 col-lg-9">
            <button type="submit" class="btn btn-primary"><?php if($edit === false){?>Feltölt<?php }else{?>Módosít<?php } ?></button>
        </div>
    </div>
    <?php if($edit === true){?>
        <?php echo form_hidden('id',$post['id']); ?>
    <?php } ?>
<?php echo form_close();?>
</div>
</div>
</div>
</div>
</div>
