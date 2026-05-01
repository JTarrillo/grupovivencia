# Cómo Conectar a MySQL desde Terminal/PowerShell

**Fecha**: 1 de Mayo de 2026  
**XAMPP Version**: Con MariaDB 10.4.32  
**Database**: grupovivencia

---

## Problema Inicial

```
PS C:\xampp\htdocs\grupovivencia> mysql -u root -p grupovivencia
mysql : El término 'mysql' no se reconoce como nombre de un cmdlet...
```

**Causa**: El comando `mysql` no está en el PATH de Windows PowerShell.

---

## Solución: Usar la Ruta Completa de XAMPP

### Comando Completo
```powershell
C:\xampp\mysql\bin\mysql -u root -p grupovivencia
```

### Desglose del Comando
- `C:\xampp\mysql\bin\mysql` - Ruta completa al ejecutable de MySQL
- `-u root` - Usuario (root es el usuario por defecto)
- `-p` - Solicita contraseña (vacía por defecto en XAMPP)
- `grupovivencia` - Nombre de la base de datos a la que conectarse

### Ejecución Paso a Paso

**1. Abre PowerShell en la carpeta del proyecto:**
```powershell
cd C:\xampp\htdocs\grupovivencia
```

**2. Ejecuta el comando:**
```powershell
C:\xampp\mysql\bin\mysql -u root -p grupovivencia
```

**3. Cuando pida contraseña, presiona Enter (está vacía):**
```
Enter password: 
```

**4. Resultado exitoso:**
```
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 234
Server version: 10.4.32-MariaDB mariadb.org binary distribution

MariaDB [grupovivencia]> 
```

---

## Comandos SQL Útiles

Una vez conectado, puedes ejecutar:

### Ver todas las tablas
```sql
SHOW TABLES;
```

### Ver estructura de una tabla
```sql
DESCRIBE projects;
DESCRIBE customers;
DESCRIBE memberships;
```

### Ver datos de una tabla
```sql
SELECT * FROM projects LIMIT 10;
```

### Salir de MySQL
```sql
EXIT;
```

---

## Alternativa: Agregar MySQL al PATH (Opcional)

Si quieres usar `mysql` sin ruta completa, agrega a las variables de entorno:

**En Windows:**
1. Abre **Variables de entorno**
2. Edita **PATH**
3. Agrega: `C:\xampp\mysql\bin`
4. Reinicia PowerShell

Luego podrás usar:
```powershell
mysql -u root -p grupovivencia
```

---

## Archivos Relacionados

- Binario MySQL: `C:\xampp\mysql\bin\mysql.exe`
- Configuración: `C:\xampp\mysql\bin\my.ini`
- Datos: `C:\xampp\mysql\data\`

---

**Estado**: ✅ Conexión exitosa
