<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscriber', compact('subscribers'));
    }

    public function destroy($subscriber)
    {
        $subscriber = Subscriber::findorFail($subscriber);
        $subscriber->delete();
        toastr()->success('Assinatura excluida com Sucesso :)','Parabéns');
        return redirect()->back();

    }
}
