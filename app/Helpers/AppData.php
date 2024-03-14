<?php 
namespace App\Helpers;

use App\Enums\ETypeNews;
use App\Enums\ETypeRealEstate;
use App\Repositories\CategoryNewsRepository;
use App\Repositories\CategoryProductsRepository;
use Illuminate\Support\Str;
class AppData
{
    const NEWS_PATH = "uploads/news";
    const BANNER_PATH = "uploads/banners";
    const TYPICAL_ENTERPRISE = "uploads/typical_enterprise";
    const NEWSPAPER_PATH = "uploads/newspaper";
    const NEWSPAPER_LOGO_PATH = "uploads/newspaper/logo";

    public static function uploadThumbnail($file, $path)
    {
        $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $fileName);

        return $path . '/' . $fileName;
    }

}

?>