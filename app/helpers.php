<?php

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;


function addImage($image, Model $model)
{
    try {
        $img = ImageIntervention::make($image->getRealPath());
        $img->resize(120, 120, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->stream(); // <-- Key point
        $dateTime = str_replace(':' , '-' ,$model->created_at);
        //Dynamic Directory According to the model
        $dir = strtolower(get_class($model));
        //Make Path
        $path = $dir. '/' . $dateTime . $image->getClientOriginalName();
        $storage = Storage::disk('s3')->put($path , $img);
        //If Image is stored then store into database
        if($storage){
            //Create Image Instance
            $image = Image::create([
                'url' => $path,
                'imageable_id' => $model->id,
                'imageable_type' =>get_class($model)
            ]);
        }
        return true;
    } catch (\Throwable $th) {
        dd($th);
        return null;
    }
}

function updateImage($image, Model $model) {
    try {
        // Delete the existing image
        $delete = Storage::disk('s3')->delete($model->image->url);
        //If image is successfully deleted then add the new image
        if($delete) {
            $img = ImageIntervention::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream(); // <-- Key point
            $dateTime = str_replace(':' , '-' ,$model->created_at);
            //Make Dynamic Directory
            $dir = strtolower(get_class($model));
            $path = $dir .'/' . $dateTime .$image->getClientOriginalName();
            $storage = Storage::disk('s3')->put($path , $img);

            //If Image is stored then update into database
            if($storage){
                //Get Image Instance
                $image = Image::where('id', $model->image->id)->first();
                //Update Image Instance URL
                $update = $image->update([
                    'url' => $path,
                ]);
                // If Image Is Successfully update then return true else null
                if($update) {
                    return true;
                } else {
                    return null;
                }
            }
            return true;
        } else {
            return null;
        }
    } catch (\Throwable $th) {
        return null;
    }
}


function deleteImage(Model $model)
{
    $delete = Storage::disk('s3')->delete($model->image->url);
    if($delete) {
        return true;
    } else {
        return false;
    }
}

function getImageUrl(Model $model)
{
    //Get URL of the website
    return Storage::disk('s3')->url($model->image->url);
}


function uploadImage($image)
{
    try {
        dd($image);
        $img = ImageIntervention::make($image->getRealPath());
        $img->resize(120, 120, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->stream(); // <-- Key point
        //Make Path
        $path = 'new/' . $image->getClientOriginalName();
        $storage = Storage::disk('s3')->put($path , $img);
        //If Image is stored then store into database
        if($storage){
            echo "stored";
        }
        return true;
    } catch (\Throwable $th) {
        dd($th);
        return null;
    }
}
