<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        // auth znaci da moras biti ulogovan da mi prisao akciji
        $this->middleware('auth')->except(['login', 'forgotpassword', 'forgotpasswordpost', 'passwordreset', 'passwordresetpost']);

        // samo admin ili moderator ako menja sebe, tj. svoje podatke
        $this->middleware('onlyadmin')->except(['welcome', 'edit', 'update', 'logout', 'changepassword', 'changepasswordpost', 'login', 'forgotpassword', 'forgotpasswordpost', 'passwordreset', 'passwordresetpost']);

        // vrsi redirekciju ako si vec ulogovan
        // samo za "gost" user-e
        $this->middleware('guest')->only(['login', 'forgotpassword','forgotpasswordpost', 'passwordreset', 'passwordresetpost']);
    }

    public function index(){
        // $users = User::where('deleted', 0)->get();
        $users = User::notdeleted()->get();
        return view('admin.users.index', compact('users'));
    }

    public function login(){

        // ako je post probaj login
        if(request()->isMethod('post')){
            // prvo ide validacija
            request()->validate([
                'email' => "required|string|email",
                'password' => "required",
                'g-recaptcha-response' => ['required', 'string', function ($attribute, $value, $fail) {
                    $secretKey = config('services.recaptcha.secret');
                    $response = $value;
                    $userIP = $_SERVER['REMOTE_ADDR'];
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                    $response = \file_get_contents($url);
                    $response = json_decode($response);
                    if (!$response->success) {
                        session()->flash('message', [
                            'type' => 'text-danger',
                            'text' => trans('Please check reCaptcha!'),
                        ]);
                        $fail($attribute . 'google Recaptcha failed');
                    }
                }
            ]]);

            // onda ide proba logina
            if(auth()->attempt([
                'email' => request()->email,
                'password' => request()->password,
                'active' => 1
            ])){
                // ako je uspesan login 
                // redirektuj gde kaze vlasnik portala
                return redirect()->intended(route('users.welcome'))
                        ->with(['message' => [
                            'type' => 'text-success',
                            'text' => trans('users.welcome-again'),
                        ]]);
            } else {
                // ako nije uspesan login
                // redirektuj nazad na login formu 
                // sa greskom da je nesto lose
                return redirect()->route('users.login')
                                ->withErrors(['email' => trans('auth.failed')])
                                ->withInput(['email' => request()->email]);
            }
        } 
        
        // ovo se desava ako je get
        return view('admin.users.login');
    }

    public function welcome(){
        
        return view('admin.users.welcome');
    }

    public function create(){
        
        return view('admin.users.create');
    }

    public function store(){
        // validacija
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:administrator,moderator',
            'password' => 'required|string|min:5|confirmed',
            // 'password-confirmed' => "same:password",
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $data['active'] = 1;
        $data['password'] = Hash::make($data['password']);

        // snimaje u bazu
        User::create($data);

        // redirekcija

        return redirect()
                ->route('users.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('users.success-created')
                ]);
    }

    public function edit(User $user){
        if(auth()->user()->role != "administrator" && auth()->id() != $user->id){
            // pokusao si da menjas kao moderator nekog ciji id nije tvoj
            abort(401, "No privileges");
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user){
        if(auth()->user()->role != "administrator" && auth()->id() != $user->id){
            // pokusao si da menjas kao moderator nekog ciji id nije tvoj
            abort(401, "No privileges");
        }

        // validacija
        $data = request()->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:administrator,moderator',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        // snimanje
        $user->name = $data['name'];
        $user->address = $data['address'];
        $user->phone = $data['phone'];
        if(auth()->user()->role == "administrator"){
            $user->role = $data['role'];
        }

        $user->save();

        // redirekcija
        return redirect()
                ->route('users.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('users.success-updated')
                ]);
    }

    public function changepassword(User $user){
        if(auth()->user()->role != "administrator" && auth()->id() != $user->id){
            // pokusao si da menjas kao moderator nekog ciji id nije tvoj
            abort(401, "No privileges");
        }
        
        return view('admin.users.changepassword', compact('user'));
    }

    public function changepasswordpost(User $user){
        if(auth()->user()->role != "administrator" && auth()->id() != $user->id){
            // pokusao si da menjas kao moderator nekog ciji id nije tvoj
            abort(401, "No privileges");
        }
        
        // validacija
        $data = request()->validate([
            'password' => 'required|string|min:5|confirmed',
        ]);

        // snimanje
        $user->password = Hash::make($data['password']);
        $user->save();

        // redirekcija
        if(auth()->user()->role == 'administrator'){
            // admin ide na listu svih korisnika
            return redirect()
                    ->route('users.index')
                    ->with('message', [
                        'type' => 'text-success',
                        'text' => trans('users.success-updated')
                    ]);
        } else {
            // svi ostali idu na dashboard sa porukom nekom da je uspesno
            return redirect()
                ->route('users.welcome')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('users.success-updated')
                ]);
        }
    }

    public function forgotpassword() {

        return view('admin.users.forgotpassword');
    }

    public function forgotpasswordpost() {
        // validacija
        request()->validate([
            'email' => 'required|string|email'
        ]);

        // slanje linka za reset password-a
        $message = Password::sendResetLink(request()->only('email'));

        // ako je uspesno, poruka odgovara konstanti RESET_LINK_SENT
        if ($message == Password::RESET_LINK_SENT) {
            // vracamo se na istu stranicu sa porukom o uspesnom slanju
            return back()->with(['message' => [
                'type' => 'text-success',
                'text' => trans($message)
                ]]);
        } else {
            // ako je neuspesno, odnosno ako korisnik nije pronadjen, vracamo se sa porukom o greski
            return back()->withErrors(['email' => trans($message)]);
        }
    }

    public function passwordreset($token) {

        return view('admin.users.passwordreset', compact('token'));
    }

    public function passwordresetpost() {
        // validacija
        $data = request()->validate([
            'token' => 'required',      
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        /* Htela sam da uradim poredjenje tokena iz request-a sa tokenom iz baze, da neko ne bi preko inspect-a mogao da izmeni i prodje
        validaciju. Nisam nasla rule za to, s obzirom na to da je u bazi token hash-ovan. Palo mi je prvo na pamet da pisem custom rule, 
        ali nisam to uradila. Nasla sam drugi nacin, koji koristi metodu Hash::check(), a preko DB fasade sam izvukla iz baze token. 
        Ostavila sam to zakomentarisano ispod za svaki slucaj. */

        // odgovarajuci token iz baze
        // $dbToken = DB::table('password_resets')->where('email', $data['email'])->first('token')->token;
        // if (Hash::check($data['token'], $dbToken) ) {
        //     // ako se podudaraju, sve ok, moze se ovde ubaciti kod ispod
        // } else {
        //     // ako se ne podudaraju, vrati se natrag sa porukom da token nije validan
        //     return back()->withErrors(['token' => 'Token not valid!']);
        // }
     

        /* Ovo je bio "rucno radjeni" reset koji vise lici na sve sto smo dosad radili,
        ali sam pretpostavila da treba da iskoristimo Password fasadu;
        ipak nisam bila sigurna, pa sam ostavila za svaki slucaj obe stvari */

        // dohvatamo user-a koji je zatrazio promenu password-a 
        //$user = User::where('email', $data['email'])->first();

        // izmena password-a i snimanje
        //$user->password = Hash::make($data['password']);
        //$user->save();

        // redirekcija sa porukom
        // return redirect()->route('users.login')
        //                 ->with('message', [
        //                     'type' => 'text-success',
        //                     'text' => trans('users.password-updated')
        //                 ]);


        // reset password-a
        $message = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);     
                $user->save();
                //Auth::loginUsingId($user->id);    // ako bismo hteli da ulogujemo korisnika; login ili loginUsingId metoda
                event(new PasswordReset($user));
            }
        );
    
        // redirekcija
        if ($message == Password::PASSWORD_RESET) {
            // vracamo se na login stranicu sa porukom o uspesnom slanju

            return redirect()
                        ->route('users.login')
                        ->with('message',[
                            'type' => 'text-success',
                            'text' => trans($message)]);
        } else {
            // ako je neuspesno, ostajemo na istoj stranici i ispisujemo gresku
            return back()->withErrors(['email' => trans($message)]);
        }
    }

    public function status(User $user){

        if($user->active == 1){
            $user->active = 0;
        } else {
            $user->active = 1;
        }
        $user->save();

        // redirekcija
        return redirect()
                ->route('users.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('users.changed-status')
                ]);
    }

    public function delete(User $user){
        // $user->delete();
        if(auth()->user()->role == "administrator"){
            $user->deleted = 1;
            $user->deleted_by = auth()->user()->id;
            $user->save();
        } else {
            Log::info("User " . auth()->user()->name . ' tried to delete user ' . $user->name);
            Auth::logout();
            // redirekcija
            return redirect()
            ->route('users.login')
            ->with('message', [
                'type' => 'text-success',
                'text' => trans('users.no-auth')
            ]);
        }

        // redirekcija
        return redirect()
                ->route('users.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('users.success-deleted')
                ]);
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();
 
        request()->session()->regenerateToken();

        return redirect(route('users.login'))
                    ->with('message', [
                        'type' => 'text-success',
                        'text' => trans('users.logout-success')
                    ]);

    }
}
