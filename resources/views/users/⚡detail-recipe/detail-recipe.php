<?php

use Illuminate\Support\Facades\Http;
use Livewire\Component;

new class extends Component
{
    public string $slug = '';
    public ?array $menu = null;
    public bool $loading = true;
    public ?string $error = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->loadMenu();
    }

    public function loadMenu(): void
    {
        try {
            $response = Http::get(config('services.api.base_url') . "/menu/detail/{$this->slug}");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['code'] === 200 && isset($data['data']['menu'])) {
                    $this->menu = $data['data']['menu'];

                    // Sort recipes by sort_number
                    if (!empty($this->menu['recipes'])) {
                        usort($this->menu['recipes'], fn($a, $b) => $a['sort_number'] <=> $b['sort_number']);
                    }
                } else {
                    $this->error = 'Data tidak ditemukan.';
                }
            } else {
                $this->error = 'Gagal memuat data resep.';
            }
        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan.';
        } finally {
            $this->loading = false;
        }
    }
};