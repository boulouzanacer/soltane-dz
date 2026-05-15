@extends('layouts.fournisseur')

@section('content')
<div class="space-y-4">
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-red-200">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <div>
            <div class="text-2xl font-extrabold tracking-wide">{{ $user->nom }}</div>
            <div class="mt-1 text-sm text-white/60">{{ $user->email }}</div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ url('/fournisseur/utilisateurs') }}"
               class="rounded-2xl px-4 py-3 font-bold border border-white/10 hover:bg-white/10">
                Retour
            </a>
            <a href="{{ url('/fournisseur/utilisateurs/'.$user->id.'/edit') }}"
               class="rounded-2xl px-4 py-3 font-extrabold text-white"
               style="background: linear-gradient(135deg, var(--frs-primary), #0A3D7A);">
                Modifier
            </a>
        </div>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[var(--frs-card)] p-6">
        <div class="text-lg font-extrabold tracking-wide">Nouvelle tâche</div>
        <form method="POST" action="{{ url('/fournisseur/utilisateurs/'.$user->id.'/taches') }}" class="mt-4 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-white/70 mb-1">Titre</label>
                    <input name="titre"
                           value="{{ old('titre') }}"
                           class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white/70 mb-1">Statut</label>
                    <select name="statut"
                            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]"
                            required>
                        <option value="todo" @selected(old('statut', 'todo') === 'todo')>todo</option>
                        <option value="in_progress" @selected(old('statut') === 'in_progress')>in_progress</option>
                        <option value="done" @selected(old('statut') === 'done')>done</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white/70 mb-1">Échéance (optionnel)</label>
                    <input type="date"
                           name="due_date"
                           value="{{ old('due_date') }}"
                           class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-white/70 mb-1">Description (optionnel)</label>
                    <textarea name="description"
                              rows="3"
                              class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="rounded-2xl px-6 py-3 font-extrabold text-white"
                        style="background: linear-gradient(135deg, var(--frs-primary), #0A3D7A);">
                    Ajouter
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[var(--frs-card)] overflow-hidden">
        <div class="p-5 border-b border-white/10 font-extrabold tracking-wide">Tâches</div>
        <div class="divide-y divide-white/10">
            @forelse($tasks as $t)
                @php
                    $st = (string)($t->statut ?? 'todo');
                    $badge = match($st) {
                        'todo' => 'bg-amber-500/15 text-amber-200 border border-amber-400/20',
                        'in_progress' => 'bg-sky-500/15 text-sky-200 border border-sky-400/20',
                        'done' => 'bg-emerald-500/15 text-emerald-200 border border-emerald-400/20',
                        default => 'bg-white/10 text-white/70 border border-white/10',
                    };
                @endphp
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $badge }}">{{ $st }}</span>
                                @if(($t->due_date ?? null))
                                    <span class="text-xs text-white/60">Échéance: {{ \Illuminate\Support\Carbon::parse($t->due_date)->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <form method="POST" action="{{ url('/fournisseur/utilisateurs/'.$user->id.'/taches/'.$t->id) }}"
                              onsubmit="return confirm('Supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-xl px-3 py-2 text-xs font-extrabold border border-red-400/20 bg-red-500/10 text-red-200 hover:bg-red-500/15">
                                Supprimer
                            </button>
                        </form>
                    </div>

                    <form method="POST" action="{{ url('/fournisseur/utilisateurs/'.$user->id.'/taches/'.$t->id) }}" class="mt-4 space-y-3">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-white/60 mb-1">Titre</label>
                                <input name="titre"
                                       value="{{ old('titre', $t->titre) }}"
                                       class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]"
                                       required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white/60 mb-1">Statut</label>
                                <select name="statut"
                                        class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]"
                                        required>
                                    <option value="todo" @selected(old('statut', (string)$t->statut) === 'todo')>todo</option>
                                    <option value="in_progress" @selected(old('statut', (string)$t->statut) === 'in_progress')>in_progress</option>
                                    <option value="done" @selected(old('statut', (string)$t->statut) === 'done')>done</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white/60 mb-1">Échéance</label>
                                <input type="date"
                                       name="due_date"
                                       value="{{ old('due_date', $t->due_date ? \Illuminate\Support\Carbon::parse($t->due_date)->format('Y-m-d') : '') }}"
                                       class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-white/60 mb-1">Description</label>
                                <textarea name="description"
                                          rows="3"
                                          class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 outline-none focus:border-[var(--frs-primary)]">{{ old('description', $t->description) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="rounded-xl px-4 py-2 text-xs font-extrabold text-white"
                                    style="background: linear-gradient(135deg, var(--frs-primary), #0A3D7A);">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="p-10 text-center text-white/60">Aucune tâche</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

