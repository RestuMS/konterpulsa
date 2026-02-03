<x-admin-layout>
    <div class="max-w-xl mx-auto mt-10">
        <h2 class="text-xl font-bold text-slate-700 mb-4">Edit Produk</h2>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-slate-200">
            <!-- Header Card -->
            <div class="bg-slate-700 px-6 py-3 border-b border-slate-600">
                <h3 class="text-white font-medium text-sm">Edit Produk: {{ $product->name }}</h3>
            </div>
            
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-2">
                    <!-- Nama Produk -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label for="name" class="col-span-4 text-sm font-bold text-slate-700">Nama Produk:</label>
                        <div class="col-span-8">
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label class="col-span-4 text-sm font-bold text-slate-700">Kategori:</label>
                        <div class="col-span-8">
                             <select name="category_id" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Provider -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label class="col-span-4 text-sm font-bold text-slate-700">Provider:</label>
                        <div class="col-span-8">
                             <select name="code" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5">
                                @foreach(['Telkomsel', 'Three', 'XL', 'Axis', 'Smartfren', 'Indosat', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Pajak', 'Tarik Tunai', 'Free Fire', 'Mobile Legends'] as $provider)
                                    <option value="{{ $provider }}" {{ old('code', $product->code) == $provider ? 'selected' : '' }}>
                                        {{ $provider }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Harga Beli (Pengeluaran) -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label for="cost_price" class="col-span-4 text-sm font-bold text-slate-700">Harga Beli:</label>
                        <div class="col-span-8">
                            <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Harga Jual (Pemasukan) -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label for="price" class="col-span-4 text-sm font-bold text-slate-700">Harga Jual:</label>
                        <div class="col-span-8">
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                     <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label class="col-span-4 text-sm font-bold text-slate-700">Status Pembayaran:</label>
                        <div class="col-span-8">
                             <select name="payment_status" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5 font-semibold">
                                <option value="paid" class="text-green-600" {{ $product->payment_status == 'paid' ? 'selected' : '' }}>LUNAS</option>
                                <option value="unpaid" class="text-red-600" {{ $product->payment_status == 'unpaid' ? 'selected' : '' }}>HUTANG / KASBON</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Pelanggan -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4 border-b border-slate-100">
                        <label class="col-span-4 text-sm font-bold text-slate-700">Nama Pelanggan:</label>
                        <div class="col-span-8">
                            <input type="text" name="customer_name" value="{{ old('customer_name', $product->customer_name) }}" placeholder="Opsional (Isi jika Hutang)" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5">
                        </div>
                    </div>

                    <!-- Stok (Visual Badge Toggle) -->
                    <div class="grid grid-cols-12 gap-4 items-center py-4">
                        <label class="col-span-4 text-sm font-bold text-slate-700">Stok:</label>
                        <div class="col-span-8">
                            <!-- Hidden real stock input -->
                            <input type="hidden" name="stock" id="real_stock" value="{{ $product->stock }}">
                            
                            <!-- Toggle / Select -->
                            <select onchange="document.getElementById('real_stock').value = this.value === 'available' ? 100 : 0" 
                                    class="bg-green-100 text-green-700 font-bold border-none rounded px-4 py-1.5 text-sm cursor-pointer focus:ring-0">
                                <option value="available" {{ $product->stock > 0 ? 'selected' : '' }}>Tersedia</option>
                                <option value="empty" {{ $product->stock == 0 ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="bg-white px-6 py-4 flex items-center justify-center gap-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow-sm text-sm transition-colors">
                        Update
                    </button>
                    <a href="{{ route('products.index') }}" class="px-8 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded shadow-sm text-sm transition-colors">
                        Batal
                    </a>
                </div>

                <!-- Hidden / Minimal Fields to prevent errors -->
            </form>
        </div>
    </div>
</x-admin-layout>
