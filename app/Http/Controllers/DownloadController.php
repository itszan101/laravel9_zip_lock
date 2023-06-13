<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use ZipArchive;

class DownloadController extends Controller
{
    public function download(Request $request, $id)
    {
        $file = File::findOrFail($id);

        $password = $request->input('password');

        // Verify the password
        if (!password_verify($password, $file->password)) {
            return redirect()->back()->with('error', 'Invalid password');
        }

        // Decrypt the file content
        $decryptedContent = Crypt::decrypt(Storage::get($file->path));

        // Generate a unique filename for the decrypted file
        $decryptedFilename = 'file_' . time() . '_' . $file->name;

        // Store the decrypted file temporarily
        $tempFile = storage_path('app/public/' . $decryptedFilename);
        file_put_contents($tempFile, $decryptedContent);

        // Create a new ZIP archive
        $zipFilename = 'file_' . time() . '.zip';
        $zip = new ZipArchive();
        $zip->open(storage_path('app/public/' . $zipFilename), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Add the decrypted file to the ZIP archive
        $zip->addFile($tempFile, $file->name);

        // Set encryption method and password for the ZIP file
        $zip->setEncryptionName($file->name, ZipArchive::EM_AES_256, $password);

        // Close the ZIP archive
        $zip->close();

        // Delete the temporary decrypted file
        unlink($tempFile);

        // Download the ZIP file
        return response()->download(storage_path('app/public/' . $zipFilename))->deleteFileAfterSend(true);
    }
}
