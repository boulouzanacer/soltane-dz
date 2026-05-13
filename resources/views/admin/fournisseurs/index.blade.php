@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <form id="fournisseursFiltersForm" method="GET" action="{{ url('/admin/fournisseurs') }}" class="flex items-center gap-2 w-full md:w-auto">
            <div class="relative w-full md:w-[340px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                <input id="fournisseursSearchInput"
                       name="q"
                       value="{{ $q }}"
                       placeholder="Rechercher nom ou email..."
                       class="w-full rounded-2xl border border-white/10 bg-[var(--admin-card)] pl-11 pr-4 py-3 outline-none focus:border-[var(--admin-primary)]">
            </div>
            <button type="submit" class="hidden">Filtrer</button>
        </form>

        <a href="{{ url('/admin/fournisseurs/create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-3 font-bold text-white"
           style="background: linear-gradient(135deg, var(--admin-primary), #0A3D7A);">
            <i class="fa-solid fa-plus"></i>
            Nouveau fournisseur
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-white/10 bg-[var(--admin-card)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-white/60">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold">Nom</th>
                        <th class="text-left py-3 px-4 font-semibold">Email</th>
                        <th class="text-left py-3 px-4 font-semibold">Tel</th>
                        <th class="text-left py-3 px-4 font-semibold">Wilaya</th>
                        <th class="text-left py-3 px-4 font-semibold">Statut</th>
                        <th class="text-right py-3 px-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($fournisseurs as $f)
                        <tr class="hover:bg-white/5">
                            <td class="py-3 px-4 font-semibold">{{ $f->nom_frs }}</td>
                            <td class="py-3 px-4 text-white/80">{{ $f->email }}</td>
                            <td class="py-3 px-4 text-white/80">{{ $f->telephone }}</td>
                            <td class="py-3 px-4 text-white/80">{{ $f->wilaya_nom }}</td>
                            <td class="py-3 px-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ (int)$f->actif === 1 ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-400/20' : 'bg-red-500/15 text-red-300 border border-red-400/20' }}">
                                        {{ (int)$f->actif === 1 ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ url('/admin/fournisseurs/'.$f->id.'/toggle-actif') }}">
                                        @csrf
                                        <label class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="checkbox"
                                                   class="sr-only peer"
                                                   onchange="this.form.submit()"
                                                   @checked((int)$f->actif === 1)>
                                            <div class="w-11 h-6 rounded-full bg-white/15 peer-checked:bg-[var(--admin-primary)] transition"></div>
                                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                                        </label>
                                    </form>

                                    <a href="{{ url('/admin/fournisseurs/'.$f->id.'/edit') }}"
                                       class="h-9 w-9 inline-flex items-center justify-center rounded-xl text-xs font-bold border border-white/10 hover:bg-white/10"
                                       title="Éditer"
                                       aria-label="Éditer">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form method="POST" action="{{ url('/admin/fournisseurs/'.$f->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Supprimer ce fournisseur ?')"
                                                class="h-9 w-9 inline-flex items-center justify-center rounded-xl text-xs font-bold border border-red-400/20 text-red-300 hover:bg-red-500/10"
                                                title="Supprimer"
                                                aria-label="Supprimer">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-white/60">Aucun fournisseur</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $fournisseurs->links() }}
    </div>

</div>
<script>
(() => {
    const form = document.getElementById('fournisseursFiltersForm');
    const input = document.getElementById('fournisseursSearchInput');
    if (!form || !input) return;

    let t = null;
    const submit = () => {
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
            return;
        }
        form.submit();
    };

    input.addEventListener('input', () => {
        if (t) clearTimeout(t);
        t = setTimeout(() => submit(), 400);
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            if (t) clearTimeout(t);
            submit();
        }
    });
})();
</script>
@endsection
