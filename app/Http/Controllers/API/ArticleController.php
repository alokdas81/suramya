<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Article;

class ArticleController extends BaseController
{
    public function getAllArticle(Request $request)
    {
        $articleObj = new Article;
        $articleArray = array();
        $allArticle = $articleObj->getAllArticle();

        if(!empty($allArticle))
        {
            foreach($allArticle as $key=>$article)
            {
                $articleArray[$key]['id'] = $article['id'];
                $articleArray[$key]['title'] = $article['title'];
                $articleArray[$key]['details'] = $article['details'];
                $articleArray[$key]['created_at'] = $article['created_at'];
                $articleArray[$key]['updated_at'] = $article['updated_at'];
            }
            $data['articleList'] = $articleArray;
			$data['total_article'] = count($articleArray);
        }
        return $this->sendResponse($data,'Article list fetched successfully');
    }
}

?>