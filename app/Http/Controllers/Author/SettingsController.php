<?php

namespace App\Http\Controllers\Author;


use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('author.settings');
    }
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'image',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $user = User::findOrFail(Auth::id());
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('profile'))
            {
                Storage::disk('public')->makeDirectory('profile');
            }
            //Altera a imagem velha de perfil da pasta
            if (Storage::disk('public')->exists('profile/'.$user->image))
            {
                Storage::disk('public')->delete('profile/'.$user->image);
            }
            $profile = Image::make($image)->resize(500,500)->stream();
            Storage::disk('public')->put('profile/'.$imageName,$profile);
        } else {
            $imageName = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Perfil Alterado com Suecsso :)', 'Parabéns');
        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Senha Alterada com Sucesso :)','Parabéns');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('A nova senha não pode ser a mesma que a senha antiga :(','ERRO!!');
                return redirect()->back();
            }
        } else {
            Toastr::error('Senha atual inválida :(','ERRO!!');
            return redirect()->back();
        }
    }
}
