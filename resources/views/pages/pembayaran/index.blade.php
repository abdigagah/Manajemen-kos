<?php

use App\Models\Pembayaran;
use Livewire\Component;
use Flux\Flux;

new class extends Component
{
    public string $search = '';

    public string $nama_penyewa = '';
    public string $nomor_kamar = '';
    public string $bulan = '';
    public string $nominal = '';
    public string $status = 'Belum Lunas';

    public ?int $deleteId = null;

    public ?int $editId = null;
    public string $editNama = '';
    public string $editNomor = '';
    public string $editBulan = '';
    public string $editNominal = '';
    public string $editStatus = '';

    public function save()
    {
        $this->validate([
            'nama_penyewa' => 'required',
            'nomor_kamar' => 'required',
            'bulan' => 'required',
            'nominal' => 'required|numeric',
            'status' => 'required',
        ]);

        Pembayaran::create([
            'nama_penyewa' => $this->nama_penyewa,
            'nomor_kamar' => $this->nomor_kamar,
            'bulan' => $this->bulan,
            'nominal' => $this->nominal,
            'status' => $this->status,
        ]);

        $this->reset(
            'nama_penyewa',
            'nomor_kamar',
            'bulan',
            'nominal'
        );

        $this->status = 'Belum Lunas';

        Flux::modal('create-pembayaran')->close();

        session()->flash('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
{
    $pembayaran = Pembayaran::findOrFail($id);

    $this->editId = $pembayaran->id;
    $this->editNama = $pembayaran->nama_penyewa;
    $this->editNomor = $pembayaran->nomor_kamar;
    $this->editBulan = $pembayaran->bulan;
    $this->editNominal = $pembayaran->nominal;
    $this->editStatus = $pembayaran->status;

    Flux::modal('edit-pembayaran')->show();
}

public function update()
{
    $this->validate([
        'editNama' => 'required',
        'editNomor' => 'required',
        'editBulan' => 'required',
        'editNominal' => 'required|numeric',
        'editStatus' => 'required',
    ]);

    Pembayaran::findOrFail($this->editId)->update([
        'nama_penyewa' => $this->editNama,
        'nomor_kamar' => $this->editNomor,
        'bulan' => $this->editBulan,
        'nominal' => $this->editNominal,
        'status' => $this->editStatus,
    ]);

    Flux::modal('edit-pembayaran')->close();

    session()->flash('success', 'Data pembayaran berhasil diupdate.');
}
    public function confirmDelete($id)
{
    $this->deleteId = $id;

    Flux::modal('delete-pembayaran')->show();
}

public function delete()
{
    Pembayaran::findOrFail($this->deleteId)->delete();

    $this->deleteId = null;

    Flux::modal('delete-pembayaran')->close();

    session()->flash('success', 'Data pembayaran berhasil dihapus.');
}

    public function getPembayaransProperty()
    {
        return Pembayaran::where(function ($query) {
                $query->where('nama_penyewa', 'like', "%{$this->search}%")
                      ->orWhere('nomor_kamar', 'like', "%{$this->search}%");
            })
            ->latest()
            ->get();
    }
};

?>
<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold">
                Data Pembayaran
            </h1>

            <p class="text-zinc-500">
                Kelola data pembayaran penyewa.
            </p>

        </div>

        <flux:modal.trigger name="create-pembayaran">
            <flux:button variant="primary">
                Tambah Pembayaran
            </flux:button>
        </flux:modal.trigger>

    </div>

    <flux:input
        wire:model.live="search"
        placeholder="Cari pembayaran..." />

    @if(session()->has('success'))
        <flux:callout variant="success">
            {{ session('success') }}
        </flux:callout>
    @endif
    <div class="overflow-hidden rounded-xl border">

    <table class="min-w-full">

        <thead class="bg-zinc-100 dark:bg-zinc-800">
    <tr>
        <th class="p-3 text-left">No</th>
        <th class="p-3 text-left">Nama Penyewa</th>
        <th class="p-3 text-left">Nomor Kamar</th>
        <th class="p-3 text-left">Bulan</th>
        <th class="p-3 text-left">Nominal</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-center">Aksi</th>
    </tr>
</thead>

        <tbody>

        @forelse($this->pembayarans as $pembayaran)

            <tr class="border-t">

                <td class="p-3">{{ $loop->iteration }}</td>

                <td class="p-3">{{ $pembayaran->nama_penyewa }}</td>

                <td class="p-3">{{ $pembayaran->nomor_kamar }}</td>

                <td class="p-3">{{ $pembayaran->bulan }}</td>

                <td class="p-3">
                    Rp {{ number_format($pembayaran->nominal,0,',','.') }}
                </td>

                <td class="p-3">

                    @if($pembayaran->status=='Lunas')

                        <span class="rounded-lg bg-green-100 px-3 py-1 text-green-700">
                            Lunas
                        </span>

                    @else

                        <span class="rounded-lg bg-red-100 px-3 py-1 text-red-700">
                            Belum Lunas
                        </span>

                    @endif

                </td>
               <td class="p-3 text-center space-x-2">

    <button
        type="button"
        wire:click="edit({{ $pembayaran->id }})"
        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
        Edit
    </button>

    <button
        type="button"
        wire:click="confirmDelete({{ $pembayaran->id }})"
        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
        Hapus
    </button>

</td>
            </tr>

        @empty

            <tr>
                <td colspan="7" class="p-6 text-center">
                    Belum ada data pembayaran.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
    <flux:modal name="edit-pembayaran" class="md:w-96">

    <form wire:submit="update" class="space-y-4">

        <flux:heading size="lg">
            Edit Pembayaran
        </flux:heading>

        <flux:input
            wire:model="editNama"
            label="Nama Penyewa" />

        <flux:input
            wire:model="editNomor"
            label="Nomor Kamar" />

        <flux:input
            wire:model="editBulan"
            label="Bulan" />

        <flux:input
            wire:model="editNominal"
            type="number"
            label="Nominal" />

        <flux:select
            wire:model="editStatus"
            label="Status">

            <option value="Belum Lunas">Belum Lunas</option>
            <option value="Lunas">Lunas</option>

        </flux:select>

        <div class="flex justify-end gap-2">

            <flux:modal.close>
                <flux:button variant="ghost">
                    Batal
                </flux:button>
            </flux:modal.close>

            <flux:button
                type="submit"
                variant="primary">
                Update
            </flux:button>

        </div>

    </form>

</flux:modal>

</div>