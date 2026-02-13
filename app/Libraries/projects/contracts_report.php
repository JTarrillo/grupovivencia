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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: #fafbfc;
    }

    th,
    td {
        border: 1px solid #bfc8d7;
        padding: 10px 7px;
        text-align: left;
    }

    th {
        background: #e3eaf5;
        color: #2a3e6c;
        font-size: 1em;
        font-weight: 600;
    }

    tr:nth-child(even) td {
        background: #f6f8fa;
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
                <?php
                $logoPath = __DIR__ . '/../../../../public/assets/front/img/logo/logo_2025__.png';
                $logoBase64 = '';
                if (file_exists($logoPath)) {
                    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                    $logoData = file_get_contents($logoPath);
                    $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
                }
                ?>
                <img src="<?= $logoBase64 ?>" alt="Logo Grupo Vivencia"
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
                <span style="font-size:1em; color:#2a3e6c; font-weight:500;">N° Contrato:
                    <?= esc($contracts[0]['contract_number'] ?? '') ?></span>
            </div>
        </div>

        <h1 style="margin-bottom:0;">CONTRATO PRIVADO DE PROMESA DE COMPRAVENTA CON ARRAS</h1>
        <hr style="margin:10px 0 20px 0;">

        <?php if (!empty($contracts)): ?>
        <?php $c = $contracts[0]; ?>
        <div style="white-space:pre-line; font-size:1em; line-height:1.7;">
            Conste por el presente documento un CONTRATO PRIVADO DE PROMESA DE COMPRAVENTA DE INMUEBLE CON ARRAS que
            celebran:

            a) De una parte, los señores; Empresa Inmobiliaria GRUPO VIVENCIA S.A.C con RUC: 20612232998, con domicilio
            común en Urb. Manuel Prado, Jr. Ollantaytambo D-27-B, representado por su GERENTE GENERAL el señor: LUIS
            GREET HUAMAN MADRID, identificado con DNI N.º 43879196, de estado civil SOLTERO con domicilio dpto. 101 urb.
            Santa Beatriz E-9, distrito Wanchaq, provincia Cusco y departamento de Cusco; a quienes para efectos de este
            documento se les denominarán como EL VENDEDOR y;

            <b>b)</b> De otra parte, <?= esc($c['customer_name'] ?? '________________') ?> identificado con DNI N.º
            <?= esc($c['dni'] ?? '__________') ?>, de estado civil <?= esc($c['civil_status'] ?? '__________') ?>, con
            domicilio común en el inmueble ubicado en <?= esc($c['address'] ?? '_________________________') ?>, distrito
            <?= esc($c['district'] ?? '__________') ?>, provincia <?= esc($c['province'] ?? '__________') ?> y
            departamento <?= esc($c['department'] ?? '__________') ?>; a quien para efectos de este documento se les
            denominará como EL COMPRADOR.

            Cualquier referencia a cláusulas en general se entenderá hecha a las cláusulas contenidas en el presente
            contrato. Este contrato se celebra en los términos y condiciones siguientes:

            PRIMERA: ANTECEDENTES. - LOS VENDEDORES son propietarios del inmueble siguiente:

            PREDIO RUSTICO DENOMINADO HUAYPO GRANDE PARCELA <?= esc($c['parcel'] ?? '_____') ?> IDENTIFICADO CON UNIDAD
            CATASTRAL NRO. <?= esc($c['cadastral_unit'] ?? '_____') ?>, UBICADO EN EL SECTOR SAN JUAN BAUTISTA/VALLE
            HUAYPO DEL DISTRITO DE CHINCHERO, PROVINCIA DE URUBAMBA, DEPARTAMENTO DE CUSCO, CON UN ÁREA DE
            <?= esc($c['area'] ?? '__________') ?> HAS., QUE SE ENCUENTRA INSCRITO EN LA PARTIDA ELECTRÓNICA N.º
            <?= esc($c['registry_number'] ?? '__________') ?> DEL REGISTRO DE PREDIOS DE LA OFICINA REGISTRAL DEL CUSCO,
            DONDE CORREN INSCRITOS EL DOMINIO, ÁREAS, LOS LINDEROS, MEDIDAS PERIMÉTRICAS Y DEMÁS CARACTERÍSTICAS DEL
            INMUEBLE SEÑALADO.

            SEGUNDA: DEL OBJETO DEL CONTRATO. Mediante el presente contrato, LOS VENDEDORES se comprometen a transferir
            a título gratuito y en propiedad el área <?= esc($c['transfer_area'] ?? '_____') ?> M2 respecto al área
            matriz correspondiente de la Mz. <?= esc($c['block'] ?? '_____') ?> Lt.
            <?= esc($c['lot_number'] ?? '_____') ?> del inmueble descrito en la Cláusula Primera del presente
            instrumento a favor del COMPRADOR, mediante un Contrato Definitivo de Compraventa con título de propiedad
            independizados inscrito en la SUNARP que celebrarán con estos últimos dentro del plazo establecido en la
            Cláusula Cuarta. Por su parte, EL COMPRADOR se obliga a pagar a LOS VENDEDORES el precio pactado en la
            Cláusula Tercera, en la forma y oportunidad convenidas para la celebración del Contrato Definitivo de
            Compraventa con título de propiedad independizado.

            El título de propiedad independizado se entregará una vez que esté listo de los 126 lotes, tendrá un costo
            adicional por lote en un promedio de S/. 1,500.00 a 2,500.00 soles dependiendo al tamaño de cada lote. Este
            pago lo realizara EL COMPRADOR en el momento de la transferencia con la independización de cada lote.

            TERCERA: DEL PRECIO Y LA FORMA DE PAGO. - Las partes estipulan que el precio total de venta del predio
            descrito en la cláusula segunda ascenderá a la suma de US$. <?= esc($c['price_usd'] ?? '__________') ?>
            (<?= esc($c['price_usd_text'] ?? '__________________________') ?> CON 00/100 DOLARES AMERICANOS) o al tipo
            de cambio en soles a la fecha del acuerdo en 3.75. El precio en soles es de S/.
            <?= esc($c['price_pen'] ?? '__________') ?>
            (<?= esc($c['price_pen_text'] ?? '__________________________') ?> con 00/100 soles). El pago está sujeta en
            la tercera modalidad financiado por la inmobiliaria GRUPO VIVENCIA S.A.C por
            <?= esc($c['financing_months'] ?? '__________') ?>
            (<?= esc($c['financing_months_text'] ?? '________________') ?> meses) con
            <?= esc($c['interest_rate'] ?? '__________') ?> intereses.

            Este importe deberá ser cancelado por EL COMPRADOR dentro del plazo establecido en la Cláusula Cuarta de
            este Contrato.

            CUARTA: DEL PLAZO. - Los intervinientes convienen en establecer como plazo límite para la conclusión del
            Contrato Definitivo de Compraventa con título de propiedad independizado inscrito en la SUNARP a ser
            celebrado sobre los <?= esc($c['transfer_area'] ?? '__________') ?> M2 correspondiente del área matriz Mz.
            <?= esc($c['block'] ?? '__________') ?> Lt. <?= esc($c['lot_number'] ?? '__________') ?> descrito en la
            Cláusula Segunda, el día <?= esc($c['limit_day'] ?? '_____') ?> DE
            <?= esc($c['limit_month'] ?? '__________') ?> DEL <?= esc($c['limit_year'] ?? '__________') ?>, contado a
            partir del día siguiente a la suscripción del presente instrumento, plazo dentro del cual EL COMPRADOR
            deberá pagar aportando mensualmente durante veinte y cuatro meses, el monto de pago mensual es de S/.
            <?= esc($c['monthly_payment'] ?? '__________') ?>
            (<?= esc($c['monthly_payment_text'] ?? '__________________________') ?> con 20/100 soles). Este pago inicia
            el <?= esc($c['start_day'] ?? '_____') ?> de <?= esc($c['start_month'] ?? '__________') ?> del
            <?= esc($c['start_year'] ?? '__________') ?> y concluye su último pago el
            <?= esc($c['end_day'] ?? '_____') ?> de <?= esc($c['end_month'] ?? '__________') ?> del
            <?= esc($c['end_year'] ?? '__________') ?>. La fecha de pago será el
            <?= esc($c['payment_day'] ?? '_____') ?> de cada mes.

            El pago de la propiedad está sujeta a la tercera modalidad que vendría a ser a financiado por la
            inmobiliaria GRUPO VIVENCIA S.AC por <?= esc($c['financing_months'] ?? '__________') ?>
            (<?= esc($c['financing_months_text'] ?? '__________') ?> meses) con interés de
            <?= esc($c['interest_rate'] ?? '__________') ?> valor total del predio. En caso de que EL COMPRADOR no
            cumplan con cancelar el íntegro del precio de venta del predio en el plazo precedentemente establecido, se
            aplicará la condición resolutoria expresa materia de la cláusula séptima.

            QUINTA: DE LAS ARRAS. - Las partes dejan constancia de que, a la fecha de suscripción del presente
            instrumento, EL COMPRADOR entrega a LOS VENDEDORES la cantidad de S/.
            <?= esc($c['arras_amount'] ?? '__________') ?>
            (<?= esc($c['arras_amount_text'] ?? '__________________________') ?> CON 00/100 SOLES) en calidad de arras
            confirmatorias, como señal de adelanto de este contrato, de conformidad con el artículo 1477° del Código
            Civil. Dicha cantidad es entregada mediante uno o más abonos (depósito/s o transferencia/s y/o efectivo,
            entregados en las oficinas de GRUPO VIVENCIA), y se le entrego un recibo como comprobante de haber recibido
            el dinero por parte de la inmobiliaria. Siendo constancia suficiente de la entrega y recepción de dicho
            importe, para efectos de este contrato, la firma de ambas partes al final del presente instrumento,
            titularidad de cuenta que tienen pleno conocimiento, aceptan y consienten LOS VENDEDORES.

            El monto total de las arras antes señaladas y entregado por EL COMPRADOR será imputado por LOS VENDEDORES
            como pago a cuenta del precio de venta establecido en la Cláusula Tercera en dólares, aplicándose la
            equivalencia en dólares señalada en el párrafo precedente de la presente cláusula y siempre y cuando EL
            COMPRADOR cumpla con cancelar el precio de venta del predio dentro del plazo estipulado al efecto (EL
            <?= esc($c['limit_day'] ?? '_____') ?> DE <?= esc($c['limit_month'] ?? '__________') ?> DEL
            <?= esc($c['limit_year'] ?? '__________') ?>).

            En caso de que se produzca la referida imputación, el saldo del precio de venta será cancelado por EL
            COMPRADOR en dólares americanos, salvo que en el contrato de compraventa definitivo las partes establezcan
            pagarlo en Soles aplicando el tipo de cambio del día en que se celebre dicho contrato definitivo.

            SEXTA: DE LAS PENALIDADES.- Ambas partes establecen que si EL COMPRADOR no cumpliera con cancelar el precio
            de venta del predio dentro del plazo estipulado en la Cláusula Cuarta del presente instrumento, LOS
            VENDEDORES podrán dejar sin efecto este Contrato, aplicando la cláusula resolutoria materia de la cláusula
            séptima; en este supuesto, LOS VENDEDORES conservarán automáticamente la suma de S/ 10,000.00 (DIEZ MIL CON
            00/100 SOLES) del total entregado, en calidad de arras penales, según lo previsto por el artículo 1478° del
            Código Civil. El monto restante podrá ser devuelto a EL COMPRADOR una vez que LOS VENDEDORES transfieran
            (vendan) el predio a un tercero, y siempre y cuando EL COMPRADOR cumpla con devolver el predio a LOS
            VENDEDORES en el plazo y condiciones señalados en el párrafo siguiente de la presente cláusula.

            En caso de que el presente contrato preparatorio sea resuelto por LOS VENDEDORES en aplicación de la
            condición resolutoria expresa establecida en su cláusula séptima, EL COMPRADOR deberá devolver el predio
            materia de este contrato dentro de los 20 (veinte) días calendario siguiente a la recepción de la
            comunicación notarial a la que se refiere dicha cláusula (séptima). En el supuesto de no producirse esta
            devolución, LOS VENDEDORES conservarán el íntegro de las arras, en calidad de penalidad, sin que haya lugar
            a ningún tipo de reclamo o reconsideración sobre el particular de parte de EL COMPRADOR.

            EL COMPRADOR en caso de incumplimiento con las fechas de pago Programadas asumirá una penalización de S/
            20.00 soles por mes, Dicha penalización se aplicará solo por 03 (tres meses) consecutivos. De seguir con la
            mora el cuarto mes se penalizará con S/. 10,000.00 soles (DIEZ MIL 00/100 SOLES) que dio el COMPRADOR.

            SÉPTIMA: CONDICIÓN RESOLUTORIA EXPRESA. - En caso de que EL COMPRADOR no cumpla con cancelar el precio total
            faltante del predio en los próximos <?= esc($c['financing_months'] ?? '__________') ?> meses pactados en la
            cláusula cuarta, y LOS VENDEDORES realicen algún acto jurídico de disposición del inmueble, o por causas
            atribuibles a LOS VENDEDORES el inmueble sea grabado con un embargo judicial, o se desistan de la venta de
            los inmuebles. Ambas partes podrán resolver de pleno derecho y en todos sus extremos el presente contrato,
            dejando sin ningún efecto este documento, en el caso de LOS VENDEDORES retornarán de manera automática sus
            derechos absolutos de propiedad sobre los <?= esc($c['transfer_area'] ?? '__________') ?> M2 de la Mz.
            <?= esc($c['block'] ?? '__________') ?> Lt. <?= esc($c['lot_number'] ?? '__________') ?> descritos en la
            cláusula segunda, y la devolución de las arras confirmatorias descrita en la cláusula quinta a EL COMPRADOR,
            para lo cual bastará que ambas partes se remitan una comunicación notarial dirigida en los domicilios
            señalados en este documento. Las partes han manifestado su intención de hacer valer la presente cláusula
            resolutoria; una vez que dicha comunicación notarial sea entregada notarialmente, de acuerdo a las normas de
            la materia, el presente contrato quedará automáticamente resuelto de pleno derecho y sin ningún efecto
            vinculante. Las partes declaran que esta cláusula tiene la naturaleza de condición resolutoria expresa del
            Contrato Preparatorio de Compraventa contenido en el presente documento, conforme a lo previsto por el
            artículo 1430° del Código Civil.

            OCTAVA: DE LAS OBLIGACIONES DE LOS VENDEDORES.- LOS VENDEDORES se obligan a través del presente instrumento
            a entregar el predio materia de este contrato preparatorio de compraventa, así como a suscribir todos los
            documentos e instrumentos necesarios para formalizar el contrato definitivo de compraventa y la
            transferencia de la propiedad de dichos bienes a favor de EL COMPRADOR, una vez que éste haya cumplido con
            cancelar la totalidad del precio de venta dentro del plazo determinado en la Cláusula Cuarta (23 días
            contados desde el día siguiente de la fecha de suscripción de este contrato).

            Asimismo, LOS VENDEDORES están obligados a no realizar ningún acto de disposición sobre los inmuebles, como
            pueden ser, contratos de: préstamo con garantía hipotecaria, ampliación de préstamo con garantía
            hipotecaria, contratos anticréticos, u otro de cualquier índole donde se graven los inmuebles. Y en caso que
            LOS VENDEDORES tengan algún conflicto con terceros que produzcan el embargo judicial de los inmuebles, estos
            se obligan a resolver y/o cancelar las deudas pendientes de pago hasta el levantamiento de todos los
            embargos que se hayan generado, sólo así se podrá suscribir el contrato definitivo de compraventa en
            adjudicación.

            NOVENA: DE LAS OBLIGACIONES DE EL COMPRADOR. - EL COMPRADOR se obliga a través del presente instrumento a
            pagar el precio convenido en el plazo pactado en la Cláusula Cuarta del presente documento, así como a
            recibir el bien inmueble, declarando conocer el perfecto estado de conservación de los mismos. Asimismo, las
            partes se obligan a respetar las estipulaciones referidas a las arras penales y contenidas en la cláusula
            sexta, renunciando desde ya a cualquier reclamo, acción o pretensión, judicial o extrajudicial, que pudieran
            formular sobre el particular.

            DÉCIMA: DE LA EQUIDAD. - Ambas partes contratantes declaran que el precio señalado en la cláusula tercera es
            el real y el que justamente corresponde a los bienes materia de este contrato preparatorio, y el que en
            consecuencia figurará en el contrato definitivo de compraventa con título de propiedad independizado
            inscrito en la SUNARP.

            DÉCIMO PRIMERA. - DEL SOMETIMIENTO DE COMPETENCIA. - Ante el improbable caso que surgiera algún conflicto o
            controversia respecto del presente Contrato, las partes se someten a la competencia de los Jueces y Salas de
            la ciudad del Cusco, renunciando así al fuero de sus domicilios de ser el caso. Igualmente, ambas partes
            señalan como sus domicilios los que figuran en la introducción de este documento; cualquier cambio o
            modificación deberá ser hecha por vía notarial, y surtirá efectos a los 15 días de recibida la respectiva
            comunicación en la que se informe del cambio de domicilio, de ser el caso.

            DECIMA SEGUNDA: CONSTRUCCION DE OBRAS. - La empresa inmobiliaria Grupo VIVENCIA S.A.C. se compromete a
            desarrollar obras dentro del proyecto Condominio Monte Verde en beneficio de todos los propietarios del
            Condominio.

            Obligaciones del Vendedor: El Vendedor se compromete a desarrollar las siguientes obras dentro del proyecto:
            - Pórtico de ingreso. - Cerco perimétrico vivo. - Área verde. – Conexión de agua para cada lote. –
            Instalación de postes y cableado en todas las calles del proyecto. – Instalación de tubería de desagüe en
            todas las calles. – Instalación de juegos infantiles. – Instalación de máquinas de GYM. – Construcción de
            parrillas. – Construcción de zona de fogatas. – Construcción de mirador. – Construcción de cancha deportiva.
            – Construcción de veredas en todas las esquinas. – Mejoramiento de vías.
            Obligaciones del Comprador: El Comprador adquiere el Lt. <?= esc($c['lot_number'] ?? '_____') ?> Mz
            <?= esc($c['block'] ?? '_____') ?>; el lote es de <?= esc($c['transfer_area'] ?? '_____') ?> M2. dentro del
            proyecto "CONDOMINIO MONTE VERDE". El comprador realizara el pago de su terreno en la modalidad de
            financiamiento.
            Plazos de Entrega: El Vendedor deberá completar y entregar las obras antes mencionadas antes del 30 de abril
            del 2026.
            Avance de Obra: El avance de obras será a medida que los propietarios del condominio lo van pagando sus
            cuotas mensuales sin retrasos o amortizando en el 2025. En caso de retraso de varios propietarios con los
            pagos mensuales, también perjudicara con el avance y podría ampliarse el tiempo de entrega de las obras.
            Modificaciones: Cualquier modificación al presente contrato deberá ser acordada por ambas partes y
            formalizada por escrito.

            DISPOSICIÓN FINAL. - Las partes declaran que en la celebración del presente Contrato no ha mediado dolo,
            coacción, error, violencia, dinero no entregado o cualquier otro vicio que enerve su validez, por lo que
            renuncian a cualquier acción o pretensión judicial o extrajudicial que tenga como objeto dejarlo sin efecto,
            firmando el presente documento en señal de conformidad.

            Cusco, <?= date('d') ?> de <?= date('F') ?> del <?= date('Y') ?>


            LOS VENDEDORES: LUIS GREET HUAMAN MADRID.

            EL COMPRADOR: <?= esc($c['customer_name'] ?? '________________') ?>
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