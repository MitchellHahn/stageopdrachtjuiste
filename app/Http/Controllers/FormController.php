<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use LogicException;
use Redirect;
use Str;

class FormController extends Controller {

    public function index(): View {
        $forms = Form::all();

        return view('admin.forms.index', compact('forms'));
    }

    public function create(): View {
        return view('admin.forms.edit');
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'route' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'body' => ['nullable', 'string'],
            'status' => [new Enum(StatusEnum::class)],
        ]);

        $form = new Form();
        $form->name = $validated['name'];
        $form->slug = Str::slug($validated['name']);
        $form->route = $validated['route'];
        $form->body = $validated['body'];
        $form->start_date = $validated['start_date'];
        $form->end_date = $validated['end_date'];
        $form->status = $validated['status'];
        $form->save();

        return Redirect::route('admin.forms.index');
    }

    public function edit(Form $form): View {
        return view('admin.forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'route' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'body' => ['nullable', 'string'],
            'status' => [new Enum(StatusEnum::class)],
        ]);

        $form->name = $validated['name'];
        $form->slug = Str::slug($validated['name']);
        $form->route = $validated['route'];
        $form->start_date = $validated['start_date'];
        $form->end_date = $validated['end_date'];
        $form->body = $validated['body'];
        $form->status = $validated['status'];
        $form->save();

        return Redirect::route('admin.forms.index');
    }

    public function delete(Form $form): RedirectResponse {
        try {
            $form->delete();
        } catch(LogicException $e) {
            report($e);

            return Redirect::back()
                ->withInput()
                ->withErrors(['general' => 'Er is iets misgegaan met het verwijderen van de gebruiker.']);
        }

        return Redirect::route('admin.forms.index');
    }
}
