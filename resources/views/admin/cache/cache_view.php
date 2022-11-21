<?php $this->load->view('admin/layout/page-header_view',$page_title);?>
<div class="row">
<div class="col-xl-12 col-md-12 mb-4">
<div class="card shadow">
<div class="card-header"><?php echo $page_title ?></div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php $this->load->view('admin/layout/system_messages');?>
    <p>A rendszerben  gyorsítótárazzuk azokat a tartalmakat, amelyek minden oldalon megjelennek. Ezek a menük (oldalak menü, kategéria menü, fejlés és lábléc menük), bannerek, blokkok, főoldali termékek, hírek, blog.
    Ha szerkesztette a tartalmat, akkor törölheti a cache tárakat és a következő oldal betöltéskor az aktuális tartalom fog megjelenni.
    </p>
    <p>Ha nem törli kézzel a cache tárat, akkor a cachelési időzítések után a rendszer automatiksuan frissíti azokat.</p>
    <h3>Cache beállítások</h3>
    <p>
        Gyorsítótár útvonala: /application/cache/<br>
        Gyorsítótár időzítése: <?php echo CACHE_TIME?> mp<br>
    </p>
    <?php echo anchor('admin/cache/clear_data/', 'Cache törlése',array('class'=>'btn btn-warning')) ?>
</div>
</div>
</div>
</div>
</div>
