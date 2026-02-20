@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengeluaran Operasional') }}
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-gray-500 text-sm">Kelola pengeluaran harian toko Anda.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pengeluaran
        </a>
    </div>

    <!-- SweetAlert Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const action = "{{ session('action', 'store') }}";
                const configs = {
                    store: { title: 'Berhasil Ditambahkan!', icon: 'success', color: '#f97316' },
                    update: { title: 'Berhasil Diperbarui!', icon: 'info', color: '#3b82f6' },
                    delete: { title: 'Berhasil Dihapus!', icon: 'warning', color: '#ef4444' }
                };
                const cfg = configs[action] || configs.store;
                Swal.fire({
                    title: cfg.title,
                    text: "{{ session('success') }}",
                    icon: cfg.icon,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: cfg.color,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <!-- Filter Section -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <form action="{{ route('expenses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex gap-2 flex-1">
                <select name="month" class="flex-1 px-3 py-2.5 border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-orange-500 focus:border-orange-500">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="w-24 px-3 py-2.5 border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-orange-500 focus:border-orange-500">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <select name="category" class="px-3 py-2.5 border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-orange-500 focus:border-orange-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-700 transition-colors shadow-sm text-sm">
                    Filter
                </button>
                @if(request('category'))
                    <a href="{{ route('expenses.index', ['month' => $month, 'year' => $year]) }}" class="px-3 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors border border-red-100 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Total Pengeluaran -->
        <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-red-600 rounded-xl p-5 shadow-lg text-white sm:col-span-2 lg:col-span-1">
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-white/10 rounded-full"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-xs font-medium bg-white/20 px-2 py-0.5 rounded">Bulan Ini</span>
                </div>
                <p class="text-white/80 text-sm font-medium mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-black">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Breakdown by Category -->
        @foreach($expenseByCategory->take(2) as $catData)
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-400 uppercase">{{ $catData->category }}</span>
                    <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded">{{ $catData->count }}x</span>
                </div>
                <p class="text-lg font-black text-slate-800">Rp {{ number_format($catData->total, 0, ',', '.') }}</p>
                @if($totalExpense > 0)
                    <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ min(($catData->total / $totalExpense) * 100, 100) }}%"></div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Expenses Table (Desktop) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-900 text-xs uppercase tracking-widest text-white font-bold">
                    <th class="px-6 py-4 rounded-tl-lg">Tanggal</th>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4 text-right">Jumlah</th>
                    <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($expenses as $expense)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-slate-600">{{ $expense->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $expense->title }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-lg bg-orange-100 text-orange-700 text-xs font-bold">
                                {{ $expense->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500">{{ $expense->description ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-red-600 font-mono">- Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="p-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form">
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
                        <td colspan="6" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                                <p class="text-lg font-medium text-slate-500">Belum ada pengeluaran</p>
                                <p class="text-sm">Mulai catat pengeluaran Anda.</p>
                                <a href="{{ route('expenses.create') }}" class="mt-4 px-4 py-2 bg-orange-50 text-orange-600 font-bold rounded-lg border border-orange-100 hover:bg-orange-100 transition-colors text-sm">
                                    + Tambah Pengeluaran
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($expenses as $expense)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-4 py-2.5 bg-slate-50 flex justify-between items-center border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-500">{{ $expense->created_at->format('d M Y') }}</span>
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-700">
                        {{ $expense->category }}
                    </span>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-slate-800 text-base">{{ $expense->title }}</h4>
                        <span class="font-mono font-bold text-red-600 text-base shrink-0 ml-2">- Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                    </div>
                    @if($expense->description)
                        <p class="text-xs text-slate-500 mb-3">{{ $expense->description }}</p>
                    @endif
                </div>
                <div class="px-4 py-2.5 bg-slate-50 flex justify-end gap-2 border-t border-slate-100">
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="px-3 py-1.5 bg-white text-blue-600 border border-blue-200 rounded-lg text-xs font-bold shadow-sm hover:bg-blue-50">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-white text-red-600 border border-red-200 rounded-lg text-xs font-bold shadow-sm hover:bg-red-50">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-slate-100">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                <p class="text-slate-500 font-medium">Belum ada pengeluaran</p>
                <a href="{{ route('expenses.create') }}" class="mt-3 inline-block px-4 py-2 bg-orange-50 text-orange-600 font-bold rounded-lg text-sm">+ Tambah</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-2">
        {{ $expenses->appends(request()->query())->links() }}
    </div>

    <!-- Delete Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Pengeluaran?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
</x-admin-layout>
