<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();

        return view('file.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|file',
            'password' => 'required|min:6',
        ]);

        $file = $request->file('file');
        $password = bcrypt($request->input('password'));

        // Encrypt the file content
        $encryptedContent = Crypt::encrypt(file_get_contents($file->path()));

        // Generate a unique filename for the encrypted file
        $encryptedFilename = 'file_' . time() . '_' . $file->getClientOriginalName();

        // Store the encrypted file in Laravel's storage system
        Storage::put($encryptedFilename, $encryptedContent);

        // Save the file details in the database
        $fileModel = new File;
        $fileModel->name = $file->getClientOriginalName();
        $fileModel->password = $password;
        $fileModel->path = $encryptedFilename;
        $fileModel->save();

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }
}