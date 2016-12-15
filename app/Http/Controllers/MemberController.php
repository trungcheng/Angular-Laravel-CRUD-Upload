<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $member = new Member();
    	if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $folder = public_path('uploads');

            $filename = $file->getClientOriginalName();
            $pathfile1 = rand(100,10000).'-'.$filename;

            $ext = $file->getClientOriginalExtension();
            $allowed = array('jpg','png','gif');

            if(in_array($ext, $allowed)){
                
                $member->name = $request->name;
                $member->address = $request->address;
                $member->age = $request->age;
                $member->photo = 'public/uploads/'.$pathfile1;
                $member->save();

                $file->move($folder, $pathfile1);
                return response()->json([
                    'status' => true,
                    'message' => 'Add new member success !'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Photo format wrong !'
                ]);
            }
        }else{
            $member->name = $request->name;
            $member->address = $request->address;
            $member->age = $request->age;
     
            if($member->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'Add new member success but not photo !'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Create member failed !'
                ]);
            }
        }
    }

    public function uploadImg(Request $request)
    {

        if ($request->hasFile('myFile')) {
            $file = $request->file('myFile');
            $folder = public_path('uploads');

            $filename = $file->getClientOriginalName();
            $pathfile = rand(100,10000).'-'.$filename;

            $ext = $file->getClientOriginalExtension();
            $allowed = array('jpg','png','gif');

            if(in_array($ext, $allowed)){
                $file->move($folder, $pathfile);
                return response()->json([
                    'path' => 'public/uploads/'.$pathfile,
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Photo format wrong !'
                ]);
            }
        }
    }

    public function checkDuplicate($name){
        $member = Member::where('name','=',$name)->get();
        if(count($member) > 0){
            return response()->json([
                'status' => false,
                'message' => 'This name has been already exist !'
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'OK'
            ]);
        }
    }

    public function edit($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }

    public function show($id){
        $member_detail = Member::where('id', '=' , $id)->get();
        return response()->json([
            'data' => $member_detail,
            'message' => 'Show member success'
        ],200);
    }

    public function update(Request $request,$id)
    {
    	$mem = Member::find($id);
            
        $mem->name = $request->name;
        $mem->address = $request->address;
        $mem->age = $request->age;
        $mem->photo = $request->photo;
 
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
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        return response()->json([
            'data' => $member,
            'message' => 'Delete member success !'
        ]);
    }
}
