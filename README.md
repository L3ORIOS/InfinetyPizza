# Infinety Pizza

Prueba Técnica – Desarrollador/a Laravel + Livewire



## Índice

- [Introducción](#introducción)
- [Instalación](#instalación)
    - [Comandos](#comandos)
- [Base de datos](#base-de-datos)
- [Estructura de datos](#estructura-de-datos)
    - [Modelos](#modelos)
        - [Usuario](#modelo-usuario)
        - [Ingrediente](#modelo-ingrediente)
        - [Pizza](#modelo-pizza)
        - [Pedido](#modelo-pedido)
    - [Migraciones](#migraciones)
        - [Usuario](#migración-usuario)
        - [Ingrediente](#migración-ingrediente)
        - [Pizza](#migración-pizza)
        - [Pedido](#migración-pedidos)
        - [Ingrediente_Pizza](#migración-ingrediente_pizza)
    - [Seeders](#seeders)
        - [Comando de Ejecución](#comando-de-ejecución) 
        - [Usuario](#seeder-usuario)
            - [Factory](#userfactory)
            - [Seeder](#userseeder)
        - [Ingrediente](#seeder-ingredientes)
        - [Pizza](#seeder-pizza)
        - [Pedido](#seeder-pedido)
        - [Base de Datos Final](#base-de-datos-final)
- [Autenticación y Gestion de roles](#configuración-de-autenticación-y-administrador)
    - [Autenticación Breeze](#autenticación-breeze)
    - [Apariencia](#apariencia)
    - [Autorización](#autorización)
    - [Redirección Post-Login](#redirección-post-login)
- [Panel de Administrador](#panel-administrador)
    - [Gestión dee Ingredientes](#gestión-de-ingredientes)
        - [Componentes Ingredientes](#componentes-ingredientes)
            - [Index (Componente Volt)](#index-ingredientes)
            - [Form (Componente Volt)](#form-ingredientes)
    - [Gestión dee Pizzas](#gestión-de-pizzas)
        - [Interfaces Pizzas](#interfaces-pizzas)
            - [Index.php (Pizzas - Clase Livewire)](#indexphp-pizzas---clase-livewire)
            - [Index.blade.php (Pizzas - Vista Livewire)](#indexbladephp-pizzas---vista-livewire)
            - [Form.php (Pizzas - Clase Livewire)](#formphp-pizzas---clase-livewire)
            - [Form.blade.php (Pizzas - Vista Livewire)](#formbladephp-pizzas---vista-livewire)

   

## Introducción

Repositorio de Infinety Pizza, aplicación desarrollada como prueba técnica, cuyo objetivo es gestionar de forma sencilla la venta de pizzas.

## Instalación

### Comandos
Para la instalación del proyecto utilice "Laravel new"

![alt text](./sources/image.png)

Definí el nombre de la aplicación

![alt text](./sources/image-1.png)

Seleccione "Livewire" para el frontend

![alt text](./sources/image-2.png)

Elegí la autenticación integrada de Laravel (Breeze)

![alt text](./sources/image-3.png)

Habilite Laravel Volt que permite escribir componentes de Livewire en archivos únicos.

![alt text](./sources/image-4.png)

Seleccione "Pest" como framework de pruebas determinado.

![alt text](./sources/image-5.png)

Ejecute automáticamente los comandos de Node.js para instalar las dependencias del frontend

![alt text](./sources/image-6.png)

## Base de datos

El proyecto utilizara SQLite para la base de datos de desarrollo.

He optado por SQLite en lugar de MySQL para la configuración local por su simplicidad y portabilidad, ya que no requiere un servidor de base externo ni configuraciones complejas.

La base de datos se almacena en un solo archivo ***(database/database.sqlite)***

## Estructura de Datos

### Modelos

Para crear los modelos utilice el comando "***php artisan make:model ModeloNuevo -mf***". Este comando que permite generar rápidamente la clase del modelo, migración y factoría.

Estos son los modelos utilizados para estructurar y gestionar los datos.

    -User
    -Ingrediente
    -Pizza
    -Pedido

A continuación, se muestra un ejemplo de los modelos creados. 

#### Modelo Usuario

Los usuarios del sistema puede ser clientes o administradores. Siendo el rol quien determinará su acceso.

<img src="./sources/image-7.png" width="450">

El modelo User extiende de la clase Authenticatable de Laravel, lo que le otorga todas las funcionalidades necesarias para la autenticación y seguridad.

El modelo User establece una relación uno a muchos con pedidos.

- **pedidos() :** Un usuario puede realizar múltiples pedidos a lo largo del tiempo. 


#### Modelo Ingrediente

Entidad mas básica del sistema, almacena los componentes que se asignaran a las pizzas.

<img src="./sources/image-8.png" width="450">

El modelo Ingrediente establece relación muchos a muchos con Pizza.

- **pizzas() :** Un ingrediente puede ser utilizado para multiples tipos de pizza. Esta relación bidireccional se resuelve mediante la tabla pivot ***ingredient_pizza***


#### Modelo Pizza

Se almacenan los detalles de cada tipo de pizza disponible para la venta como nombre, descripción y precio.

<img src="./sources/image-9.png" width="450">

El modelo Pizza establece una relación muchos a muchos con ingredientes y uno a muchos con pedidos.

- **ingredientes() :** Define que ingredientes componen la pizza. La relación se gestionara mediante una tabla pivote ***ingredient_pizza*** permitiendo que una pizza tenga multiples ingredientes y que un ingrediente se use en multiples pizzas. 

- **pedidos() :** Una pizza puede ser seleccionada por múltiples pedidos individuales.

#### Modelo Pedido

Registro de transacción del sistema, representa una unidad de una pizza ordenada por un cliente especifico.

<img src="./sources/image-10.png" width="450">

El modelo Pedido establece relación muchos a uno con User y Pizza.

- **user() :** Define que usuario pertenece el pedido. 

- **pizza() :** Define cual pizza fue ordenada. 


### Migraciones

#### Migración Usuario

La migración Usuarios establecerá la autenticación de usuarios y la gestión de sesiones de la aplicación. Define tres tablas esenciales: **user, password_reset_tokens y sessions** 

<img src="./sources/image-12.png" width="450">

- **id:** Clave primaria
- **name:** Nombre del Usuario.
- **email:** Dirección de correo del Usuario. Debe ser único.
- **email_verified_at:** Marca de tiempo que indica cuando se verifico el correo electrónico.
- **password:** Contraseña cifrada del usuario.
- **is_admin:** Campo booleano para determinar el rol, por defecto false (cliente), true para administradores.
- **remember_token:** Se utiliza para recordar al usuario después de cerrar el navegador.
- **created_at, updated_at:** Marca de tiempo que registra la creación y la ultima actualización del usuario.

#### Migración Pizza

La migración Pizza sera el catalogo de productos. 

<img src="./sources/image-13.png" width="450">

- **id:** Clave primaria
- **name:** Nombre de la pizza, es unique para evitar duplicados.
- **description:** Descripción completa de la pizza.
- **price:** El precio de la pizza, es un decimal con 8 dígitos en total y dos decimales.
- **timestamps:** Registra la creación y ultima actualización del registro.



#### Migración Ingrediente

La migración Ingredientes serán los componentes individuales de las pizzas. 

<img src="./sources/image-13.png" width="450">

- **id:** Clave primaria
- **name:** Nombre del ingrediente, es unique para evitar duplicados.
- **timestamps:** Registra la creación y ultima actualización del registro.

#### Migración Pedidos

La migración Pedido creara las transacciones de la aplicación depende de users y pizzas.

<img src="./sources/image-14.png" width="450">

- **id:** Clave primaria
- **user_id:** Clave foránea al modelo User.
- **pizza_id:** Clave foránea al modelo Pizza.
- **fecha_hora_pedido:** Fecha y hora especifica de cuando se creo el pedido.
- **timestamps:** Registra la creación y ultima actualización del registro.

#### Migración Ingrediente_Pizza

Migración sin modelo creada para resolver la relación muchos a muchos entre las pizzas y los ingredientes.

<img src="./sources/image-15.png" width="450">

- **ingrediente_id:** Referencia a la tabla ingredientes.
- **pizza_id:** Referencia a la tabla pizzas.

### Seeders

La aplicación utiliza Seeders para poblar la base de datos.

#### Comando de Ejecución

Para construir y poblar la base de datos de prueba, se utiliza el siguiente comando de Artisan:

**php artisan migrate:fresh --seed**

**migrate:fresh:** Borra todas las tablas existentes en la base de datos y ejecuta las migraciones desde cero.

**--seed:** Indica que, una vez que la estructura esté lista, debe ejecutar el DatabaseSeeder para iniciar la carga de todos los datos de prueba.

#### Seeder Usuario

Para poblar la tabla users con datos utilice una combinación de de UserFactory y UserSeeder para crear un par de usuarios de prueba. Un usuario Administrador y un Cliente asi como algunos clientes aleatorios con la contraseña "password" para todos los casos. 


##### UserFactory 

UserFactory define la estructura base para la crear instancias del modelo User. Ademas de métodos helpers para la diferenciación de usuarios.

<img src="./sources/image-16.png" width="450">

- **definition() :** Aquí se definen los atributos por defecto para un nuevo usuario. Por default un usuario se crea como cliente, establecido en el campo **is_admin** en **false**. 
    - **'name' => fake()->name():** Genera un nombre aleatorio.
    - **'email' => fake()->unique()->safeEmail():** Se crea un email único y con formato valido. 
    - **'password' => static::$password ??= Hash::make('password'):** Genera un hash seguro de la contraseña.
    - **'remember_token' => Str::random(10):** Genera un token aleatorio.
    - **'two_factor_secret' => Str::random(10):** Clave secreta para la autenticación en dos factores (2FA).
    - **'two_factor_recovery_codes':** Código de respaldo para la 2FA.
    - **'two_factor_confirmed_at' => now():** Marca la fecha y la hora de la supuesta confirmación. 
    

- **admin() :** Esta función modifica el estado por defecto para crear un administrador cambiando el campo **is_admin** en **true**.

##### UserSeeder

El UserSeeder utiliza el UserFactory para crear 3 tipos de usuarios. (Usuario administrador, cliente y clientes aleatorios )

<img src="./sources/image-17.png" width="450">

- **User::factory( )->admin( )->create([...]) :** Dentro de la función run() se hace uso del UserFactory y su estado admin() para sobrescribir el rol por defecto a administrador.
    - **Nombre:** Admin Infinety
    - **Correo:** admin@infinety.com
    - **Contraseña:** password123
- **User::factory( )->create([...]) :** Crea un usuario de prueba con su estado por defecto donde is_admin es false. 
    - **Nombre:** Test User
    - **Correo:** test@example.com
- **User::factory( 5 )->create( ) :** Crea usuarios aleatorios adicionales con nombres y correos electrónicos aleatorios, todos con el rol de cliente.

#### Seeder Ingredientes

Predefiní una lista de ingredientes básicos en un array llamado $ingredientes. 

<img src="./sources/image-18.png" width="450">

Mediante un buble foreach itere el array $ingredientes usando el método **firstOrCreate( )**. Si el ingrediente ya existe en la base de datos, no hace nada. Si el ingrediente no existe, lo crea inmediatamente. De modo que nunca se duplicara.


#### Seeder Pizza

Cree las pizzas Margarita, Hawaiana y Pepperoni, añadiendo la relación muchos a muchos asociándolas a los ingredientes previamente creados.

<img src="./sources/image-19.png" width="450">

- **$ingredientes = Ingrediente::all( )->keyBy('name'); :** Recupera todos los ingredientes, organizándolos en una colección. Reindexa la colección usando el nombre del ingrediente como clave.
    - **{"Mozzarella":{"id":1,"name":"Mozzarella"}, ...  }**

- **$getIngrediente = fn ($name) => $ingredientes->get($name)?->id; :** Se define a la variable $getIngrediente como una función que obtiene el ID de cualquier ingrediente usando el nombre. **?->id** garantiza que si un ingrediente no se encuentra, no cause un error.  

- **$margarita = Pizza::create([...]); :** Se inserta la pizza a la tabla asignando el nombre, descripción y precio base. El objeto $margarita ahora contiene la instancia del modelo con su ID.

- **$margarita->ingredientes()->attach([ $getIngrediente('Tomate'),]) :** Asociación muchos a muchos mediante la método **ingredientes( )** previamente creado en el modelo de Pizza y utiliza el método **attach( )** para añadir a la tabla pivote (**ingrediente_pizza**) pasándole el método **$getIngrediente( )** que devuelve el ID del ingrediente que se le pase por parámetro.

#### Seeder Pedido

Cree un pedido por pizza asignándolo al cliente de prueba con el fin de tener un listado de pedidos listo para el panel de administración.

<img src="./sources/image-20.png" width="450">

- **$client = User::where('email', 'test@example.com')->first(); :** Se recupera la instancia del modelo cliente de prueba.

- **$pizzas = Pizza::all(); :** Carga todas las pizzas disponibles en la base de datos.

- **foreach ($pizzas as $pizza) { ... } :** Se itera sobre la colección de pizzas, creando un registro de Pedido con las claves del cliente y la pizza.

### Base de Datos Final

Después de ejecutar el comando **php artisan migrate:fresh --seed** la base de datos se creo correctamente y los seeders poblaron los datos de prueba. 
#### User
<img src="./sources/image-21.png" width="450">

#### Ingredientes
<img src="./sources/image-22.png" width="450">

#### Pizzas
<img src="./sources/image-23.png" width="450">

#### Ingredientes_Pizzas
<img src="./sources/image-25.png" width="450">

#### Pedidos
<img src="./sources/image-24.png" width="450">



## Configuración de Autenticación y Gestion de Roles

### Autenticación Breeze

El sistema utiliza Laravel Breeze y la arquitectura Livewire/Blade para manejar la autenticación (Login, Registro, Recuperación de Contraseña y Verificación de Email). Breeze utiliza sesiones y cookies para mantener la identidad del usuario logueado.


### Apariencia

Se realizaron ajustes mínimos en las plantillas de para personalizar el aspecto visual:

- Logo/Favicon: Se reemplazaron los íconos predeterminado de Laravel por el logo de Infinety Pizza para mantener la identidad visual del proyecto.

### Autorización  

Se utiliza la configuración de Laravel a traves  de un middleware para asegurar que:

- Los administradores sean redirigidos al Panel de Administración (/admin/dashboard).
- Los cientes sean redirigidos a la pagina de inicio del cliente (/dashboard).

<img src="./sources/image-26.png" width="450">

#### Rutas protegidas

Todas las rutas que formaran parte del panel de administración se agruparan y se les aplicaran el middleware AuthzMiddleware ('admin') junto con el middleware estándar de autenticación ('auth').

<img src="./sources/image-27.png" width="450">


### Redirección Post-Login

La lógica de inicio de sesión se modificó para redirigir a los usuarios a un dashboard específico basado en su rol, en lugar de usar la ruta por defecto (/dashboard) para todos.

Se identificó el componente de Livewire/Volt que maneja el inicio de sesión (app/Livewire/auth/login.blade.php) y se modificó el método login()

<img src="./sources/image-28.png" width="450">

## Panel Administrador

El bloque de administración solo aparece si el usuaria autenticado es admin. Esto en el componente sidebar que utiliza la aplicación.

**resources\views\components\layouts\app\sidebar.blade.php**

<img src="./sources/image-29.png" width="450">

**resources\views\admin\dashboard.blade.php**

<img src="./sources/image-30.png" width="450">

### Gestión de ingredientes  

Se desarrolló utilizando Livewire, Volt (componentes de un solo archivo) y Flux (librería UI).

- Los componentes cubre las operaciones CRUD completas (crear, ver, actualizar y eliminar), con validaciones y una interfaz basada en modales.

- Un modal reutilizable para crear y editar.

- Validaciones

- UX con <flux:modal>, <flux:input>, <flux:button> y paginación.

- El mismo formulario sirve para crear (sin id) y editar (con id).

- Al guardar, el hijo emite ingrediente-refreshed → el padre cierra modal y refresca la tabla.

#### Componentes Ingredientes

##### Index Ingredientes

Lista los ingredientes, abre el modal y gestiona edición/eliminación.

<img src="./sources/image-32.png" width="450">

- **Clase** 
    
    <img src="./sources/image-31.png" width="450">
    
    - **use WithPagination; :**
        - Permite usar el método ->paginate() en las consultas.
        - Agrega automáticamente el manejo de la paginación reactiva en el componente
        - Escucha los eventos de cambio de página (page en la URL o links de paginación) y actualiza el contenido sin recargar la página.
    
    -  **public bool $showModal = false; :** controla la apertura/cierre del modal de Flux.
    -  **public ?int $editingId = null; :** determina el modo del formulario.
        - **null:** Crea.
        - **int:**  Edita el ingrediente con ese ID.

    - **public function with(): array:** 
        - Devuelve los datos a renderizar.
        - Carga los ingredientes paginados con Ingrediente::latest()->paginate(5),mostrando los más recientes primero.

    - **public function openCreate(): void :** Limpia $editingId y abre el modal para rear un nuevo ingrediente.

    - **public function openEdit(int $id): void :** Asigna el id a $editingId y abre el modal en modo edición.

    - **#[On('ingrediente-refreshed')] public function ingredienteRefreshed(): void :**
        - Escucha el evento emitido por el componente hijo (Form) cuando se guarda un ingrediente.
        - Refresca la lista y reinicia la paginación con $this->resetPage().


    - **public function delete(int $id): void:**
        - Elimina el ingrediente especificado por su id usando Ingrediente::findOrFail($id)->delete().
        -La tabla se actualiza automáticamente en el siguiente render.        

- **Contenido (HTML)** 

    - Título principal y botón “Nuevo Ingrediente” que abre el modal (wire:click="openCreate").

        <img src="./sources/image-33.png" width="450">

    - Modal reutilizable con <flux:modal> que carga el componente hijo Form:
        
        <img src="./sources/image-34.png" width="450">

        - **@livewire('admin.ingredientes.form', ['ingredienteId' => $editingId], key('ingrediente-form-'.($editingId ?? 'new')))**

            - Si $editingId es null, el formulario crea un nuevo registro.

            - Si tiene un valor, el formulario carga los datos del ingrediente para editarlo.

    - Tabla de ingredientes con acciones:

        <img src="./sources/image-35.png" width="450">

        - Editar: abre el modal con el ingrediente seleccionado (wire:click="openEdit({{ $id }})").

        - Eliminar: elimina el registro (wire:click="delete({{ $id }})").

    - Paginación al final mediante {{ $ingredientes->links() }}.


##### Form Ingredientes

Se incluye dentro del modal del Index y emite eventos al completar una acción.

<img src="./sources/image-38.png" width="450">

- **Clase**

    <img src="./sources/image-36.png" width="450">

    - **public ?int $ingredienteId = null; :** Identifica si el formulario está en modo creación (null) o edición (id existente).

    - **public string $name = ''; :**  Almacena el valor del nombre del ingrediente que se está editando o creando.

    - **public function mount(?int $ingredienteId = null): void :**

        - Si $ingredienteId tiene un valor, carga el ingrediente desde base de datos y precarga $name.

        - Si es null, inicia el formulario vacío.

    - **public function rules(): array: :** Define las reglas de validación del campo name:

        - required, string, min:3, max:100.

        - unique en la tabla ingredientes, ignorando el registro actual si se edita.

    - **public function save(): void :**
        - Valida los datos del formulario.

        - Si $ingredienteId existe, actualiza el registro correspondiente.

        - Si no, crea uno nuevo en la base de datos.

        - Luego emite el evento ingrediente-refreshed al componente padre (Index) para refrescar la lista y cerrar el modal.

    - **public function render() :**
        - Devuelve la vista Blade livewire.admin.ingredientes.form, con los valores actuales y errores de validación si los hay.

- **Contenido (HTML)**

    <img src="./sources/image-37.png" width="450">

    - Campo de entrada con < flux:input> para el nombre del ingrediente (wire:model.defer="name").

    - Botón de envío con < flux:button type="submit">.

    - Validaciones visuales y mensajes de error integrados.

    - El formulario está dentro de < form wire:submit.prevent="save"> , por lo que se envía sin recargar la página.




### Gestión de Pizzas  

Desarrollada utilizando Livewire  y Flux UI.

- El módulo incluye todas las operaciones CRUD y permite asignar ingredientes a cada pizza
- Se emplea una clase Livewire independiente (Index y Form), en lugar de Volt, ya que la lógica de negocio es más compleja (validaciones, sincronización de relaciones y múltiples campos).
- La interfaz se basa en modales reutilizables y una tabla dinámica con paginación reactiva.

#### Interfaces Pizzas

Lista las pizzas, abre el modal y gestiona edición y eliminación.

<img src="./sources/image-39.png" width="450">

Componente hijo encargado de crear o editar una pizza, con asignación de ingredientes.

<img src="./sources/image-40.png" width="450">

##### Index.php (Pizzas - Clase Livewire)

<img src="./sources/image-41.png" width="450">

- **use WithPagination; :**
    - Permite usar el método ->paginate() en las consultas.
    - Maneja automáticamente la paginación reactiva (sin recargar la página).
    - Escucha el cambio de página y actualiza los datos visibles en el componente.

-  **public bool $showModal = false; :** Controla la apertura y cierre del modal de Flux para crear o editar pizzas.

-  **public ?int $editingId = null; :**Determina el modo del formulario.
    - **null :** Modo crear.
    - **int :** Modo editar, con los datos precargados de la pizza seleccionada.

- **public function openCreate(): void :** Limpia $editingId y abre el modal en modo creación.

- **public function openEdit(int $id): void :** Asigna $editingId con el ID de la pizza seleccionada y abre el modal en modo edición.

- **#[On('pizza-refreshed')] public function pizzaRefreshed(): void**
    - Escucha el evento emitido por el componente hijo (Form) cuando una pizza se guarda correctamente.
    - Reinicia la paginación y refresca la lista ($this->resetPage()).

- **public function delete(int $id): void :**
    - Elimina la pizza seleccionada mediante Pizza::findOrFail($id)->delete().
    - Refresca la tabla automáticamente tras el render.

- **public function render() :**
    - Recupera las pizzas con su conteo de ingredientes:
        - Pizza::query()->withCount('ingredientes')->latest()->paginate(10);
    - Retorna la vista livewire.admin.pizzas.index con los datos necesarios.


##### Index.blade.php (Pizzas - Vista Livewire)

<img src="./sources/image-42.png" width="450">

- Título y botón “Nueva Pizza” (wire:click="openCreate").

- Modal reutilizable (< Flux:modal wire:model="showModal">) que carga el componente hijo Form:

    - **@livewire('admin.pizzas.form', ['pizzaId' => $editingId], key('pizza-form-'.($editingId ?? 'new')))**
    - $editingId determina si el formulario está creando o editando.

- Tabla de pizzas con acciones:
    - Cada fila muestra:
        - Nombre de la pizza.
        - Precio.
        - Editar: **wire:click="openEdit({{ $pizza->id }})".**
        - Eliminar: **wire:click="delete({{ $pizza->id }})".**
        - Cantidad de ingredientes asociados.

- Paginación mediante {{ $pizzas->links() }}.



##### Form.php (Pizzas - Clase Livewire) 

<img src="./sources/image-43.png" width="450">

- **public ?int $pizzaId = null; :** Determina si el formulario está en modo creación o edición.

- **public ?Pizza $pizza = null; :** Contiene la instancia actual de la pizza al editar.

- **public string $name = ''; :** Nombre de la pizza.

- **public ?string $description = null; :** Descripción opcional de la pizza.

- **public string|float|int $price = ''; :** Precio de la pizza.

- **public array $ingredientesSeleccionados = []; :** IDs de los ingredientes seleccionados.

- **public function mount(?int $pizzaId = null): void :** 
    - Si $pizzaId está presente:
        - Carga la pizza desde la base de datos.
        - Precarga los campos (name, description, price) y los IDs de los ingredientes seleccionados.

    - Si es null, inicia los valores vacíos (modo creación).

- **public function rules(): array :** Reglas de validación para los campos.

- **public function messages(): array :** Mensajes de validación personalizados.

- **public function save(): void :** 
    - Valida los datos según las reglas.
    - Si $pizzaId existe:
        - Actualiza los campos de la pizza actual.
    - Si no, crea una nueva pizza en la base de datos.
    - Sincroniza los ingredientes seleccionados con ->ingredientes()->sync($this->ingredientesSeleccionados).
    - Emite el evento pizza-refreshed al componente padre (Index).

- **public function render() :**
    - Devuelve la vista livewire.admin.pizzas.form con los datos:
        - Lista de ingredientes (Ingrediente::orderBy('name')->get(['id','name'])).
        - Indicador editMode (true o false).

##### Form.blade.php (Pizzas - Vista Livewire) 

<img src="./sources/image-44.png" width="450">

- Formulario principal dentro de <form wire:submit.prevent="save">.
- Campos:
    - <flux:input> para nombre.
    - <flux:textarea> para descripción.
    - <flux:input type="number" step="0.01"> para precio.
    - Lista de checkboxes para ingredientes:
        - **< input type="checkbox" wire:model="ingredientesSeleccionados" value="{{ $ing->id }}">**
    - Validaciones visuales y errores (@error('campo')).
    - Botón de acción principal <flux:button type="submit"> con texto dinámico:
        - “Crear pizza” o “Guardar cambios”.

## Extensiones utilizadas en VS Code

### Livewire Language Support 

### Laravel

Official Laravel VS Code Extension 

### Capture Code
### SQLite Viewer
- [ ]

