<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4" data-modal>
    <div class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-lg bg-white p-6 shadow-xl md:p-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ $eyebrow }}</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">{{ $title }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $description }}</p>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" data-modal-close="{{ $modalId }}" aria-label="{{ __('Fermer') }}">
                X
            </button>
        </div>

        <form method="POST" action="{{ $action }}" class="mt-8">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <input type="hidden" name="modal_target" value="{{ $modalId }}">
            @include('appointments._form')
        </form>
    </div>
</div>
