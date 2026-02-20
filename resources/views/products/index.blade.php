@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<x-admin-layout>
    <x-slot name="header">
        {{ __('Transaction Management') }}
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-500">Manage your store Restu Cell.</p>
        <a href="{{ route('products.create') }}" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105">
            + Tambah Transaksi
        </a>
    </div>

    <!-- Success Message (SweetAlert Trigger) -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Transaksi Sukses!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            });
        </script>
    @endif

    <!-- Search Form -->
    <!-- Search & Filter Form -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            
            <!-- Search Input -->
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama produk..." class="w-full pl-12 pr-4 py-3 border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-700 placeholder-slate-400 shadow-sm transition-all">
            </div>

            <!-- Date Input -->
            <div class="relative md:w-1/4">
                <input type="date" name="date" value="{{ request('date') }}" class="w-full pl-4 pr-10 py-3 border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-700 shadow-sm transition-all" title="Filter berdasarkan tanggal">
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-3 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-700 transition-colors shadow-sm">
                    Filter
                </button>
                @if(request('search') || request('date'))
                    <a href="{{ route('products.index') }}" class="px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors border border-red-100 flex items-center justify-center" title="Reset Filter">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Summary Cards -->
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Pemasukan (Green) -->
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl p-5 shadow-lg text-white">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 skew-x-12 transform origin-bottom-left"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-xs font-medium bg-emerald-800/30 px-2 py-1 rounded text-emerald-100">Omset</span>
                </div>
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Pemasukan</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs text-emerald-100/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Total Potensi</span>
                </div>
            </div>
             <!-- Decor Icon -->
             <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <!-- Pengeluaran (Red) -->
        <div class="relative overflow-hidden bg-gradient-to-br from-rose-500 to-rose-700 rounded-xl p-5 shadow-lg text-white">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 skew-x-12 transform origin-bottom-left"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                     <span class="text-xs font-medium bg-rose-800/30 px-2 py-1 rounded text-rose-100">Modal</span>
                </div>
                <div>
                     <p class="text-rose-100 text-sm font-medium mb-1">Pengeluaran</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalCost, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs text-rose-100/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Total Stok</span>
                </div>
            </div>
             <!-- Decor Icon -->
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        </div>

        <!-- Laba (Sky Blue/Cyan) -->
        <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl p-5 shadow-lg text-white">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 skew-x-12 transform origin-bottom-left"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                     <span class="text-xs font-medium bg-sky-800/30 px-2 py-1 rounded text-sky-100">Bersih</span>
                </div>
                 <div>
                    <p class="text-sky-100 text-sm font-medium mb-1">Laba</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs text-sky-100/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Estimasi</span>
                </div>
            </div>
             <!-- Decor Icon -->
             <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
        </div>

        <!-- Total Produk (Blue) -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-5 shadow-lg text-white">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 skew-x-12 transform origin-bottom-left"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-2">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                       <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                     <span class="text-xs font-medium bg-blue-800/30 px-2 py-1 rounded text-blue-100">Item</span>
                </div>
                <div>
                     <p class="text-blue-100 text-sm font-medium mb-1">Total Produk</p>
                    <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs text-blue-100/80">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Dalam Database</span>
                </div>
            </div>
             <!-- Decor Icon -->
            <svg class="absolute -right-6 -bottom-6 w-32 h-32 text-white/10 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        </div>
    </div>

    <!-- Products Table (Desktop) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-900 border-b border-gray-800 text-xs uppercase tracking-widest text-white font-bold">
                    <th class="px-6 py-4 rounded-tl-lg">Tanggal</th>
                    <th class="px-6 py-4">Provider</th>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4 text-right">Modal</th>
                    <th class="px-6 py-4 text-right">Jual</th>
                    <th class="px-6 py-4 text-right">Laba</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($products as $product)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                        <!-- Tanggal -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-slate-600 block">{{ optional($product->created_at)->format('d M Y') ?? '-' }}</span>
                        </td>

                        <!-- Provider -->
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-lg bg-slate-800 text-white font-mono text-xs font-bold tracking-wide shadow-sm">
                                {{ $product->code }}
                            </span>
                        </td>
                        
                        <!-- Produk Name -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="font-bold text-slate-800 text-base md:text-sm group-hover:text-pink-600 transition-colors">
                                    {{ $product->name }}
                                </div>
                                @if($product->quantity > 1)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                        x{{ $product->quantity }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4">
                            @if($product->category)
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200 uppercase tracking-tight">
                                    {{ $product->category->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">No Category</span>
                            @endif
                        </td>

                        <!-- Pelanggan -->
                        <td class="px-6 py-4">
                            @if($product->customer_name)
                                <span class="text-sm font-bold text-slate-700">{{ $product->customer_name }}</span>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <!-- Modal (Black) -->
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-slate-800 font-mono">
                                {{ number_format($product->cost_price ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <!-- Jual (Red) -->
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-red-600 font-mono">
                                {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </td>

                        <!-- Laba -->
                        <td class="px-6 py-4 text-right text-emerald-600">
                            @php
                                $profit = $product->price - ($product->cost_price ?? 0);
                            @endphp
                            <div class="flex items-center justify-end gap-1 font-mono text-sm font-bold bg-emerald-100/50 text-emerald-700 px-2 py-1 rounded-lg inline-block">
                                <span class="text-xs">+</span> {{ number_format($profit, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            @if($product->payment_status == 'paid')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-500 text-white shadow-md shadow-green-200">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    LUNAS
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-600 text-white shadow-md shadow-red-200 animate-pulse">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    KASBON
                                </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="p-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 border border-red-100 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg font-medium text-slate-500">Belum ada transaksi</p>
                                <p class="text-sm">Mulai tambahkan transaksi baru sekarang.</p>
                                <a href="{{ route('products.create') }}" class="mt-4 px-4 py-2 bg-pink-50 text-pink-600 font-bold rounded-lg border border-pink-100 hover:bg-pink-100 transition-colors text-sm">
                                    + Buat Transaksi
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View (md and below) -->
    <div class="md:hidden space-y-4">
        @forelse($products as $product)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <!-- Card Header -->
                <div class="px-4 py-3 bg-slate-50 flex justify-between items-center border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-500">{{ optional($product->created_at)->format('d M Y') ?? '-' }}</span>
                    @if($product->payment_status == 'paid')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700">
                            LUNAS
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">
                            KASBON
                        </span>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="inline-block px-2 py-0.5 rounded-md bg-slate-800 text-white font-mono text-[10px] font-bold mb-1">
                                {{ $product->code }}
                            </span>
                            <div class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                {{ $product->name }}
                                @if($product->quantity > 1)
                                    <span class="text-xs font-normal text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">x{{ $product->quantity }}</span>
                                @endif
                            </div>
                            @if($product->category)
                                <span class="text-xs text-slate-500">{{ $product->category->name }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                        <div class="bg-slate-50 p-2 rounded-lg">
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Harga Jual</p>
                            <p class="font-mono font-bold text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-emerald-50 p-2 rounded-lg">
                            <p class="text-[10px] text-emerald-600 uppercase font-bold">Laba</p>
                            @php $profit = $product->price - ($product->cost_price ?? 0); @endphp
                            <p class="font-mono font-bold text-emerald-700">+ Rp {{ number_format($profit, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($product->customer_name)
                        <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>{{ $product->customer_name }}</span>
                        </div>
                    @endif
                </div>

                <!-- Card Footer (Actions) -->
                <div class="px-4 py-3 bg-gray-50 flex justify-end gap-2 border-t border-slate-100">
                     <a href="{{ route('products.edit', $product->id) }}" class="px-3 py-1.5 bg-white text-blue-600 border border-blue-200 rounded-lg text-xs font-bold shadow-sm hover:bg-blue-50">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-white text-red-600 border border-red-200 rounded-lg text-xs font-bold shadow-sm hover:bg-red-50">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-slate-100">
                 <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <p class="text-slate-500 font-medium">Tidak ada transaksi</p>
                <a href="{{ route('products.create') }}" class="mt-3 inline-block px-4 py-2 bg-pink-50 text-pink-600 font-bold rounded-lg text-sm">
                    + Buat Baru
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-2">
        {{ $products->links() }}
    </div>

</x-admin-layout>
