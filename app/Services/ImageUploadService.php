<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload and convert image to WebP format.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string|null Mapped relative path to file or null on failure
     */
    public function uploadToWebp(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        try {
            // Read image from file path
            $imagePath = $file->getRealPath();
            $imageInfo = getimagesize($imagePath);
            if (!$imageInfo) {
                return null;
            }

            $mimeType = $imageInfo['mime'];
            
            // Create GD image resource based on mime type
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($imagePath);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($imagePath);
                    // Preserve transparency for PNG
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($imagePath);
                    break;
                default:
                    // Return raw upload for unsupported formats
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    return 'storage/' . $file->storeAs($folder, $filename, 'public');
            }

            if (!$image) {
                return null;
            }

            // Define output path
            $filename = Str::uuid() . '.webp';
            $relativeFolder = $folder;
            
            // Ensure folder exists in public disk
            if (!Storage::disk('public')->exists($relativeFolder)) {
                Storage::disk('public')->makeDirectory($relativeFolder);
            }

            $outputPath = Storage::disk('public')->path($relativeFolder . '/' . $filename);

            // Save image as WebP
            imagewebp($image, $outputPath, 80);
            imagedestroy($image);

            return 'storage/' . $folder . '/' . $filename;
        } catch (\Exception $e) {
            logger()->error("Image conversion failed: " . $e->getMessage());
            // Fallback: save original if conversion fails
            try {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                return 'storage/' . $path;
            } catch (\Exception $ex) {
                return null;
            }
        }
    }
}
