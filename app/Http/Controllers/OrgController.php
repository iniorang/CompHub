<?php

namespace App\Http\Controllers;

use App\Models\organizer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    public function create(): View
    {
        return view('organizer.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'nama' => 'required|min:5',
        ]);

        organizer::create([
            'nama' => $request->nama,

        ]);
        return redirect()->route('index')->with(['success' => 'Organizer Terdaftar']);
    }


    public function edit(string $id): view
    {
        $organizer = organizer::findorfail($id);
        return view('organizer.edit', compact('organizer'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'nama' => 'min:5'
        ]);
        $organizer = organizer::findorfail($id);
        $organizer->update([
            'nama' => $request->nama
        ]);
        return redirect()->route('index')->with(['success' => 'Data organizer Terubah']);
    }

    public function destroy($id): RedirectResponse{
        $organizer = organizer::findOrFail($id);
        $organizer->delete();
        return redirect()->route('index')->with(['success' => 'Data organizer dihapus']);
    }
}
