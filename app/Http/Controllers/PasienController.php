<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasienController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pasien::query();

        if ($request->filled('filter_nama')) {
            $query->where('nama', 'like', '%' . $request->filter_nama . '%');
        }

        if ($request->filled('filter_jk')) {
            $query->where('jenis_kelamin', $request->filter_jk);
        }

        if ($request->filled('filter_umur_min')) {
            $query->where('umur', '>=', $request->integer('filter_umur_min'));
        }

        if ($request->filled('filter_umur_max')) {
            $query->where('umur', '<=', $request->integer('filter_umur_max'));
        }

        $pasiens = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('pasiens.index', compact('pasiens'));
    }

    public function create(): View
    {
        return view('pasiens.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Pasien::create($this->validateData($request));

        return redirect()
            ->route('pasiens.index')
            ->with('success', 'Data pasien berhasil ditambahkan!');
    }

    public function show(int $id): View
    {
        $pasien = Pasien::findOrFail($id);

        $totalPemberian = $pasien->pemberianObat()->count();

        $riwayatObat = $pasien->pemberianObat()
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->get();

        return view('pasiens.show', compact('pasien', 'totalPemberian', 'riwayatObat'));
    }

    public function edit(int $id): View
    {
        $pasien = Pasien::findOrFail($id);

        return view('pasiens.edit', compact('pasien'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($this->validateData($request));

        return redirect()
            ->route('pasiens.show', $pasien)
            ->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()
            ->route('pasiens.index')
            ->with('success', 'Data pasien berhasil dihapus!');
    }

    public function cetak(int $id): View
    {
        $pasien = Pasien::findOrFail($id);

        $totalPemberian = $pasien->pemberianObat()->count();

        $riwayatObat = $pasien->pemberianObat()
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->get();

        return view('pasiens.cetak', compact('pasien', 'totalPemberian', 'riwayatObat'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'umur' => ['required', 'integer', 'min:0', 'max:150'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'alamat' => ['required', 'string'],
        ]);
    }
}
