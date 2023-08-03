<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use App\Models\kompetisi;
use App\Models\User;
use App\Models\organizer;
use App\Models\tim;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KompetisiController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $org = organizer::latest()->paginate(10);
        $comp = kompetisi::latest()->paginate(10);
        $user = User::where('disabled', false)->latest()->paginate(10);
        $tim = tim::latest()->paginate(10);

        $org_count = organizer::count();
        $tim_count = tim::count();
        $user_count = user::count();
        $comp_count = kompetisi::count();
        // $competition = Kompetisi::findOrFail($id);

        //$organizer = $competition->organizer->nama;
        $transactions = Transaction::with('user', 'kompetisi')->paginate(10);


        return view('adminDashboard', compact('comp','user','org','tim','org_count','tim_count','user_count','comp_count',));
    }

    public function create(): View
    {
        $org = Organizer::all();
        return view('kompetisi.create',compact('org'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'img' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'desk' => 'required|min:10',
            'org' => 'required',
            'harga_daftar',
        ]);

        $img = $request->file('img');
        $img->storeAs('public/competition', $img->hashName());

        kompetisi::create([
            'img' => $img->hashName(),
            'nama' => $request->nama,
            'desk' => $request->desk,
            'org' => $request->org,
            'harga_daftar' => $request->daftar
        ]);
        return redirect()->route('index')->with(['success' => 'Data Kompetisi Tersimpan']);
    }

    public function show(string $id): view
    {
        $comp = kompetisi::with('peserta')->findOrFail($id);
        $part = $comp->peserta;
        return view('kompetisi.detail', compact('comp','part'));
    }

    public function edit(string $id): view
    {
        $comp = kompetisi::findorfail($id);
        $org = Organizer::all();
        return view('kompetisi.edit', compact('comp','org'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //dd($id);
        $this->validate($request, [
            'img' => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'desk' => 'required|min:10',
            'org' => 'required',
            'harga_daftar'
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
                'harga_daftar' => $request->daftar
            ]);
        } else {
            $comp->update([
                'nama' => $request->nama,
                'desk' => $request->desk,
                'org' => $request->org,
                'harga_daftar' => $request->daftar
            ]);
        }
        return redirect()->route('index')->with(['success' => 'Data Kompetisi Terubah']);
    }

    public function destroy($id): RedirectResponse{
        $comp = kompetisi::findOrFail($id);
        $comp->peserta()->detach();
        Storage::delete('public/competition' . $comp->image);
        $comp->delete();
        return redirect()->route('index')->with(['success' => 'Data Kompetisi dihapus']);
    }

    public function printPDF(){
        $comp = kompetisi::all();

        $comp = Pdf::loadView('Kompetisi.CompPdf',['comp' => $comp]);
        return $comp->download('comp.pdf');
    }

    public function detail(string $id): view
    {
        $comp = kompetisi::findorfail($id);
        return view('detailKomp', compact('comp'));
    }

    public function ikutKomp(Request $request, $id)
    {
        $comp = kompetisi::findOrFail($id);
        $user = Auth::user();
    
        if ($user->kompetisis()->where('komps_id', $comp->id)->exists()) {
            return redirect()->back()->with('status', 'Anda sudah terdaftar dalam kompetisi ini.');
        }
    
        // Jika harga daftar tidak kosong, buat transaksi dengan nilai harga_daftar dari kompetisi
        if ($comp->harga_daftar > 0) {
            // Buat transaksi
            $totalPembayaran = $comp->harga_daftar;
            $transaksi = new Transaksi([
                'kompetisi_id' => $comp->id,
                'total' => $totalPembayaran,
                'status' => true, // Langsung diverifikasi karena kompetisi gratis
            ]);
            $user->transaksis()->save($transaksi);
        }
    
        // Attach kompetisi ke user
        $user->kompetisis()->attach($comp->id);
    
        return view('detailKomp', compact('comp'));
    }

    public function lihatIkut(){
        $user = Auth::user();
        $comp = $user->kompetisis()->get();

        return view('historyIkut',compact('comp'));
    }
}
