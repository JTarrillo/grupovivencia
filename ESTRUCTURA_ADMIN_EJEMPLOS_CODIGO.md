# Ejemplos de Código - Estructura Admin Grupo Vivencia

## 1. FLUJO DE AUTENTICACIÓN

### 1.1 Página de Login (Inicio)

```php
// app/Controllers/Login.php
public function index() {
    if (session()->has('isLoggedIn')) {
        return redirect()->to('/dashboard/panel');
    }
    return view('login_view');
}
```

### 1.2 Procesamiento de Login

```php
// app/Controllers/B_admin.php - Línea 100+

public function login_admin()
{
    $session = session();
    $request = \Config\Services::request();
    $email = $request->getPostGet('email');
    $password = $request->getPostGet('password');

    // 1. Busca el usuario en tabla `users`
    $user = new UsersModel();
    $res = $user->get_data_by_email($email);

    if ($res) {
        $pass = $res->password;
        // 2. Verifica contraseña con bcrypt
        $authenticatePassword = password_verify($password, $pass);

        if ($authenticatePassword) {
            // 3. Prepara datos de sesión
            $ses_data = [
                'id'           => $res->id,
                'name'         => $res->name,
                'lastname'     => $res->lastname,
                'email'        => $res->email,
                'dni'          => $res->dni,
                'privilage'    => $res->privilage ?? 'admin',
                'privilegio'   => $res->privilegio ?? ($res->privilage ?? 'admin'),
                'active'       => $res->active,
                'isLoggedIn'   => TRUE
            ];

            // 4. Guarda sesión
            $session->set($ses_data);

            // 5. Retorna respuesta JSON
            $data['status'] = true;
            $data['message'] = 'Bienvenido al sistema.';
            return json_encode($data);
        }
    }
}
```

### 1.3 Rutas Protegidas

```php
// app/Config/Routes.php

// Ruta de login (pública)
$routes->post('/dashboard/validate', 'B_admin::login_admin');

// Rutas del dashboard (protegidas con authGuard)
$routes->get('/dashboard/panel', 'D_panel::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/usuarios', 'D_usuarios::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/usuarios/load/(:num)', 'D_usuarios::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/usuarios/validate', 'D_usuarios::validacion', ['filter' => 'authGuard']);
```

### 1.4 Filtro de Autenticación

```php
// app/Filters/AuthGuard.php

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Si no está logueado, redirige a login
        if (!$session->has('isLoggedIn') || !$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acciones posteriores
    }
}
```

---

## 2. GESTIÓN DE USUARIOS - CONTROLLERS

### 2.1 Listar Usuarios

```php
// app/Controllers/D_usuarios.php

class D_usuarios extends BaseController
{
    public function index()
    {
        // Obtiene datos de la sesión
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $session_name = $_SESSION['name'] . " " . $_SESSION['last_name'];

        // Obtiene todos los usuarios de la tabla `users`
        $Users = new UsersModel();
        $obj_users = $Users->get_all();

        // Pasa datos a la vista
        $data = [
            'obj_users' => $obj_users,
            'session_name' => $session_name
        ];

        return view('admin/usuarios/list', $data);
    }
}
```

### 2.2 Cargar Formulario de Usuario

```php
// app/Controllers/D_usuarios.php

public function load($id = false)
{
    $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
    $obj_users = null;

    // Si se pasa un ID, carga los datos del usuario
    if ($id != false) {
        $Users = new UsersModel();
        $obj_users = $Users->get_all_by_id($id);
    }

    $data = [
        'obj_users' => $obj_users,
        'session_name' => $session_name
    ];

    return view('admin/usuarios/load', $data);
}
```

### 2.3 Validar y Guardar Usuario

```php
// app/Controllers/D_usuarios.php

public function validacion()
{
    if ($this->request->isAJAX()) {
        $Users = new UsersModel();

        // Obtiene datos del formulario
        $res = service('request')->getPost();
        $user_id = $res['user_id'];
        $email = $res['email'];
        $name = $res['name'];
        $lastname = $res['lastname'];
        $password = $res['password'];
        $privilage = $res['privilage'];

        // Prepara datos para guardar
        $data_insert = [
            'email' => $email,
            'name' => $name,
            'lastname' => $lastname,
            'privilage' => $privilage,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Si hay contraseña, la hashea
        if (!empty($password)) {
            $data_insert['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Actualiza o inserta
        if ($user_id) {
            $Users->update($user_id, $data_insert);
        } else {
            $data_insert['active'] = '1';
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $Users->insert($data_insert);
        }

        return json_encode([
            'status' => true,
            'message' => 'Usuario guardado correctamente'
        ]);
    }
}
```

---

## 3. GESTIÓN DE USUARIOS - MODELS

### 3.1 UsersModel

```php
// app/Models/UsersModel.php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    public $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id', 'name', 'lastname', 'phone', 'dni', 'avatar',
        'type', 'active', 'email', 'privilage', 'password',
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Obtém todos los usuarios
    public function get_all()
    {
        return $this->findAll();
    }

    // Obtén usuario por ID
    public function get_all_by_id($id)
    {
        return $this->find($id);
    }

    // Obtén usuario por email
    public function get_data_by_email($email)
    {
        return $this->where('email', $email)->first();
    }

    // Búsqueda avanzada
    public function get_search_row($data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data["select"]) && $data["select"] != "") {
            $builder->select($data["select"]);
        }
        if (isset($data["where"]) && $data["where"] != "") {
            $builder->where($data["where"]);
        }
        if (isset($data["order"]) && $data["order"] != "") {
            $builder->orderBy($data["order"]);
        }

        $query = $builder->get();
        return $query->getResult();
    }
}
```

---

## 4. GESTIÓN DE MENÚ Y PRIVILEGIOS

### 4.1 Header con Control de Privilegios

```php
// app/Views/admin/header.php (línea 540+)

<?php
$session = session();
$session_privilege = $session->get('privilegio');
$session_email = $session->get('email');

// Diferencia entre admin y cliente
if ($session_privilege === 'admin' ||
    $session_privilege === 'Administrador' ||
    $session_privilege === 'superadmin') {

    // Usuario es administrador
    $full_name = trim($session_name . ' ' . $session_lastname);
    $dni = $session_dni;

    echo "<script>console.log('ADMIN:', {name: '$full_name', privilage: '$session_privilege'});</script>";
} else {
    // Usuario es cliente - busca en tabla customers
    if ($session_email) {
        $CustomerModel = new \App\Models\CustomerModel();
        $customer = $CustomerModel->where('email', $session_email)->first();

        if ($customer) {
            $full_name = trim($customer['name'] . ' ' . $customer['lastname']);
            $dni = $customer['dni'] ?? '';
        }
    }
}
?>
```

### 4.2 Determinación de Menú Activo

```php
// app/Views/admin/header.php (línea 130+)

<?php
// Obtém la ruta actual
$url = explode("/", uri_string());
$nav = isset($url[1]) ? $url[1] : "";

// Variables iniciales para estilos
$usuarios_color = null;
$usuarios_style = null;
$mantenimientos_style = null;
// ... más variables

// Switch para resaltar el menú actual
switch ($nav) {
    case "usuarios":
        $mantenimientos_style = "active pcoded-trigger";
        $usuarios_color = "active_nav";  // Se resalta
        break;

    case "clientes":
        $mantenimientos_style = "active pcoded-trigger";
        $clientes_color = "active_nav";
        break;

    case "rangos":
        $mantenimientos_style = "active pcoded-trigger";
        $rangos_color = "active_nav";
        break;

    // ... más casos

    default:
        $panel_style = "active pcoded-trigger";
        $panel_color = "active_nav";
        break;
}
?>
```

### 4.3 Renderización del Menú

```php
// app/Views/admin/header.php (línea 650+)

<ul class="nav pcoded-inner-navbar">
    <!-- Usuarios -->
    <li class="nav-item <?php echo $mantenimientos_style; ?>">
        <a href="/dashboard/usuarios" class="nav-link <?php echo $usuarios_color; ?>">
            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
            <span class="pcoded-mtext">Usuarios</span>
        </a>
    </li>

    <!-- Clientes -->
    <li class="nav-item <?php echo $mantenimientos_style; ?>">
        <a href="/dashboard/clientes" class="nav-link <?php echo $clientes_color; ?>">
            <span class="pcoded-micon"><i class="fa fa-users"></i></span>
            <span class="pcoded-mtext">Clientes</span>
        </a>
    </li>

    <!-- Rangos -->
    <li class="nav-item <?php echo $mantenimientos_style; ?>">
        <a href="/dashboard/rangos" class="nav-link <?php echo $rangos_color; ?>">
            <span class="pcoded-micon"><i class="fa fa-bars"></i></span>
            <span class="pcoded-mtext">Rangos</span>
        </a>
    </li>

    <!-- ... más elementos del menú ... -->
</ul>
```

---

## 5. VISTAS - LISTADO DE USUARIOS

### 5.1 Vista Completa

```php
// app/Views/admin/usuarios/list.php

<!doctype html>
<html lang="es-PE">
    <?php echo view("admin/head"); ?>
    <body>
        <?php echo view("admin/header"); ?>

        <section class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <div class="pcoded-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de Usuarios</h5>
                                            <button class="btn btn-secondary"
                                                    onclick="new_user();">
                                                <i class="fa fa-plus"></i> Nuevo Usuario
                                            </button>
                                        </div>

                                        <div class="card-block">
                                            <table id="zero-configuration"
                                                   class="display table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>E-mail</th>
                                                        <th>Privilegio</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($obj_users as $value): ?>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $value->id; ?></b>
                                                        </td>
                                                        <td>
                                                            <h6><?php echo $value->name . " " . $value->lastname; ?></h6>
                                                        </td>
                                                        <td>
                                                            <h6><?php echo $value->email; ?></h6>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Convierte el número de privilage a etiqueta legible
                                                            switch ($value->privilage) {
                                                                case 1:
                                                                    echo "Control Básico";
                                                                    break;
                                                                case 2:
                                                                    echo "Control Medio";
                                                                    break;
                                                                case 3:
                                                                    echo "Control Total";
                                                                    break;
                                                                case 4:
                                                                    echo "Superadministrador";
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('d/m/Y', strtotime($value->created_at)); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value->active == 1 ? 'Activo' : 'Inactivo'; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-info"
                                                                    onclick="edit_users(<?php echo $value->id; ?>)">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger"
                                                                    onclick="eliminar(<?php echo $value->id; ?>)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="<?php echo base_url('assets/admin/js/script/users.js'); ?>"></script>
        <?php echo view("admin/footer"); ?>
    </body>
</html>
```

---

## 6. VISTAS - FORMULARIO DE USUARIO

### 6.1 Formulario Crear/Editar

```php
// app/Views/admin/usuarios/load.php (parcial)

<form name="form-user" id="form-user"
      enctype="multipart/form-data" method="post"
      action="javascript:void(0);" onsubmit="validate();">

    <div class="form-row">
        <?php if(isset($obj_users)): ?>
        <div class="form-group col-md-12">
            <label>ID</label>
            <input class="form-control" type="text"
                   value="<?php echo $obj_users->id; ?>"
                   disabled>
            <input type="hidden" name="user_id"
                   value="<?php echo $obj_users->id; ?>">
        </div>
        <?php endif; ?>

        <div class="form-group col-md-6">
            <label>E-mail</label>
            <input class="form-control" type="email" id="email"
                   name="email"
                   value="<?php echo isset($obj_users)?$obj_users->email:""; ?>"
                   required>
        </div>

        <div class="form-group col-md-6">
            <label>Nombres</label>
            <input class="form-control" type="text" id="name"
                   name="name"
                   value="<?php echo isset($obj_users)?$obj_users->name:""; ?>"
                   required>
        </div>

        <div class="form-group col-md-6">
            <label>Apellidos</label>
            <input class="form-control" type="text" id="lastname"
                   name="lastname"
                   value="<?php echo isset($obj_users)?$obj_users->lastname:""; ?>"
                   required>
        </div>

        <div class="form-group col-md-6">
            <label>Contraseña</label>
            <div class="input-group">
                <input class="form-control" type="password" id="password"
                       name="password" placeholder="Password" minlength="8">
                <span class="input-group-text" onclick="show_pass();">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label>Privilegios</label>
            <select class="form-control" name="privilage" id="privilage" required>
                <option value="">Seleccionar Privilegio</option>
                <option value="1" <?php echo isset($obj_users) && $obj_users->privilage == 1 ? 'selected' : ''; ?>>
                    Control Básico
                </option>
                <option value="2" <?php echo isset($obj_users) && $obj_users->privilage == 2 ? 'selected' : ''; ?>>
                    Control Medio
                </option>
                <option value="3" <?php echo isset($obj_users) && $obj_users->privilage == 3 ? 'selected' : ''; ?>>
                    Control Total
                </option>
                <option value="4" <?php echo isset($obj_users) && $obj_users->privilage == 4 ? 'selected' : ''; ?>>
                    Superadministrador
                </option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <button type="submit" id="submit" class="btn btn-primary">
                Guardar
            </button>
            <button type="button" class="btn btn-secondary"
                    onclick="cancelar_users();">
                Cancelar
            </button>
        </div>
    </div>
</form>
```

---

## 7. JAVASCRIPT - MANEJO FRONTEND

### 7.1 Funciones AJAX de Usuarios

```javascript
// public/assets/admin/js/script/users.js

// Editar usuario existente
function edit_users(user_id) {
  var url = "dashboard/usuarios/load/" + user_id;
  location.href = site + url;
}

// Crear nuevo usuario
function new_user() {
  var url = "dashboard/usuarios/load";
  location.href = site + url;
}

// Cancelar edición
function cancelar_users() {
  var url = "dashboard/usuarios";
  location.href = site + url;
}

// Validar y guardar usuario
function validate() {
  document.getElementById("submit").disabled = true;
  document.getElementById("submit").innerHTML =
    "<span class='spinner-border spinner-border-sm'></span> Procesando...";

  var oData = new FormData(document.forms.namedItem("form-user"));

  $.ajax({
    url: site + "dashboard/usuarios/validate",
    method: "POST",
    data: oData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      var response = JSON.parse(data);

      if (response.status == true) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: response.message,
          showConfirmButton: false,
        });

        // Redirecciona al listado después de 1.5 segundos
        window.setTimeout(function () {
          window.location = site + "dashboard/usuarios";
        }, 1500);
      } else {
        Swal.fire({
          position: "top-end",
          icon: "info",
          title: response.message,
        });

        document.getElementById("submit").disabled = false;
        document.getElementById("submit").innerHTML = "Guardar";
      }
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error al procesar la solicitud",
      });

      document.getElementById("submit").disabled = false;
      document.getElementById("submit").innerHTML = "Guardar";
    },
  });
}

// Eliminar usuario
function eliminar(user_id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "Esta acción no se puede deshacer",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: site + "dashboard/usuarios/delete/" + user_id,
        method: "POST",
        success: function (data) {
          Swal.fire("Eliminado", "Usuario eliminado correctamente", "success");
          window.location.reload();
        },
      });
    }
  });
}

// Mostrar/ocultar contraseña
function show_pass() {
  var password = document.getElementById("password");
  if (password.type === "password") {
    password.type = "text";
  } else {
    password.type = "password";
  }
}
```

---

## 8. RESUMEN DE FLUJOS

### Flujo de Creación de Usuario

```
1. Click en "Nuevo Usuario"
   ↓
2. new_user() → redirecciona a /dashboard/usuarios/load
   ↓
3. D_usuarios::load() → carga vista vacía
   ↓
4. Usuario completa formulario
   ↓
5. Form.onsubmit → validate()
   ↓
6. validate() → AJAX POST /dashboard/usuarios/validate
   ↓
7. D_usuarios::validacion()
   ↓
8. Crea registro en tabla `users`
   ↓
9. Retorna JSON {status: true, message: "..."}
   ↓
10. JavaScript redirige a /dashboard/usuarios
    ↓
11. Se actualiza el listado con el nuevo usuario
```

### Flujo de Edición de Usuario

```
1. Click en botón "Editar" en row
   ↓
2. edit_users(id) → redirecciona a /dashboard/usuarios/load/{id}
   ↓
3. D_usuarios::load($id)
   ↓
4. Busca usuario en tabla `users` por ID
   ↓
5. Carga vista con datos precargados
   ↓
6. Usuario modifica datos (puede cambiar contraseña)
   ↓
7. Form.onsubmit → validate()
   ↓
8. validate() → AJAX POST /dashboard/usuarios/validate
   ↓
9. D_usuarios::validacion()
   ↓
10. UPDATE en tabla `users`
    ↓
11. Retorna JSON {status: true}
    ↓
12. Redirige a /dashboard/usuarios
    ↓
13. Listado se actualiza
```
