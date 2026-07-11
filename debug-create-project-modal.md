# [OPEN] Debug Session: create-project-modal

## Síntoma
- En `/dashboard/inmueble/projects`, al hacer clic en "Nuevo Proyecto" aparece:
  - `Uncaught ReferenceError: showCreateProjectModal is not defined`

## Hipótesis
1. Hay un error de sintaxis antes de la definición de `showCreateProjectModal`.
2. `showCreateProjectModal` se define en un scope no global.
3. Existe una estructura HTML o `<script>` mal ubicada que impide ejecutar ese bloque.
4. Otro script previo falla y aborta la inicialización.
5. La vista renderizada en runtime no coincide con la que estamos editando.

## Estado
- Sesión abierta.
- Pendiente: instrumentación, reproducción, análisis, fix mínimo y verificación.
