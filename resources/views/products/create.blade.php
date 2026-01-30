<x-admin-layout>
    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <h2 class="text-lg font-bold text-slate-800">Tambah Transaksi</h2>
                <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>
            
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Nama Produk -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label for="name" class="col-span-3 text-sm font-bold text-slate-700">Nama Produk:</label>
                    <div class="col-span-9">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-black" required>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-sm font-bold text-slate-700">Kategori:</label>
                    <div class="col-span-9 flex items-center gap-2">
                        <!-- Main Category Select -->
                        <div class="relative w-full">
                            <select name="category_id" class="w-full appearance-none bg-blue-600 text-white border-none rounded-md py-2 pl-4 pr-10 text-sm font-semibold focus:ring-0 cursor-pointer">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code (Provider) -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label for="code" class="col-span-3 text-sm font-bold text-slate-700">Kode:</label>
                    <div class="col-span-9 relative">
                        <select name="code" id="code" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-black appearance-none" required>
                            <option value="" disabled selected>Pilih Kode Provider</option>
                            <option value="Telkomsel" {{ old('code') == 'Telkomsel' ? 'selected' : '' }}>Telkomsel</option>
                            <option value="Three" {{ old('code') == 'Three' ? 'selected' : '' }}>Three</option>
                            <option value="XL" {{ old('code') == 'XL' ? 'selected' : '' }}>XL</option>
                            <option value="Axis" {{ old('code') == 'Axis' ? 'selected' : '' }}>Axis</option>
                            <option value="Smartfren" {{ old('code') == 'Smartfren' ? 'selected' : '' }}>Smartfren</option>
                            <option value="Indosat" {{ old('code') == 'Indosat' ? 'selected' : '' }}>Indosat</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                             <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Harga Beli (Pengeluaran) -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label for="cost_price" class="col-span-3 text-sm font-bold text-slate-700">Harga Beli (Pengeluaran):</label>
                    <div class="col-span-9 relative">
                        <input type="number" name="cost_price" id="cost_price" value="0" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm pl-3 text-black" required>
                    </div>
                </div>

                <!-- Harga Jual (Pemasukan) -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label for="price" class="col-span-3 text-sm font-bold text-slate-700">Harga Jual (Pemasukan):</label>
                    <div class="col-span-9 relative">
                        <input type="number" name="price" id="price" value="0" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm pl-3 text-black" required>
                    </div>
                </div>

                <!-- Status Pembayaran -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-sm font-bold text-slate-700">Status Pembayaran:</label>
                    <div class="col-span-9">
                        <select name="payment_status" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-black font-semibold">
                            <option value="paid" class="text-green-600">LUNAS</option>
                            <option value="unpaid" class="text-red-600">HUTANG / KASBON</option>
                        </select>
                    </div>
                </div>

                <!-- Nama Pelanggan (Optional) -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-sm font-bold text-slate-700">Nama Pelanggan:</label>
                    <div class="col-span-9">
                         <input type="text" name="customer_name" placeholder="Opsional (Isi jika Hutang)" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-black">
                    </div>
                </div>

                <!-- Stok -->
                <div class="mb-5 grid grid-cols-12 gap-4 items-center">
                    <label for="stock_status" class="col-span-3 text-sm font-bold text-slate-700">Stok:</label>
                    <div class="col-span-9">
                        <select name="stock_status" onchange="document.getElementById('stock').value = this.value === 'available' ? 100 : 0" class="w-full border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-black">
                            <option value="available">Tersedia</option>
                            <option value="empty">Habis</option>
                        </select>
                        <input type="hidden" name="stock" id="stock" value="100">
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="mt-8">
                     <button type="submit" class="px-8 py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-md shadow-sm transition-colors text-sm">
                        Simpan
                     </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>
