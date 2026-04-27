<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4" data-modal>
    <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $title }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Renseignez les informations du service.') }}</p>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" data-modal-close="{{ $modalId }}" aria-label="{{ __('Fermer') }}">
                X
            </button>
        </div>

        <form method="POST" action="{{ $action }}" class="mt-6 space-y-4">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <input type="hidden" name="modal_target" value="{{ $modalId }}">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-name">{{ __('Nom du service (FR)') }} *</label>
                    <input id="{{ $modalId }}-name" name="name" type="text" value="{{ old('modal_target') === $modalId ? old('name') : $serviceModel?->name }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-duration">{{ __('Duree (minutes)') }} *</label>
                    <input id="{{ $modalId }}-duration" name="duration" type="number" min="1" max="480" value="{{ old('modal_target') === $modalId ? old('duration') : ($serviceModel?->duration ?? 30) }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-price">{{ __('Prix (Dh)') }} *</label>
                    <input id="{{ $modalId }}-price" name="price" type="number" min="0" step="0.01" max="999999.99" value="{{ old('modal_target') === $modalId ? old('price') : ($serviceModel?->price ?? '0.00') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-color">{{ __('Couleur ') }} *</label>
                    <div class="flex gap-2">
                        <input id="{{ $modalId }}-color" name="color" type="text" value="{{ old('modal_target') === $modalId ? old('color') : ($serviceModel?->color ?? '#3B82F6') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none" placeholder="#3B82F6">
                        <span class="inline-flex items-center rounded-md border border-slate-300 px-2" data-color-preview style="background-color: {{ old('modal_target') === $modalId ? old('color') : ($serviceModel?->color ?? '#3B82F6') }};">
                            <span class="h-4 w-4 rounded"></span>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-icon">{{ __('Icone') }} *</label>
                    @php
                        $icons = [
                            'stethoscope' => 'Stethoscope',
                            'heart' => 'Coeur',
                            'shield' => 'Bouclier',
                            'baby' => 'Bebe',
                            'user-nurse' => 'Infirmier',
                            'bone' => 'Os',
                            'droplet' => 'Goutte',
                        ];
                        $selectedIcon = old('modal_target') === $modalId ? old('icon', 'stethoscope') : ($serviceModel?->icon ?? 'stethoscope');
                    @endphp
                    <select id="{{ $modalId }}-icon" name="icon" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                        @foreach ($icons as $value => $label)
                            <option value="{{ $value }}" @selected($selectedIcon === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-description">{{ __('Description') }}</label>
                <textarea id="{{ $modalId }}-description" name="description" rows="3" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">{{ old('modal_target') === $modalId ? old('description') : $serviceModel?->description }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input id="{{ $modalId }}-is_active" name="is_active" type="checkbox" @checked(old('modal_target') === $modalId ? old('is_active') : ($serviceModel?->is_active ?? true)) class="h-4 w-4 rounded border-slate-300 text-rose-700 focus:ring-rose-700">
                <label for="{{ $modalId }}-is_active" class="text-sm font-medium text-slate-700">{{ __('Service actif') }}</label>
            </div>

            @if ($errors->any() && old('modal_target') === $modalId)
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-end gap-3">
                <button type="button" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50" data-modal-close="{{ $modalId }}">
                    {{ __('Annuler') }}
                </button>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById(@js($modalId));
        const colorInput = document.getElementById(@js($modalId . '-color'));
        const colorPreview = modal?.querySelector('[data-color-preview]');

        if (!colorInput || !colorPreview) {
            return;
        }

        colorInput.addEventListener('input', function () {
            colorPreview.style.backgroundColor = this.value;
        });
    });
</script>
