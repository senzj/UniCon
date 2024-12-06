<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class FileDownloadController extends Controller
{
    // Download a file
    public function download($filename)
    {
        // URL decode the filename to handle special characters
        $filename = urldecode($filename);

        // Log the full received filename
        Log::info('Attempting to download file: ' . $filename);

        // Construct the full file path
        $filePath = 'uploads/' . $filename;

        // Additional logging for debugging
        Log::info('Constructed file path: ' . $filePath);

        // Check if file exists
        if (!Storage::disk('public')->exists($filePath)) {
            // Log detailed error information
            Log::error('File not found', [
                'filepath' => $filePath,
                'full_path' => Storage::disk('public')->path($filePath),
                'all_files' => Storage::disk('public')->files('uploads')
            ]);

            return response()->json([
                'message' => 'File not found',
                'filepath' => $filePath,
                'exists' => Storage::disk('public')->exists($filePath)
            ], 404);
        }

        // Get the full system path
        $fullPath = Storage::disk('public')->path($filePath);

        // Log full path for verification
        Log::info('Full system path: ' . $fullPath);

        // Verify file exists at system level
        if (!file_exists($fullPath)) {
            Log::error('File does not exist at system level', [
                'fullPath' => $fullPath
            ]);

            return response()->json([
                'message' => 'File system error',
                'fullPath' => $fullPath
            ], 500);
        }

        // Attempt to download
        try {
            return response()->download($fullPath, basename($filename));
        } catch (\Exception $e) {
            Log::error('Download failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Download failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
