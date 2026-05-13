# Validación: Cuota Inicial vs Precio del Lote

## Contexto

Al crear un contrato (`contracts.php`) ya existe la validación correcta:

> ❌ Error: La cuota inicial (S/ X) no puede ser mayor que el precio del lote (S/ Y)

Esta validación funciona bien porque en ese punto ya se conoce el lote específico con su precio calculado.

---

## Intento anterior (revertido)

Se intentó agregar esta misma validación en los modales de **Nuevo Proyecto** y **Editar Proyecto** (`projects.php`), comparando el "Monto Mínimo (S/)" ingresado contra un precio estimado de lote de 100m².

**Por qué se eliminó:** al crear/editar un proyecto aún no se conoce el área de los lotes, por lo que cualquier comparación es una estimación arbitraria y puede bloquear configuraciones válidas.

---

## Mejora futura sugerida

### Idea

Cuando el usuario configure el **Monto Mínimo (S/)** en el proyecto, calcular automáticamente el precio mínimo del lote usando los datos reales de los lotes ya creados en ese proyecto:

```
Precio del lote = Precio Base por m²  ×  Área (m²)
```

Si existe al menos un lote en el proyecto, se puede comparar:

```
min_down_payment_fixed  <  MIN( precio_base_m2 × area_m2 )  para todos los lotes del proyecto
```

### Dónde implementar

- **Frontend (`projects.php`):** al abrir el modal de editar proyecto (cuando ya tiene lotes), hacer un fetch a un endpoint que devuelva el precio mínimo de lote del proyecto.
- **Endpoint sugerido:** `GET /dashboard/inmueble/api/get_min_lot_price/{project_id}` → devuelve `{ min_price: 15999.00, lot_count: 12 }`.
- Mostrar el error inline solo si `lot_count > 0`.

### Lógica de validación

```javascript
// Solo validar si el proyecto ya tiene lotes
if (lotCount > 0 && minDp > 0 && minDp >= minLotPrice) {
  // Mostrar error: la cuota mínima supera el precio del lote más barato
}
```

### Consideraciones

- Si el proyecto aún no tiene lotes: **no validar**, dejar pasar (el error se captura al crear el contrato).
- Si se cambia el precio base por m²: re-consultar el precio mínimo de lote.
- La validación en `contracts.php` debe **mantenerse siempre** como barrera definitiva.

---

## Estado actual

| Lugar                              | Validación                            | Estado                                   |
| ---------------------------------- | ------------------------------------- | ---------------------------------------- |
| `contracts.php`                    | Cuota inicial vs precio real del lote | ✅ Activa                                |
| `projects.php` (crear/editar)      | Cuota mínima vs precio estimado       | ❌ Eliminada (no hay datos de lotes aún) |
| `projects.php` (editar, con lotes) | Cuota mínima vs precio mínimo real    | 🔲 Pendiente de implementar              |
