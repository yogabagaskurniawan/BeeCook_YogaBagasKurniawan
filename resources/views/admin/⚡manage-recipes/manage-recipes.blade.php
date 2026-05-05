<div>
<main class="px-6 md:px-[123px] py-10 pt-[126px]">

    {{-- ── Page heading ── --}}
    <section aria-label="Header Halaman Kelola" class="mb-8">
        <h1 class="font-inter font-bold text-4xl md:text-5xl text-black">
            Kelola Resep
        </h1>
    </section>

    <section aria-label="Daftar Resep">
        <a wire:navigate href="/add-recipes"
            class="mb-8 inline-flex items-center justify-center px-6 py-4 bg-primary text-white font-inter font-bold text-lg rounded-lg hover:opacity-90 transition-opacity whitespace-nowrap"
        >
            Tambah Resep
        </a>

        <div class="overflow-x-auto rounded-xl mt-4">
            <table class="w-full min-w-[600px] border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-5 py-3 text-left font-inter font-medium text-xs text-gray-500 tracking-wide w-[370px]">Nama Resep</th>
                        <th class="px-5 py-3 text-left font-inter font-medium text-xs text-gray-500 tracking-wide w-[207px]">Kategori</th>
                        <th class="px-5 py-3 text-left font-inter font-medium text-xs text-gray-500 tracking-wide w-[306px]">File ID</th>
                        <th class="px-5 py-3 text-left font-inter font-medium text-xs text-gray-500 tracking-wide">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($loading)
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center font-inter text-sm text-gray-400">
                                Memuat data...
                            </td>
                        </tr>
                    @else
                    @forelse ($menus as $menu)
                        <tr class="{{ !$loop->last ? 'border-b border-gray-200' : '' }} hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-inter font-medium text-sm text-gray-800">{{ $menu['name'] }}</td>
                            <td class="px-5 py-3 font-inter font-medium text-sm text-gray-800">{{ $menu['category']['name'] ?? '-' }}</td>
                            <td class="px-5 py-3 font-inter font-medium text-sm text-gray-800 truncate max-w-[200px]">{{ $menu['file_id'] }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-4">
                                    {{-- DELETE --}}
                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $menu['id'] }}, '{{ addslashes($menu['name']) }}')"
                                        class="font-inter font-semibold text-sm text-red-500 hover:text-red-700 transition-colors"
                                    >
                                        Delete
                                    </button>

                                    {{-- EDIT --}}
                                    <a wire:navigate href="/edit-recipes/{{ $menu['slug'] }}"
                                        class="font-inter font-semibold text-sm text-blue-600 hover:text-blue-800 transition-colors"
                                    >
                                        Edit
                                    </a>

                                    {{-- UPLOAD GAMBAR --}}
                                    <button
                                        type="button"
                                        wire:click="openUploadModal({{ $menu['id'] }}, '{{ addslashes($menu['name']) }}')"
                                        class="font-inter font-semibold text-sm text-teal-500 hover:text-teal-700 transition-colors"
                                    >
                                        Gambar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center font-inter text-sm text-gray-400">
                                Tidak ada resep ditemukan.
                            </td>
                        </tr>
                    @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if ($totalPages > 1)
            <div class="flex items-center gap-1 mt-4 px-1">
                <button
                    type="button"
                    wire:click="previousPage"
                    @disabled($currentPage <= 1)
                    class="h-[38px] px-3 font-inter font-medium text-base text-gray-800 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                >«</button>
                <div class="flex items-center">
                    <div class="w-[38px] h-[38px] flex items-center justify-center rounded-full border border-gray-200 font-inter font-medium text-base text-gray-800">
                        {{ $currentPage }}
                    </div>
                    <span class="px-2 font-inter font-medium text-base text-gray-800">of</span>
                    <span class="font-inter font-medium text-base text-gray-800">{{ $totalPages }}</span>
                </div>
                <button
                    type="button"
                    wire:click="nextPage"
                    @disabled($currentPage >= $totalPages)
                    class="h-[38px] px-3 font-inter font-medium text-base text-gray-800 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                >»</button>
            </div>
        @endif
    </section>

</main>


{{-- ══════════════════════════════════════
    MODAL KONFIRMASI DELETE
══════════════════════════════════════ --}}
@if ($showDeleteModal)
<div
    role="dialog"
    aria-modal="true"
    class="fixed inset-0 z-[100] flex items-center justify-center px-4"
>
    {{-- Backdrop --}}
    <div
        wire:click="cancelDelete"
        class="absolute inset-0 bg-black/40"
    ></div>

    {{-- Panel --}}
    <div class="relative w-full max-w-[420px] bg-white rounded-xl shadow-xl p-7 flex flex-col gap-5">
        
        {{-- Ikon warning --}}
        <div class="flex justify-center">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
        </div>

        {{-- Teks --}}
        <div class="text-center">
            <h2 class="font-inter font-bold text-xl text-gray-800 mb-1">Hapus Resep?</h2>
            <p class="font-inter text-sm text-gray-500">
                Apakah kamu yakin ingin menghapus resep
                <span class="font-semibold text-gray-700">"{{ $deleteMenuName }}"</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex gap-3">
            <button
                type="button"
                wire:click="cancelDelete"
                class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-800 font-inter font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors"
            >
                <span wire:target="cancelDelete" wire:loading.remove>Batal</span> 
                <span wire:target="cancelDelete" wire:loading>Memproses...</span>
            </button>
            <button
                type="button"
                wire:click="deleteMenu"
                class="flex-1 px-4 py-2.5 bg-red-600 text-white font-inter font-medium text-sm rounded-lg hover:bg-red-700 transition-colors"
            >
                <span wire:target="deleteMenu" wire:loading.remove>Ya, Hapus</span>
                <span wire:target="deleteMenu" wire:loading>Memproses...</span>
            </button>
        </div>

    </div>
</div>
@endif


{{-- ══════════════════════════════════════
    MODAL UPLOAD GAMBAR
══════════════════════════════════════ --}}
@if ($showUploadModal)
<div
    role="dialog"
    aria-modal="true"
    class="fixed inset-0 z-[100] flex items-start justify-center pt-12 px-4 pb-6"
>
    {{-- Backdrop --}}
    <div
        wire:click="closeUploadModal"
        class="absolute inset-0 bg-black/40"
    ></div>

    {{-- Panel modal --}}
    <div class="relative w-full max-w-[510px] bg-white rounded-xl shadow-xl flex flex-col overflow-hidden max-h-[90vh]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-7 pt-7 pb-4">
            <div class="flex-1">
                <h2 class="font-inter font-semibold text-2xl text-gray-800 text-center">
                    Upload Gambar
                </h2>
                {{-- <p class="font-inter text-sm text-gray-400 text-center mt-0.5">{{ $uploadMenuName }}</p> --}}
            </div>
            <button
                type="button"
                wire:click="closeUploadModal"
                class="w-9 h-9 flex items-center justify-center bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors flex-shrink-0"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-10 py-6 flex flex-col gap-6">

            {{-- Error --}}
            @if ($uploadError)
                <div class="w-full px-4 py-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="font-inter text-sm text-red-600">{{ $uploadError }}</p>
                </div>
            @endif

            {{-- Success --}}
            @if ($uploadSuccess)
                <div class="w-full px-4 py-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="font-inter text-sm text-green-600">Gambar berhasil diupload!</p>
                </div>
            @endif

            {{-- Validation error --}}
            @error('uploadFile')
                <div class="w-full px-4 py-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="font-inter text-sm text-red-600">{{ $message }}</p>
                </div>
            @enderror

            {{-- Drop zone / file input --}}
            <label
                for="upload-file-input"
                x-data="{
                    isDragging: false,
                    handleDrop(e) {
                        this.isDragging = false;
                        const file = e.dataTransfer.files[0];
                        if (!file) return;

                        const input = document.getElementById('upload-file-input');
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;
                        input.dispatchEvent(new Event('change'));
                    }
                }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop($event)"
                for="upload-file-input"
                :class="isDragging ? 'border-blue-500 bg-blue-100 scale-[1.01]' : ($wire.uploadFile ? 'border-blue-400 bg-blue-50' : 'border-gray-200')"
                class="w-full border-2 border-dashed rounded-xl p-12 flex flex-col items-center gap-5 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                    :class="isDragging ? 'text-blue-500 scale-110' : 'text-blue-600'"
                    class="w-12 h-12 transition-transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                <div class="text-center">
                    @if ($uploadFile)
                        <p class="font-inter font-semibold text-base text-blue-600">
                            {{ $uploadFile->getClientOriginalName() }}
                        </p>
                        <p class="font-inter text-sm text-gray-400 mt-1">
                            {{ number_format($uploadFile->getSize() / 1024, 1) }} KB
                        </p>
                    @else
                        <p class="font-inter font-medium text-base text-gray-800">
                            Seret gambar ke sini atau
                            <span class="text-blue-600 font-semibold">browse file</span>
                        </p>
                        <p class="font-inter font-medium text-sm text-gray-400 mt-1">Maximum size: 50MB</p>
                    @endif
                </div>

                <input
                    id="upload-file-input"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    wire:model="uploadFile"
                />
            </label>

            {{-- Preview --}}
            <div>
                <p class="font-inter font-medium text-sm text-gray-600 mb-2">Preview</p>
                <div class="w-full h-[200px] bg-gray-50 rounded-lg overflow-hidden flex items-center justify-center">
                    @if ($uploadFile && !$errors->has('uploadFile'))
                        <img
                            src="{{ $uploadFile->temporaryUrl() }}"
                            class="w-full h-full object-cover"
                            alt="Preview"
                        />
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M7.5 8.25h.008v.008H7.5V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                    @endif
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-5 py-4 border-t border-gray-200 flex items-center justify-end gap-2">
            <button
                type="button"
                wire:click="closeUploadModal"
                class="px-4 py-2 bg-white border border-gray-200 text-gray-800 font-inter font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors"
            >
                Cancel
            </button>
            <button
                type="button"
                wire:click="uploadGambar"
                wire:loading.attr="disabled"
                wire:target="uploadGambar,uploadFile"
                class="px-4 py-2 bg-blue-600 text-white font-inter font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
                {{-- Spinner saat loading --}}
                <svg
                    wire:loading
                    wire:target="uploadGambar,uploadFile"
                    class="w-4 h-4 animate-spin"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>

                <span wire:loading wire:target="uploadGambar">Mengupload...</span>
                <span wire:loading wire:target="uploadFile">Memproses...</span>
                <span wire:loading.remove wire:target="uploadGambar,uploadFile">Upload</span>
            </button>
        </div>

    </div>
</div>
@endif

</div>