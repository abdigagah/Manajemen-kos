@php
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pembayaran;

try {
    $totalAdmin = User::where('role', 'admin')->count();
    $totalKamar = Kamar::count();
    $kamarKosong = Kamar::where('status', 'Kosong')->count();
    $kamarTerisi = Kamar::where('status', 'Terisi')->count();
    $totalPembayaran = Pembayaran::sum('nominal');
    $totalTransaksi = Pembayaran::count();
    $totalLunas = Pembayaran::where('status', 'Lunas')->count();
    $totalBelumLunas = Pembayaran::where('status', 'Belum Lunas')->count();
} catch (\Exception $e) {
    dd($e->getMessage());
}
@endphp

<x-layouts::app :title="__('Dashboard')">

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-bold">
                Dashboard Manajemen Kos
            </h1>

            <p class="text-gray-500">
                Selamat Datang,
                <b>{{ auth()->user()->name }}</b>
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

            <!-- Total Kamar -->
            <div class="rounded-xl bg-blue-500 p-6 text-white shadow">
                <h2 class="text-lg font-semibold">
                    Total Kamar
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $totalKamar }}
                </h1>
            </div>

            <!-- Kamar Kosong -->
            <div class="rounded-xl bg-green-500 p-6 text-white shadow">
                <h2 class="text-lg">
                    Kamar Kosong
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $kamarKosong }}
                </h1>
            </div>

            <!-- Kamar Terisi -->
            <div class="rounded-xl bg-red-500 p-6 text-white shadow">
                <h2 class="text-lg">
                    Kamar Terisi
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $kamarTerisi }}
                </h1>
            </div>

            <!-- Total Admin -->
            <div class="rounded-xl bg-yellow-500 p-6 text-white shadow">
                <h2 class="text-lg">
                    Total Admin
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $totalAdmin }}
                </h1>
            </div>

            <!-- Total Pembayaran -->
            <div class="rounded-xl bg-purple-600 p-6 text-white shadow">
                <h2 class="text-lg">
                    Total Pembayaran
                </h2>

                <h1 class="mt-3 text-3xl font-bold">
                    Rp {{ number_format($totalPembayaran,0,',','.') }}
                </h1>
            </div>

            <!-- Total Transaksi -->
            <div class="rounded-xl bg-indigo-600 p-6 text-white shadow">
                <h2 class="text-lg">
                    Total Transaksi
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $totalTransaksi }}
                </h1>
            </div>

            <!-- Pembayaran Lunas -->
            <div class="rounded-xl bg-emerald-600 p-6 text-white shadow">
                <h2 class="text-lg">
                    Pembayaran Lunas
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $totalLunas }}
                </h1>
            </div>

            <!-- Belum Lunas -->
            <div class="rounded-xl bg-rose-600 p-6 text-white shadow">
                <h2 class="text-lg">
                    Belum Lunas
                </h2>

                <h1 class="mt-3 text-4xl font-bold">
                    {{ $totalBelumLunas }}
                </h1>
            </div>

        </div>

    </div>

</x-layouts::app>