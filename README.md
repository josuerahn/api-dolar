## Documentación del proyecto: api-dolar

**api-dolar** es una API desarrollada en Laravel que permite convertir montos en dólares estadounidenses a pesos argentinos utilizando cotizaciones actualizadas.

### Características principales
- **Conversión de moneda:** Recibe un valor en dólares y retorna el equivalente en pesos argentinos.
- **Obtención de cotización:** Consume una API externa para obtener la cotización actual del dólar (puede ser oficial u otro tipo).
- **Endpoint principal:** `/api/convertir` (GET), parámetros: `valor` (monto en USD), `tipo` (tipo de dólar, por defecto "oficial").
- **Autenticación:** Incluye middleware para autenticación con Laravel Sanctum en otros endpoints.
- **Configuración flexible:** La URL de la API de cotización se define en el archivo de configuración `config/services.php`.

### Ejemplo de uso
```http
GET /api/convertir?valor=100&tipo=oficial
```
Respuesta:
```json
{
  "tipo": "oficial",
  "valor_dolar": 100,
  "cotizacion": 900,
  "resultado_en_pesos": 90000
}
```

## Endpoints y rutas de prueba

### Guardar y consultar cotización

**GET** `/api/convertir?valor=100&tipo=blue`
- Guarda la cotización (actualiza si ya existe para ese tipo y fecha) y devuelve el resultado de conversión, junto con el promedio mensual/anual de venta.
- El sistema utiliza `updateOrCreate` para evitar duplicados en la base de datos, asegurando que cada cotización por tipo y fecha se actualice si ya existe.
- Parámetros:
  - `valor`: monto en dólares (obligatorio)
  - `tipo`: tipo de dólar (opcional, por defecto "oficial")

### Consultar promedios históricos

**GET** `/api/promedio?tipo=blue&valor=venta&mes=09&anio=2025`
- Devuelve el promedio mensual y anual de las cotizaciones guardadas según tipo y valor.
- Parámetros:
  - `tipo`: tipo de dólar (ej: blue, oficial, etc.)
  - `valor`: `venta` o `compra`
  - `mes`: mes en formato `MM` (opcional, por defecto el actual)
  - `anio`: año en formato `YYYY` (opcional, por defecto el actual)

### Comando para guardar cotización periódicamente (pruebas en terminal)

```
php artisan cotizacion:consultar oficial
php artisan cotizacion:consultar blue
```
- Guarda la cotización en la base de datos según el tipo.

## Estructura y archivos principales creados

- **app/Models/Cotizacion.php**
  - Modelo Eloquent para la tabla `cotizaciones`. Permite interactuar con los registros históricos de cotizaciones, incluyendo los campos tipo, compra, venta, fecha de consulta y fuente.

- **database/migrations/xxxx_create_cotizaciones_table.php**
  - Migración que crea la tabla `cotizaciones` en la base de datos, con los campos necesarios para guardar cada consulta y cotización.

- **database/migrations/xxxx_add_fecha_consulta_to_cotizaciones_table.php**
  - Migración que agrega el campo `fecha_consulta` para registrar la fecha exacta de cada consulta realizada.

- **app/Http/Controllers/CotizacionController.php**
  - Controlador principal de la API. Gestiona la consulta a la API pública, guarda cada cotización, calcula promedios y expone los endpoints `/api/convertir` y `/api/promedio`.

- **app/Console/Commands/ConsultarCotizacion.php**
  - Comando Artisan para consultar y guardar cotizaciones de manera periódica (ejecutado por el scheduler o manualmente).

- **app/Console/Kernel.php**
  - Configura el scheduler de Laravel para ejecutar el comando de consulta de cotización cada hora automáticamente.

- **config/services.php**
  - Archivo de configuración donde se define la URL base de la API pública de cotización del dólar.

- **routes/api.php**
  - Define las rutas de la API: `/api/convertir` para consultar y guardar cotizaciones, y `/api/promedio` para consultar promedios históricos.

Cada uno de estos archivos cumple una función específica para que el sistema pueda consultar, guardar y analizar cotizaciones del dólar de forma automática y bajo demanda.
