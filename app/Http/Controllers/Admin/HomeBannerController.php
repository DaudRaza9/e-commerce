<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class HomeBannerController extends Controller
{

    public function index()
    {
        $homeBanner = HomeBanner::all();
        return view('admin.home-banner.index',[
            'homeBanner'=>$homeBanner
            ]);
    }

    public function ManageHomeBanner(Request $request){

        return view('admin.home-banner.manage-home-banner');
    }
    public function insert(Request $request){

        $request->validate([
             'image'=>'required|mimes:jpeg,jpg,png'
        ]);
        $homeBanner = new HomeBanner();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $imageName = 'HOME-BANNER-' . time() . '.' . $extension;
            $image->storeAs('public/home-banner', $imageName);
            $homeBanner->image = $imageName;
        }
        $homeBanner->button_text=$request->post('button_text');
        $homeBanner->button_link=$request->post('button_link');

        $homeBanner->status=1;
        $homeBanner->save();
        $msg = "Home Banner inserted successfully";
        $request->session()->flash('message',$msg);
        return redirect('admin/home-banner');
    }

    public function delete(Request $request,$id){
        $category = HomeBanner::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Home Banner Deleted');
        return redirect('admin/home-banner');
    }

    public function edit(Request $request,$id){
        $homeBanner = HomeBanner::find($id);

        return view('admin.home-banner.manage-home-banner',['homeBanner'=>$homeBanner]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'image'=>'mimes:jpeg,jpg,png'
        ]);
        $homeBanner = HomeBanner::findorfail($request->id);

        if ($request->hasFile('image')) {
            $homeBannerImages = DB::table('home_banners')->where([
                'id'=>$request->id
            ])->get();
            if(Storage::exists('public/home-banner/'.$homeBannerImages[0]->image))
            {
                Storage::delete('public/home-banner/'.$homeBannerImages[0]->image);
            }
            $image = $request->file('image');
            $extension = $image->extension();
            $imageName = 'HOME-BANNER-' . time() . '.' . $extension;
            $image->storeAs('public/home-banner', $imageName);
            $homeBanner->image = $imageName;
        }
        $homeBanner->button_text=$request->button_text;
        $homeBanner->button_link=$request->button_link;

        $homeBanner->status=1;
        $homeBanner->update();
        $msg = "Home Banner Updated successfully";
        $request->session()->flash('message',$msg);
        return redirect('admin/home-banner');
    }
    public function status(Request $request,$status,$id){
        $category = HomeBanner::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Home Banner status updated');
        return redirect('admin/home-banner');
    }


}
