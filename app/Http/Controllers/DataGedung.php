<?php

namespace App\Http\Controllers;

use App\Models\MDataGedung;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DataGedung extends Controller
{
    public function index(Request $request)
    {
        return view('admin.gedung.index', [
            'title' => 'Data Gedung | SIRARA',
            'page_title' => 'Data Gedung',

            'datagedung' => MDataGedung::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'gedung' => 'required|string|max:255',
                'kampus' => 'required|string|max:1',
            ]);

            $gedung = new MDataGedung();

            $gedung->uuid = Str::uuid();
            $gedung->gedung = $request->gedung;
            $gedung->kampus = $request->kampus;

            $gedung->save();

            if ($gedung) {
                return back()->with('success', 'Berhasil menambahkan data');
            } else {
                return back()->with('error', 'Terdapat kesalahan ketika menambahkan data');
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika menambahkan data');
        }
    }

    public function update(Request $request)
    {
        try {
            $gedung = MDataGedung::where('uuid', $request->uuid)->firstOrFail();

            $gedung->gedung = $request->gedung;
            $gedung->kampus = $request->kampus;

            $gedung->save();

            if ($gedung) {
                return back()->with('success', 'Berhasil memperbarui data');
            } else {
                return back()->with('error', 'Terdapat kesalahan ketika memperbarui data');
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika memperbarui data');
        }
    }

    public function delete(Request $request)
    {
        $item = MDataGedung::where('uuid', $request->uuid)->firstOrFail();

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }
}
