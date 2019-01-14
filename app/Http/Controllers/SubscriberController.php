<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:subscribers'
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();
        //Toastr::success('Assinatura efetuada com Sucesso!','Parabéns');
        toastr()->success('Assinatura efetuada com Sucesso!','Parabéns');
        return redirect()->back();
    }
}
