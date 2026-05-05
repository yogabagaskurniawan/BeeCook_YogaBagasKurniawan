<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;
    public array $menus = [];
    public bool $loading = true;

    public string $search = '';
    public int $currentPage = 1;
    public int $totalPages = 1;
    public int $totalItems = 0;
    public int $itemsPerPage = 10;

    // Property untuk upload gambar
    public $uploadFile = null;  // file sementara
    public string $uploadError = '';
    public bool $uploadSuccess = false;

    // Property untuk modal upload
    public bool $showUploadModal = false;
    public ?int $uploadMenuId = null;
    public string $uploadMenuName = '';

    // Property untuk modal konfirmasi delete
    public bool $showDeleteModal = false;
    public ?int $deleteMenuId = null;
    public string $deleteMenuName = '';

    public function mount(): void
    {
        $this->loadMenus();
    }

    public function loadMenus(): void
    {
        $this->loading = true;
        try {
            $response = Http::get(config('services.api.base_url') . '/menu', [
                'page'   => $this->currentPage,
                'limit'  => $this->itemsPerPage,
                'search' => $this->search,
            ]);

            if ($response->successful()) {
                $data = $response->json('data');
                $this->menus       = $data['menus']      ?? [];
                $this->totalPages  = $data['totalPages']  ?? 1;
                $this->totalItems  = $data['totalItems']  ?? 0;
                $this->currentPage = $data['currentPage'] ?? 1;
            }
        } catch (\Exception $e) {
            // handle error
            $this->loading = false;
        }
        $this->loading = false;
    }

    public function goToPage(int $page): void
    {
        if ($page < 1 || $page > $this->totalPages) return;
        $this->currentPage = $page;
        $this->loadMenus();
    }

    public function previousPage(): void
    {
        $this->goToPage($this->currentPage - 1);
    }

    public function nextPage(): void
    {
        $this->goToPage($this->currentPage + 1);
    }

    // ── DELETE ──────────────────────────────────────
    public function confirmDelete(int $id, string $name): void
    {
        $this->deleteMenuId   = $id;
        $this->deleteMenuName = $name;
        $this->showDeleteModal = true;
    }

    public function deleteMenu(): void
    {
        if (!$this->deleteMenuId) return;

        Cache::lock('delete-menu-' . $this->deleteMenuId)->block(10, function () {
            try {
                $response = Http::delete(
                    config('services.api.base_url') . '/menu/delete/' . $this->deleteMenuId
                );
    
                if ($response->successful()) {
                    $this->showDeleteModal = false;
                    $this->deleteMenuId   = null;
                    $this->deleteMenuName = '';
                    $this->loadMenus(); // refresh tabel
                }
            } catch (\Exception $e) {
                // handle error
            }
        });
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deleteMenuId   = null;
        $this->deleteMenuName = '';
    }

    // ── UPLOAD GAMBAR ────────────────────────────────
    public function openUploadModal(int $id, string $name): void
    {
        $this->uploadMenuId   = $id;
        $this->uploadMenuName = $name;
        $this->showUploadModal = true;
    }
    
    public function updatedUploadFile(): void
    {
        $this->uploadError = '';
        $this->validate([
            'uploadFile' => 'required|image|max:51200', // max 50MB
        ]);
    }

    public function uploadGambar(): void
    {
        $this->validate([
            'uploadFile' => 'required|image|max:51200',
        ]);

        if (!$this->uploadMenuId) return;

        try {
            $this->validate([
                'uploadFile' => 'required|image|max:51200',
            ]);

            if (!$this->uploadMenuId) return;

            // Gunakan readStream atau get() via storage disk
            $fileContents = $this->uploadFile->get();
            $fileName = $this->uploadFile->getClientOriginalName();

            $response = Http::attach(
                'image',
                $fileContents,
                $fileName
            )->put(
                config('services.api.base_url') . '/menu/upload/' . $this->uploadMenuId
            );

            if ($response->successful()) {
                $this->uploadFile    = null;
                $this->uploadSuccess = true;
                $this->uploadError   = '';
                $this->loadMenus();
            } else {
                $this->uploadError = $response->json('message') ?? 'Upload gagal.';
            }
        } catch (\Exception $e) {
            $this->uploadError = 'Terjadi kesalahan saat upload.';
        }
    }

    public function closeUploadModal(): void
    {
        $this->showUploadModal = false;
        $this->uploadMenuId    = null;
        $this->uploadMenuName  = '';
        $this->uploadFile      = null;
        $this->uploadError     = '';
        $this->uploadSuccess   = false;
    }
};