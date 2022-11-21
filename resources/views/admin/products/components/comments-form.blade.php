<?php if(!empty($comments)){ ?>
<h2 class="page-header">Hozzászólások</h2>
<?php
    function display_comments($comments, $indent = '0',$product_id)
    {
    foreach ($comments as $comment)
    {
        $column = 12-$indent;
        ?>
        <?php echo form_open(base_url('admin/products/edit_comment/'.$comment['id'].'/'.$product_id)) ?>
        <div class="col-md-<?php echo $column ?> <?php echo 'col-md-offset-'.$indent ?> comment">
            <!-- Author name -->
            <div class="comment-author"><a><?php echo $comment['author']?></a></div>
            <!-- Comment -->
            <textarea class="form-control input-sm" name="comment"><?php echo $comment['comment']?></textarea>
            <div class="clearfix"></div>
            <div class="cmeta">
                Közzétéve: <?php echo $comment['created']?>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-success btn-xs">Módsít</button>
                <a class="btn btn-danger btn-xs" href="<?php echo base_url('admin/products/delete_comment/'.$comment['id'].'/'.$product_id) ?>" onclick="return confirm('Biztos hogy törlöd ezt a hozzászólást?');">Töröl</a>
            </div>
        </div>
        <?php echo form_close() ?>
        <div class="clearfix"></div>
        <hr />
        <?php
        if (!empty($comment['replies'])) {
        display_comments($comment['replies'], $indent + 1,$product_id);
        }
    }
    }
    display_comments($comments,0,$product['id']);
    ?>
