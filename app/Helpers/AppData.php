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


    public static function getCategoryData()
    {
        $categoryProductsRepository = new CategoryProductsRepository();
        $categoryNewsRepository = new CategoryNewsRepository();

        $info = [
            'categoryType' => ETypeRealEstate::SELL,
            'position' => 'fe'
        ];
        $listCategoriesSell = $categoryProductsRepository->getlistCategory($info);
        $info = [
            'categoryType' => ETypeRealEstate::RENT,
            'position' => 'fe'
        ];
        $listCategoriesRent = $categoryProductsRepository->getlistCategory($info);
        $info = [
            'categoryType' => ETypeRealEstate::PROJECT,
            'position' => 'fe'
        ];
        $listCategoriesProject = $categoryProductsRepository->getlistCategory($info);


        $info = [
            'categoryType' => ETypeNews::NEWS
        ];
        $listCategoriesNews = $categoryNewsRepository->getlistCategory($info);

        $info = [
            'categoryType' => ETypeNews::WIKI
        ];
        $listCategoriesWikis = $categoryNewsRepository->getlistCategory($info);

        $info = [
            'categoryType' => ETypeNews::FENGSHUI
        ];
        $listCategoriesFengshuis = $categoryNewsRepository->getlistCategory($info);
        
        $category = [
            'listCategoriesSell' => $listCategoriesSell,
            'listCategoriesRent' => $listCategoriesRent,
            'listCategoriesProject' => $listCategoriesProject,
            'listCategoriesNews' => $listCategoriesNews,
            'listCategoriesWikis' => $listCategoriesWikis,
            'listCategoriesFengshuis' => $listCategoriesFengshuis
        ];
        return $category;
    }

    public static function getFilterData()
    {
        $categoryProductsRepository = new CategoryProductsRepository();
        $categoryNewsRepository = new CategoryNewsRepository();
        
        $category = [
            'listCategoriesSell' => $listCategoriesSell,
            'listCategoriesRent' => $listCategoriesRent,
            'listCategoriesProject' => $listCategoriesProject,
            'listCategoriesNews' => $listCategoriesNews,
            'listCategoriesWikis' => $listCategoriesWikis,
            'listCategoriesFengshuis' => $listCategoriesFengshuis
        ];
        return $category;
    }
}

?>