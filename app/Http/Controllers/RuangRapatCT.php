<?php

namespace App\Http\Controllers;

use App\Models\MDataGedung;
use App\Models\MDataRuangRapat;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RuangRapatCT extends Controller
{
    public function index(Request $request)
    {

        $ruang = MDataRuangRapat::all();

        return view('admin.ruangan.rapat.index', [
            'title' => 'Ruang Rapat | SIRARA',
            'page_title' => 'Data Ruang Rapat',

            'dataruang' => $ruang
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.ruangan.rapat.create', [
            'title' => 'Ruang Rapat | SIRARA',
            'page_title' => 'Tambah Data Ruang Rapat',
            'data_gedung' => MDataGedung::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ruang' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'gedung' => 'required|string|max:1',
                'kampus' => 'required|string|max:1',

                'hari' => 'required|array',
                'hari.*' => 'required|string|max:8',

                'waktu' => 'required|array',
                'waktu.*' => 'required|string|max:1',

                'foto' => 'required|array',
                'foto.*' => 'required|mimes:jpg,jpeg,png,heic,heif|file|max:8192',

            ]);

            $uploadedFileNames = [];

            try {
                foreach ($request->foto as $f) {
                    $newFileName = time() . '-' . Str::random(8) . '.' . $f->getClientOriginalExtension();
                    $f->move(public_path('images'), $newFileName);
                    $uploadedFileNames[] = $newFileName;
                }
            } catch (\Exception $errr) {
                return back()->with('error', 'Terdapat kesalahan ketika menggunggah foto')->withInput();
            }

            $rapat = new MDataRuangRapat();

            $rapat->uuid = Str::uuid();
            $rapat->ruang = $request->ruang;
            $rapat->lokasi = $request->lokasi;
            $rapat->id_gedung = $request->gedung;
            $rapat->kampus = $request->kampus;
            $rapat->time_available = implode(',', $request->waktu);
            $rapat->day_available = implode(',', $request->hari);
            $rapat->foto = implode(',', $uploadedFileNames);

            $status = $rapat->save();

            if ($status) {
                return redirect()->route('admin.data-ruangan.rapat.index')->with('success', 'Berhasil menambahkan data');
            } else {
                return back()->with('error', 'Terdapat kesalahan ketika menambahkan data')->withInput();
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada form input')->withInput();
        } catch (\Exception $err) {
            dd($err);
            return back()->with('error', 'Terdapat kesalahan ketika menambahkan data')->withInput();
        }
    }

    public function detail(Request $request)
    {
        $ruang = MDataRuangRapat::where('uuid', $request->uuid)->firstOrFail();

        if ($ruang) {
            return view('admin.ruangan.rapat.detail', [
                'title' => 'Ruang Rapat | SIRARA',
                'page_title' => 'Detail Data Ruang Rapat',

                'ruang' => $ruang
            ]);
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function edit(Request $request)
    {
        $ruang = MDataRuangRapat::where('uuid', $request->uuid)->firstOrFail();

        if ($ruang) {
            return view('admin.ruangan.rapat.edit', [
                'title' => 'Ruang Rapat | SIRARA',
                'page_title' => 'Edit Data Ruang Rapat',

                'ruang' => $ruang,
                'data_gedung' => MDataGedung::all()
            ]);
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|string|max:255',
                'ruang' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'gedung' => 'required|string|max:1',
                'kampus' => 'required|string|max:1',

                'hari' => 'required|array',
                'hari.*' => 'required|string|max:8',

                'waktu' => 'required|array',
                'waktu.*' => 'required|string|max:1',

                'foto' => 'nullable|array',
                'foto.*' => 'nullable|mimes:jpg,jpeg,png,heic,heif|file|max:8192',

            ]);

            $uploadedFileNames = [];

            try {
                foreach ($request->foto as $f) {
                    $newFileName = time() . '-' . Str::random(8) . '.' . $f->getClientOriginalExtension();
                    $f->move(public_path('images'), $newFileName);
                    $uploadedFileNames[] = $newFileName;
                }
            } catch (\Exception $errr) {
                return back()->with('error', 'Terdapat kesalahan ketika menggunggah foto')->withInput();
            }


            $rapat = MDataRuangRapat::find($request->id);

            $existFoto = $rapat->foto;
            $newFoto = $existFoto . ',' . implode(',', $uploadedFileNames);

            $rapat->ruang = $request->ruang;
            $rapat->lokasi = $request->lokasi;
            $rapat->id_gedung = $request->gedung;
            $rapat->kampus = $request->kampus;
            $rapat->time_available = implode(',', $request->waktu);
            $rapat->day_available = implode(',', $request->hari);
            $rapat->foto = $newFoto;

            $status = $rapat->save();

            if ($status) {
                return redirect()->route('admin.data-ruangan.rapat.index')->with('success', 'Berhasil memperbarui data');
            } else {
                return back()->with('error', 'Terdapat kesalahan ketika memperbarui data')->withInput();
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada form input')->withInput();
        } catch (\Exception $err) {
            dd($err);
            return back()->with('error', 'Terdapat kesalahan ketika memperbarui data')->withInput();
        }
    }

    public function delete(Request $request)
    {
        $item = MDataRuangRapat::where('uuid', $request->uuid)->firstOrFail();

        if ($item) {
            $fileStore = explode(',', $item->foto);
            foreach ($fileStore as $images) {
                $filePath = public_path('images/' . $images);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $item->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function deleteFoto(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'foto' => 'required|string|max:255',
            ]);

            $item = MDataRuangRapat::find($request->id);

            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            $fotoStore = explode(',', $item->foto);

            if (in_array($request->foto, $fotoStore)) {
                $filePath = public_path('images/' . $request->foto);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $fotoStore = array_filter($fotoStore, function ($foto) use ($request) {
                    return $foto !== $request->foto;
                });

                $newFotoStore = implode(',', $fotoStore);

                $item->foto = $newFotoStore;
                $item->save();

                return response()->json(['message' => 'Berhasil menghapus foto'], 200);
            } else {
                return response()->json(['message' => 'Foto tidak ditemukan'], 404);
            }
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $err) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
