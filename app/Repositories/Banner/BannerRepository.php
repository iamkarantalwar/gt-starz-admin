<?php

namespace App\Repositories\Banner;

use App\Models\Banner;

class BannerRepository implements BannerRepositoryInterface
{
    //Protected Model
    protected $banner, $pagination;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
        $this->pagination = config('constant.pagination.web');
    }

    public function all()
    {
        return $this->banner->paginate($this->pagination);
    }

    public function create(array $data)
    {

        // Store the data into the model
        $banner = $this->banner->create($data);
        //Check if stored or not
        if($banner) {
            //Store the image
            $image = addImage($data['image'], $banner);
            //If Image is store then return collection
            if($image) {
                return $banner;
            // Else return the null and delete the entry
            } else {
                $banner->delete();
                return null;
            }
        } else {
            return null;
        }
    }

    public function getBanner(Banner $banner)
    {
        return $banner;
    }

    public function update(array $data, Banner $banner)
    {
        // Update the data into the model
        $update =  $banner->update($data);
        //Check if updated or not
        if($update) {
            // If Updated Check Image is there or not
            if(isset($data['image'])) {
                //If There Then Update The Image
                $image = updateImage($data['image'], $banner);
                //If Image is store then return collection
                if($image) {
                    return $banner;
                } else {
                    return null;
                }
            //If Not Present Then Return The Category Image
            } else {
                return $banner;
            }
        } else {
            return null;
        }
    }

    public function delete(Banner $banner)
    {
        //Delete the image from the storage
        $delteImage = deleteImage($banner);
        if($delteImage) {
            // Delete the model instance
            $delete = $banner->delete();
            //If model instance is deleted return true : false
            if($delete) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function getBannerImages()
    {
        $banners = $this->banner
                           ->get()
                           ->map(function ($q){
                               $q->image_url = getImageUrl($q);
                               return $q;
                           });
        return $banners;
    }


}

?>
