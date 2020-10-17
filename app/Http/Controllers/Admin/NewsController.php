<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

class NewsController extends Controller
{
 public function add (){
     return view('admin.news.create');
 }
 
 public function create(Request $request)
  {   
      $this->validate($request,News::$rules);
      
      $news = new News;
      $form = $request->all();
      
      if(isset($form['image'])){
       $path = $request->file('image')->store('public/image');
       $news->image_path = basename('$path');
      }else{
       $news->image_path = null;
      }
      //フォームから送信されてきた下記削除
      unset($form['token']);
      unset($form['image']);
      
      //DBに保存
      $news->fill($form);
      $news->save();
      
      // admin/news/createにリダイレクトする
      return redirect('admin/news/create');
  }  
}
