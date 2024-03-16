<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\content_images;
use App\Models\contents;
use App\Models\dosens;
use App\Models\owners;
use App\Models\specialities;
use App\Models\tags;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class publicPageController extends Controller
{
    public function login(){
        return view('public.login');
    }
    public function dashboard(){
        return view('public.layout_baru.dashboard');
    }

    public function showcase(){
        $dosens = dosens::all();
        return view('public.showcase', compact('dosens'));
    }

    public function portofolio(Request $request){

        // dd($request['category']);
        $arrayCategories = [];

        if($request['category'] == "all"){
            $contents =   DB::table('contents')
            ->join('dosens', 'contents.id_dosen', '=', 'dosens.id')
            ->select('contents.*', 'dosens.name')
            ->distinct()->get();

            // $arraySpecialities = [];

            foreach($contents as $content){
                $tmp = [];
                    $tags = tags::where('id_content', $content->id)->get();
                    foreach($tags as $tag){
                        array_push($tmp, $tag->tag);
                    }
                    array_push($arrayCategories, $tmp);
            }

        }else{

            $contents = DB::table('contents')
            ->join('dosens', 'contents.id_dosen', '=', 'dosens.id')
            ->join('tags', 'contents.id', '=', 'tags.id_content')
            ->select('contents.*', 'dosens.name')
            ->where('tags.tag', '=', $request['category'])
            ->distinct()->get();

            // $tmpcontent = DB::table('tags')
            // ->select('tags.id_content')
            // ->where('tags.tag', '=', $request['category'])
            // ->distinct()
            // ->get();

            // dd($contents);

            // $contents =   DB::table('contents')
            // ->join('dosens', 'contents.id_dosen', '=', 'dosens.id')
            // ->select('contents.*', 'dosens.name')
            // ->distinct()->paginate(7);

            // $arraySpecialities = [];

            foreach($contents as $content){
                $tmp = [];
                    $tags = tags::where('id_content', $content->id)->get();
                    foreach($tags as $tag){
                        array_push($tmp, $tag->tag);
                    }
                    array_push($arrayCategories, $tmp);
            }
        }

        return view('public.layout_baru.portofolio_page', compact('contents', 'arrayCategories'));
    }

    public function TA(String $id){

        $contents = DB::table('contents')
        ->join('dosens', 'contents.id_dosen', '=', 'dosens.id')
        ->select('contents.*', 'dosens.name')
        ->where('contents.id', '=', $id)
        ->first();

        $arrayCategories = [];
        $arrayimages = [];


        $tags = tags::where('id_content', $contents->id)->get();
        foreach($tags as $tag){
            array_push($arrayCategories, $tag->tag);
        }


        $images = content_images::where('id_content', $contents->id)->get();
        foreach($images as $image){
            array_push($arrayimages, $image->image_url);
        }


        // $dosens = dosens::all();
        return view('public.layout_baru.TA', compact('contents', 'arrayCategories', 'arrayimages'));
    }

    public function team(){

        $contents =   DB::table('dosens')
        ->select('dosens.*')
        ->paginate(7);

        $arraySpecialities = [];

        foreach($contents as $data){
            $tmp = [];
                $specialities = specialities::where('id_dosen', $data->id)->get();
                foreach($specialities as $speciality){
                    array_push($tmp, $speciality->speciality);
                }
                array_push($arraySpecialities, $tmp);
        }

        // $dosens = dosens::all();
        return view('public.layout_baru.teampage', compact('contents', 'arraySpecialities'));
    }

    public function lecturer(String $id){

        $dosens = DB::table('dosens')
        ->join('users', 'dosens.id_user', '=', 'users.id')
        ->select('dosens.*', 'users.email')
        ->where('dosens.id', '=', $id)
        ->first();

        $contents =   DB::table('contents')
            ->select('contents.*')
            ->where('contents.id_dosen', '=', $dosens->id)
            ->paginate(6);

        $arrayCategories = [];
        $arraySpecialities = [];


        foreach($contents as $content){
            $tmp = [];
                $tags = tags::where('id_content', $content->id)->get();
                foreach($tags as $tag){
                    array_push($tmp, $tag->tag);
                }
                array_push($arrayCategories, $tmp);
        }


        $specialities = specialities::where('id_dosen', $dosens->id)->get();
        foreach($specialities as $speciality){
            array_push($arraySpecialities, $speciality->speciality);
        }


        // $dosens = dosens::all();
        return view('public.layout_baru.lecturer', compact('contents', 'dosens', 'arrayCategories', 'arraySpecialities'));
    }

}
