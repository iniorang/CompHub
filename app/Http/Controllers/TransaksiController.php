<?php

namespace App\Http\Controllers;

use App\Models\kompetisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function verify($id)
    {
        $transaction = Transaksi::findOrFail($id);
        $transaction->status = true;
        $transaction->save();

        return redirect()->route('index')->with('success', 'Transaksi berhasil diverifikasi.');
    }

    public function cancel($id)
    {
        $transaction = Transaksi::findOrFail($id);

        if (!$transaction) {
            // Transaksi tidak ditemukan, berikan respon sesuai kebutuhan (misalnya notifikasi)
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        // Hapus data dari tabel user_ikut_komps jika ada
        if ($transaction->user && $transaction->kompetisi) {
            $transaction->user->kompetisis()->detach($transaction->kompetisi->id);
        }

        // Hapus transaksi
        $transaction->delete();

        // Berikan respon sesuai kebutuhan (misalnya notifikasi)
        return redirect()->route('index')->with('success', 'Transaksi berhasil dibatalkan.');
    }
}
