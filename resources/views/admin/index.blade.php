<x-layouts::app :title="'Data Admin'">

    <div class="p-6">

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Data Admin</h1>

            <a href="{{ route('admin.create') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Tambah Admin
            </a>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border px-4 py-3">No</th>
                        <th class="border px-4 py-3">Nama</th>
                        <th class="border px-4 py-3">Email</th>
                        <th class="border px-4 py-3">Role</th>
                        <th class="border px-4 py-3">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($admins as $admin)

                    <tr>

                        <td class="border px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $admin->name }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $admin->email }}
                        </td>

                        <td class="border px-4 py-3">
                            {{ $admin->role }}
                        </td>

                        <td class="border px-4 py-3">

                            <a href="{{ route('admin.edit',$admin->id) }}"
                               class="text-blue-600">
                                Edit
                            </a>

                            |

                            <form action="{{ route('admin.destroy',$admin->id) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Hapus admin?')"
                                        class="text-red-600">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="py-5 text-center">
                            Belum ada data admin.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-layouts::app>