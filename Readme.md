## Para crear el proyecto en laravel se uso

```bash
docker-compose run --rm composer create-project --prefer-dist laravel/laravel src
```
El problema esque te crea en la carpeta src otra carpeta src y ahi recien el proyecto en laravel solo mover todo el contenido fuera del segundo src

## Optimizacion basica

```bash
docker-compose run --rm artisan config:cache
```
## Crear archivo base para la api

```bash
docker-compose run --rm artisan install:api
```

## Crear archivo de migracion de una tabla para la base de datos

```bash
docker-compose run --rm artisan make:migration create_productos_table
```

Agregar los valores que se necesitara en la tabla

```bash
Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',150);
            $table->string('descripcion',255);
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
            $table->timestamps();
        });
```

En caso de tener llaves foraneas seguir el siguiente ejemplo 

```bash
Schema::create('partidos', function (Blueprint $table) {
            $table->id('id_partido');
            $table->foreignId('id_equipo_local')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('id_equipo_visitante')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->string('resultado');
            $table->timestamps();
        });
```

## Migrar todo a la base de datos

```bash
docker-compose --rm artisan migrate
```
en caso de que borrar todas las migraciones de la base de datos

```bash
docker-compose --rm artisan migrate:reset
```

## Crear modelos

```bash
docker-compose --rm artisan make:model Productos
```

Agregar variables

```bash
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table = 'productos'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];
}
```


## Crear Controllers

```bash
docker-compose --rm artisan make:controller ProductosController --resource
```

codigo a agregar revisar en src/app/Http/Controllers

## Configuración de Rutas para la API RESTful
En el archivo api generado anteriormente agregar

```bash
use App\Http\Controllers\ProductosController;

Route::get('productos', [ProductosController::class, 'index']);
Route::post('productos', [ProductosController::class, 'store']);
Route::get('productos/{id}', [ProductosController::class, 'show']);
Route::put('productos/{id}', [ProductosController::class, 'update']);
Route::delete('productos/{id}', [ProductosController::class, 'destroy']);
```

Ejecutar en terminal

```bash
docker-compose run --rm artisan route:list
```

## Pruebas
Acceder a la pagina de laravel desde
http://localhost:8080/

Acceder a phpmyadmin
http://localhost:8090/

Probar la api desde
localhost:8080/api/productos