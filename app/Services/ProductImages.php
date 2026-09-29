<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImages
{
    public static function rules(): array
    {
        return [
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /** Save the product and its images together; clean up new files on failure. */
    public function save(Post $product, Request $request): void
    {
        $paths = [];

        try {
            DB::transaction(function () use ($product, $request, &$paths) {
                $product->save();
                $files = $request->file('gallery_images', []);
                if (! $request->hasFile('product_image') && empty($files)) {
                    return;
                }
                if ($request->hasFile('product_image')) {
                    // Keep the previous main image in the gallery.
                    Upload::where('post_id', $product->id)->update(['status' => '0']);
                    array_unshift($files, $request->file('product_image'));
                }

                $hasFeatured = Upload::where('post_id', $product->id)->where('status', '1')->exists();
                if (! $hasFeatured && ! $request->hasFile('product_image')) {
                    // Older galleries may not have a designated main image yet.
                    $existing = $product->uploads()->first();
                    if ($existing) {
                        $existing->update(['status' => '1']);
                        $hasFeatured = true;
                    }
                }
                foreach ($files as $file) {
                    $path = $file->store('media/products', 'public');
                    if (! $path) {
                        throw new \RuntimeException('The product image could not be stored.');
                    }
                    $paths[] = $path;

                    Upload::create([
                        'post_id' => $product->id,
                        'site_id' => $product->site_id,
                        'user_id' => $request->user()->id,
                        'name' => basename($path),
                        'file_path' => '/storage/'.$path,
                        'image_type' => 'media',
                        'status' => $hasFeatured ? '0' : '1',
                    ]);
                    $hasFeatured = true;
                }
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($paths);
            throw $exception;
        }
    }
}
