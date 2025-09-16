
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
