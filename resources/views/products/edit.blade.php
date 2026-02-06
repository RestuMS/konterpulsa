<x-admin-layout>
    <div class="max-w-xl mx-auto mt-10 p-4">
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
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label for="name" class="md:col-span-4 text-sm font-bold text-slate-700">Nama Produk:</label>
                        <div class="md:col-span-8">
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label class="md:col-span-4 text-sm font-bold text-slate-700">Kategori:</label>
                        <div class="md:col-span-8">
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
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label class="md:col-span-4 text-sm font-bold text-slate-700">Provider:</label>
                        <div class="md:col-span-8">
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
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label for="cost_price" class="md:col-span-4 text-sm font-bold text-slate-700">Harga Beli:</label>
                        <div class="md:col-span-8">
                            <input type="text" name="cost_price" id="cost_price" value="{{ old('cost_price', number_format($product->cost_price, 0, ',', '')) }}" class="rupiah-input w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Harga Jual (Pemasukan) -->
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label for="price" class="md:col-span-4 text-sm font-bold text-slate-700">Harga Jual:</label>
                        <div class="md:col-span-8">
                            <input type="text" name="price" id="price" value="{{ old('price', number_format($product->price, 0, ',', '')) }}" class="rupiah-input w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5" required>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                     <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label class="md:col-span-4 text-sm font-bold text-slate-700">Status Pembayaran:</label>
                        <div class="md:col-span-8">
                             <select name="payment_status" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5 font-semibold">
                                <option value="paid" class="text-green-600" {{ $product->payment_status == 'paid' ? 'selected' : '' }}>LUNAS</option>
                                <option value="unpaid" class="text-red-600" {{ $product->payment_status == 'unpaid' ? 'selected' : '' }}>HUTANG / KASBON</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Pelanggan -->
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4 border-b border-slate-100">
                        <label class="md:col-span-4 text-sm font-bold text-slate-700">Nama Pelanggan:</label>
                        <div class="md:col-span-8">
                            <input type="text" name="customer_name" value="{{ old('customer_name', $product->customer_name) }}" placeholder="Opsional (Isi jika Hutang)" class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5">
                        </div>
                    </div>

                    <!-- Stok (Visual Badge Toggle) -->
                    <div class="flex flex-col md:grid md:grid-cols-12 gap-2 md:gap-4 py-4">
                        <label class="md:col-span-4 text-sm font-bold text-slate-700">Stok:</label>
                        <div class="md:col-span-8">
                            <!-- Hidden real stock input -->
                            <input type="hidden" name="stock" id="real_stock" value="{{ $product->stock }}">
                            
                            <!-- Toggle / Select -->
                            <select onchange="document.getElementById('real_stock').value = this.value === 'available' ? 100 : 0" 
                                    class="w-full border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm text-black px-3 py-1.5">
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

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputs = document.querySelectorAll('.rupiah-input');
                        
                        function formatRupiah(angka) {
                            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                            split   = number_string.split(','),
                            sisa    = split[0].length % 3,
                            rupiah  = split[0].substr(0, sisa),
                            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
                
                            if(ribuan){
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                
                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                            return rupiah;
                        }

                        function cleanRupiah(angka) {
                            return angka.replace(/\./g, '');
                        }

                        inputs.forEach(input => {
                            // Initial format
                            if(input.value) {
                                input.value = formatRupiah(input.value);
                            }

                            input.addEventListener('input', function(e) {
                                e.target.value = formatRupiah(e.target.value);
                            });
                        });

                        const form = document.querySelector('form');
                        form.addEventListener('submit', function() {
                            inputs.forEach(input => {
                                input.value = cleanRupiah(input.value);
                            });
                        });
                    });
                </script>

                <!-- Hidden / Minimal Fields to prevent errors -->
            </form>
        </div>
    </div>
</x-admin-layout>
