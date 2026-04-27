<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4" data-modal>
    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-rose-700">{{ __('Suppression') }}</p>
                <h2 class="mt-1 text-xl font-semibold text-slate-900">{{ $title }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $message }}</p>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" data-modal-close="{{ $modalId }}" aria-label="{{ __('Fermer') }}">
                X
            </button>
        </div>

        <form method="POST" action="{{ $action }}" class="mt-6">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-3">
                <button type="button" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50" data-modal-close="{{ $modalId }}">
                    {{ __('Annuler') }}
                </button>
                <button type="submit" class="rounded-md bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600">
                    {{ __('Supprimer') }}
                </button>
            </div>
        </form>
    </div>
</div>
