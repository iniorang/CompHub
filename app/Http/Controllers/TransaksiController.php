<?php

namespace App\Http\Controllers;

use App\Models\kompetisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'kompetisi_id' => 'required|exists:kompetisis,id',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $kompetisi = kompetisi::findOrFail($request->kompetisi_id);
        $totalPembayaran = $kompetisi->harga_masuk ?? 0;

        $file = $request->file('bukti_pembayaran');
        $buktiPembayaran = $file->store('bukti_pembayaran', 'public');

        Transaksi::create([
            'user_id' => auth()->user()->id,
            'kompetisi_id' => $request->kompetisi_id,
            'total_pembayaran' => $totalPembayaran,
            'bukti_pembayaran' => $buktiPembayaran,
            'verified' => false,
        ]);

        return redirect()->route('verifikasi')->with('success', 'Transaksi berhasil dibuat. Silakan tunggu verifikasi dari admin.');
    }

    public function verifikasi()
    {
        $transaksis = Transaksi::where('verified', false)->get();

        return view('verifikasi', compact('transaksis'));
    }

    public function verifikasiTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->verified = true;
        $transaksi->save();

        return redirect()->route('verifikasi')->with('success', 'Transaksi berhasil diverifikasi.');
    }

    public function hapusTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('verifikasi')->with('success', 'Transaksi berhasil dihapus.');
    }
}