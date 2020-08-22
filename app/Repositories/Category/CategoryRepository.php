<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryRepositoryInterface {

    //Protected Fields
    protected $category, $pagination;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->pagination = config('constant.pagination.web');
    }

    public function filterCategories($search)
    {
        return $this->category->where('category_name', 'like', '%'.$search.'%')->paginate($this->pagination);
    }

    public function all()
    {
        return $this->category->paginate($this->pagination);
    }

    public function getCategoiresWithoutPagination()
    {
        return $this->category->all();
    }

    public function create(array $data)
    {

        // Store the data into the model
        $category = $this->category->create($data);
        //Check if stored or not
        if($category) {
            //Store the image
            $image = addImage($data['image'], $category);
            //If Image is store then return collection
            if($image) {
                return $category;
            // Else return the null and delete the entry
            } else {
                $category->delete();
                return null;
            }
        } else {
            return null;
        }
    }

    public function getCategory(Category $category)
    {
        return $category;
    }

    public function update(array $data, Category $category)
    {
        // Update the data into the model
        $update =  $category->update($data);
        //Check if updated or not
        if($update) {
            // If Updated Check Image is there or not
            if(isset($data['image'])) {
                //If There Then Update The Image
                $image = updateImage($data['image'], $category);
                //If Image is store then return collection
                if($image) {
                    return $category;
                } else {
                    return null;
                }
            //If Not Present Then Return The Category Image
            } else {
                return $category;
            }
        } else {
            return null;
        }
    }

    public function delete(Category $category)
    {
        //Delete the image from the storage
        $delteImage = deleteImage($category);
        if($delteImage) {
            // Delete the model instance
            $delete = $category->delete();
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

    public function getCategoiresWithImage()
    {
        $categories = $this->category
                           ->get()
                           ->map(function ($q){
                               $q->image_url = getImageUrl($q);
                               return $q;
                           });
        return $categories;
    }
}
