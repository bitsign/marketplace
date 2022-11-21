<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-md-6 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?> lista</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <div class="table-responsive">
       <table class="table table-striped datatable">
        <thead>
            <tr>
                <th>Kód</th>
                <th>Típus</th>
                <th>Érték</th>
                <th>Info</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($stngs))
        {
            foreach ($stngs as $s)
            {
                if($s['type'] != 'product')
                    continue;
                ?>
                <tr>
                    <td><?php echo $s['key'];?></td>
                    <td><?php echo $types[$s['type']];?></td>
                    <td style="width: 300px; word-wrap:break-word;"><?php echo $s['value'];?></td>
                    <td>
                        <?php if(!empty($s['description'])) { ?>
                        <i class="bi bi-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $s['description'];?>"></i>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="btn-group" style="float:right">
                            <a href="<?php echo base_url().'admin/products/settings/false/'.$s['id'] ?>" class="btn btn-success btn-xs text-white">Módosít</a>
                            <!--a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>admin/products/settings/delete/<?php echo $s['id'];?>" onclick="return confirm('Biztos hogy törlöd ezt a beállítást?');">Töröl</a-->
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
<div class="col-md-6 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title; ?> <?php if($edit === false){?>létrehozása<?php }else{?>szerkesztése<?php } ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php if($edit === true){?>
        <?php echo form_open(base_url().'admin/products/settings/update/'.$post['id'],'class="form-horizontal" role="form" id="settings_form"');?>
    <?php }else{?>
        <?php echo form_open(base_url().'admin/products/settings/add/0','class="form-horizontal" role="form" id="settings_form"');?>
    <?php } ?>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Kód <code>*</code></label>
        <div class="col-lg-8">
            <input name="key" type="text" value="<?php echo $post['key']?>" class="form-control" placeholder="Kód" />
        </div>
    </div>
    <div class="row mb-2">
        <label class="col-lg-2 control-label">Típus <code>*</code></label>
        <div class="col-lg-8">
            <?php echo form_dropdown('type',$types,$post['type'],'class="form-control"'); ?>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Érték</label>
        <div class="col-lg-8">
            <textarea name="value" class="form-control"><?php echo $post['value']?></textarea>
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-lg-2 control-label">Info</label>
        <div class="col-lg-8">
            <textarea name="description" class="form-control"><?php echo $post['description']?></textarea>
        </div>
    </div>
    <hr />
    <div class="row mb-2">
        <div class="col-lg-offset-2 col-lg-9">
            <button type="submit" class="btn btn-primary"><?php if($edit === false){?>Feltölt<?php }else{?>Módosít<?php } ?></button>
        </div>
    </div>
<?php echo form_close();?>
</div>

<div class="row no-gutters align-items-center">
    <h4 class="box-title py-3">Termékkép méretek szerkesztése</h3>
    <table class="table table-striped table-hovered">
    <thead>
        <tr>
            <th>Kép típus</th>
            <th>Szélesség (px)</th>
            <th>Magasság (px)</th>
            <th>Műveletek</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($img_types as $dir => $value)
        {
            echo form_open(base_url('admin/products/update_img_settings'));
            if (!file_exists(getcwd().'/files/products/'.$dir.'/.htconfig'))
            {
                $fh = fopen(getcwd().'/files/products/'.$dir.'/.htconfig', 'w');
                fwrite($fh, "maxw:\n\rmaxh:\n");
                fclose($fh);
            }
            $lines = file (getcwd().'/files/products/'.$dir.'/.htconfig');
            foreach ($lines as $line)
            {
                $match = preg_match ("/([a-z0-9_]+):(.*)$/", trim ($line), $found);
                if ($match)
                    $vdata[$found[1]] = trim ($found[2]);
            }
            ?>
            <tr>
                <td><?php echo $value ?><input type="hidden" name="img_type" value="<?php echo $dir ?>"/></td>
                <td><input type="text" name="maxw" value="<?php echo $vdata["maxw"] ?>" class="form-control"/></td>
                <td><input type="text" name="maxh" value="<?php echo $vdata["maxh"] ?>" class="form-control"/></td>
                <td><button type="submit" class="btn btn-primary">Módosít</button></td>
            </tr>
            <?php
            echo form_close();
        } ?>
    </tbody>
    </table>
    <div class="callout callout-info">
        <p>
        Az eredeti termékképek könyvtára: /files/products/original/ (maximális fotóméret magasság 1200px, szélesség 1200px). A könyvtár tartalma nem érhető el internetről.<br/>
        Innen a rendszer automatikusan 3 méretű fotót készít feltöltéskor 3 külön könyvtárba a <a href="<?php echo base_url('admin/products/settings')?>">beállítások</a> alatt megadott méretekben: </br>
        1 - listakép - Kicsi (/files/products/small/)<br />
        2 - termék oldali kép - Közepes (/files/products/medium/)<br />
        3 - nagy termék kép - Nagy (/files/products/original/large/)<br />
        CSV-ből való termékfeltöltés esetén a termékképeket FTP-n keresztűl a <i>/files/products/original/</i> könyvtárba kell felmásolni, innen a rendszer automatikusan átméretezi.
        </p>
    </div>
</div>
</div>
</div>
</div>
</div>
