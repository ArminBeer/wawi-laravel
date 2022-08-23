<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Rules\OnlyAscii;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('user.index', array (
            'users' => $users
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new OnlyAscii],
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
        ]);

        // Image
         if ($request->image) {
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();

            $filePath = public_path('storage') . '/thumbnails';

            $img = Image::make($image->path());
            $img->resize(800, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('storage') . '/images';
            $image->move($filePath, $input['imagename']);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => User::generatePassword(),
            'staff_right' => ($request->input('staff_right') ? 1 : 0),
            'kitchen_watch_right' => ($request->input('kitchen_watch_right') ? 1 : 0),
            'kitchen_edit_right' => ($request->input('kitchen_edit_right') ? 1 : 0),
            'warehouse_right' => ($request->input('warehouse_right') ? 1 : 0),
            'stocktaking_right' => ($request->input('stocktaking_right') ? 1 : 0),
            'order_right' => ($request->input('order_right') ? 1 : 0),
            'picture' => ($request->image ? ('/thumbnails/' . $input['imagename']) : null),
        ])->sendWelcomeEmail();

        return redirect('/user')->with('success', 'Mitarbeiter angelegt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        return view('user.edit', array (
            'user' => $user->toArray()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', new OnlyAscii, 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user)],
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
            ]);

        // Image
        if ($request->image) {
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();

            $filePath = public_path('storage') . '/thumbnails';

            $img = Image::make($image->path());
            $img->resize(800, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('storage') . '/images';
            $image->move($filePath, $input['imagename']);

            $user->picture = '/thumbnails/' . $input['imagename'];
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->staff_right = ($request->input('staff_right') ? 1 : 0);
        $user->kitchen_watch_right = ($request->input('kitchen_watch_right') ? 1 : 0);
        $user->kitchen_edit_right = ($request->input('kitchen_edit_right') ? 1 : 0);
        $user->warehouse_right = ($request->input('warehouse_right') ? 1 : 0);
        $user->stocktaking_right = ($request->input('stocktaking_right') ? 1 : 0);
        $user->order_right = ($request->input('order_right') ? 1 : 0);
        $user->save();

        return redirect('/user')->with('success', 'Mitarbeiterdaten erfolgreich geändert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect('/user')->with('success', 'Mitarbeiter gelöscht');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return redirect('/user')->with('success', 'Passwort Resetlink abgeschickt');

    }
}
