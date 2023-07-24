<?php

namespace App\Http\Controllers;
use App\Models\tim;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class timController extends Controller
{
    public function create(): View
    {
        return view('tim.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'nama' => 'required|min:5',
        ]);

        tim::create([
            'nama' => $request->nama,

        ]);
        return redirect()->route('index')->with(['success' => 'Data tim Tersimpan']);
    }

    public function show(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.detail', compact('tim'));
    }

    public function edit(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.edit', compact('tim'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'nama' => 'required|min:5',
        ]);

        $tim = tim::findorfail($id);
        return redirect()->route('index')->with(['success' => 'Data tim Terubah']);
    }

    public function destroy($id): RedirectResponse{
        $tim = tim::findOrFail($id);
        $tim->delete();
        return redirect()->route('index')->with(['success' => 'Data tim dihapus']);
    }
}
