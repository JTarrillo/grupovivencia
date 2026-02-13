<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->

<!-- begin head -->
<?php echo view("head"); ?>
<!-- begin head -->

<body>

    <!-- begin head -->
    <?php echo view("header"); ?>
    <!-- begin head -->

    <div id="checkout-checkout" class="container">

        <div class="row">
            <form name="form" method="post" enctype="multipart/form-data" action="<?php echo site_url() . "page-method"; ?>">
                <div id="content" class="col-sm-12">
                    <div class="head-t mt60 mb60 text-center">
                        <h4><span>Detalle de Entrega</span></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Fecha</label><br>
                            <label for=""><?php echo date('Y-m-d') ?></label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Nombre</label><br>
                            <label for=""><?php echo $obj_customer->name . " " . $obj_customer->lastname ?></label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Cédula / DNI</label><br>
                            <label for=""><?php echo $obj_customer->dni ?></label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Email</label><br>
                            <label for=""><?php echo $obj_customer->email ?></label>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Telefono contacto <?php echo $id ?> </label><br>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $obj_customer->phone ?>">
                            <input type="hidden" name="store_id" id="phone" value="2">
                        </div>
                        <div class="col-md-4">
                            <label for="">Dirección de entrega</label><br>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="">Delivery</label><br>
                            <select name="delivery" id="delivery" class="form-control">
                                <option value="lima">Lima (10 soles)</option>
                                <option value="provincia">Provincia (15 soles)</option>
                            </select>
                        </div>
                    </div>
                    <br><br>
                    <form>
                        <div class="table-responsive">
                            <?php if (empty($cart)) : ?>
                                <p>No hay productos en el carrito.</p>
                            <?php else : ?>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($cart as $item) : ?>
                                        <tr>
                                            <script>
                                                var item = <?= json_encode($item); ?>;
                                            </script>
                                            <td><img src="<?= site_url() . 'membresias/' . esc($item['id']) . '/' . esc($item['img']); ?>" alt="<?= esc($item['name']); ?>" style="width: 50px;"></td>
                                            <td><?= esc($item['name']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= format_number_moneda_soles(esc($item['price']));?></td>
                                            <td><?= format_number_moneda_soles(esc($item['qty'] * $item['price'])); ?></td>
                                            <?php $id = $item['id']; ?>
                                            <td>
                                                <div class="quantity-buttons">
                                                <button class="quantity-decrease btn" data-id="<?= $id ?>"><i class="fa fa-minus"></i></button>
                                                <button class="quantity-increase btn" data-id="<?= $id ?>"><i class="fa fa-plus"></i></button>
                                                <button type="button" class="remove-button btn btn-danger" data-id="<?= $id ?>"><i class="fa fa-trash" aria-hidden="true"></i></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                        <div class="buttons clearfix">
                            <div class="pull-left">
                                <a href="<?php echo site_url() . "productos"; ?>" class="btn btn-primary">Seguir Comprando</a>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>

    <!-- begin head -->
    <?php echo view("footer"); ?>
    <!-- begin head -->
</body>

</html>