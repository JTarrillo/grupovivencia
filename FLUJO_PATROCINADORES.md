# Flujo de Patrocinadores

## Idea principal

En este sistema un patrocinador no nace como un registro aparte.

Primero existe como **cliente** en la tabla `customers`.
Despues pasa a cumplir el rol de **patrocinador** cuando ese cliente es usado como `sponsor_id` en una relacion de la tabla `unilevels`.

En otras palabras:

- `customers` = quien es la persona
- `unilevels` = con quien esta relacionado dentro de la red

## Cuando un cliente pasa a ser patrocinador

Un cliente pasa a ser patrocinador cuando sucede alguna de estas acciones:

1. Se crea o edita un cliente y en el campo `Patrocinador` se elige a ese cliente como sponsor de otro cliente.
2. El sistema guarda la relacion en `unilevels`:
   - `customer_id` = cliente hijo
   - `sponsor_id` = cliente patrocinador

Desde ese momento, ese cliente ya esta actuando como patrocinador dentro de la red.

## Importante: no existe un campo "es patrocinador"

Actualmente no hay una columna tipo:

- `is_sponsor`
- `tipo = patrocinador`
- `estado_patrocinador`

El sistema interpreta que alguien es patrocinador por su uso en la red.

## Que significa activo o inactivo

El estado activo o inactivo pertenece al cliente en `customers`, no al rol de patrocinador.

### Cliente activo

Si `customers.active = '1'`, el cliente esta activo.

Con la logica actual:

- puede aparecer en el combo de patrocinadores
- puede ser elegido como patrocinador de otro cliente
- puede participar en el flujo normal de red y comisiones

### Cliente inactivo

Si `customers.active = '0'`, el cliente esta inactivo.

Con la logica actual:

- no deberia aparecer en el combo de patrocinadores
- no deberia usarse para nuevas asignaciones
- si ya tuvo relaciones antiguas en `unilevels`, esas relaciones pueden seguir existiendo en la BD, pero ya no deberia ser seleccionable para nuevas operaciones

## Entonces, cuando "se convierte" en patrocinador

La conversion real no ocurre por solo crear el cliente.

Se necesitan dos condiciones:

1. El cliente debe existir en `customers`
2. Debe quedar relacionado como `sponsor_id` de otro cliente en `unilevels`

Formula simple:

`patrocinador = cliente + relacion en unilevels`

## Ejemplo practico

Supongamos esto:

- Cliente A = Jose
- Cliente B = Maria

Si Maria se registra en el sistema y al guardarla se elige a Jose como patrocinador:

- `customers` sigue teniendo a Jose y Maria como clientes
- `unilevels` guarda una fila parecida a esta:

```text
customer_id = Maria
sponsor_id = Jose
```

Desde ese momento Jose ya esta actuando como patrocinador.

## Sobre el combo de patrocinadores

El combo de patrocinadores muestra clientes activos.

Por eso, para que alguien aparezca ahi, debe cumplir al menos esto:

- existir en `customers`
- estar activo (`active = '1'`)
- no estar eliminado logicamente (`deleted_at IS NULL`)

## Lo que se corrigio

Se detecto que el combo estaba vacio porque el filtro del modelo comparaba mal el campo `active`.

La columna `customers.active` es de tipo `ENUM('0','1')`, asi que la comparacion correcta es:

```php
where('active', '1')
```

No:

```php
where('active', 1)
```

## Resumen corto

- Crear cliente no lo convierte automaticamente en patrocinador
- Ser patrocinador no es un tipo de usuario aparte
- Un patrocinador es un cliente activo usado como `sponsor_id` en `unilevels`
- Activo/inactivo depende de `customers.active`
- Si esta inactivo, no deberia salir en el combo para nuevas asignaciones

