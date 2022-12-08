<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request){
        $data = Message::paginate(10);
        $terkirim = Message::where('status',1)->count();
        $gagal = Message::where('status',2)->count();
        $pending = Message::where('status',0)->count();
        if($request->filter_status=='terkirim'){
            $data = Message::where('status',1)->paginate(10);
        }
        if($request->filter_status=='gagal'){
            $data = Message::where('status',2)->paginate(10);
        }
        if($request->filter_status=='pending'){
            $data = Message::where('status',0)->paginate(10);
        }
        return view('message.index',compact('data','terkirim','gagal','pending'));
    }
    public function delete($id){
        Message::where('id',$id)->delete();
        return $id;
    }
}
