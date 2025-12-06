<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">
    <div class="w-full max-w-xl bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-2xl font-bold text-slate-800 text-center mb-6">
            To-Do List
        </h1>

        {{-- Form tambah tugas --}}
        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-4">
            @csrf
            <input
                type="text"
                name="title"
                placeholder="Tulis tugas baru..."
                required
                class="flex-1 px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
            >
            <button
                type="submit"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 active:scale-95 transition"
            >
                Tambah
            </button>
        </form>

        @error('title')
            <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
        @enderror

        <div class="bg-slate-50 rounded-lg border border-slate-200">
            <ul class="divide-y divide-slate-200">
                @forelse ($tasks as $task)
                    <li class="flex items-center justify-between px-3 py-2">
                        <div class="flex items-center gap-3">
                            {{-- Checkbox toggle selesai/belum --}}
                            <form
                                action="{{ route('tasks.toggle', $task) }}"
                                method="POST"
                                class="flex items-center"
                                id="toggle-task-{{ $task->id }}"
                            >
                                @csrf
                                @method('PATCH')
                                <input
                                    type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $task->is_done ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                >
                            </form>

                            <div>
                                <span class="text-sm {{ $task->is_done ? 'line-through text-slate-400' : 'text-slate-800' }}">
                                    {{ $task->title }}
                                </span>
                                <div class="text-[11px] text-slate-400">
                                    Dibuat: {{ $task->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>

                        {{-- Tombol hapus --}}
                        <form
                            action="{{ route('tasks.destroy', $task) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus tugas ini?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-xs px-2 py-1 rounded-md border border-red-200 text-red-600 hover:bg-red-50 transition"
                            >
                                Hapus
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="px-3 py-4 text-sm text-slate-500 text-center">
                        Belum ada tugas. Tambah dulu di atas.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</body>
</html>
