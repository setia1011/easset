<?php echo view('templates/header.php'); ?>

<?php echo view('templates/menu.php'); ?>

<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <?php $this->renderSection('contents'); ?>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

<?php echo view('templates/footer.php'); ?>

<?php

if (isset($pagefile)) {
    if (file_exists(realpath(APPPATH . '/Views/pages/'.$pagefile.'_js.php'))) {
        echo view('pages/'.$pagefile.'_js.php');
    } 
}

?>
