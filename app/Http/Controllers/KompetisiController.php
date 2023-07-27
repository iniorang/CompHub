<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\kompetisi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KompetisiController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $comp = kompetisi::latest()->paginate(10);
        $user = user::latest()->paginate(10);
        return view('adminDashboard', compact('comp','user'));
    }

    public function create(): View
    {
        return view('kompetisi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'img' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'desk' => 'required|min:10',
            'org' => 'required'
        ]);

        $img = $request->file('img');
        $img->storeAs('public/competition', $img->hashName());

        kompetisi::create([
            'img' => $img->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
            'org' => $request->org

        ]);
        return redirect()->route('index')->with(['success' => 'Data Kompetisi Tersimpan']);
    }

    public function show(string $id): view
    {
        $comp = kompetisi::findorfail($id);
        return view('kompetisi.detail', compact('comp'));
    }

    public function edit(string $id): view
    {
        $comp = kompetisi::findorfail($id);
        return view('kompetisi.edit', compact('comp'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //dd($id);
        $this->validate($request, [
            'img' => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'desk' => 'required|min:10',
            'org' => 'required'
        ]);

        $comp = kompetisi::findorfail($id);
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $img->storeAs('public/competition', $img->hashName());
            Storage::delete('public/competition' . $comp->image);
            $comp->update([
                'img' => $img->hashName(),
                'nama' => $request->nama,
                'desk' => $request->desk,
                'org' => $request->org,
            ]);
        } else {
            $comp->update([
                'nama' => $request->nama,
                'desk' => $request->desk,
                'org' => $request->org,
            ]);
        }
        return redirect()->route('index')->with(['success' => 'Data Kompetisi Terubah']);
    }

    public function destroy($id): RedirectResponse{
        $comp = kompetisi::findOrFail($id);
        Storage::delete('public/competition' . $comp->image);
        $comp->delete();
        return redirect()->route('index')->with(['success' => 'Data Kompetisi dihapus']);
    }

    public function printPDF(){
        $comp = kompetisi::all();

        $comp = Pdf::loadView('Kompetisi.CompPdf',['comp' => $comp]);
        return $comp->download('comp.pdf');
    }
}
