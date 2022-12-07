<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
        $data = Message::paginate(10);
        return view('message.index',compact('data'));
    }
    public function delete($id){
        Message::where('id',$id)->delete();
        return $id;
    }
}
