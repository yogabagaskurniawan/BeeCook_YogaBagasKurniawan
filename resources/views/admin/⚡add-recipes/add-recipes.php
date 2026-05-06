<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

new class extends Component
{
    // Mode: 'add' atau 'edit'
    public string $mode = 'add';
    public ?string $editSlug = null;
    public ?int $editId = null;

    // Form fields
    public string $name = '';
    public string $description = '';
    public string $cooking_duration = '';
    public string $category_id = '';
 
    // Dynamic lists
    public array $ingredients = [['description' => '']];
    public array $recipes = [['description' => '', 'sort_number' => 1]];
 
    // Nutrition
    public string $calory = '';
    public string $protein = '';
    public string $carbohydrate = '';
    public string $fat = '';
 
    // Categories dari API
    public array $categories = [];
 
    // State
    public bool $isLoading = false;
 
    public function mount(?string $slug = null): void
    {
        $this->loadCategories();
        
        if ($slug) {
            $this->mode = 'edit';
            $this->editSlug = $slug;
            $this->loadMenuData($slug);
        }
    }
 
    private function loadCategories(): void
    {
        try {
            $response = Http::get(config('services.api.base_url') . '/category');
            if ($response->successful()) {
                $this->categories = $response->json('data.categories') ?? [];
            }
        } catch (\Exception $e) {
            // fallback kosong
        }
    }
 
    private function loadMenuData(string $slug): void
    {
        try {
            $response = Http::get(config('services.api.base_url') . '/menu/detail/' . $slug);
            if ($response->successful()) {
                $menu = $response->json('data.menu');
 
                $this->editId        = $menu['id'];
                $this->name          = $menu['name'] ?? '';
                $this->description   = $menu['description'] ?? '';
                $this->cooking_duration = (string) ($menu['cooking_duration'] ?? '');
                $this->category_id   = (string) ($menu['category_id'] ?? '');
 
                $this->ingredients = collect($menu['ingredients'] ?? [])
                    ->map(fn($i) => ['description' => $i['description']])
                    ->toArray();
 
                $this->recipes = collect($menu['recipes'] ?? [])
                    ->sortBy('sort_number')
                    ->values()
                    ->map(fn($r, $idx) => [
                        'description' => $r['description'],
                        'sort_number' => $r['sort_number'] ?? ($idx + 1),
                    ])
                    ->toArray();
 
                $nutrition = $menu['nutrition'] ?? $menu['nutritions'] ?? [];
                $this->calory       = (string) ($nutrition['calory'] ?? '');
                $this->protein      = (string) ($nutrition['protein'] ?? '');
                $this->carbohydrate = (string) ($nutrition['carbohydrate'] ?? '');
                $this->fat          = (string) ($nutrition['fat'] ?? '');
            } else {
                $this->dispatch('failed-message', 'Resep tidak ditemukan.');
            }
        } catch (\Exception $e) {
            $this->dispatch('failed-message', 'Gagal memuat data menu.');
        }
    }
 
    // ── Ingredients ──────────────────────────────
    public function addIngredient(): void
    {
        $this->ingredients[] = ['description' => ''];
    }
 
    public function removeIngredient(int $index): void
    {
        if (count($this->ingredients) > 1) {
            array_splice($this->ingredients, $index, 1);
        }
    }
 
    // ── Recipes / Instruksi ───────────────────────
    public function addRecipe(): void
    {
        $this->recipes[] = [
            'description' => '',
            'sort_number' => count($this->recipes) + 1,
        ];
    }
 
    public function removeRecipe(int $index): void
    {
        if (count($this->recipes) > 1) {
            array_splice($this->recipes, $index, 1);
            // Re-number
            foreach ($this->recipes as $i => &$r) {
                $r['sort_number'] = $i + 1;
            }
        }
    }
 
    // ── Submit ────────────────────────────────────
    public function save(): void
    {
        $this->validate([
            'name'             => 'required|string|min:3',
            'description'      => 'required|string|min:5',
            'cooking_duration' => 'required|numeric|min:1',
            'category_id'      => 'required',
            'ingredients'      => 'required|array|min:1',
            'ingredients.*.description' => 'required|string',
            'recipes'          => 'required|array|min:1',
            'recipes.*.description'     => 'required|string',
            'calory'           => 'required|numeric',
            'protein'          => 'required|numeric',
            'carbohydrate'     => 'required|numeric',
            'fat'              => 'required|numeric',
        ], [
            'name.required'             => 'Nama resep wajib diisi.',
            'description.required'      => 'Deskripsi wajib diisi.',
            'cooking_duration.required' => 'Durasi masak wajib diisi.',
            'cooking_duration.numeric'  => 'Durasi masak harus berupa angka.',
            'category_id.required'      => 'Kategori wajib dipilih.',
            'ingredients.*.description' => 'Semua bahan wajib diisi.',
            'recipes.*.description'     => 'Semua instruksi wajib diisi.',
            'calory.required'           => 'Kalori wajib diisi.',
            'protein.required'          => 'Protein wajib diisi.',
            'carbohydrate.required'     => 'Karbohidrat wajib diisi.',
            'fat.required'              => 'Lemak wajib diisi.',
        ]);

        $this->isLoading = true;

        $lockKey = 'save-menu-' . auth()->id();
        $lock    = Cache::lock($lockKey, 10);

        if (! $lock->get()) {
            $this->dispatch('failed-message', 'Permintaan sedang diproses, harap tunggu.');
            $this->isLoading = false;
            return;
        }

        $payload = [
            'name'             => $this->name,
            'description'      => $this->description,
            'cooking_duration' => $this->cooking_duration,
            'category_id'      => $this->category_id,
            'ingredients'      => $this->ingredients,
            'recipes'          => array_values($this->recipes),
            'nutritions'       => [
                'calory'       => $this->calory,
                'protein'      => $this->protein,
                'carbohydrate' => $this->carbohydrate,
                'fat'          => $this->fat,
            ],
        ];

        try {
            if ($this->mode === 'edit') {
                $response = Http::patch(
                    config('services.api.base_url') . '/menu/update/' . $this->editId,
                    $payload
                );
            } else {
                $response = Http::post(
                    config('services.api.base_url') . '/menu',
                    $payload
                );
            }

            if ($response->successful()) {
                $this->mode === 'edit'
                    ? session()->flash('success-message', 'Resep berhasil diperbarui!')
                    : session()->flash('success-message', 'Resep berhasil ditambahkan!');

                if ($this->mode === 'add') {
                    $this->reset(['name', 'description', 'cooking_duration', 'category_id',
                                'calory', 'protein', 'carbohydrate', 'fat']);
                    $this->ingredients = [['description' => '']];
                    $this->recipes     = [['description' => '', 'sort_number' => 1]];
                }

                $this->redirect('/manage', navigate: true);
            } else {
                $this->dispatch('failed-message', 'Terjadi kesalahan.');
            }
        } catch (\Exception $e) {
            $this->dispatch('failed-message', 'Gagal terhubung ke server.');
        } finally {
            $lock->release();
            $this->isLoading = false;
        }
    }
};