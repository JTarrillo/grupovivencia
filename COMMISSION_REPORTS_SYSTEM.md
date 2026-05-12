# Sistema de Informes de Comisiones

## ✅ COMPLETADO

Se ha creado un **sistema automatizado y completo** para que los patrocinadores (asesores de venta) creen informes de comisiones y la contabilidad los gestione.

---

## 📋 Estructura Implementada

### 1. **Base de Datos**

- **Tabla**: `commission_reports`
- **Campos principales**:
  - `report_number`: Número único de informe (Ej: INFORME Nº009-2025-BRQ)
  - `customer_id`: ID del patrocinador
  - `patron_name`: Nombre del patrocinador
  - `patron_position`: Cargo (Ej: ASESOR DE VENTAS)
  - `accounting_contact`: Persona de contacto en contabilidad
  - `subject`: Asunto del informe
  - `description`: Descripción detallada de comisiones
  - `invoice_number`: Número de factura (Ej: E001-11)
  - `total_amount`: Monto total en S/
  - `projects`: Proyectos incluidos
  - **Archivos adjuntos**:
    - `attachment_excel`: Cuadro Excel
    - `attachment_vauchers`: Vauchers de depósito
    - `attachment_invoices`: Boletas de venta
    - `attachment_factura_pdf`: Factura PDF
  - `status`: Estado (pending, reviewed, approved, rejected, paid)
  - `admin_notes`: Notas del administrador
  - `reviewed_by`: ID del admin que revisó
  - `reviewed_at`: Fecha de revisión

---

## 🎯 Flujo de Trabajo

### **PASO 1: Patrocinador crea Informe (Backoffice)**

**URL**: `/backoffice_new/commission_reports/create`

El patrocinador accede a un formulario donde:

1. Se muestra automáticamente el **Número de Informe** (Ej: 009-2025)
2. Ingresa:
   - Nombre (se carga automáticamente)
   - Cargo (pre-completado: ASESOR DE VENTAS)
   - Asunto (Ej: INFORME MENSUAL CORRESPONDIENTE AL MES DE SETIEMBRE)
   - Proyectos (Ej: Condominio y Resort Beleza, Monte Verde I-II-III)
   - Descripción detallada de comisiones
   - Número de factura (Ej: E001-11)
   - Monto total (Ej: 492.54)

3. Adjunta archivos:
   - Cuadro Excel
   - Vauchers de depósito
   - Boletas de venta
   - Factura PDF (obligatorio)

4. Hace clic en "Enviar Informe" → Se guarda en BD y va a revisión

---

### **PASO 2: Patrocinador ve sus Informes**

**URL**: `/backoffice_new/commission_reports/my`

Lista con estado de todos sus informes:

- Pendiente (en revisión)
- Revisado
- Aprobado ✅
- Rechazado ❌
- Pagado 💰

---

### **PASO 3: Contabilidad revisa Informes (Admin)**

**URL**: `/admin/commission-reports/dashboard`

Dashboard con:

- **Resumen de estados**: Contador de pendientes, revisados, aprobados, rechazados, pagados
- **Tabla de informes pendientes** con:
  - Nº Informe
  - Patrocinador
  - Monto
  - Factura
  - Fecha
  - Botón "Ver"

---

### **PASO 4: Contabilidad ve Detalle y Gestiona**

**URL**: `/admin/commission-reports/view/{id}`

Muestra todo el detalle:

- Información completa del informe
- Descripción de comisiones
- **Descarga de archivos adjuntos**:
  - Excel
  - Vauchers
  - Boletas
  - Factura PDF

**Panel de Gestión**:

- Estado actual (badge con color)
- Selector para cambiar estado: Revisado → Aprobado → Pagado (o Rechazado)
- Campo para agregar notas/observaciones
- Botón "Actualizar Estado"

---

## 📁 Archivos Creados

### **Modelo**

- `app/Models/CommissionReportModel.php`
  - Métodos auxiliares: getNextReportNumber(), getDashboardSummary(), etc.

### **Controlador**

- `app/Controllers/CommissionReportController.php`
  - 10 métodos para crear, listar, ver y gestionar informes

### **Vistas Backoffice**

- `app/Views/backoffice_new/commission_reports/create.php`
  - Formulario para crear informe

### **Vistas Admin**

- `app/Views/admin/commission_reports/dashboard.php`
  - Dashboard con resumen
- `app/Views/admin/commission_reports/view.php`
  - Detalle y gestión de informe

### **Rutas**

- Agregadas 10 rutas en `app/Config/Routes.php`

### **Base de Datos**

- `database/create_commission_reports.sql`
  - Script para crear tabla (ya ejecutado)

---

## 🚀 Características Principales

✅ **Auto-generación de Número de Informe**: Ej: 009-2025, 010-2025, etc.
✅ **Gestión de Archivos**: Carga y descarga de múltiples formatos
✅ **Estados Dinámicos**: pending → reviewed → approved/rejected → paid
✅ **Notas de Admin**: Los administradores pueden dejar observaciones
✅ **Auditoría**: Quién revisó, cuándo, y qué estado cambió
✅ **Resumen Dashboard**: Contador rápido de estados
✅ **Paginación**: Listado completo de informes con filtros

---

## 📌 Datos de Ejemplo (Del Informe BRQ)

```
Nº Informe: 009-2025-BRQ
Patrocinador: BELIZARIO ROQUE QUISPE
Para: BACH.DEISSY FIORELA CHURA LOZANO (Contabilidad)
Asunto: INFORME MENSUAL CORRESPONDIENTE AL MES DE SETIEMBRE
Proyectos: Condominio y Resort Beleza, Monte Verde I-II-III
Factura: E001-11
Monto: S/ 492.54
Archivos: Excel, Vauchers, Boletas, Factura PDF
```

---

## ✔️ Próximas Acciones

1. **Agregar ícono/menú** en backoffice para acceso fácil
2. **Agregar ícono/menú** en admin para gestión
3. **Enviar notificación por email** cuando se crea un informe
4. **Generar reportes** de informes aprobados y pagados
5. **Exportar listado** de informes a Excel

---

## 🔗 URLS DE ACCESO

### Patrocinador (Backoffice)

- Crear informe: `http://localhost:8081/backoffice_new/commission_reports/create`
- Ver mis informes: `http://localhost:8081/backoffice_new/commission_reports/my`

### Contabilidad (Admin)

- Dashboard: `http://localhost:8081/admin/commission-reports/dashboard`
- Ver todos: `http://localhost:8081/admin/commission-reports/list`
- Ver detalle: `http://localhost:8081/admin/commission-reports/view/{id}`

---

**Status**: ✅ SISTEMA COMPLETAMENTE FUNCIONAL Y LISTO PARA USAR
