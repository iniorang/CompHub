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
        $tim = Tim::findorfail($id);
        $anggota = User::where('anggotaTim', $tim->id)->get();

        return view('tim.detail', compact('tim', 'anggota'));
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
        $tim->anggota()->update(['anggotaTim' => null]);
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

        return redirect()->route('manajemenTim')->with(['success' => 'Tim Terbuat']);
    }

    public function editTim(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.edit', compact('tim'));
    }

    public function timDash()
    {
        $user = auth()->user();
        $tim = $user->tim;

        // Kembali ke view dan mengirim data daftar tim

        return view('tim', compact('user', 'tim'));
    }

    public function ikutTim($timId)
    {
        $user = auth()->user();
        $tim = Tim::find($timId);

        if ($tim && !$user->tim->contains($tim->id)) {
            $user->tim()->attach($tim);

            return redirect()->route('manajemenTim', ['id' => $tim->id])->with('success', 'Anda berhasil bergabung ke tim.');
        }

        return redirect()->route('beranda')->with('gagal', 'Gagal mendaftarkan diri ke tim');
    }

    public function kick($userId)
    {
        $user = User::findOrFail($userId);

        if (auth()->user()->id === $user->tim->ketua) {
            $user->anggotaTim = null;
            $user->save();

            return redirect()->back()->with('success', 'Anggota berhasil dikeluarkan dari tim.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengeluarkan anggota dari tim.');
    }

    public function bubarkan($id)
    {
        $tim = tim::findOrFail($id);

        if (auth()->user()->type === 'admin' || auth()->user()->id === $tim->ketua) {
            User::where('anggotaTim', $tim->id)->update(['anggotaTim' => null]);
            //$tim = tim::findOrFail($id);
            Storage::delete('public/timlogo' . $tim->image);
            $tim->delete();

            return redirect()->route('beranda')->with('success', 'Tim berhasil dibubarkan.');
        }
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membubarkan tim.');
    }

    public function detail(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('detailTim', compact('tim'));
    }

    public function keluarTim(Request $request)
    {
        $user = $request->user();

        if ($user->anggotaTim) {
            $tim = Tim::find($user->anggotaTim);
            if ($tim) {
                if ($tim->ketua->id === $user->id) {
                    $tim->anggota()->delete();
                    $tim->delete();
                    return redirect()->route('beranda')->with('success', 'Tim berhasil dibubarkan.');
                }
                $user->anggotaTim = null;
                $user->save();
                return redirect()->route('beranda')->with('success', 'Anda telah keluar dari tim.');
            }
        }
        return redirect()->back()->with('error', 'Anda belum tergabung dalam tim.');
    }
}
