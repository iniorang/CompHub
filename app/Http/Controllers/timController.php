<?php

namespace App\Http\Controllers;

use App\Models\tim;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class timController extends Controller
{
    public function create(): View
    {
        return view('tim.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'desk' => 'required',
            'ketua' => 'required'
        ]);

        $logo = $request->file('logo');
        $logo->storeAs('public/timlogo', $logo->hashName());

        tim::create([
            'logo' => $logo->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
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
            'logo' => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'min:5',
            'desk',
            'ketua'
        ]);
        $tim = tim::findorfail($id);
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo->storeAs('public/timlogo', $logo->hashName());
            Storage::delete('public/timlogo' . $tim->logo);
            $tim->update([
                'logo' => $logo->hashName(),
                'nama' => $request->nama,
                'desk' => $request->desk,
                'ketua' => $request->ketua,
            ]);
        }else{
            $tim->update([
                'nama' => $request->nama,
                'desk' => $request->desk,
                'ketua' => $request->ketua
            ]);
        }
        return redirect()->route('index')->with(['success' => 'Data tim Terubah']);
    }

    public function destroy($id): RedirectResponse
    {
        $tim = tim::findOrFail($id);
        Storage::delete('public/timlogo' . $tim->image);
        $tim->delete();
        return redirect()->route('index')->with(['success' => 'Data tim dihapus']);
    }

    //User
    public function showBuat(): View
    {
        return view('userCreateTim');
    }
    public function buatTim(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
        ]);

        $logo = $request->file('logo');
        $logo->storeAs('public/timlogo', $logo->hashName());

        tim::create([
            'logo' => $logo->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
            'ketua' => Auth::id(),
            
        ]);
        return redirect()->route('beranda')->with(['success' => 'Tim Terbuat']);
    }

    public function editTim(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.edit', compact('tim'));
    }

    public function timDash(){
        $user = auth()->user();
        $tim = null;

        if ($user->tim_id) {
            $tim = Tim::with('anggota')->findOrFail($user->tim_id);
        }

        return view('tim', compact('tim'));
    }
    public function keluarkanAnggota($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan dari tim.');
    }

    public function bubarkanTim()
    {
        $user = Auth::user();
        $tim = $user->tim;
        $tim->anggota()->delete();
        $tim->delete();

        return redirect()->route('manajemen_tim')->with('success', 'Tim berhasil dibubarkan.');
    }
}
