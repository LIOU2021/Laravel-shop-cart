<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class NewsController extends Controller
{
    public function newsJson(News $news)
    {
        return $news->all();
    }

    public function newJson($id)
    {
        return News::find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(News $news)
    {
        return view('news', ['data' => $news->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, News $news)
    {
        $news->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //個別文章的views
        $redisId = "article id:" . $id . ":views";
        $views = Redis::incr($redisId);
        Redis::zIncrBy('articleViews', 1, $redisId);

        return view('newsDetail', ['data' => News::find($id), 'views' => $views]);
    }

    /**
     * 顯示熱門文章排行
     */
    public function sortByViewsOfArticle()
    {

        $result = Cache::remember("BlogViewsRank", 60, function () {
            $articlePopular = Redis::zRevRange("articleViews", 0, -1); //這裡return的是一個array，裡面放的是article ID，並且照著views的值排序
            //zRevRange是指由大到小排序。
            $array = array();

            $count = 5;//只顯示前五名
            foreach ($articlePopular as $values) {
                if ($count == 0) {
                    break;
                }
                // echo $values . " " . Redis::get($values) . "次觀看<br>"; //打印出articleViews 有序集合內的id
                $id = explode(":", $values)[1];
                $newsData = News::find($id);
                array_push($array, [
                    'id' => $id,
                    'views' => Redis::get($values),
                    'date' => $newsData->date,
                    'title' => $newsData->title,
                ]);
                $count--;
            }
            return $array;
        }); //Cache只存在60秒，名稱為 BlogViewsRank ，如果沒找到，就執行閉包。

        return view('hotNews', ['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        News::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::destroy($id);
    }
}
