<x-layouts::app :title="'Tambah Admin'">

    <div class="max-w-3xl mx-auto p-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">
                Tambah Admin
            </h1>

            <a href="{{ route('admin.index') }}"
                class="rounded-lg bg-gray-500 px-5 py-2 text-white hover:bg-gray-600">
                ← Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow p-6">

            <form action="{{ route('admin.store') }}" method="POST">

                @csrf

                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="w-full rounded-lg border p-3"
                        required>

                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="w-full rounded-lg border p-3"
                        required>

                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-lg border p-3"
                        required>

                </div>

                <div class="flex gap-3 mt-8">

                    <button
                        type="submit"
                        class="rounded-lg bg-green-600 px-6 py-3 text-white hover:bg-green-700">

                        💾 Simpan

                    </button>

                    <a href="{{ route('admin.index') }}"
                        class="rounded-lg bg-gray-500 px-6 py-3 text-white hover:bg-gray-600">

                        ← Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>