<?php

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Flux\Flux;

new class extends Component
{
    public string $search = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';

    public ?int $deleteId = null;
    public ?int $editId = null;
    public string $editName = '';
    public string $editEmail = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'admin',
        ]);

        $this->reset('name', 'email', 'password');

        Flux::modal('create-admin')->close();

        session()->flash('success', 'Admin berhasil ditambahkan.');
    }

   public function confirmDelete($id)
{
    $this->deleteId = $id;
     Flux::modal('delete-admin')->show();
}
public function delete()
{
    User::findOrFail($this->deleteId)->delete();

    $this->deleteId = null;

     Flux::modal('delete-admin')->close();

     $this->dispatch('$refresh');
     
    session()->flash('success', 'Admin berhasil dihapus.');
}
public function edit($id)
{
    $admin = User::findOrFail($id);

    $this->editId = $admin->id; 
    $this->editName = $admin->name;
    $this->editEmail = $admin->email;

    Flux::modal('edit-admin')->show();
}   
public function update()
{
    $this->validate([
        'editName' => 'required|min:3',
        'editEmail' => 'required|email|unique:users,email,' . $this->editId,
    ]);

    User::findOrFail($this->editId)->update([
        'name' => $this->editName,
        'email' => $this->editEmail,
    ]);

    Flux::modal('edit-admin')->close();

    session()->flash('success', 'Admin berhasil diupdate.');
}

    public function getAdminsProperty()
    {
        return User::where('role', 'admin')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
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
                Data Admin
            </h1>

            <p class="text-zinc-500">
                Kelola data administrator.
            </p>
        </div>

        <flux:modal.trigger name="create-admin">
            <flux:button variant="primary">
                Tambah Admin
            </flux:button>
        </flux:modal.trigger>

    </div>

    <flux:input
        wire:model.live="search"
        placeholder="Cari admin..." />

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
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($this->admins as $admin)

                    <tr class="border-t">

                        <td class="p-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="p-3">
                            {{ $admin->name }}
                        </td>

                        <td class="p-3">
                            {{ $admin->email }}
                        </td>

                        <td class="p-3">
                            {{ $admin->role }}
                        </td>

                        <td class="p-3 text-center space-x-2">

                 <button
                type="button"
                wire:click="edit({{ $admin->id }})"
                class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Edit
                 </button>
              <button
    type="button"
    wire:click="confirmDelete({{ $admin->id }})"
    class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">

    Hapus

</button>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-6 text-center">
                            Belum ada data admin.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- Modal Tambah Admin -->

    <flux:modal name="create-admin" class="md:w-96">

        <form wire:submit="save" class="space-y-4">

            <flux:heading size="lg">
                Tambah Admin
            </flux:heading>

            <flux:input
                wire:model="name"
                label="Nama"
                placeholder="Masukkan nama" />

            <flux:input
                wire:model="email"
                type="email"
                label="Email"
                placeholder="Masukkan email" />

            <flux:input
                wire:model="password"
                type="password"
                label="Password"
                placeholder="Masukkan password" />

            <div class="flex justify-end gap-2">

                <flux:modal.close>
                    <flux:button variant="ghost">
                        Batal
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">
                    Simpan
                </flux:button>

            </div>

        </form>

    </flux:modal>
    <flux:modal name="edit-admin" class="md:w-96">

    <form wire:submit="update" class="space-y-4">

        <flux:heading size="lg">
            Edit Admin
        </flux:heading>

        <flux:input
            wire:model="editName"
            label="Nama" />

        <flux:input
            wire:model="editEmail"
            type="email"
            label="Email" />

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
<flux:modal name="delete-admin" class="md:w-96">

    <div class="space-y-4">

        <flux:heading size="lg">
            Hapus Admin
        </flux:heading>

        <p class="text-zinc-600">
            Apakah Anda yakin ingin menghapus admin ini?
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