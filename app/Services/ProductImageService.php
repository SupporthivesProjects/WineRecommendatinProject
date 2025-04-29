<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Upload multiple product images
     *
     * @param Product $product
     * @param array $images
     * @param int|null $primaryImageIndex
     * @return void
     */
    public function uploadProductImages(Product $product, array $images, ?int $primaryImageIndex = null)
    {
        
        // Log the start of the image upload process
        Log::info("Starting image upload for product ID: {$product->id}");
    
        foreach ($images as $index => $image) {
            try {
                // Check if the file is valid
                if ($image instanceof UploadedFile) {
                    Log::info("Processing file at index {$index}: " . $image->getClientOriginalName());
    
                    if (!$image->isValid()) {
                        Log::error("Invalid file at index {$index}: " . $image->getErrorMessage());
                        throw new \Exception("File {$index} is invalid: " . $image->getErrorMessage());
                    }
                    
                    // Generate a unique filename
                    $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    Log::info("Generated filename for file at index {$index}: {$filename}");
                    
                    // Ensure the storage directory exists
                    $storagePath = storage_path('app/public/products');
                    if (!file_exists($storagePath)) {
                        Log::info("Storage directory does not exist, creating: {$storagePath}");
                        mkdir($storagePath, 0755, true);
                    }
                    
                    // Store the file with explicit disk specification
                    $path = $image->storeAs('products', $filename, 'public');
                    Log::info("Stored file at index {$index}: {$path}");
                    
                    if (!$path) {
                        Log::error("Failed to store file at index {$index}");
                        throw new \Exception("Failed to store file {$index}");
                    }
    
                    // Create product image record
                    $isPrimary = $index === (int)$primaryImageIndex;
                    Log::info("Is file at index {$index} the primary image? " . ($isPrimary ? 'Yes' : 'No'));
                    
                    $product->images()->create([
                        'image_path' => $filename,
                        'is_primary' => $isPrimary,
                        'display_order' => $index
                    ]);
                    
                    Log::info("Successfully uploaded file at index {$index}: {$filename}");
    
                } else {
                    Log::warning("Item at index {$index} is not a valid UploadedFile");
                }
            } catch (\Exception $e) {
                Log::error("Exception uploading file at index {$index}: " . $e->getMessage());
                throw new \Exception("Error uploading file {$index}: " . $e->getMessage());
            }
        }
    
        // Log the completion of the image upload process
        Log::info("Completed image upload for product ID: {$product->id}");
    }
       
    /**
     * Delete product images
     *
     * @param Product $product
     * @return void
     */
    public function deleteProductImages(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::delete('public/products/' . $image->image_path);
            $image->delete();
        }
    }
    
    /**
     * Update product images
     *
     * @param Product $product
     * @param array $newImages
     * @param array $imagesToDelete
     * @param int|null $primaryImageIndex
     * @return void
     */
    public function updateProductImages(Product $product, array $newImages = [], array $imagesToDelete = [], ?int $primaryImageIndex = null)
    {                
        // Delete specified images
        if (!empty($imagesToDelete)) {
            foreach ($imagesToDelete as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    Storage::delete('public/products/' . $image->image_path);
                    $image->delete();
                }
            }
        }

        // Upload new images
        if (!empty($newImages)) {
            $this->uploadProductImages($product, $newImages, $primaryImageIndex);
        }
        
        // Update primary image if specified
        if ($primaryImageIndex !== null) {
            // First, set all images as non-primary
            $product->images()->update(['is_primary' => false]);
            
            // Then set the selected image as primary
            if (is_numeric($primaryImageIndex)) {
                // If primary image is among new uploads, it's already set in uploadProductImages
                // This is for existing images
                $product->images()
                    ->where('id', $primaryImageIndex)
                    ->update(['is_primary' => true]);
            }
        }
    }
}
