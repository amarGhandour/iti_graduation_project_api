<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

/**
 * Trait for Upload images
 */
trait ImageTrait
{
    private $noImage = "no_image.png";

    public function setNoImage($name)
    {
        $this->noImage = $name;
    }

    public function updateImage(Request $request, $old_image, $path, $imageFile = null, $key = "image")
    {

        $imageFileName = "";
        if (!$request->hasFile($key)) {
            $imageFileName = $old_image;
        } elseif ($old_image == $this->noImage) {
            $imageFileName = $this->uploadImage($request, $path, null, $key);
        } else {
            $deleted = $this->deleteImage($old_image, $path);
            if ($deleted)
                $imageFileName = $this->uploadImage($request, $path, null, $key);
        }
        return $imageFileName;
    }

    public function uploadImage(Request $request, $path, $imageFile = null, $key = "image")
    {
        $imageFileName = "";

        if (isset($imageFile)) {
            $imageFileName = time() . "." . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path($path), $imageFileName);
        } else if ($request->hasFile($key)) {
            $image = $request->image;
            $imageFileName = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path($path), $imageFileName);
        } else {
            $imageFileName = $this->noImage;
        }

        return $imageFileName;
    }

    public function deleteImage($image, $path)
    {
        if ($image != $this->noImage) {
            $unlinked = unlink(public_path($path) . $image);
            if (!$unlinked) return false;
        }

        return true;
    }
}
