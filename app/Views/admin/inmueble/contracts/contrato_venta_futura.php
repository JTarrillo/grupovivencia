<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 13px;
        background: #fff;
        color: #222;
    }

    .report-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px;
        background: #fff;
        box-shadow: 0 0 8px #eee;
        border-radius: 8px;
    }

    h1 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 10px;
        color: #2a3e6c;
    }

    .no-data {
        text-align: center;
        color: #888;
        font-style: italic;
    }
    </style>
</head>

<body>
    <div class="report-container">
        <div
            style="display:flex; align-items:center; justify-content:space-between; background:#f7f9fc; border-radius:10px; padding:18px 28px 18px 18px; margin-bottom:18px; box-shadow:0 2px 8px #e3eaf5;">
            <div style="display:flex; align-items:center; gap:22px;">
                <!-- Usar ruta relativa para compatibilidad con Word -->
                <img src="/public/assets/front/img/logo/logo_2025__.png" alt="Logo Grupo Vivencia"
                    style="height:80px; width:auto; border-radius:8px; box-shadow:0 2px 8px #bfc8d7; background:#fff;">
                <div>
                    <span
                        style="font-size:2.1em; color:#2a3e6c; font-weight:700; font-family:'Segoe UI', Arial, sans-serif; letter-spacing:1px;">Grupo
                        Vivencia</span><br>
                    <span
                        style="font-size:1.1em; color:#555; font-weight:400; font-family:'Segoe UI', Arial, sans-serif;">Gestión
                        Inmobiliaria</span>
                </div>
            </div>
            <div style="text-align:right; min-width:180px;">
                <span style="font-size:1em; color:#2a3e6c; font-weight:500;">Fecha: <?= date('Y-m-d') ?></span><br>
            </div>
        </div>
        <h1 style="margin-bottom:0;">CONTRATO DE COMPRA VENTA FUTURA</h1>
        <hr style="margin:10px 0 20px 0;">
        <?php if (!empty($contracts)): ?>
        <?php 
            $c = $contracts[0];
            // Construir nombre completo
            $nombreCompleto = trim(($c['name'] ?? '') . ' ' . ($c['lastname'] ?? '') . ' ' . ($c['mother_last'] ?? ''));
            if (empty($nombreCompleto)) {
                $nombreCompleto = $c['customer_name'] ?? '________________';
            }
            // Nacionalidad
            $nacionalidad = '__________';
            if (isset($c['country_id']) && ($c['country_id'] == 1 || strtolower($c['country'] ?? '') == 'peru')) {
                $nacionalidad = 'peruana';
            } elseif (!empty($c['country'])) {
                // Puedes mapear otros países aquí si lo deseas
                $nacionalidad = strtolower($c['country']);
            }
        ?>
        <div style="white-space:normal; font-size:1em; line-height:1.7;">
            <p>CONSTE POR EL PRESENTE DOCUMENTO DE CONTRATO COMPRA VENTA DE BIEN INMUEBLE, QUE OTORGAN DE UNA PARTE LA
                EMPRESA "GRUPO VIVENCIA S.A.C., CON RUC: 20612232998, CON DOMICILIO FISCAL EN LA URB. MANUEL PRADO
                D-27-B JR. OLLANTAYTAMBO, DISTRITO, PROVINCIA Y DEPARTAMENTO DE CUSCO, INSCRITA EN LA PARTIDA
                ELECTRÓNICA N° 11316876 DEL REGISTRO DE PERSONAS JURÍDICAS DE LA ZONA REGISTRAL N° X SEDE CUSCO,
                DEBIDAMENTE REPRESENTADA POR EL GERENTE GENERAL SR. LUIS GREET HUAMAN MADRID, DE NACIONALIDAD PERUANO,
                IDENTIFICADO CON DNI N° 43879196, DE ESTADO CIVIL SOLTERO, OCUPACIÓN INDEPENDIENTE, CON DOMICILIO REAL
                EN DEPARTAMENTO 101 LA URB. SANTA BEATRIZ E-9, DISTRITO WANCHAQ, PROVINCIA Y DEPARTAMENTO DE CUSCO, A
                QUIEN EN ADELANTE SE DENOMINARA “EL VENDEDOR”, Y DE OTRA PARTE SR.
                <?= esc($nombreCompleto) ?> DE NACIONALIDAD
                <?= esc($nacionalidad) ?>, IDENTIFICADO CON DNI N°
                <?= esc($c['dni'] ?? '__________') ?>, OCUPACIÓN <?= esc($c['occupation'] ?? '__________') ?>, DE ESTADO
                CIVIL <?= esc($c['civil_status'] ?? '__________') ?>, CON DOMICILIO REAL
                <?= esc($c['address'] ?? '_________________________') ?>, DISTRITO
                <?= esc($c['district'] ?? '__________') ?>, PROVINCIA <?= esc($c['province'] ?? '__________') ?>,
                DEPARTAMENTO <?= esc($c['department'] ?? '__________') ?>, MANZANA
                "<?= esc($c['block'] ?? '__________') ?>", UNIDAD CATASTRAL N°
                <?= esc($c['cadastral_unit'] ?? '__________') ?>; A QUIENES EN ADELANTE SE LE DENOMINARA “EL
                COMPRADOR”; EN LOS TÉRMINOS Y CONDICIONES CONTENIDOS EN LAS CLÁUSULAS SIGUIENTES:</p>
            <p><strong>PRIMERA. ANTECEDENTES:</strong> “EL VENDEDOR” ES PROPIETARIO LEGÍTIMO DEL
                <?= esc($c['ownership_percent'] ?? '__________') ?>%
                (<?= esc($c['ownership_percent_text'] ?? '_________________________') ?>), EN RELACIÓN AL ÁREA MATRIZ
                QUE ES DE <?= esc($c['main_area_ha'] ?? '__________') ?> HAS., SEGÚN CONSTA EN EL ASIENTO N°
                <?= esc($c['seat_number'] ?? '__________') ?>, PREDIO RUSTICO DENOMINADO HUAYPO GRANDE PARCELA
                <?= esc($c['lot_number'] ?? '__________') ?> IDENTIFICADO CON UNIDAD CATASTRAL N°
                <?= esc($c['cadastral_unit'] ?? '__________') ?>, UBICADO EN EL SECTOR DE
                <?= esc($c['sector'] ?? '__________') ?>, DISTRITO DE <?= esc($c['district'] ?? '__________') ?>,
                PROVINCIA DE <?= esc($c['province'] ?? '__________') ?>, DEPARTAMENTO DEL
                <?= esc($c['department'] ?? '__________') ?>. CUYO DERECHO DE PROPIEDAD CORRE INSCRITO EN EL ASIENTO
                <?= esc($c['seat_number'] ?? '__________') ?> DE LA PARTIDA ELECTRONICA N°
                <?= esc($c['registry_number'] ?? '__________') ?>, EN EL REGISTRO DE PREDIOS DE LA ZONA REGISTRAL N° X
                SEDE - CUSCO. CONFORME A LA ESCRITURA PÚBLICA DEL <?= esc($c['public_deed_date'] ?? '__________') ?>,
                SUSCRITO ANTE EL NOTARIO <?= esc($c['notary'] ?? '__________') ?> EN LA CIUDAD DE
                <?= esc($c['notary_city'] ?? '__________') ?>.</p>
            <p><strong>SEGUNDA. OBJETO DE CONTRATO:</strong> “EL VENDEDOR” MEDIANTE EL PRESENTE INSTRUMENTO TRANSFIERE
                EN VENTA REAL A FAVOR DE “EL COMPRADOR” EL BIEN INMUEBLE LOTE
                <?= esc($c['lot_number'] ?? '__________') ?>, MANZANA “<?= esc($c['block'] ?? '__________') ?>” A TITULO
                DE COMPRA Y VENTA Y EN PROPIEDAD EL <?= esc($c['main_area_ha'] ?? '__________') ?> HAS., QUE ES IGUAL A
                <?= esc($c['area_sqm'] ?? '__________') ?> M2
                (<?= esc($c['area_sqm_text'] ?? '_________________________') ?> METROS CUADRADOS), EQUIVALENTE
                <?= esc($c['ownership_percent'] ?? '__________') ?>%, RESPECTO DEL AREA MATRIZ MENCIONADA CLAUSULA
                PRIMERA, PREDIO RUSTICO DENOMINADO HUAYPO GRANDE PARCELA <?= esc($c['lot_number'] ?? '__________') ?>
                IDENTIFICADO CON UNIDAD CATASTRAL N° <?= esc($c['cadastral_unit'] ?? '__________') ?>, UBICADO EN EL
                SECTOR DE <?= esc($c['sector'] ?? '__________') ?>, DE DISTRITO DE
                <?= esc($c['district'] ?? '__________') ?>, PROVINCIA DE <?= esc($c['province'] ?? '__________') ?>,
                DEPARTAMENTO DEL <?= esc($c['department'] ?? '__________') ?>. LA PRESENTE TRANSFERENCIA COMPRENDE SUS
                INGRESOS, SALIDAS, AIRES, USOS, EDIFICACIONES, SERVICIOS, MEJORAS, BIENES ACCESORIOS Y TODO CUANTO DE
                HECHO Y DERECHO LE CORRESPONDA, EN RELACIÓN AL ÁREA MATRIZ DESCRITA PRECEDENTEMENTE.</p>
            <p><strong>TERCERA. PRECIO, FORMA Y LUGAR DE PAGO:</strong> LOS DERECHOS Y ACCIONES OBJETO DE PRESTACIÓN A
                CARGO DE “EL VENDEDOR” TIENE UNA VALORIZACIÓN DE S/. <?= esc($c['price_pen'] ?? '__________') ?>
                (<?= esc($c['price_pen_text'] ?? '_________________________') ?> CON 00/100 SOLES).<br>S/.
                <?= esc($c['payment_amount'] ?? '__________') ?>
                (<?= esc($c['payment_amount_text'] ?? '_________________________') ?> CON 00/100 SOLES) A LA CUENTA DE
                BBVA N° <?= esc($c['bbva_account'] ?? '_________________________') ?> CON NUMERO DE OPERACIÓN
                <?= esc($c['operation_number'] ?? '__________') ?> TITULAR DE GRUPO VIVENCIA S.A.C.</p>
            <p><strong>CUARTA.</strong> “EL VENDEDOR” SE OBLIGA A ENTREGAR EL BIEN OBJETO DE LA PRESTACIÓN A SU CARGO EN
                LA FECHA DE LA FIRMA DEL PRESENTE DOCUMENTO DE COMPRA VENTA, POR SU PARTE LOS COMPRADORES SE OBLIGAN A
                LA ENTREGA DE LOS COMPROBANTES QUE SE REFIERE LA CLÁUSULA ANTERIOR, ACTO QUE SE VERIFICARÁ CON LA
                ENTREGA DE DOCUMENTOS DEL MENCIONADO INMUEBLE, PROCURÁNDOLE A “EL COMPRADOR” TOMAR EFECTIVA POSESIÓN DE
                DICHO BIEN.</p>
            <p><strong>QUINTA.</strong> “EL VENDEDOR” SE OBLIGA A ENTREGAR TODOS LOS DOCUMENTOS RELATIVOS A LA PROPIEDAD
                Y USO DEL BIEN OBJETO DE LA PRESTACIÓN A SU CARGO, Y EL COMPROBANTE DE PAGO CANCELADO DEL IMPUESTO DE LA
                PROPIEDAD PREDIAL. “EL COMPRADOR” DEBERÁ RECIBIR EL BIEN OBJETO DE LA PRESTACIÓN A CARGO DE “EL
                VENDEDOR”, EN LA FORMA Y OPORTUNIDAD PACTADAS.</p>
            <p><strong>SEXTA. OBLIGACIONES DE SANEAMIENTO FISICO LEGAL:</strong> “EL VENDEDOR” DECLARA Y ACLARA QUE
                SUSCRIBE EL PRESENTE DOCUMENTO PRIVADO DE COMPRA VENTA, DEBIDO A QUE EN LA FECHA SE VIENE REALIZANDO EL
                PROYECTO DE SANEAMIENTO FISICO LEGAL DE INDEPENDIZACION DEL BIEN INMUEBLE; DE MANERA QUE, UNA VEZ QUE
                CONCLUYA EL PROCESO DE SANEAMIENTO ANTES SEÑALADO, ESTARA OBLIGADO OTORGAR LA ESCRITURA PUBLICA. EL
                COSTO DE LA INDEPENDIZACION SERA ASUMIDO POR EL COMPRADOR.</p>
            <p><strong>SEPTIMA. OBLIGACIONES DE SANEAMIENTO FISICO LEGAL:</strong> “EL VENDEDOR” DECLARA QUE EL BIEN
                OBJETO DE LA PRESTACIÓN A SU CARGO, SE ENCUENTRA AL MOMENTO DE CELEBRARSE ESTE CONTRATO, LIBRE DE TODA
                CARGA, GRAVAMEN, DERECHO REAL DE GARANTÍA, MEDIDA JUDICIAL O EXTRAJUDICIAL Y EN GENERAL DE TODO ACTO O
                CIRCUNSTANCIA QUE IMPIDA, PRIVE O LIMITE LA LIBRE DISPONIBILIDAD Y/O EL DERECHO DE PROPIEDAD, POSESIÓN O
                USO DEL BIEN. NO OBSTANTE, SE OBLIGA AL SANEAMIENTO DE LEY.</p>
            <p><strong>OCTAVA. GASTOS Y TRIBUTOS:</strong> LAS PARTES ACUERDAN QUE TODOS LOS GASTOS QUE ORIGINEN LA
                CELEBRACIÓN, FORMALIZACIÓN Y/O EJECUCIÓN DEL PRESENTE CONTRATO SERÁN ASUMIDOS POR “EL COMPRADOR”.</p>
            <p><strong>NOVENA.</strong> “EL VENDEDOR” DECLARA QUE AL MOMENTO DE CELEBRARSE ESTE CONTRATO, NO TIENE
                NINGUNA OBLIGACIÓN TRIBUTARIA PENDIENTE DE PAGO RESPECTO DE LOS DERECHOS Y ACCIONES OBJETO DE LA
                PRESTACIÓN A SU CARGO; CASO CONTRARIO, ASUMIRÁ Y CANCELARÁ LOS TRIBUTOS QUE CORRESPONDAN HASTA ANTES DE
                LA TRANSFERENCIA.</p>
            <p><strong>DECIMA. DOMICILIO:</strong> PARA LA VALIDEZ DE TODAS LAS COMUNICACIONES Y NOTIFICACIONES,
                CURSADAS CON MOTIVO DE LA EJECUCIÓN DE ESTE CONTRATO, AMBAS PARTES SEÑALAN COMO SUS RESPECTIVOS
                DOMICILIOS LOS INDICADOS EN EL EXORDIO DE ESTE DOCUMENTO. EL CAMBIO DE DOMICILIO DE CUALQUIERA DE LAS
                PARTES SURTIRÁ EFECTO DESDE LA FECHA DE COMUNICACIÓN DE DICHO CAMBIO A LA OTRA PARTE, POR CUALQUIER
                MEDIO ESCRITO.</p>
            <p><strong>DÉCIMA PRIMERA. COMPETENCIA TERRITORIAL:</strong> PARA EFECTOS DE CUALQUIER CONTROVERSIA QUE SE
                GENERE CON MOTIVO DE LA CELEBRACIÓN Y/O EJECUCIÓN DE ESTE CONTRATO, LAS PARTES SE SOMETEN A LA
                COMPETENCIA TERRITORIAL DE LOS JUECES Y TRIBUNALES DE LA CIUDAD DEL CUSCO.</p>
            <p><strong>DÉCIMA SEGUNDA. APLICACIÓN SUPLETORIA DE LA LEY:</strong> EN TODO LO NO PREVISTO POR LAS PARTES
                EN EL PRESENTE CONTRATO, AMBAS SE SOMETEN A LO ESTABLECIDO POR LAS NORMAS DEL CÓDIGO CIVIL Y DEMÁS DEL
                SISTEMA JURÍDICO QUE RESULTEN APLICABLES.</p>
            <?php
            $meses = [
                'January' => 'enero',
                'February' => 'febrero',
                'March' => 'marzo',
                'April' => 'abril',
                'May' => 'mayo',
                'June' => 'junio',
                'July' => 'julio',
                'August' => 'agosto',
                'September' => 'septiembre',
                'October' => 'octubre',
                'November' => 'noviembre',
                'December' => 'diciembre'
            ];
            $mes = $meses[date('F')];
            ?>
            <p>Cusco, <?= date('d') ?> de <?= $mes ?> del <?= date('Y') ?></p>
            <p><strong>EL VENDEDOR:</strong> LUIS GREET HUAMAN MADRID.</p>
            <p><strong>EL COMPRADOR:</strong> <?= esc($nombreCompleto) ?></p>
        </div>
        <hr style="margin:20px 0;">
        <table style="width:100%; aborder:none;">
            <tr>
                <td style="border:none; width:60%;">
                    <br><br>
                    ___________________________<br>
                    Firma del Cliente
                </td>
                <td style="border:none; text-align:right;">
                    <br><br>
                    ___________________________<br>
                    Firma del Representante
                </td>
            </tr>
        </table>
        <?php else: ?>
        <div class="no-data">No hay contratos disponibles</div>
        <?php endif; ?>
    </div>
</body>

</html>