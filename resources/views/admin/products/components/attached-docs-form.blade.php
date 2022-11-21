<?php
if(!empty($files))
{
    echo form_fieldset('Csatolt dokumentumok');
    foreach ($files as $f)
    {
        $pdf_icon_url = site_url().'assets/theme/images/pdf_icon.png';
        $word_icon_url = site_url().'assets/theme/images/word_icon.png';
        $file_icon_url = site_url().'assets/theme/images/file_icon.png';
        $path_parts = pathinfo($f['name']);
        if($path_parts['extension'] == 'pdf')
            $file_icon = $pdf_icon_url;
        elseif($path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx')
            $file_icon = $word_icon_url;
        else
            $file_icon = $file_icon_url;

        echo '<a target="blank" href="'.site_url('files/editor/docs/'.$f['name']).'"><img src="'.$file_icon.'" style="float: left; margin: 0 10px 0 0; width:40px;">'.$f['name'].' - '.$f['title'].'</a>';
        echo '<a href= "'.site_url().'admin/products/delete_doc/'.$f['id'].'/'.$f['product_id'].'" style="color: red; width:150px;  display:block" onclick="return confirm(\'Biztos hogy leválasztod ezt a fájlt?\');">Leválasztás</a><hr />';
    }

    echo form_fieldset_close();
}
?>
<div class="clearfix"></div>
<?php echo form_open(base_url('admin/products/save_doc/'.$product['id']),'class="form-horizontal"') ?>
<div class="form-group">
    <label class="col-lg-2 control-label">Dokumentum címe</label>
    <div class="col-lg-10">
        <div class="input-group col-lg-12">
            <input type="text" value="" name="title" class="form-control input-sm" />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Fájl kiválasztása / feltöltése</label>
    <div class="col-lg-10">
        <div class="input-group col-lg-12">
            <input id="fieldID" type="text" value="" name="file" class="form-control input-sm">
            <span class="input-group-btn">
            <a class="btn btn-default iframe-btn" type="button" href="<?php echo base_url()?>assets/admin/plugins/filemanager/dialog.php?fldr=docs&field_id=fieldID">Fájl kiválasztása</a>
            </span>
        </div>
        <p class="form-helper">A fájlt a docs könyvtárba kell feltölteni/kiválasztani</p>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary col-lg-offset-2">Dokumentum csatolása</button>
</div>

<?php echo form_close() ?>
