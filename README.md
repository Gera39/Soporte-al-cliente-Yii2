# 📬 Sistema de Soporte al Cliente - Yii2 + Bootstrap + JS

Sistema completo de levantamiento de tickets y gestión de soporte al cliente en línea. Desarrollado con el framework **Yii2**, **Bootstrap** para el frontend y **JavaScript** para funcionalidades dinámicas. Pensado para mejorar la atención, seguimiento y evaluación de operadores y clientes.

---

## 🚀 Funcionalidades principales

### 👑 Administrador
- Gestión de usuarios y operadores
- Bloqueo y desbloqueo de cuentas
- Registro de logs del sistema
- Visualización de secciones individuales y generales
- Reportes y calificaciones de operadores

### 🎧 Operador
- Ver sus tickets asignados
- Revisar reportes de los clientes (quejas)
- Visualizar su calificación
- Levantar paquetes y servicios

### 👤 Cliente
- Levantar tickets de soporte
- Ver historial de chat
- Solicitar cancelaciones
- Aceptar o rechazar decisiones
- Visualizar estado de sus servicios
- Ser bloqueado/desbloqueado por administración

---

## 📁 Tecnologías utilizadas

| Tecnología     | Descripción                        |
|----------------|------------------------------------|
| Yii2 Framework | Backend PHP MVC y ORM              |
| Bootstrap      | Interfaz responsive y moderna      |
| JavaScript     | Interactividad del cliente         |
| MySQL          | Base de datos relacional           |
| HTML/CSS       | Maquetación y estilos personalizados |

---

## 🔐 Seguridad

- Gestión de roles: administrador, operador, cliente
- Control de acceso por permisos y rutas
- Validaciones en frontend y backend
- Mecanismo de bloqueo/desbloqueo de usuarios

---

## 📂 Estructura del proyecto

```bash
project/
├── assets/                  # Recursos como JS y CSS
├── commands/                # Comandos de consola Yii
├── config/                  # Configuraciones generales
├── controllers/             # Controladores MVC
├── models/                  # Modelos ORM
├── modules/                 # Módulos separados por roles
│   ├── admin/
│   ├── client/
│   └── operator/
├── runtime/                 # Archivos temporales
├── views/                   # Vistas del sistema
└── web/                     # Entrada pública del sistema
