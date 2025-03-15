<?php

namespace App\Http\Controllers;

use App\Models\CardContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{

    public function index()
    {
        $cardContents = CardContent::all();

        return view('index', compact('cardContents'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'judul' => 'required|string|max:255',
        'media' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'deskripsi' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    if ($request->hasFile('media')) {
        $image = $request->file('media');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);
    } else {
        $imageName = 'users.jpg';

        // Memindahkan users.jpg dari Public/Assets/images ke storage
        $sourcePath = public_path('Assets/images/users.jpg');
        $destinationPath = storage_path('app/public/images/users.jpg');

        if (file_exists($sourcePath)) {
            // Pastikan file ada sebelum dipindahkan
            rename($sourcePath, $destinationPath);
        }
    }

    $cardContent = new CardContent();
    $cardContent->judul = $request->input('judul');
    $cardContent->deskripsi = $request->input('deskripsi');
    $cardContent->images = $imageName;
    $cardContent->save();

    return redirect()->route('content.index')->with('success', 'Card content berhasil disimpan!');
}


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'media' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cardContent = CardContent::findOrFail($id);

        if ($request->hasFile('media')) {
            $image = $request->file('media');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            if ($cardContent->images != 'users.JPG') {
                Storage::delete('public/images/' . $cardContent->images);
            }

            $cardContent->images = $imageName;
        }

        $cardContent->judul = $request->input('judul');
        $cardContent->deskripsi = $request->input('deskripsi');
        $cardContent->save();

        return redirect()->route('content.index')->with('success', 'Card content berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $cardContents = CardContent::findOrFail($id);

        $imagePath = public_path('storage/images/' . $cardContents->images);
        if (file_exists($imagePath) && $cardContents->images != 'users.JPG') {
            unlink($imagePath);
        }

        $cardContents->delete();

        return redirect()->route('content.index')->with('success', 'Card content berhasil dihapus!');
    }


}
