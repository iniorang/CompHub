<?php

namespace App\Http\Controllers;
use App\Models\tim;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'ketua' => 'required'
        ]);

        tim::create([
            'nama' => $request->nama,
            'ketua' => $request->ketua,
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
            'nama' => 'min:5',
            'ketua'
        ]);
        $tim = tim::findorfail($id);
        $tim->update([
            'nama' => $request->nama,
            'ketua' => $request->ketua
        ]);
        return redirect()->route('index')->with(['success' => 'Data tim Terubah']);
    }

    public function destroy($id): RedirectResponse{
        $tim = tim::findOrFail($id);
        $tim->delete();
        return redirect()->route('index')->with(['success' => 'Data tim dihapus']);
    }

    public function buatTim(Request $request) :RedirectResponse{
        $this->validate($request, [
            'nama' => 'required|min:5',
            'ketua'
        ]);

        tim::create([
            'nama' => $request->nama,
            'ketua' => Auth::id(),
        ]);
        return redirect()->route('index')->with(['success' => 'Data tim Tersimpan']);
    }

}
