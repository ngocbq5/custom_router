<?php
if (isset($request)) {
    var_dump($errors);
    extract($request);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">Link</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Link</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Link</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Link</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Link</a>
                </li>
            </ul>
        </nav>
        <form action="/product/add" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?= $name ?? '' ?>">
                    <?php if (isset($errors['name'])) : ?>
                        <div class="invalid-feedback">
                            <?= $errors['name'] ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="number" name="price" placeholder="price" class="form-control" value="<?= $price ?? '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="file" name="image" id="" class="form-file">
                    <?php if (isset($errors['image'])) : ?>
                        <div class="invalid-feedback">
                            <?= $errors['image'] ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-6 mb-3">
                    <select name="cate_id" class="select-form">
                        <?php
                        foreach ($category as $cate) : ?>
                            <option value="<?= $cate->id ?>" <?= isset($cate_id) ? ($cate_id == $cate->id) ? 'selected' : '' : '' ?>>
                                <?= $cate->cate_name ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <textarea class="form-control" placeholder="Mô tả ngăbs" name="short_desc" style="height: 100px"><?= $short_desc ?? '' ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <textarea name="detail" class="form-control" placeholder="Nội dung chi tiết" rows="10"><?= $detail ?? '' ?></textarea>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-outline-primary">Lưu</button>
                    <button type="reset" class="btn btn-outline-primary">Xóa</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>