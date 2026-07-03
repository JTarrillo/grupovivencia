# Debug Session: menu-clicks

- **Status**: [OPEN]
- **Issue**: Los accesos de `Clientes & Proveedores`, `Ventas & Compras` y `Comisiones` no muestran nada al hacer clic despues del merge de `devPaolo`.
- **Debug Server**: Pending
- **Log File**: `.dbg/trae-debug-log-menu-clicks.ndjson`

## Reproduction Steps

1. Abrir el admin en `http://localhost:8081/`.
2. Ir al sidebar.
3. Hacer clic en `Clientes & Proveedores`, `Ventas & Compras` y `Comisiones`.
4. Verificar si abre submenu, navega o no pasa nada.

## Hypotheses & Verification

| ID  | Hypothesis                                                                           | Likelihood | Effort | Evidence |
| --- | ------------------------------------------------------------------------------------ | ---------- | ------ | -------- |
| A   | El click es interceptado por JS global del menu y no navega ni abre submenu.         | High       | Low    | Pending  |
| B   | Los enlaces del header/sidebar quedaron apuntando a rutas incorrectas tras el merge. | High       | Low    | Pending  |
| C   | Un error JS temprano en `header` o `footer` aborta la ejecucion del menu.            | High       | Low    | Pending  |
| D   | El merge modifico `Routes.php` y alguna ruta del menu ya no responde como antes.     | Med        | Low    | Pending  |
| E   | El HTML del submenu no coincide con lo que espera el script `pcoded`.                | Med        | Low    | Pending  |

## Log Evidence

- `Escaneo inicial del sidebar`: se detectan exactamente `3` items con submenu: `Clientes & Proveedores`, `Comisiones`, `Ventas & Compras`.
- `Click en item principal del menu`: los clics llegan correctamente al `<a href="#!">`, por lo que el evento no estaba perdido.
- `Resultado del toggle del submenu`: el submenu quedaba con `isOpenAfter: true` pero `maxHeight: "0px"` y `submenuHeight: 0`.
- Esto confirma que el problema no era la ruta ni el controlador, sino el render visual del submenu colapsado.
- Tambien aparece un error global de `PerfectScrollbar`, pero los logs muestran que el click del sidebar seguia entrando aun con ese error.

## Verification Conclusion

- **Confirmed**: `E` El HTML del submenu no quedo visible aunque el toggle JS si se ejecutaba.
- **Rejected**: `A` El click no estaba siendo bloqueado; si llegaba al manejador.
- **Rejected**: `B` y `D` No hay evidencia de rutas o controladores fallando en esta reproduccion.
- **Observed but secondary**: `C` Hay un error global de `PerfectScrollbar`, pero no explica por si solo que estos menus no abrieran.
- **Fix aplicado**: al abrir/cerrar submenu se sincroniza `display` con `maxHeight/opacidad` para que el contenido tenga altura real y sea clicable.
