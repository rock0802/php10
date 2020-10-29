<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    public function add ()
    {
        return view ('admin.profile.create');
    }
    public function create (Request $request)
    {
        $this->validate($request,Profile::$rules);
      
      $news = new Profile;
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
        
        return redirect('admin/profile/create');
    }
    public function edit (Request $request)
    {
       // Profile Modelからデータを取得する
        $news = Profile::find($request->id);
        return view ('admin.profile.edit');
    }
    public function update(Request $request)
    {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profile Modelからデータを取得する
      $news = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      unset($news_form['_token']);
      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
        return redirect('admin/profile/edit');
    }
    public function delete(Request $request)
    {
      // 該当するProfile Modelを取得
      $news = Profile::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/profile/');
    }
}
