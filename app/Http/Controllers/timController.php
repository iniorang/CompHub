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
            'ketua'
        ]);

        $logo = $request->file('logo');
        $logo->storeAs('public/timlogo', $logo->hashName());

        tim::create([
            'logo' => $logo->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,

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
        } else {
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

        $tim = tim::create([
            'logo' => $logo->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
            'ketua' => Auth::id(),
        ]);
        $user = Auth::user();
        $user->anggotatim = $tim->id;
        $user->save();

        return redirect()->route('tim')->with(['success' => 'Tim Terbuat']);
    }

    public function editTim(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.edit', compact('tim'));
    }

    public function timDash()
    {
        $user = Auth::user();
        $tim = null;

        if ($user->tim_id) {
            $tim = Tim::with('anggota')->findOrFail($user->tim_id);
        }

        return view('tim', compact('tim'));
    }

    public function ikutTim($timId)
    {
        $user = auth()->user();
        $tim = Tim::find($timId);

        if ($tim && !$user->anggotatim) {
            $user->anggotatim = $tim->id;
            $user->save();

            return redirect()->route('manajemenTim', ['id' => $tim->id])->with('success', 'Anda berhasil bergabung ke tim.');
        }

        return redirect()->route('detailt')->with('error', 'Gagal bergabung ke tim.');
    }
    public function kick($userId)
    {
        $user = Auth::user();
        $tim = Tim::findOrFail($user->tim_id);

        if ($user->id === $tim->ketua) {
            $tim->anggota()->detach($userId);

            $anggota = User::findOrFail($userId);
            $anggota->anggotaTim = null;
            $anggota->save();

            return redirect()->route('manajemenTim')->with('success', 'Anggota berhasil dikeluarkan dari tim.');
        } else {
            return redirect()->route('manajemenTim')->with('error', 'Anda tidak memiliki izin untuk melakukan ini.');
        }
    }

    public function bubarkan()
    {
        $user = Auth::user();
        $tim = Tim::findOrFail($user->tim_id);

        if ($user->id === $tim->ketua) {
            $tim->anggota()->detach();

            $tim->delete();

            $user->anggotaTim = null;
            $user->save();

            return redirect()->route('tim.dashboard')->with('success', 'Tim telah dibubarkan.');
        } else {
            return redirect()->route('tim.dashboard')->with('error', 'Anda tidak memiliki izin untuk melakukan ini.');
        }
    }

    public function detail(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('detailTim', compact('tim'));
    }
}
