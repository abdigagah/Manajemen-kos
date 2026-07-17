@php
use App\Models\User;
use App\Models\Kamar;

$totalAdmin = User::where('role', 'admin')->count();

$totalKamar = Kamar::count();

$kamarKosong = Kamar::where('status', 'Kosong')->count();

$kamarTerisi = Kamar::where('status', 'Terisi')->count();
@endphp
<x-layouts::app :title="__('Dashboard')">

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-bold">Dashboard Manajemen Kos</h1>
            <p class="text-gray-500">
                Selamat Datang, <b>{{ auth()->user()->name }}</b>
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">

            <div class="rounded-xl bg-blue-500 p-6 shadow">
    <h2 class="text-lg font-semibold text-white">
        Total Kamar
    </h2>

    <h1 class="mt-3 text-4xl font-bold text-white">
        {{ $totalKamar }}
    </h1>
</div>

            <div class="rounded-xl bg-green-500 p-6 text-white shadow">
                <h2 class="text-lg">Kamar Kosong</h2>
               <h1 class="mt-3 text-4xl font-bold">
    {{ $kamarKosong }}
</h1>
            </div>

            <div class="rounded-xl bg-red-500 p-6 text-white shadow">
                <h2 class="text-lg">Kamar Terisi</h2>
                <h1 class="mt-3 text-4xl font-bold">
    {{ $kamarTerisi }}
</h1>
            </div>

           <div class="rounded-xl bg-yellow-500 p-6 text-white shadow">
    <h2 class="text-lg">Total Admin</h2>
    <h1 class="mt-3 text-4xl font-bold">
        {{ $totalAdmin }}
    </h1>
</div>

        </div>
</x-layouts::app>