<?= $this->extend('layouts/header'); ?>

<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert-success alert" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <div class="col-xs-1-12">
        <div class="card-group">
            <?php foreach ($product as $p) : ?>
                <div class="card m-3" style="width: 18rem;">
                    <img src="/img/<?= $p['image']; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['name']; ?></h5>
                        <p class="text font-weight-bold">Rp. <?= $p['price']; ?></p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?= $this->endSection('content'); ?>