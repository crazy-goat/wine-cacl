<!DOCTYPE html>
<html lang="<?= $this->lang() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $seo_description ?? $this->trans('html.head.description'); ?>">
    <meta name="author" content="<?= $seo_author ?? $this->trans('html.head.author'); ?>">
    <title><?= $seo_title ?? $this->trans('html.head.title'); ?></title>
    <link href="/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/scrolling-nav.css" rel="stylesheet">
</head>
<body id="page-top">
<?php $this->insert('_partial/navigation') ?>
<div id="wrap">
    <div id="main">
        <?= $this->section('content') ?>
    </div>
</div>
<?php $this->insert('_partial/footer') ?>
<script src="/public/vendor/jquery/jquery.min.js"></script>
<script src="/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>