# Diagrama de Patrocinador, Cliente y Unilevel

## Idea base

En este sistema, **patrocinador no es una tabla separada**.

Un patrocinador es simplemente un **cliente (`customers`)** que:

- existe en la tabla `customers`
- esta `active = '1'`
- y puede quedar relacionado con otros clientes mediante la tabla `unilevels`

## Diagrama simple

```text
USUARIO DEL PANEL
    |
    | crea / administra
    v
CUSTOMERS
    |
    | puede estar activo o inactivo
    | puede ser agente interno o agente externo
    |
    +------------------------------+
    |                              |
    v                              v
CLIENTE INACTIVO               CLIENTE ACTIVO
active = '0'                   active = '1'
    |                              |
    | no debe salir como           | si puede salir como
    | patrocinador valido          | patrocinador valido
    |                              |
    +--------------+---------------+
                   |
                   v
             UNILEVELS
     relacion cliente -> patrocinador

unilevels.customer_id = cliente hijo
unilevels.sponsor_id  = cliente patrocinador
```

## Relacion real

```text
customers
---------
id = 20   -> cliente nuevo
id = 6    -> Fiorela

unilevels
---------
customer_id = 20
sponsor_id  = 6

Resultado:
El cliente 20 fue patrocinado por Fiorela.
Fiorela actua como sponsor/patrocinador.
```

## Que significa cada concepto

### 1. Cliente

Es todo registro de la tabla `customers`.

Puede tener:

- nombre
- dni
- email
- `active`
- `tipo_agente`

## 2. Cliente activo

Es un cliente con:

```text
customers.active = '1'
```

Ese cliente:

- si puede ser patrocinador valido
- si debe aparecer en los combos y modales de patrocinador
- si puede recibir relaciones en `unilevels`

## 3. Cliente inactivo

Es un cliente con:

```text
customers.active = '0'
```

Ese cliente:

- no debe salir como patrocinador seleccionable
- no debe considerarse patrocinador valido en el registro

## 4. Patrocinador / Sponsor

En este proyecto, **patrocinador** y **sponsor** significan lo mismo.

No se crea en una tabla aparte.

Se vuelve patrocinador cuando:

1. existe como cliente en `customers`
2. esta activo
3. es usado como `sponsor_id` o puede ser elegido como sponsor

## 5. Unilevel

`unilevels` es la tabla que guarda la red.

Campos clave:

- `customer_id`: cliente hijo
- `sponsor_id`: patrocinador del cliente
- `node`: cadena de jerarquia

Ejemplo:

```text
customer_id = 20
sponsor_id = 6
```

Eso significa:

```text
Cliente 20 pertenece a la red de Fiorela (id 6)
```

## 6. Agente interno / agente externo

Eso pertenece al cliente y normalmente vive en:

```text
customers.tipo_agente
```

Sirve para clasificar el tipo de agente, pero **no define por si solo** si es patrocinador.

O sea:

- un agente interno puede ser patrocinador si esta activo
- un agente externo puede ser patrocinador si esta activo
- lo importante para sponsor valido es que sea cliente activo

## Flujo correcto del sistema

```text
1. Se crea un cliente en customers
2. Ese cliente puede quedar activo o inactivo
3. Si esta activo, puede ser elegido como patrocinador
4. Cuando se registra otro cliente y se le asigna sponsor:
   - se guarda en customers
   - se crea la relacion en unilevels
5. Desde ese momento ya existe la relacion cliente -> sponsor
```

## Regla practica

```text
Cliente activo + relacion en red = sponsor funcionando
Cliente inactivo = no debe salir como sponsor
```

## Como leerlo mentalmente sin confundirse

```text
users/admin
    = usuarios del panel que administran

customers
    = personas/clientes/agentes de la red

sponsor/patrocinador
    = un customer activo que patrocina a otro

unilevels
    = la tabla que une al cliente con su patrocinador
```

## Ejemplo completo

```text
Fiorela
- esta en customers
- active = '1'
- tipo_agente = interno o externo

Entonces:
- puede salir en el modal de patrocinadores

Si Jose nuevo se registra con sponsor Fiorela:

customers
- se crea Jose

unilevels
- customer_id = Jose
- sponsor_id = Fiorela

Resultado:
- Jose es cliente patrocinado
- Fiorela es sponsor de Jose
```

## Resumen corto

```text
Patrocinador = customer activo
Cliente inactivo = no sponsor valido
Unilevel = relacion entre cliente y sponsor
Agente interno/externo = clasificacion del cliente, no una tabla aparte
```
