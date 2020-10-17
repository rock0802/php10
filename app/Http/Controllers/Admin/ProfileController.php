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
      
      $news = new Profiles;
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
    public function edit ()
    {
        return view ('admin.profile.edit');
    }
    public function update()
    {
        return redirect('admin/profile/edit');
    }
}
