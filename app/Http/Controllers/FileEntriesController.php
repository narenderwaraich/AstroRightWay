<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\FileEntry;
use Storage;
use File;
use App\Product;

class FileEntriesController extends Controller
{
    public function uploadFile(Request $request) {
        $file = Input::file('file');
        $filename = $file->getClientOriginalName();

        $path = hash( 'sha256', time());


        if(Storage::disk('public')->put($path.'/'.$filename,  File::get($file))) {
            $input['filename'] = $filename;
            $input['mime'] = $file->getClientMimeType();
            $input['path'] = $path;
            $input['size'] = $file->getClientSize();
            $file = FileEntry::create($input);

            return response()->json([
                'success' => true,
                'id' => $request->all()
            ], 200);
        }
        $product = Product::create($request->all());
        return response()->json([
            'success' => false
        ], 500);
    }

    public function index() {
    $files = FileEntry::all();

    return view('index', compact('files'));
	}
	public function create() {
    return view('create');
}
}
