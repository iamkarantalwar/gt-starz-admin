<?php

namespace App\Repositories\Banner;

use App\Models\Banner;

interface BannerRepositoryInterface {
    public function create(array $data);
    public function all();
    public function getBanner(Banner $category);
    public function update(array $data, Banner $category);
    public function delete(Banner $category);
    public function getBannerImages();
}
