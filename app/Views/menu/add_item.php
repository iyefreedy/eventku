<?= $this->extend('layouts/header'); ?>

<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Item</h1>

    <div class="col-lg-8">
        <form method="POST" action="/menu/additem" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name">
                    <div class="invalid-feedback">
                        <?= $validation->getError('name'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : ''; ?>" id="price" name="price">
                    <div class="invalid-feedback">
                        <?= $validation->getError('price'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea class="form-control <?= ($validation->hasError('description')) ? 'is-invalid' : ''; ?>" name="description" id="description" rows="5"></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('description'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-2">
                    <img src="/img/default.png" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-8">
                    <div class="custom-file">
                        <input type="file" name="image" id="image" onchange="previewImg()" class="custom-file-input <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('image'); ?>
                        </div>
                        <label for="image" class="custom-file-label">Choose Image</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary col-3">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?= $this->endSection(); ?>