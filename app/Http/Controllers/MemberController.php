<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member;

class MemberController extends Controller
{

    public function index()
    {
        $members = Member::all();
        
        if(!$members){
            return \Response::json([
                'status' => false,
                'data' => [],
                'message' => 'Get all members failed !'
            ]);
        }else{
            return \Response::json([
                'status' => true,
                'data' => $members,
                'message' => 'Get all members success !'
            ]);
        }
    }

    public function store(Request $request)
    {
    	if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder = __DIR__.'/../../../public/uploads/';
            
            $filename = $file->getClientOriginalName();
            $pathfile = rand(100,1000).'-'.$filename;

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $allowed = array('jpg','png','gif');

            if(in_array($ext,$allowed)){
                $file->move($folder, $pathfile);
                $member = new Member();
                $member->photo = 'uploads/'.$pathfile;
                $member->name = $request->name;
                $member->address = $request->address;
                $member->age = $request->age;
         
                $member->save();
                return \Response::json([
                    'status' => true,
                    'message' => 'Add new member success !'
                ]); 
            }else{
                return \Response::json([
                    'status' => false,
                    'message' => 'Photo format wrong !'
                ]);
            }
        }else{
            $member = new Member();
            $member->name = $request->name;
            $member->address = $request->address;
            $member->age = $request->age;
     
            if($member->save()){
                return \Response::json([
                    'status' => true,
                    'message' => 'Add new member success but not photo !'
                ]);
            }else{
                return \Response::json([
                    'status' => false,
                    'message' => 'Create member failed !'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $member = Member::find($id);
        return response($member);
    }

    public function show($id){
        $member_detail = Member::where('id', '=' , $id)->get();
        return \Response::json([
            'data' => $member_detail,
            'message' => 'Show member success'
        ],200);
    }

    public function update(Request $request,$id)
    {
    	$mem = Member::find($id);

        if($request->hasFile('file')) {
            $photo = $request->file('file');
            
            $name = $photo->getClientOriginalName();
            $nameFile = rand(1,100000).'-'.$name;
            $path = 'uploads/'.$nameFile;
            
            $folder = __DIR__.'/../../../public/uploads/';
            $file->move($folder, $nameFile);
            
            $mem->photo = $path;
            $mem->name = $request->name;
            $mem->address = $request->address;
            $mem->age = $request->age;
     
            if($mem->save()){
                return \Response::json([
                    'status' => true,
                    'message' => 'Update member success, have image !'
                ]);
            }else{
                return \Response::json([
                    'status' => false,
                    'message' => 'Update member failed !'
                ]);
            }
        }else{
            $mem->name = $request->name;
            $mem->address = $request->address;
            $mem->age = $request->age;
            if($mem->save()){
                return \Response::json([
                    'status' => true,
                    'message' => 'Update member success, not change image !'
                ]);
            }else{
                return \Response::json([
                    'status' => false,
                    'message' => 'Update member failed, not change image !'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        return \Response::json([
            'message' => 'Delete member success !'
        ]);
    }
}
