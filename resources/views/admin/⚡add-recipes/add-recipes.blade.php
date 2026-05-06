<div>
    <main class="relative px-6 md:px-[123px] py-10 pt-[126px]">

        <!-- Glow blob dekoratif kanan -->
        <div
        class="absolute top-[300px] right-0 w-[300px] h-[300px] md:w-[490px] md:h-[492px] bg-primary opacity-30 rounded-full blur-[150px] pointer-events-none -z-10"
        aria-hidden="true"
        ></div>

        <!-- Page heading -->
        <h1 class="font-inter font-bold text-4xl md:text-5xl text-black mb-8">
            {{ $mode === 'edit' ? 'Edit Resep' : 'Buat Resep Baru' }}
        </h1>

        <!-- ════════════════════════════════════════
            CARD: Informasi Utama
        ════════════════════════════════════════ -->
        <section class="bg-white rounded-2xl shadow-lg p-8 md:p-10 mb-6">
            <h2 class="font-inter font-medium text-2xl text-black mb-6">Informasi Utama</h2>

            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Kolom kiri -->
                <div class="flex flex-col gap-5 flex-1 max-w-[400px]">

                    <!-- Nama Resep -->
                    <div class="flex flex-col gap-2">
                        <label class="font-inter font-semibold text-sm text-gray-800">Nama Resep</label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="Nama Resep"
                            class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                                {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                        />
                        @error('name') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="flex flex-col gap-2">
                        <label class="font-inter font-semibold text-sm text-gray-800">Kategori</label>
                        <select
                            wire:model="category_id"
                            class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-800 outline-none focus:border-primary transition-colors appearance-none bg-white cursor-pointer
                                    {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                            >
                            <option value="" disabled>Pilih Kategori</option>
                            @if (count($categories) > 0)
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                @endforeach
                            @else
                                {{-- Fallback hardcode jika API kategori belum ada --}}
                                <option value="1">Main Course</option>
                                <option value="2">Beverages</option>
                                <option value="3">Appetizer</option>
                                <option value="4">Side Dish</option>
                                <option value="5">Dessert</option>
                            @endif
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Durasi Masak -->
                    <div class="flex flex-col gap-2">
                        <label class="font-inter font-semibold text-sm text-gray-800">Durasi Masak (menit)</label>
                        <input
                            type="number"
                            wire:model="cooking_duration"
                            placeholder="60"
                            min="1"
                            class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                                {{ $errors->has('cooking_duration') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                        />
                        @error('cooking_duration') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom kanan: Deskripsi -->
                <div class="flex flex-col gap-2 flex-1">
                    <label class="font-inter font-semibold text-sm text-gray-800">Deskripsi</label>
                    <textarea
                        wire:model="description"
                        placeholder="Isi deskripsi singkat tentang makanan"
                        rows="9"
                        class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors resize-none
                            {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                    ></textarea>
                    @error('description') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>


        <!-- ════════════════════════════════════════
            CARD: Bahan-bahan & Instruksi Masak
        ════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Bahan-bahan -->
        <section class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-inter font-medium text-2xl text-black">Bahan - Bahan</h2>
                <button
                    type="button"
                    wire:click="addIngredient"
                    class="px-4 py-1.5 border border-gray-300 bg-slate-50 rounded font-inter font-medium text-xs text-gray-800 hover:bg-gray-100 transition-colors"
                >
                    Tambah Bahan
                </button>
            </div>

            <div class="flex flex-col gap-3">
                @foreach ($ingredients as $i => $ingredient)
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            wire:model="ingredients.{{ $i }}.description"
                            placeholder="Bahan {{ $i + 1 }}"
                            class="flex-1 px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                                {{ $errors->has("ingredients.$i.description") ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                        />
                        @if (count($ingredients) > 1)
                            <button
                                type="button"
                                    wire:click="removeIngredient({{ $i }})"
                                    class="p-2 text-red-400 hover:text-red-600 transition-colors"
                                    title="Hapus bahan"
                                >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                    @error("ingredients.$i.description")
                        <span class="text-red-500 text-xs font-inter ml-1">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>
        </section>


        <!-- Instruksi Masak -->
        <section class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-inter font-medium text-2xl text-black">Instruksi Masak</h2>
                <button
                    type="button"
                    wire:click="addRecipe"
                    class="px-4 py-1.5 border border-gray-300 bg-slate-50 rounded font-inter font-medium text-xs text-gray-800 hover:bg-gray-100 transition-colors"
                >
                    Tambah Instruksi
                </button>
            </div>

            <div class="flex flex-col gap-3">
                @foreach ($recipes as $i => $recipe)
                    <div class="flex items-center gap-2">
                    <span class="font-inter font-bold text-xs text-gray-400 w-5 shrink-0">{{ $i + 1 }}</span>
                    <input
                        type="text"
                        wire:model="recipes.{{ $i }}.description"
                        placeholder="Instruksi {{ $i + 1 }}"
                        class="flex-1 px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                            {{ $errors->has("recipes.$i.description") ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                    />
                    @if (count($recipes) > 1)
                        <button
                        type="button"
                        wire:click="removeRecipe({{ $i }})"
                        class="p-2 text-red-400 hover:text-red-600 transition-colors"
                        title="Hapus instruksi"
                        >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        </button>
                    @endif
                    </div>
                    @error("recipes.$i.description")
                    <span class="text-red-500 text-xs font-inter ml-4">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>
        </section>

        </div>


        <!-- ════════════════════════════════════════
            CARD: Informasi Nutrisi
        ════════════════════════════════════════ -->
        <section class="bg-white rounded-2xl shadow-lg p-8 md:p-10 mb-10">
        <h2 class="font-inter font-medium text-2xl text-black mb-6">Informasi Nutrisi</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

            <!-- Kalori -->
            <div class="flex flex-col gap-2">
            <label class="font-inter font-semibold text-sm text-gray-800">Kalori (kkal)</label>
            <input
                type="number"
                wire:model="calory"
                placeholder="0"
                min="0"
                class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                    {{ $errors->has('calory') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
            />
            @error('calory') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
            </div>

            <!-- Protein -->
            <div class="flex flex-col gap-2">
            <label class="font-inter font-semibold text-sm text-gray-800">Protein (g)</label>
            <input
                type="number"
                wire:model="protein"
                placeholder="0"
                min="0"
                class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                    {{ $errors->has('protein') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
            />
            @error('protein') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
            </div>

            <!-- Karbohidrat -->
            <div class="flex flex-col gap-2">
            <label class="font-inter font-semibold text-sm text-gray-800">Karbohidrat (g)</label>
            <input
                type="number"
                wire:model="carbohydrate"
                placeholder="0"
                min="0"
                class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                    {{ $errors->has('carbohydrate') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
            />
            @error('carbohydrate') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
            </div>

            <!-- Lemak -->
            <div class="flex flex-col gap-2">
            <label class="font-inter font-semibold text-sm text-gray-800">Lemak (g)</label>
            <input
                type="number"
                wire:model="fat"
                placeholder="0"
                min="0"
                class="w-full px-4 py-3 border rounded-lg font-inter font-medium text-sm text-gray-700 outline-none focus:border-primary transition-colors
                    {{ $errors->has('fat') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
            />
            @error('fat') <span class="text-red-500 text-xs font-inter">{{ $message }}</span> @enderror
            </div>

        </div>
        </section>

        <!-- Tombol Simpan -->
        <div class="flex justify-end gap-4">
            <a
                wire:navigate href="/manage"
                class="px-8 py-4 border border-gray-300 text-gray-700 font-inter font-bold text-lg rounded-lg hover:bg-gray-50 transition-colors"
            >
                Batal
            </a>
            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="px-8 py-4 bg-primary text-white font-inter font-bold text-lg rounded-lg hover:opacity-90 transition-opacity disabled:opacity-60 disabled:cursor-not-allowed flex items-center gap-2"
            >
                <span wire:loading.remove wire:target="save">
                    {{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan Resep' }}
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    Menyimpan...
                </span>
            </button>
        </div>

    </main>
</div>