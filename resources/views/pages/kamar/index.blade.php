<?php

use App\Models\Kamar;
use Livewire\Component;
use Flux\Flux;

new class extends Component
{
    public string $search = '';

    public string $filterStatus = '';
    public string $nomor = '';
    public string $harga = '';
    public string $status = 'Kosong';
    public string $keterangan = '';

    public ?int $deleteId = null;

    public ?int $editId = null;
    public string $editNomor = '';
    public string $editHarga = '';
    public string $editStatus = '';
    public string $editKeterangan = '';

    public function save()
    {
        $this->validate([
    'nomor' => 'required|unique:kamars,nomor_kamar',
    'harga' => 'required|numeric',
    'status' => 'required',
    ]);

      Kamar::create([
    'nomor_kamar' => $this->nomor,
    'harga' => $this->harga,
    'status' => $this->status,
    'keterangan' => $this->keterangan,
    ]);
    

        $this->reset('nomor', 'harga', 'keterangan');

        Flux::modal('create-kamar')->close();

        session()->flash('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);

        $this->editId = $kamar->id;
        $this->editNomor = $kamar->nomor_kamar;
        $this->editHarga = $kamar->harga;
        $this->editStatus = $kamar->status;
        $this->editKeterangan = $kamar->keterangan;

        Flux::modal('edit-kamar')->show();
    }

    public function update()
    {
        $this->validate([
           'editNomor' => 'required|unique:kamars,nomor_kamar,' . $this->editId,
            'editHarga' => 'required|numeric',
            'editStatus' => 'required',
        ]);

        Kamar::findOrFail($this->editId)->update([
    'nomor_kamar' => $this->editNomor,
            'harga' => $this->editHarga,
            'status' => $this->editStatus,
            'keterangan' => $this->editKeterangan,
        ]);

        Flux::modal('edit-kamar')->close();

        session()->flash('success', 'Data kamar berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;

        Flux::modal('delete-kamar')->show();
    }

    public function delete()
    {
        Kamar::findOrFail($this->deleteId)->delete();

        $this->deleteId = null;

        Flux::modal('delete-kamar')->close();

        session()->flash('success', 'Data kamar berhasil dihapus.');
    }

   public function getKamarsProperty()
{
    return Kamar::query()
        ->when($this->search, function ($query) {
            $query->where('nomor_kamar', 'like', '%' . $this->search . '%');
        })
        ->when($this->filterStatus, function ($query) {
            $query->where('status', $this->filterStatus);
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
                Data Kamar Kos
            </h1>

            <p class="text-zinc-500">
                Kelola data kamar kos.
            </p>

        </div>

        <flux:modal.trigger name="create-kamar">
            <flux:button variant="primary">
                Tambah Kamar
            </flux:button>
        </flux:modal.trigger>

    </div>

    <div class="flex gap-4">

    <flux:input
        wire:model.live="search"
        placeholder="Cari nomor kamar..."
        class="flex-1" />

    <flux:select wire:model.live="filterStatus">

        <option value="">Semua Status</option>
        <option value="Kosong">Kosong</option>
        <option value="Terisi">Terisi</option>

    </flux:select>

</div>

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

                    <th class="p-3 text-left">Nomor Kamar</th>

                    <th class="p-3 text-left">Harga</th>

                    <th class="p-3 text-left">Status</th>

                    <th class="p-3 text-left">Keterangan</th>

                    <th class="p-3 text-center">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($this->kamars as $kamar)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-3">
                        {{ $kamar->nomor_kamar }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($kamar->harga,0,',','.') }}
                    </td>

                    <td class="p-3">

                        @if($kamar->status == 'Kosong')

                            <span class="rounded-lg bg-green-100 px-3 py-1 text-green-700">
                                Kosong
                            </span>

                        @else

                            <span class="rounded-lg bg-red-100 px-3 py-1 text-red-700">
                                Terisi
                            </span>

                        @endif

                    </td>

                    <td class="p-3">
                        {{ $kamar->keterangan }}
                    </td>

                    

                       <td class="p-3 text-center space-x-2">

    <button
        type="button"
        wire:click="edit({{ $kamar->id }})"
        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
        Edit
    </button>

    <flux:button
    variant="danger"
    wire:click="confirmDelete({{ $kamar->id }})"
    >
    Hapus
</flux:button>
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="p-6 text-center">

                        Belum ada data kamar.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
          <!-- Modal Tambah Kamar -->

<flux:modal name="create-kamar" class="md:w-96">

    <form wire:submit="save" class="space-y-4">

        <flux:heading size="lg">
            Tambah Kamar
        </flux:heading>

        <flux:input
            wire:model="nomor"
            label="Nomor Kamar"
            placeholder="Contoh: A01" />

        <flux:input
            wire:model="harga"
            type="number"
            label="Harga" />

        <flux:select
            wire:model="status"
            label="Status">

            <option value="Kosong">Kosong</option>
            <option value="Terisi">Terisi</option>

        </flux:select>

        <flux:textarea
            wire:model="keterangan"
            label="Keterangan"
            placeholder="Contoh: Lantai 2, AC, Kamar Mandi Dalam" />

        <div class="flex justify-end gap-2">

            <flux:modal.close>
                <flux:button variant="ghost">
                    Batal
                </flux:button>
            </flux:modal.close>

            <flux:button
                type="submit"
                variant="primary">

                Simpan

            </flux:button>

        </div>

    </form>

</flux:modal>

<!-- Modal Edit -->

<flux:modal name="edit-kamar" class="md:w-96">

    <form wire:submit="update" class="space-y-4">

        <flux:heading size="lg">
            Edit Kamar
        </flux:heading>

        <flux:input
            wire:model="editNomor"
            label="Nomor Kamar" />

        <flux:input
            wire:model="editHarga"
            type="number"
            label="Harga" />

        <flux:select
            wire:model="editStatus"
            label="Status">

            <option value="Kosong">Kosong</option>
            <option value="Terisi">Terisi</option>

        </flux:select>

        <flux:textarea
            wire:model="editKeterangan"
            label="Keterangan" />

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

<!-- Modal Hapus -->

<flux:modal name="delete-kamar" class="md:w-96">

    <div class="space-y-4">

        <flux:heading size="lg">
            Hapus Kamar
        </flux:heading>

        <p class="text-zinc-600">
            Apakah Anda yakin ingin menghapus kamar ini?
        </p>

        <div class="flex justify-end gap-2">

            <flux:modal.close>
                <flux:button variant="ghost">
                    Batal
                </flux:button>
            </flux:modal.close>

            <flux:button
                variant="danger"
                wire:click="delete">

                Hapus

            </flux:button>

        </div>

    </div>

</flux:modal>

</div>