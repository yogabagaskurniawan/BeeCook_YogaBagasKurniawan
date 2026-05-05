<?php

use Illuminate\Support\Facades\Http;
use Livewire\Component;

new class extends Component
{
    public array $menus = [];
    public array $categories = [];
    public bool $loading = true;

    public string $search = '';
    public string $activeCategory = '';
    public int $currentPage = 1;
    public int $totalPages = 1;
    public int $totalItems = 0;
    public int $itemsPerPage = 9;

    public function mount(): void
    {
        $this->loadCategories();

        $slug = request()->query('category', '');
        if ($slug) {
            $matched = collect($this->categories)
                ->firstWhere('slug', $slug);

            if ($matched) {
                $this->activeCategory = (string) $matched['id'];
            }
        }
    }

    public function loadCategories(): void
    {
        try {
            $response = Http::get(config('services.api.base_url') . '/category');

            if ($response->successful()) {
                $this->categories = $response->json('data.categories', []);
            }
        } catch (\Exception $e){
            $this->loading = false;
        }
    }

    public function loadMenus(): void
    {
        $this->loading = true;
        try {
            $response = Http::get(config('services.api.base_url') . '/menu', [
                'page'        => $this->currentPage,
                'limit'       => $this->itemsPerPage,
                'search'      => $this->search,
                'category_id' => $this->activeCategory,
            ]);

            if ($response->successful()) {
                $data = $response->json('data');
                $this->menus       = $data['menus'] ?? [];
                $this->totalPages  = $data['totalPages'] ?? 1;
                $this->totalItems  = $data['totalItems'] ?? 0;
                $this->currentPage = $data['currentPage'] ?? 1;
            }

            $this->loading = false;
        } catch (\Exception $e){
            $this->loading = false;
        }
    }

    public function filterCategory(string $categoryId): void
    {
        $this->activeCategory = $categoryId;
        $this->currentPage = 1;
        $this->loading  = true;
        $this->dispatch('fetch-menus');
    }

    public function goToPage(int $page): void
    {
        if ($page < 1 || $page > $this->totalPages) return;
        $this->currentPage = $page;
        $this->loading = true;
        $this->dispatch('fetch-menus');
    }

    public function getPageNumbers(): array
    {
        $pages = [];
        $total = $this->totalPages;
        $current = $this->currentPage;

        if ($total <= 5) {
            return range(1, $total);
        }

        $pages[] = 1;

        if ($current > 3) $pages[] = '...';

        for ($i = max(2, $current - 1); $i <= min($total - 1, $current + 1); $i++) {
            $pages[] = $i;
        }

        if ($current < $total - 2) $pages[] = '...';

        $pages[] = $total;

        return $pages;
    }
};