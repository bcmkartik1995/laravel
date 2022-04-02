<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Blog;
use App\Category;
use Illuminate\Support\Facades\DB;

class BlogsController extends Controller
{
    use ApiResponser;

    public function blogs(Request $request) {

        $blogs = Blog::where(['status' => 1])
            ->select('id','title','details','photo','tags', 'source', 'author_name', DB::raw('DATE_FORMAT(created_at, "%b %d") as created_date'))
            ->orderBy('id','desc')
            ->get()
            ->map(function($query){
                if(!empty($query->photo)){
                    $query->photo = asset('assets/images/blogimage/'.$query->photo);
                }else{
                    $query->photo =  asset('assets/front-assets/images/noimage.png');
                }
                return $query;
            });
        if ($blogs->count()) {
            return $this->success([
                'blogs' => $blogs
            ]);
        }else{
            return $this->error('No any blogs found.', 401);
        }
    }

    public function blog_detail($blog_id=null) {
        if(!$blog_id){
            return $this->error('Please enter blog id.', 401);
        }

        $blog = Blog::where(['status' => 1, 'id' => $blog_id])
        ->select('id','title','details','photo','tags', 'source', 'author_name', DB::raw('DATE_FORMAT(created_at, "%d %b, %Y") as created_date'))
        ->orderBy('id','desc')
        ->first();

        if(!$blog){
            return $this->error('Please enter valid blog id.', 401);
        }

        if(!empty($blog->photo)){
            $blog->photo = asset('assets/images/blogimage/'.$blog->photo);
        }else{
            $blog->photo =  asset('assets/front-assets/images/noimage.png');
        }

        $categories = Category::where('categories.status','=',1)
            ->leftjoin("blogs AS b", function ($join) {
                $join->on('categories.id', '=', 'b.category_id')->where(['b.status' => 1, 'b.deleted_at' => NULL]);
            })
            ->select('categories.id', 'categories.title', 'categories.slug',DB::raw('count(b.category_id) as blog_count'))
            ->groupBy('categories.id')
        ->get();

        $tags = [];
        $blogs_tag = Blog::pluck('tags')->toArray();
        foreach($blogs_tag as $tag) {
            $tags = array_merge($tags, explode(',',$tag));
        }
        $tags = array_unique(array_filter($tags));

        $recent_posts = Blog::orderBy('id', 'desc')
            ->select('id','title','details','photo','tags', DB::raw('DATE_FORMAT(created_at, "%d %b, %Y") as created_date'))
            ->limit(4)
            ->get()
            ->map(function($query){
                if(!empty($query->photo)){
                    $query->photo = asset('assets/images/blogimage/'.$query->photo);
                }else{
                    $query->photo =  asset('assets/front-assets/images/noimage.png');
                }
                return $query;
            });
        return $this->success([
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags,
            'recent_posts' => $recent_posts
        ]);
    }

    public function blogs_by_category($category_id=null) {

        if(!$category_id){
            return $this->error('Please enter category id.', 401);
        }
        $blogs = Blog::where('category_id', '=',$category_id)->where(['status' => 1])
            ->select('id','title','details','photo','tags', 'source', 'author_name', DB::raw('DATE_FORMAT(created_at, "%b %d") as created_date'))
            ->orderBy('id','desc')
            ->get()
            ->map(function($query){
                if(!empty($query->photo)){
                    $query->photo = asset('assets/images/blogimage/'.$query->photo);
                }else{
                    $query->photo =  asset('assets/front-assets/images/noimage.png');
                }
                return $query;
            });
        if ($blogs->count()) {
            return $this->success([
                'blogs' => $blogs
            ]);
        }else{
            return $this->error('No any blogs found.', 401);
        }
    }

    public function blogs_by_tag($tag_slug=null) {

        if(!$tag_slug){
            return $this->error('Please enter tag.', 401);
        }
        $blogs = Blog::where('tags', 'like', '%' . $tag_slug . '%')->where(['status' => 1])
            ->select('id','title','details','photo','tags', 'source', 'author_name', DB::raw('DATE_FORMAT(created_at, "%b %d") as created_date'))
            ->orderBy('id','desc')
            ->get()
            ->map(function($query){
                if(!empty($query->photo)){
                    $query->photo = asset('assets/images/blogimage/'.$query->photo);
                }else{
                    $query->photo =  asset('assets/front-assets/images/noimage.png');
                }
                return $query;
            });
        if ($blogs->count()) {
            return $this->success([
                'blogs' => $blogs
            ]);
        }else{
            return $this->error('No any blogs found.', 401);
        }
    }

}
