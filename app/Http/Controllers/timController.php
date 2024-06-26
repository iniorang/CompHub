<?php

namespace App\Http\Controllers;

use App\Models\RequestJoin;
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

        $tim = Tim::create([
            'logo' => $logo->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
            'ketua' => Auth::id(),
        ]);
        Auth::user()->tim()->attach($tim);

        return redirect()->route('manajemenTim')->with(['success' => 'Tim Terbuat']);
    }


    public function editTim(string $id): view
    {
        $tim = tim::findorfail($id);
        return view('tim.edit', compact('tim'));
    }

    public function updateTim(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'logo' => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'min:5',
            'desk',
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
            ]);
        } else {
            $tim->update([
                'nama' => $request->nama,
                'desk' => $request->desk,
            ]);
        }
        return redirect()->route('dashboardTim')->with(['success' => 'Data tim Terubah']);
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

    //Request Experimental
    public function mintaBergabung($timId)
    {
        $user = auth()->user();
        $tim = Tim::find($timId);

        if ($tim && !$user->tim->contains($tim->id)) {
            // Create a new join request
            $joinRequest = new RequestJoin();
            $joinRequest->user_id = $user->id;
            $joinRequest->tim_id = $tim->id;
            $joinRequest->status = 'pending';
            $joinRequest->save();

            return redirect()->route('beranda')->with('success', 'Permintaan bergabung berhasil diajukan.');
        }

        return redirect()->route('beranda')->with('error', 'Gagal mengajukan permintaan bergabung.');
    }


    public function terimaPermintaan($requestId)
    {
        $request = RequestJoin::find($requestId);
        $request->update(['status' => 'accepted']);
        $request->tim->anggota()->attach($request->user);
        return redirect()->route('dashboardTim', ['id' => $request->tim->id])->with('success', 'Permintaan bergabung diterima.');

    }

    public function tolakPermintaan($requestId)
    {
        $request = RequestJoin::find($requestId);
        $request->update(['status' => 'rejected']);
        return redirect()->route('dashboardTim', ['id' => $request->tim->id])->with('success', 'Permintaan bergabung ditolak.');
    }


    //End Request
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
        $tim = Tim::findOrFail($id);

        if (auth()->user()->type === 'admin' || $tim->ketua === auth()->user()->id) {
            User::where('anggotaTim', $tim->id)->update(['anggotaTim' => null]);
            Storage::delete('public/timlogo/' . $tim->image);
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

    public function keluarTim(Request $request, $timId)
    {
        $user = $request->user();

        if ($user->tim()->where('tims.id', $timId)->exists()) {
            $user->tim()->detach($timId);
            return redirect()->route('beranda')->with('success', 'Anda telah keluar dari tim.');
        }

        return redirect()->back()->with('error', 'Anda belum tergabung dalam tim.');
    }


    public function listAnggota($id)
    {
        $tim = Tim::findOrFail($id);
        $anggota = $tim->anggota;
        $ketua = $tim->Ketua()->first();
        $permintaan = $tim->request;

        return view('dashboardTim', compact('tim', 'anggota', 'ketua', 'permintaan'));
    }
}