<?php $this->layout('layout', []) ?>

<header class="bg-primary text-white">
    <div class="container text-center">
        <h1><?= $title ?></h1>
        <?php if(!empty($head)): ?><p class="lead"><?= $head ?></p><?php endif;?>
    </div>
</header>

<div class="container">
    <?= $content ?>
</div>