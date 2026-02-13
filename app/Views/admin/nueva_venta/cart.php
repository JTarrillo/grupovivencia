<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Detalle de Compra</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/nueva_venta">Listado de
                                                productos</a></li>
                                        <li class="breadcrumb-item"><a>Detalle de Compra</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row invoice-contact">
                            <div class="col-md-12">
                                <div class="invoice-box row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table table-borderless p-l-20">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a class="b-brand">
                                                            <img class="img-fluid"
                                                                src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>"
                                                                alt="Logo" width="50">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>GRUPO VIVENCIA</td>
                                                </tr>
                                                <tr>
                                                    <td>RUC:20613043889</td>
                                                </tr>
                                                <tr>
                                                    <td><a class="text-secondary">contacto@alelifeglobal.com</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form name="form" id="form" method="post" enctype="multipart/form-data"
                            action="<?php echo site_url() . "dashboard/nueva_venta/carrito"; ?>">
                            <div class="card-body">
                                <div class="row invoive-info">
                                    <div class="col-md-3 col-xs-12 invoice-client-info">
                                        <label>Cliente</label>
                                        <select name="customer_id" onchange="submit()" id="customer_id"
                                            style="border-radius: 3px 0px 0px 3px;" class="selectpicker form-control"
                                            data-live-search="true" required>
                                            <option value="">Seleccionar patrocinador</option>
                                            <?php foreach ($obj_customer as $value) : ?>
                                            <option value="<?php echo $value->id; ?>"
                                                <?php echo $customer_id == $value->id ? "selected" : ""; ?>>
                                                <?php echo $value->code . "  -  $value->dni (" . $value->name . " " . $value->lastname . ")"; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php
                           $data_membership = array();
                           if ($membership_id) { ?>
                                    <div class="col-md-3 col-sm-6">
                                        <label>Kit de afiliación <?php echo $membership_id ?> </label>
                                        <select name="membership_id" id="membership_id" class="form-control" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                    foreach ($obj_membership as $key => $value) {
                                       array_push(
                                          $data_membership,
                                          array(
                                             "price" => $value->price,
                                             "subtotal" => $sub_total,
                                             "name" => $value->name,
                                          )
                                       )
                                    ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-3 col-sm-6">
                                        <label>Teléfono de contacto</label>
                                        <input type="text" name="phone" id="phone" min="5" value="<?php echo $phone; ?>"
                                            class="form-control" required />
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label>Recojo de productos</label>
                                        <select id="store_id" name="store_id" class="form-control" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                 foreach ($obj_store as $key => $value) { ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table invoice-detail-table">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                        <th class="min-w-100px pb-2">
                                                            <?php echo lang('Global.descripcion'); ?></th>
                                                        <th class="min-w-100px pb-2">Cantidad</th>
                                                        <th class="min-w-80px pb-2">Precio</th>
                                                        <th class="min-w-80px pb-2">
                                                            <?php echo lang('Global.importe'); ?></th>
                                                        <th class="min-w-150px pb-2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                       foreach ($content as $key => $row) { ?>
                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                        <td
                                                            class="d-flex align-items-center name_<?php echo $row->options['details']; ?>">
                                                            <?php echo $row->name; ?>
                                                        </td>
                                                        <td class="">
                                                            <input id="<?php echo $key; ?>" type="number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="qty_<?php echo $row->rowId; ?>"
                                                                value="<?php echo $row->qty; ?>" min="1" max="3000" />
                                                        </td>
                                                        <td><?php echo $row->price; ?></td>
                                                        <td><?php echo format_number_miles_decimal($row->subtotal); ?>
                                                        </td>
                                                        <td>
                                                            <div class="operation">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        id="edit_<?php echo $row->rowId; ?>"
                                                                        onclick="edit('<?php echo $row->rowId; ?>', '<?php echo $key; ?>');"
                                                                        class="btn btn-icon btn-info"><i
                                                                            class="fa fa-edit"></i></button>
                                                                    <button type="button"
                                                                        onclick="deleted('<?php echo $row->rowId; ?>');"
                                                                        class="btn btn-icon btn-danger"
                                                                        onclick="eliminar('2');"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                        <td class="d-flex align-items-center"></td>
                                                        <td></td>
                                                        <td>Sub Total</td>
                                                        <td id="subtotal_max" class="fs-5 text-dark fw-bolder">
                                                            s/.<?php echo $sub_total; ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                        <td class="d-flex align-items-center"></td>
                                                        <td></td>
                                                        <td>IGV</td>
                                                        <td class="fs-5 text-dark fw-bolder">-</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                        <td class="d-flex align-items-center"></td>
                                                        <td></td>
                                                        <td>Total</td>
                                                        <td class="fs-5 text-dark fw-bolder">
                                                            s/.<?php echo $sub_total; ?></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php
                              if ($membership_id == 1) { ?>
                                        <div class="fw-semibold text-gray-600 fs-7">Importe mínimo a comprar: s/.<span
                                                id="show_price">0</span> </div>
                                        <?php } else { ?>
                                        <div class="fw-semibold text-gray-600 fs-7">Importe mínimo a comprar: s/.<span
                                                id="show_price">0</span> </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 p-3">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            <button id="btn_submit" type="submit"
                                                class="btn btn-sm btn-primary btn-active-light-primary">Finalizar
                                                Compra</button>
                                            <a href="<?php echo site_url() . "dashboard/nueva_venta"; ?>"
                                                onclick="removeSessionStorage()"
                                                class="btn btn-sm btn-light btn-active-light-primary"><i
                                                    class="fa fa-shopping-bag"></i> Seguir comprando</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    const kitName = document.querySelector("td.name_membresia")
    const selectCustomer = document.getElementById("customer_id")
    selectCustomer.addEventListener("change", () => {
        removeSessionStorage()
    })
    const membership_id = <?php echo $membership_id ?? 0; ?>;
    const select = document.getElementById("membership_id");
    const savedSelection = sessionStorage.getItem("selection");
    const membresia = document.querySelector("input.membresia");
    const data = <?php echo json_encode($data_membership); ?>;

    if (membership_id > 1) {
        select.removeAttribute('required')
    }

    let cost = 0
    if (membresia) {
        membresia.disabled = true
        cost = 50
    }

    const btnFinish = document.getElementById("btn_submit")
    btnFinish.addEventListener("click", () => {
        const inputPhone = document.getElementById("phone")
        const selectAlmacen = document.getElementById("store_id")
        const index = selectAlmacen.selectedIndex
        const indexKit = select.selectedIndex
        const value = inputPhone.value;
        if (membership_id > 1) {
            if (index > 0 && value.trim() !== '') {
                removeSessionStorage()
                document.form.action = 'checkout';
                document.form.submit()
            }
        } else {
            if (index > 0 && value.trim() !== '' && indexKit > 0) {
                removeSessionStorage()
                document.form.action = 'checkout';
                document.form.submit()
            }
        }
    })

    if (savedSelection) {
        const index = savedSelection
        const option = select.options[index];
        option.setAttribute("selected", "selected");

        if (index != 0) {
            let name = data[index - 1].name
            let price = data[index - 1].price
            const subtotalFormat = data[index - 1].subtotal
            let subtotal = subtotalFormat.replace(/,/g, '');

            if (membership_id == 1) {
                if (kitName) {
                    kitName.textContent = name;
                }
            }

            if (subtotal > 0) {
                let nextPrice = 0
                if (data[index] != undefined) {
                    nextPrice = data[index].price
                }
                document.getElementById("show_price").innerHTML = price;
                price = Number(price);
                nextPrice = Number(nextPrice)
                subtotal = Number(subtotal);
                if ((subtotal - cost) >= price && nextPrice === 0 && (subtotal - cost) <= 3000) {
                    document.getElementById('btn_submit').disabled = false;
                } else {
                    if ((subtotal - cost) >= price && (subtotal - cost) < nextPrice) {
                        document.getElementById('btn_submit').disabled = false;
                    } else {
                        document.getElementById('btn_submit').disabled = true;
                    }
                }
            }
        }
    }

    select.addEventListener("change", () => {
        const index = select.selectedIndex
        const option = select.options[index];

        for (const op of select.options) {
            op.removeAttribute("selected");
        }

        option.setAttribute("selected", "selected");

        if (index != 0) {
            let name = data[index - 1].name
            if (membership_id == 1) {
                if (kitName) {
                    kitName.textContent = name;
                }
            }

            if (data[index - 1].subtotal) {
                let nextPrice = 0
                if (data[index] != undefined) {
                    nextPrice = data[index].price
                }
                change(data[index - 1].price, data[index - 1].subtotal, cost, nextPrice)
            }
        }

        sessionStorage.setItem('selection', index)
    });
    </script>
    <script>
    document.getElementById("btn_submit").addEventListener("click", function(event) {
        event.preventDefault(); // Evita el envío automático

        let form = document.getElementById("form");

        if (form.checkValidity()) { // Verifica que los campos requeridos sean válidos
            form.action =
            "<?php echo site_url() . 'dashboard/nueva_venta/checkout'; ?>"; // Cambia el action dinámicamente
            form.submit(); // Envía el formulario con POST
        } else {
            alert("Por favor, completa todos los campos requeridos.");
            form.reportValidity(); // Muestra los mensajes de validación del navegador
        }
    });
    </script>
    <script src='<?php echo site_url() . 'assets/admin/js/script/nueva_venta.js?123'; ?>'></script>
    <script>
    function submit() {
        document.getElementById("form").submit();
    }
    </script>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>