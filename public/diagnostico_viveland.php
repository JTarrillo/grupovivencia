<?php
// Diagnóstico VIVELAND - Temporal para debugging

echo "<h1>Diagnóstico VIVELAND</h1>";
echo "<hr>";

// 1. Verificar conexión a BD
echo "<h2>1. Conexión a Base de Datos</h2>";
try {
    $db = \Config\Database::connect();
    echo "✅ Conexión exitosa<br>";
    echo "Base de datos: " . $db->getDatabase() . "<br>";
} catch (\Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    exit;
}

// 2. Verificar tabla viveland_registros
echo "<h2>2. Tabla viveland_registros</h2>";
try {
    $result = $db->query("SHOW TABLES LIKE 'viveland_registros'");
    $tables = $result->getResultArray();
    if (count($tables) > 0) {
        echo "✅ Tabla existe<br>";
        
        // Mostrar estructura
        $columns = $db->query("DESCRIBE viveland_registros")->getResultArray();
        echo "<pre>";
        foreach ($columns as $col) {
            echo $col['Field'] . " (" . $col['Type'] . ")" . ($col['Null'] === 'NO' ? " NOT NULL" : "") . "\n";
        }
        echo "</pre>";
    } else {
        echo "❌ Tabla NO existe<br>";
    }
} catch (\Exception $e) {
    echo "❌ Error verificando tabla: " . $e->getMessage() . "<br>";
}

// 3. Contar registros
echo "<h2>3. Registros en VIVELAND</h2>";
try {
    $count = $db->query("SELECT COUNT(*) as total FROM viveland_registros")->getRow();
    echo "✅ Total de registros: " . $count->total . "<br>";
} catch (\Exception $e) {
    echo "❌ Error contando: " . $e->getMessage() . "<br>";
}

// 4. Verificar modelo
echo "<h2>4. Modelo VivelandRegistroModel</h2>";
try {
    $model = new \App\Models\VivelandRegistroModel();
    echo "✅ Modelo cargado correctamente<br>";
    
    // Verificar métodos
    $methods = ['get_all', 'get_by_id', 'get_stats'];
    foreach ($methods as $method) {
        if (method_exists($model, $method)) {
            echo "✅ Método $method existe<br>";
        } else {
            echo "❌ Método $method NO existe<br>";
        }
    }
} catch (\Exception $e) {
    echo "❌ Error cargando modelo: " . $e->getMessage() . "<br>";
}

// 5. Verificar vista
echo "<h2>5. Vista admin/viveland_registros/list</h2>";
$viewPath = APPPATH . 'Views/admin/viveland_registros/list.php';
if (file_exists($viewPath)) {
    echo "✅ Vista exists: " . $viewPath . "<br>";
} else {
    echo "❌ Vista archivo NO existe: " . $viewPath . "<br>";
}

echo "<hr>";
echo "<p>✅ Diagnóstico completado</p>";
?>
