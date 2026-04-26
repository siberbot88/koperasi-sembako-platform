<div>
    <x-slot:header>Dashboard</x-slot:header>

    @if($store)
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        {{-- Revenue Today --}}
        <div class="card-bordered p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-koperasi-primary/40 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-medium">Pendapatan Hari Ini</p>
                    <p class="text-lg font-bold text-koperasi-black">Rp {{ number_format($stats['revenue_today'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Orders Today --}}
        <div class="card-bordered p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-koperasi-accent/40 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-medium">Pesanan Hari Ini</p>
                    <p class="text-lg font-bold text-koperasi-black">{{ $stats['total_orders_today'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="card-bordered p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-medium">Perlu Diproses</p>
                    <p class="text-lg font-bold text-orange-600">{{ ($stats['pending_orders'] ?? 0) + ($stats['processing_orders'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="card-bordered p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] text-koperasi-dark/50 uppercase tracking-wider font-medium">Stok Menipis</p>
                    <p class="text-lg font-bold text-red-600">{{ $stats['low_stock'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats Row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="card p-3 text-center">
            <p class="text-2xl font-bold text-koperasi-black">{{ $stats['total_products'] ?? 0 }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-0.5">Total Produk</p>
        </div>
        <div class="card p-3 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $stats['active_products'] ?? 0 }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-0.5">Produk Aktif</p>
        </div>
        <div class="card p-3 text-center">
            <p class="text-2xl font-bold text-orange-600">{{ $stats['low_stock'] ?? 0 }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-0.5">Stok Rendah</p>
        </div>
        <div class="card p-3 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $stats['out_of_stock'] ?? 0 }}</p>
            <p class="text-[10px] text-koperasi-dark/50 mt-0.5">Stok Habis</p>
        </div>
    </div>

    {{-- Analytics Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        {{-- Retention Chart --}}
        <div class="lg:col-span-8 card-bordered p-4 bg-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-sm text-koperasi-black">Retensi Pembelian</h3>
                    <p class="text-[10px] text-koperasi-dark/50">Persentase repeat order harian (30 hari terakhir)</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-1 bg-koperasi-primary/20 rounded-lg border border-koperasi-primary/30">% Repeat Order</span>
            </div>
            <div id="retention-chart" style="min-height: 300px;"></div>
        </div>

        {{-- Category Pie Chart --}}
        <div class="lg:col-span-4 card-bordered p-4 bg-white flex flex-col">
            <h3 class="font-bold text-sm text-koperasi-black mb-1">Kategori Terlaris</h3>
            <p class="text-[10px] text-koperasi-dark/50 mb-4">Berdasarkan kuantitas terjual</p>
            <div class="flex-1 flex items-center justify-center">
                <div id="category-pie-chart" class="w-full" style="min-height: 280px;"></div>
            </div>
        </div>

        {{-- Category Treemap --}}
        <div class="lg:col-span-12 card-bordered p-4 bg-white">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-sm text-koperasi-black">Distribusi Volume Kategori</h3>
                    <p class="text-[10px] text-koperasi-dark/50">Visualisasi perbandingan volume antar kategori produk</p>
                </div>
            </div>
            <div id="category-treemap" style="min-height: 350px;"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            initCharts();
        });

            initCharts();

        function initCharts() {
            // Destroy existing charts if any to prevent duplicates
            window.ApexCharts && window.ApexCharts.exec && window.ApexCharts.exec('retention-chart', 'destroy');
            window.ApexCharts && window.ApexCharts.exec && window.ApexCharts.exec('category-pie-chart', 'destroy');
            window.ApexCharts && window.ApexCharts.exec && window.ApexCharts.exec('category-treemap', 'destroy');

            const brandColors = ['#FFD700', '#1E1E1E', '#FDE68A', '#4B5563', '#FACC15', '#374151', '#EAB308', '#6B7280'];

            // 1. Retention Chart
            const retentionData = @json($dailyRetention);
            if (document.getElementById('retention-chart')) {
                new ApexCharts(document.getElementById('retention-chart'), {
                    chart: {
                        id: 'retention-chart',
                        type: 'area',
                        height: 300,
                        toolbar: { show: false },
                        zoom: { enabled: false },
                        fontFamily: 'Inter, sans-serif',
                        animations: { enabled: true }
                    },
                    series: [{
                        name: 'Retention Rate',
                        data: retentionData.map(d => ({ x: d.x, y: d.y }))
                    }],
                    colors: ['#FFD700'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3, colors: ['#FFD700'] },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
                    xaxis: {
                        type: 'datetime',
                        labels: { style: { fontSize: '10px', fontWeight: 500 } },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: { 
                            formatter: (val) => val + '%',
                            style: { fontSize: '10px', fontWeight: 500 } 
                        },
                        max: 100,
                        tickAmount: 5
                    },
                    tooltip: {
                        theme: 'light',
                        x: { format: 'dd MMM' },
                        y: { formatter: (val) => val + '%' }
                    }
                }).render();
            }

            // 2. Category Pie Chart
            const topCategories = @json($topCategories);
            if (document.getElementById('category-pie-chart')) {
                new ApexCharts(document.getElementById('category-pie-chart'), {
                    chart: {
                        id: 'category-pie-chart',
                        type: 'donut',
                        height: 280,
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: Object.values(topCategories),
                    labels: Object.keys(topCategories),
                    colors: brandColors,
                    legend: { position: 'bottom', fontSize: '10px', fontWeight: 600 },
                    dataLabels: { enabled: false },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    name: { show: true, fontSize: '10px', fontWeight: 600 },
                                    value: { show: true, fontSize: '16px', fontWeight: 800 },
                                    total: { show: true, label: 'TOTAL QTY', fontSize: '10px', fontWeight: 700 }
                                }
                            }
                        }
                    }
                }).render();
            }

            // 3. Category Treemap
            const categoryStats = @json($categoryStats);
            if (document.getElementById('category-treemap')) {
                new ApexCharts(document.getElementById('category-treemap'), {
                    chart: {
                        id: 'category-treemap',
                        height: 350,
                        type: 'treemap',
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: [{
                        data: Object.entries(categoryStats).map(([key, val]) => ({ x: key, y: val }))
                    }],
                    colors: brandColors,
                    plotOptions: {
                        treemap: {
                            distributed: true,
                            enableShades: false
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: { fontSize: '12px', fontWeight: 'bold' },
                        offsetY: -4
                    }
                }).render();
            }
        }
    </script>
    @endpush

    {{-- Recent Orders --}}
    <div class="card-bordered">
        <div class="flex items-center justify-between px-4 py-3 border-b border-koperasi-dark/10">
            <h3 class="font-bold text-sm text-koperasi-black">Pesanan Terbaru</h3>
            <a href="{{ route('seller.orders') }}" class="text-xs font-medium text-koperasi-dark/60 hover:text-koperasi-black transition-colors" wire:navigate>Lihat semua &rarr;</a>
        </div>

        @if($recentOrders->count())
        <div class="table-wrapper border-0 rounded-none">
            <table class="table-base">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="font-mono text-xs font-semibold">{{ $order->order_number }}</td>
                        <td class="text-sm">{{ $order->user?->name ?? '-' }}</td>
                        <td class="text-sm font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'ready' => 'bg-green-100 text-green-800 border-green-300',
                                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                                    'completed' => 'bg-koperasi-accent text-koperasi-dark border-koperasi-dark/20',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="text-xs text-koperasi-dark/60">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state py-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg>
            <h3>Belum ada pesanan</h3>
            <p>Pesanan baru akan muncul di sini</p>
        </div>
        @endif
    </div>

    @else
    {{-- No Store --}}
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
        </svg>
        <h3>Toko belum dibuat</h3>
        <p>Hubungi admin untuk mengaktifkan toko Anda</p>
    </div>
    @endif
</div>
