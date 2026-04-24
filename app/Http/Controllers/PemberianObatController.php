<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\PemberianObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemberianObatController extends Controller
{
    public function index(Request $request): View
    {
        $query = PemberianObat::query()
            ->with(['pasien:id,nama,jenis_kelamin,umur']);

        if ($request->filled('filter_pasien')) {
            $query->where('pasien_id', $request->integer('filter_pasien'));
        }

        if ($request->filled('filter_tanggal')) {
            $query->whereDate('tanggal_pemberian', $request->filter_tanggal);
        }

        if ($request->filled('filter_keyword')) {
            $keyword = trim($request->filter_keyword);

            $query->where(function ($subQuery) use ($keyword) {
                $subQuery
                    ->where('obat_aturan_pakai', 'like', '%' . $keyword . '%')
                    ->orWhere('diagnosa_keluhan', 'like', '%' . $keyword . '%')
                    ->orWhere('informasi_tambahan', 'like', '%' . $keyword . '%');
            });
        }

        $pemberianObats = $query
            ->orderByDesc('tanggal_pemberian')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama']);

        return view('pemberian_obats.index', compact('pemberianObats', 'pasiens'));
    }

    public function create(): View
    {
        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama', 'umur', 'jenis_kelamin']);

        return view('pemberian_obats.create', compact('pasiens'));
    }

    public function store(Request $request): RedirectResponse
    {
        $pemberian = PemberianObat::create($this->validateData($request));

        return redirect()
            ->route('pemberian_obats.show', $pemberian)
            ->with('success', 'Data pemberian obat berhasil ditambahkan!');
    }

    public function show(int $id): View
    {
        $pemberianObat = PemberianObat::with('pasien')->findOrFail($id);

        return view('pemberian_obats.show', compact('pemberianObat'));
    }

    public function edit(int $id): View
    {
        $pemberianObat = PemberianObat::with('pasien')->findOrFail($id);
        $pasiens = Pasien::orderBy('nama')->get(['id', 'nama', 'umur', 'jenis_kelamin']);

        return view('pemberian_obats.edit', compact('pemberianObat', 'pasiens'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->update($this->validateData($request));

        return redirect()
            ->route('pemberian_obats.show', $pemberianObat)
            ->with('success', 'Data pemberian obat berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pemberianObat = PemberianObat::findOrFail($id);
        $pemberianObat->delete();

        return redirect()
            ->route('pemberian_obats.index')
            ->with('success', 'Data pemberian obat berhasil dihapus!');
    }

    public function cetak(int $id): View
    {
        $pemberianObat = PemberianObat::with('pasien')->findOrFail($id);

        return view('pemberian_obats.cetak', compact('pemberianObat'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'pasien_id' => ['required', 'integer', 'exists:pasiens,id'],
            'obat_aturan_pakai' => ['required', 'string', 'min:3'],
            'tanggal_pemberian' => ['required', 'date'],
            'diagnosa_keluhan' => ['required', 'string'],
            'informasi_tambahan' => ['nullable', 'string'],
        ]);
    }
}
