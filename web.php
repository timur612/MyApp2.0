<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Role;
use App\Post;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/registr', function(Request $req){
   header('Access-Control-Allow-Origin:*');
    $id = App\User::insertGetId(
    ['name' => $req->login , 'email' => $req->email, 'password' => $req->password]
);
    return $id;
});

Route::get('/signIn', function(Request $req){
    header('Access-Control-Allow-Origin:*');
    
    $user=App\User::where("name",'=',$req->log )->where("password","=",$req->pass)->get();
    return $user;
});

Route::get('/role',function(Request $req){
      header('Access-Control-Allow-Origin:*');
    
   $role= App\Role::create(["role"=>$req->role,'user_id'=>$req->userId,'name'=>$req->name,'surname'=>$req->surname,'phone'=>$req->phone, ]);
    return $role;
    
});
Route::get('/getRole',function(Request $req){
       header('Access-Control-Allow-Origin:*');
    $user=    App\Role::where('user_id','=',$req->user_id)->get();
    return $user;
    
});
Route::get('/sW',function(Request $req){
     header('Access-Control-Allow-Origin:*');
   $id=App\Role::where("user_id",'=',$req->id)->get();
    return $id;
});
Route::get('/post',function(Request $req){
     header('Access-Control-Allow-Origin:*');
    $post=App\Post::where('status',0)->get();
    return $post;
});

Route::get('/create_post',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    App\Post::create(["description"=>$req->desc,"phone"=>$req->phone,"user_id"=>$req->user_id, "respon_id"=>0, "status"=>0]);
});
Route::get('/upPost',function(Request $req){
     header('Access-Control-Allow-Origin:*');
     $id=App\Post::find($req->post_id);
   $post= App\Post::where('id',$id["id"])->update(['status'=>1,'respon_id'=>$req->resp_id]);
    return $post;
    
});
Route::get('/myPost',function(Request $req){
     header('Access-Control-Allow-Origin:*');
    $post=App\Post::where('status',1)->where("respon_id",$req->user_id)->get();
    return $post;
});

Route::get('/polzPost',function(Request $req){
     header('Access-Control-Allow-Origin:*');
    $post=App\Post::where('status',1)->where("user_id", $req->worker_id)->get();
    
  // $res = new Collection();
   // $result = $res->merge($user)->merge($post);
    return $post;
});

Route::get('/getRespond',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $responds = [];
    for($i=0;$i<count($req->ids);$i++){
      $users =   App\Role::where("user_id", $req->ids[$i])->get();
        array_push($responds, $users);
    }
    return $responds;
});

Route::get('/donePost',function(Request $req){
     header('Access-Control-Allow-Origin:*');
    App\Post::where('id',$req->p_id)->update(["status"=>2]);
    
});
Route::get('/donePosts',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $donePosts=App\Post::where('status',2)->where("user_id",$req->user_id)->get();
    return $donePosts;
});
Route::get('/myPosts',function(Request $req){
    header('Access-Control-Allow-Origin:*');
   $post= App\Post::where('user_id',$req->user_id)->get();
    return $post;
});

Route::get('/donePostsForSw',function(Request $req){
    header('Access-Control-Allow-Origin:*');
    $donePosts=App\Post::where('status',2)->where("respon_id",$req->user_id)->get();
    return $donePosts;
});
