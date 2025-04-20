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
        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                try {
                    // Check if the file is valid
                    if (!$image->isValid()) {
                        Log::error("Invalid file at index {$index}: " . $image->getErrorMessage());
                        throw new \Exception("File {$index} is invalid: " . $image->getErrorMessage());
                    }
                    
                    // Generate a unique filename
                    $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    
                    // Ensure the storage directory exists
                    $storagePath = storage_path('app/public/products');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }
                    
                    // Store the file with explicit disk specification
                    $path = $image->storeAs('products', $filename, 'public');
                    
                    if (!$path) {
                        Log::error("Failed to store file at index {$index}");
                        throw new \Exception("Failed to store file {$index}");
                    }
                    
                    // Create product image record
                    $product->images()->create([
                        'image_path' => $filename,
                        'is_primary' => $index === (int)$primaryImageIndex,
                        'display_order' => $index
                    ]);
                    
                    Log::info("Successfully uploaded file {$index}: {$filename}");
                } catch (\Exception $e) {
                    Log::error("Exception uploading file {$index}: " . $e->getMessage());
                    throw new \Exception("Error uploading file {$index}: " . $e->getMessage());
                }
            } else {
                Log::warning("Item at index {$index} is not a valid UploadedFile");
            }
        }
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
