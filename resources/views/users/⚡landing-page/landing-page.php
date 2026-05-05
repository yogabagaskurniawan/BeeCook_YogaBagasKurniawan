<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
new class extends Component
{
    public array $categories = [];
    public bool $loading = true;

    public function mount(): void
    {
        try{
            $response = Http::get(config('services.api.base_url') . '/category');

            if ($response->successful()) {
                $this->categories = $response->json('data.categories', []);
            }

            $this->loading = false;
        }catch(\Exception $e){
            $this->loading = false;
        }
    }
};