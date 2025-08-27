# 📚 Bookio - Vzdělávací průvodce Laravel aplikací

## 🎯 Úvod

Aplikace **Bookio** je kompletní Laravel 12 aplikace pro správu knih, která demonstruje moderní webové vývojové praktiky. Tento dokument slouží jako vzdělávací materiál pro pochopení všech technologií a konceptů použitých v aplikaci.

---

## 🏗️ Architektura aplikace

### MVC Pattern (Model-View-Controller)
Aplikace následuje MVC architekturu:
- **Models** - reprezentují data a business logiku
- **Views** - zobrazují data uživateli (Blade šablony)
- **Controllers** - zpracovávají požadavky a koordinují mezi modely a views

---

## 📊 Databáze a Modely

### Eloquent ORM
Laravel používá Eloquent ORM pro práci s databází:

```php
// Model Book s relacemi
class Book extends Model
{
    protected $fillable = ['title', 'author', 'description', 'price', 'stock', 'user_id'];
    
    // Relace - kniha patří uživateli
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

**Co se naučíte:**
- Definice modelů a jejich vlastností
- Eloquent relace (belongsTo, hasMany)
- Mass assignment protection ($fillable)
- Custom metody v modelech

**Dokumentace:** [Laravel Eloquent](https://laravel.com/docs/11.x/eloquent)

### Migrace
Migrace definují strukturu databáze:

```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('author');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->unsignedInteger('stock');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});
```

**Co se naučíte:**
- Vytváření a úprava databázových tabulek
- Definice sloupců a jejich typů
- Foreign key constraints
- Rollback migrací

**Dokumentace:** [Laravel Migrations](https://laravel.com/docs/11.x/migrations)

### Factories
Pro testování a seeding dat:

```php
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
    }
}
```

**Dokumentace:** [Laravel Factories](https://laravel.com/docs/11.x/eloquent-factories)

---

## 🎮 Controllery

### Resource Controllers
Aplikace používá resource controllery pro CRUD operace:

```php
class BooksController extends Controller
{
    public function index(Request $request) { /* seznam knih */ }
    public function create() { /* formulář pro vytvoření */ }
    public function store(Request $request) { /* uložení nové knihy */ }
    public function edit(Book $book) { /* formulář pro úpravu */ }
    public function update(Request $request, Book $book) { /* aktualizace */ }
    public function destroy(Book $book) { /* smazání */ }
}
```

**Co se naučíte:**
- RESTful routing
- Route Model Binding
- Request handling
- Response types (views, redirects)

**Dokumentace:** [Laravel Controllers](https://laravel.com/docs/11.x/controllers)

---

## 🛡️ Autentifikace a Autorizace

### Authentication
Kompletní autentifikační systém:
- Registrace uživatelů
- Přihlašování/odhlašování
- Obnovení hesla
- Ověření emailu

### Policies
Autorizace pomocí policies:

```php
class BookPolicy
{
    public function update(User $user, Book $book): bool
    {
        return $user->id === $book->user_id;
    }
    
    public function delete(User $user, Book $book): bool
    {
        return $user->id === $book->user_id;
    }
}
```

**Co se naučíte:**
- Laravel Breeze/Sanctum
- Policy classes
- Gate authorization
- Middleware pro ochranu routes

**Dokumentace:** 
- [Laravel Authentication](https://laravel.com/docs/11.x/authentication)
- [Laravel Authorization](https://laravel.com/docs/11.x/authorization)

---

## ✅ Validace

### Form Request Validation
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'author' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
    'description' => 'nullable|string|max:1000',
]);
```

**Co se naučíte:**
- Validation rules
- Custom validation messages
- Form Request classes
- Error handling

**Dokumentace:** [Laravel Validation](https://laravel.com/docs/11.x/validation)

---

## 🌐 Routing

### Web Routes
```php
Route::middleware(['auth'])->group(function () {
    Route::resource('books', BooksController::class);
    Route::post('/locale', [LocaleController::class, 'set'])->name('locale.set');
});
```

**Co se naučíte:**
- Route definition
- Route groups
- Middleware application
- Named routes
- Resource routing

**Dokumentace:** [Laravel Routing](https://laravel.com/docs/11.x/routing)

---

## 🎨 Frontend - Blade Templates

### Blade Templating Engine
```blade
<x-layouts.app>
    <h1>{{ __('Your books') }}</h1>
    
    @foreach ($books as $book)
        <div class="book-card">
            <h3>{{ $book->title }}</h3>
            <p>{{ $book->author }}</p>
        </div>
    @endforeach
</x-layouts.app>
```

### Blade Components
```blade
<x-button type="primary" class="w-full">
    {{ __('Save Book') }}
</x-button>
```

**Co se naučíte:**
- Blade syntax (@if, @foreach, @include)
- Template inheritance
- Blade components
- Slots a props
- Conditional classes

**Dokumentace:** [Laravel Blade](https://laravel.com/docs/11.x/blade)

---

## 🎨 Styling - TailwindCSS

### Utility-First CSS Framework
```html
<div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
    <button class="inline-flex items-center rounded-lg border border-red-200/60 bg-white/80 p-2">
        Smazat
    </button>
</div>
```

**Co se naučíte:**
- Utility classes
- Responsive design
- Dark mode support
- Component composition

**Dokumentace:** [TailwindCSS](https://tailwindcss.com/docs)

---

## ⚡ JavaScript - AlpineJS

### Lightweight JavaScript Framework
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

**Co se naučíte:**
- Reactive data
- Event handling
- DOM manipulation
- Component state

**Dokumentace:** [AlpineJS](https://alpinejs.dev/)

---

## 🌍 Lokalizace

### Internationalization (i18n)
```php
// V Blade šablonách
{{ __('Your books') }}

// V PHP kódu
__('Book created successfully.')
```

```json
// lang/cs.json
{
    "Your books": "Vaše knihy",
    "Book created successfully.": "Kniha byla úspěšně vytvořena."
}
```

**Co se naučíte:**
- Translation files
- Language switching
- Pluralization
- Date/time localization

**Dokumentace:** [Laravel Localization](https://laravel.com/docs/11.x/localization)

---

## 🔧 Middleware

### Custom Middleware
```php
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('locale')) {
            session(['locale' => $request->locale]);
        }
        
        app()->setLocale(session('locale', 'en'));
        
        return $next($request);
    }
}
```

**Co se naučíte:**
- Request/Response pipeline
- Custom middleware creation
- Global vs route-specific middleware

**Dokumentace:** [Laravel Middleware](https://laravel.com/docs/11.x/middleware)

---

## 💾 Session Management

### Session Storage
```php
// Ukládání do session
Session::flash('status', __('Book created successfully.'));

// Čtení ze session
if (session('status')) {
    echo session('status');
}
```

**Co se naučíte:**
- Session drivers (file, database, redis)
- Flash messages
- Session security
- CSRF protection

**Dokumentace:** [Laravel Session](https://laravel.com/docs/11.x/session)

---

## 🔍 Vyhledávání a Filtrování

### Query Building
```php
$books = Auth::user()
    ->books()
    ->when($request->filled('search'), fn ($q) =>
        $q->where('title', 'like', '%'.$request->input('search').'%')
    )
    ->paginate(15);
```

**Co se naučíte:**
- Eloquent query builder
- Conditional queries
- Pagination
- Search implementation

**Dokumentace:** [Laravel Query Builder](https://laravel.com/docs/11.x/queries)

---

## 📄 Pagination

### Automatic Pagination
```php
// V controlleru
$books = Book::paginate(15);

// V Blade šabloně
{{ $books->links() }}
```

**Co se naučíte:**
- Simple vs LengthAware pagination
- Custom pagination views
- Query string preservation

**Dokumentace:** [Laravel Pagination](https://laravel.com/docs/11.x/pagination)

---

## 🧪 Testování

### Pest Testing Framework
```php
test('user can create a book', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/books', [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'price' => 29.99
        ]);

    $response->assertRedirect('/books');
    $this->assertDatabaseHas('books', ['title' => 'Test Book']);
});
```

**Co se naučíte:**
- Feature testing
- Unit testing
- Database testing
- HTTP testing
- Mocking

**Dokumentace:**
- [Laravel Testing](https://laravel.com/docs/11.x/testing)
- [Pest PHP](https://pestphp.com/)

---

## 🛠️ Development Tools

### Composer Dependencies
```json
{
    "require": {
        "laravel/framework": "^12.0",
        "blade-ui-kit/blade-icons": "^1.8",
        "owenvoke/blade-fontawesome": "^2.9"
    },
    "require-dev": {
        "pestphp/pest": "^4.0",
        "larastan/larastan": "^3.0",
        "laravel/pint": "^1.13"
    }
}
```

### NPM Dependencies
```json
{
    "dependencies": {
        "alpinejs": "^3.14.9"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.1.7",
        "laravel-vite-plugin": "^1.2.0",
        "vite": "^6.2.4"
    }
}
```

**Co se naučíte:**
- Package management
- Build tools (Vite)
- Code quality tools (Pint, Larastan)
- Asset compilation

---

## 🔧 Konfigurace

### Environment Configuration
```php
// config/app.php
'name' => env('APP_NAME', 'Laravel'),
'env' => env('APP_ENV', 'production'),
'debug' => (bool) env('APP_DEBUG', false),
```

### Database Configuration
```php
// config/database.php
'default' => env('DB_CONNECTION', 'sqlite'),
'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
    ],
]
```

**Co se naučíte:**
- Environment variables
- Configuration caching
- Service providers
- Application lifecycle

**Dokumentace:** [Laravel Configuration](https://laravel.com/docs/11.x/configuration)

---

## 🎨 UI Components

### Blade Icons
```blade
<x-fas-magnifying-glass class="w-4 h-4" />
<x-fas-trash class="h-3 w-3" />
```

### Custom Components
```blade
<x-button type="primary" class="w-full">
    {{ $slot }}
</x-button>
```

**Co se naučíte:**
- Icon libraries integration
- Component composition
- Slot system
- Props passing

**Dokumentace:**
- [Blade UI Kit](https://blade-ui-kit.com/)
- [Blade FontAwesome](https://github.com/owenvoke/blade-fontawesome)

---

## 🚀 Deployment a Production

### Build Process
```bash
# Development
npm run dev

# Production build
npm run build

# Laravel optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Co se naučíte:**
- Asset optimization
- Caching strategies
- Environment setup
- Performance optimization

---

## 📚 Doporučené zdroje pro další studium

### Oficiální dokumentace
- [Laravel Documentation](https://laravel.com/docs)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [AlpineJS Documentation](https://alpinejs.dev/)

### Vzdělávací platformy
- [Laravel Daily](https://laraveldaily.com/)
- [Laracasts](https://laracasts.com/)
- [Laravel News](https://laravel-news.com/)

### Komunita
- [Laravel.io](https://laravel.io/)
- [Laravel Discord](https://discord.gg/laravel)
- [Reddit r/laravel](https://reddit.com/r/laravel)

---

## 🎯 Praktické cvičení

### Úkoly pro procvičení:
1. **Přidejte nové pole** - Rozšiřte model Book o pole "isbn"
2. **Vytvořte nový controller** - Implementujte správu kategorií knih
3. **Napište testy** - Pokryjte všechny CRUD operace testy
4. **Přidejte API** - Vytvořte REST API pro mobilní aplikaci
5. **Implementujte cache** - Přidejte cachování pro seznam knih

### Pokročilé funkce k implementaci:
- **File uploads** - Nahrávání obalů knih
- **Email notifications** - Notifikace o nových knihách
- **Queue jobs** - Asynchronní zpracování
- **Real-time updates** - WebSocket integrace
- **Search engine** - Elasticsearch/Algolia

---

## 🏆 Závěr

Aplikace Bookio demonstruje moderní Laravel development stack a poskytuje solidní základ pro pochopení webového vývoje v PHP. Každá technologie má svou roli a společně tvoří robustní, škálovatelnou aplikaci.

**Klíčové takeaways:**
- MVC architektura pro organizaci kódu
- Eloquent ORM pro práci s databází
- Blade templating pro frontend
- Middleware pro request processing
- Policies pro autorizaci
- Testing pro kvalitu kódu

Pokračujte ve studiu jednotlivých komponent a experimentujte s rozšiřováním aplikace o nové funkce!
