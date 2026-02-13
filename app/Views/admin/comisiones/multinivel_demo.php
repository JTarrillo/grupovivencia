<?php
// Vista demo de gestión inmobiliaria y comisiones
// Ubicación: app/Views/admin/comisiones/multinivel_demo.php

use App\Models\ProjectModel;
use App\Models\LotModel;
use App\Models\CustomerModel;
use App\Models\ContractModel;
use App\Models\InvoicesModel;
use App\Models\CommissionsModel;

$Project = new ProjectModel();
$Lot = new LotModel();
$Customer = new CustomerModel();
$Contracts = new ContractModel();
$Invoices = new InvoicesModel();
$Commissions = new CommissionsModel();
$db = \Config\Database::connect();

// Consulta las últimas 50 contratos inmobiliarios
$contratos = $Contracts->builder()
    ->orderBy('contract_date', 'DESC')
    ->limit(50)
    ->get()
    ->getResultArray();
?>

<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body>
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
                                        <h5 class="m-b-10">Demo: Comisiones Multinivel</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Demo Multinivel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de Gestión Inmobiliaria y Comisiones</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Venta</th>
                                                            <th>Fecha</th>
                                                            <th>Proyecto</th>
                                                            <th>Lote</th>
                                                            <th>Cliente</th>
                                                            <th>Agente</th>
                                                            <th>Estado</th>
                                                            <th>Hito</th>
                                                            <th>Monto Venta</th>
                                                            <th>Comisión</th>
                                                            <th>Tipo Comisión</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($contratos as $c): ?>
                                                        <?php $lote = isset($c['lot_id']) ? $Lot->find($c['lot_id']) : null; ?>
                                                        <?php $proyecto = ($lote && isset($lote['project_id'])) ? $Project->find($lote['project_id']) : null; ?>
                                                        <?php $cliente = isset($c['customer_id']) ? $Customer->find($c['customer_id']) : null; ?>
                                                        <?php 
                                                        // Buscar el agente (patrocinador) usando la tabla unilevels
                                                        $agente = null;
                                                        if (isset($c['customer_id'])) {
                                                            $unilevel = $db->table('unilevels')->where('customer_id', $c['customer_id'])->get()->getRowArray();
                                                            if ($unilevel && isset($unilevel['sponsor_id'])) {
                                                                $agente = $Customer->find($unilevel['sponsor_id']);
                                                            }
                                                        }
                                                        // Buscar la factura asociada al contrato
                                                        $factura = $Invoices->where('contract_id', $c['id'])->first();
                                                        $comision = null;
                                                        if ($factura && isset($factura['id'])) {
                                                            $comisionArr = $Commissions->getWhere(['invoice_id' => $factura['id']]);
                                                            if ($comisionArr && method_exists($comisionArr, 'getResultArray')) {
                                                                $comArr = $comisionArr->getResultArray();
                                                                $comision = (is_array($comArr) && count($comArr) > 0) ? $comArr[0] : null;
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        // Traducción de estados
                                                        $estados_lote = [
                                                            'sold' => 'Vendido',
                                                            'reserved' => 'Reservado',
                                                            'available' => 'Disponible',
                                                            'blocked' => 'Bloqueado',
                                                        ];
                                                        $estados_contrato = [
                                                            'active' => 'Activo',
                                                            'completed' => 'Completado',
                                                            'cancelled' => 'Cancelado',
                                                            'suspended' => 'Suspendido',
                                                        ];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $c['id']; ?></td>
                                                            <td><?php echo $c['contract_date']; ?></td>
                                                            <td><?php echo $proyecto ? $proyecto['name'] : '-'; ?></td>
                                                            <td><?php echo $lote ? $lote['lot_number'] : '-'; ?></td>
                                                            <td><?php echo $cliente ? $cliente['name'] : '-'; ?></td>
                                                            <td><?php echo $agente ? $agente['name'] : '-'; ?></td>
                                                            <td><?php echo $lote && isset($estados_lote[$lote['status']]) ? $estados_lote[$lote['status']] : '-'; ?>
                                                            </td>
                                                            <td><?php echo isset($c['status']) && isset($estados_contrato[$c['status']]) ? $estados_contrato[$c['status']] : '-'; ?>
                                                            </td>
                                                            <td>S/<?php echo isset($c['total_amount']) ? number_format($c['total_amount'],2) : '-'; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($comision): ?>
                                                                S/<?php echo number_format($comision['amount'],2); ?>
                                                                <?php else: ?>
                                                                -
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($comision): ?>
                                                                <?php echo $comision['type']; ?>
                                                                <?php else: ?>
                                                                -
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>ID Venta</th>
                                                            <th>Fecha</th>
                                                            <th>Proyecto</th>
                                                            <th>Lote</th>
                                                            <th>Cliente</th>
                                                            <th>Agente</th>
                                                            <th>Estado</th>
                                                            <th>Hito</th>
                                                            <th>Monto Venta</th>
                                                            <th>Comisión</th>
                                                            <th>Tipo Comisión</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p>Solo muestra las últimas 50 ventas/lotes con hitos y comisiones.
                                                    Puedes personalizar filtros y columnas según lo que necesites
                                                    mostrar.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo view("admin/footer"); ?>
</body>

</html>