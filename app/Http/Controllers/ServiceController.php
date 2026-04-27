<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->paginate(20);

        return view('admin.services.index', [
            'services' => $services,
            'pageTitle' => __('Gestion des services'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', __('Service cree avec succes.'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', __('Service mis a jour avec succes.'));
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', __('Service supprime avec succes.'));
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration' => ['required', 'integer', 'min:1', 'max:480'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'icon' => ['required', Rule::in([
                'stethoscope',
                'heart',
                'shield',
                'baby',
                'user-nurse',
                'bone',
                'droplet',
            ])],
        ];
    }
}
