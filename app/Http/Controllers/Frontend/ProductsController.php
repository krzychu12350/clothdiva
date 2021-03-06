<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Product;
use DB;
use Session;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{

    public function showProducts(Request $request)
    {
        //try{
        //$products_selection = DB::select("select products_selection() as products_selection from products FETCH FIRST 1 ROWS ONLY");
        //$category = Category::where('name_of_category', $type)->first();
        //$subcategory = Sub_category::where('id_category', $category->id)->first();

        /*
         $favourite_products = DB::table('products')
            ->join('favorite_products', 'favorite_products.id_product', '=', 'products.id_product')
            ->select('products.id_product', 'products.name', 'products.prize')
            ->where('favorite_products.id_ushop', '=', $id)
            ->get();

    
           SELECT * FROM products p
            INNER JOIN sub_categories sb ON sb.id_sub_category = p.id_sub_category 
            INNER JOIN categories c ON c.id_category = sb.id_category 
            INNER JOIN images i ON i.id_product = p.id_product
            WHERE sb.name_of_subcategory='Shorts' AND c.name_of_category='Women';
             */
        //$category = $request->input('type');
         //$subcategory = $request->input('subcategory');
     
        //$cos = Request::input('type');
        //var_dump($cos);
       // var_dump($subcategory);
      // $url = explode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

       //var_dump($url[3]);
       // $allParams = $request->all();
        //var_dump($allParams);
          /*
        foreach ($allParams as $key => $value) {

            var_dump($value);   
        }*/
 
        // $allparams is an associative array, you can also read individual element as $allparams['model']
   
        
        $url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $category = $url[2];
        $subcategory = $_GET['subcategory'];
        //$subcategory = $url[3];
     
        Session::put('category', $category);
        Session::put('subcategory', $subcategory);

        //dd($subcategory);
        //$category = $request->input('type');
         //$subcategory = $request->input('subcategory');
        /*
        $products_selection = DB::table('products p as products_selection')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->select('p.id_product', 'p.name', 'p.prize', 'p.size_of_product')
        ->get();
    
        $products_selection = DB::table('products p as products_selection')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->select('p.id_product', 'p.name', 'p.prize', 'p.size_of_product')
        ->get();
        */
        $all_sizes = DB::table('products p')->select('p.size_of_product')->distinct()
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->orderByRaw('size_of_product DESC')->get();

        $all_colors = DB::table('products p')->select('p.color')->distinct()
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->orderByRaw('color DESC')->get();
        /*
  
        $minPrize = DB::table('products p')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->where('p.prize', \DB::raw("(select min(`p.prize`))"))
        ->get();*/

    
        $minPrize = DB::table('products p')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->min('prize');
    
        $maxPrize = DB::table('products p')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=',  $category)
        ->max('prize');

        Session::put('all_sizes', $all_sizes);
        Session::put('all_colors', $all_colors);
        Session::put('minPrize', $minPrize);
        Session::put('maxPrize', $maxPrize);
        
        //$size = "";
        //$sizep = $request->input('sizep');
        //dd($sizep);

        $products_shop_view2 = DB::select("select products_shop_view('$subcategory','$category','') as products_shop_view from images FETCH FIRST 1 ROWS ONLY");
     

        $products_shop_view = $this->paginate($products_shop_view2);
        $products_shop_view->setPath($category.'?subcategory='.$subcategory);
 
    
       
        /*
        $data2 = DB::table('images')
        ->join('products p', 'p.id_product', '=', 'images.id_product')
        ->where('images.id_product', '=', )
        ->select('images.image')
        ->get();
        dd($data2);*/
       
        return view('frontend.shop', compact('products_shop_view','all_sizes','all_colors','minPrize','maxPrize','category','subcategory'));

        /*
        }
        catch(Exception $e){
            //return view('frontend.firstlookpage');
            report($e);
        }*/
    }
    
    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    public function paginate($items, $perPage = 6, $page = null, $options = [])

    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
         
        
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    }



    public function showProductsbyPrice(Request $request){
        $category = Session::get('category');
        $subcategory = Session::get('subcategory');

        $all_sizes = Session::get('all_sizes');
        $all_colors = Session::get('all_colors');
        $minPrize = Session::get('minPrize');
        $maxPrize = Session::get('maxPrize');

        $min_price = $request->input('min-amount');
        $max_price = $request->input('max-amount');

        $products_shop_view2 = DB::select("select products_by_prize('$subcategory', '$category', '$min_price', '$max_price') as products_shop_view from images FETCH FIRST 1 ROWS ONLY");

        $products_shop_view = $this->paginate($products_shop_view2);
        $products_shop_view->setPath('productsbyPrice')->appends(['min-amount' => $min_price,'max-amount' => $max_price]);

        return view('frontend.shop', compact('products_shop_view','all_sizes','all_colors','minPrize','maxPrize','category','subcategory'));
    }

    public function showProductsbySize(Request $request){
        //$url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        //$category = $url[2];
        //$subcategory = $url[3];
        $category = Session::get('category');
        $subcategory = Session::get('subcategory');

        //$sizep = $_GET['sizep'];
        $checked2 = $request->input('checked');
        Session::put('checked2', $checked2);
        
        //dd($checked2);
        //dd($checked);
        $checked = Session::get('checked2');
        foreach ($checked as &$value) {
            $value =  "'".$value."'";
        }
        unset($value);
        $all_size = implode(', ', $checked);
        
        //$all_size = implode("', '", $checked);
        //$all_size2 = implode("','", $all_size);

        //dd($checked[0],$checked[1]);
        //dd(count($checked));
      
        //dd($all_size);

        $all_sizes = Session::get('all_sizes');
        $all_colors = Session::get('all_colors');
        $minPrize = Session::get('minPrize');
        $maxPrize = Session::get('maxPrize');
        /*
        select MIN(i.image) as image_src,  p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion from images i
        left join products p on p.id_product = i.id_product
        INNER JOIN sub_categories sb ON sb.id_sub_category = p.id_sub_category
        INNER JOIN categories c ON c.id_category = sb.id_category 
        LEFT JOIN promotions prom ON  prom.id_promotion = p.id_promotion
        WHERE sb.name_of_subcategory=subcat AND c.name_of_category=cat AND p.size_of_product=psize
        group by p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion;
        $products_shop_view = DB::table('images i')
        ->where('sb.name_of_subcategory', '=', $subcategory)
        ->where('c.name_of_category', '=', $category)
        ->whereIn('p.size_of_product', $checked)
        ->leftJoin('products p', 'p.id_product', '=', 'i.id_product')
        ->join('sub_categories sb', 'sb.id_sub_category', '=', 'p.id_sub_category')
        ->join('categories c', 'c.id_category', '=', 'sb.id_category')
        ->leftJoin('promotions prom', 'prom.id_promotion', '=', 'p.id_promotion')
        ->select('MIN(image)', 'p.*', 'c.name_of_category', 'prom.size_of_promotion')
        ->get();*/
        //->min('image');

        $products_shop_view2 = DB::select( DB::raw(" select MIN(i.image) as image_src,  p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion from images i
        left join products p on p.id_product = i.id_product
        INNER JOIN sub_categories sb ON sb.id_sub_category = p.id_sub_category
        INNER JOIN categories c ON c.id_category = sb.id_category 
        LEFT JOIN promotions prom ON  prom.id_promotion = p.id_promotion
        WHERE sb.name_of_subcategory='$subcategory' AND c.name_of_category='$category' AND p.size_of_product IN ($all_size)
        group by p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion") );

        //$products_shop_view = DB::select("select products_shop_view('$subcategory', '$category', '$checked[0]') as products_shop_view from images FETCH FIRST 1 ROWS ONLY");
      
        $products_shop_view = $this->paginate($products_shop_view2);
    
        $products_shop_view->setPath($subcategory)->appends([ 'checked' => $checked2 ]);
        
        return view('frontend.shop', compact('products_shop_view','all_sizes','all_colors','minPrize','maxPrize','category','subcategory'));
    }

    public function showProductsbyColor(Request $request){
        $url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        //$category = $url[2];
        //$subcategory = $url[3];
        $category = Session::get('category');
        $subcategory = Session::get('subcategory');

      
        #$checked = $request->input('checked-color');
        $checked2 = $request->input('checked-color');
        Session::put('checked2', $checked2);
        
        //dd($checked2);
        //dd($checked);
        $checked = Session::get('checked2');
        
        foreach ($checked as &$value) {
            $value =  "'".$value."'";
        }
        unset($value);

        $all_color = implode(', ', $checked);
        //dd($all_color);

        $all_sizes = Session::get('all_sizes');
        $all_colors = Session::get('all_colors');
        $minPrize = Session::get('minPrize');
        $maxPrize = Session::get('maxPrize');

        $products_shop_view2 = DB::select( DB::raw(" select MIN(i.image) as image_src,  p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion from images i
        left join products p on p.id_product = i.id_product
        INNER JOIN sub_categories sb ON sb.id_sub_category = p.id_sub_category
        INNER JOIN categories c ON c.id_category = sb.id_category 
        LEFT JOIN promotions prom ON  prom.id_promotion = p.id_promotion
        WHERE sb.name_of_subcategory='$subcategory' AND c.name_of_category='$category' AND p.color IN ($all_color)
        group by p.id_product, p.name, p.prize, p.size_of_product, c.name_of_category, prom.size_of_promotion") );
      
       
        $products_shop_view = $this->paginate($products_shop_view2);
        $products_shop_view->setPath($subcategory)->appends([ 'checked' => $checked2 ]);
        //$products_shop_view = DB::select("select products_shop_view('$subcategory', '$category', '$checked[0]') as products_shop_view from images FETCH FIRST 1 ROWS ONLY");
      
     
       //dd($products_shop_view);
        return view('frontend.shop', compact('products_shop_view','all_sizes','all_colors','minPrize','maxPrize','category','subcategory'));
    }
    
}
