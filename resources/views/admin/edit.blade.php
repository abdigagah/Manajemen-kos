<x-layouts::app :title="'Edit Admin'">

    <div class="max-w-4xl mx-auto p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    Edit Admin
                </h1>
                <p class="text-gray-500 dark:text-gray-400">
                    Ubah data administrator.
                </p>
            </div>

            <a href="{{ route('admin.index') }}"
                class="rounded-lg bg-gray-600 px-5 py-2.5 text-white hover:bg-gray-700 transition">
                ← Kembali
            </a>
        </div>

        <!-- Card -->
        <div class="rounded-xl bg-white dark:bg-zinc-900 shadow-lg border border-gray-200 dark:border-zinc-700 p-8">

            <form action="{{ route('admin.update', $admin->id) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $admin->name) }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $admin->email) }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <!-- Tombol -->
                <div class="mt-8 flex gap-3">

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">
                        Update
                    </button>

                    <a href="{{ route('admin.index') }}"
                        class="rounded-lg bg-gray-500 px-6 py-3 text-white font-semibold hover:bg-gray-600 transition">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>