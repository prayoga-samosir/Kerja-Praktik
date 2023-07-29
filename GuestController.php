<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function __construct()
    {
        $this->middleware('auth:admin');
        if (!Auth::guard('admin')->check() || !Session::get('temph1')) {
            return redirect('/login');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function search(Request $request)
    {

        if ($request->ajax()) {
            $temph1 = Session::get('temph1');
            $temph2 = Session::get('temph2');
            $temph3 = Session::get('temph3');
            $temph4 = Session::get('temph4');
            $ip = Session::get('ip');
            $browser = Session::get('browser');

            $output = "";
            $id_user = Auth::guard('admin')->user()->id_member;

            $search_guest = "";
            // dd($request);

            if ($request->id_level) {
                $search_guest = DB::select("CALL sp_chc_guest ('search_advance','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','$request->search','$request->id_membertype','$request->id_gender','$request->id_blood','$request->id_level','$request->id_occupation','$request->id_expertise','','','','','','','','','','','','')");
            } else {
                $search_guest = DB::select("CALL sp_chc_guest ('search_simple','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','$request->search','','','','','','','','','','','','','','','','','','')");
                // die($search_guest);
            }

            if (isset($search_guest[0]->message)) {
                return redirect('/logout_error');
            }

            if ($search_guest) {
                // dump($search_guest);
                foreach ($search_guest as $key => $item) {
                    // dump($key . " => " . $item->nameguest);
                    $thumbnail = "";
                    $thumb = "";
                    $teks = $item->nameguest;
                    // die('line 74');
                    if ($item->photoguest == "") {
                        $teks = explode(",", $teks);

                        foreach ($teks as $t) {
                            $kata = substr($t, 0, 1);
                            $thumbnail .= $kata . " ";
                        }
                        if (isset($teks[0])) {
                            $thumb = substr($thumbnail, 0, 1);
                        }
                        if (isset($teks[1])) {
                            $thumb = substr($thumbnail, 0, 1);
                        }

                        $stat =  '';
                    } else {
                        $thumb = '<img src="' . $item->photoguest . '" alt="">';
                    }

                    $stat =  '';


                    $output .= '<li class="list-group-item">' .
                        '<a style="color: #212529" href="' . url("profile/" . $item->id_guest) . '">' .
                        '<div class="row">' .
                        '<div class="col-auto">' .
                        '<div class="avatar avatar-50 shadow rounded-10 text-white" style="background-color: #E73712;">' .
                        $thumb .
                        '</div>' .
                        '</div>' .
                        '<div class="col align-self-center ps-0">' .
                        '<p class="text-color-theme mb-0">' . $item->nameguest . '</p>' .
                        '<p class="text-muted size-12">' . $item->address . ' </p>' .
                        '</div>' .
                        '<div class="col-auto text-end">' .
                        '<p>' .
                        '<small class="text-muted size-12">Online <span class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>' .
                        '</p>' .
                        '</div>' .
                        '</div>' .
                        '</a>' .
                        '</li>';
                }

                return Response($output);
            }
        }
    }

    public function searchabjad(Request $request)
    {

        if ($request->ajax()) {
            $temph1 = Session::get('temph1');
            $temph2 = Session::get('temph2');
            $temph3 = Session::get('temph3');
            $temph4 = Session::get('temph4');
            $ip = Session::get('ip');
            $browser = Session::get('browser');

            $output = "";
            $id_user = Auth::guard('admin')->user()->id_member;


            $serach_member = DB::select("CALL sp_chc_guest ('sel_index','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','$request->abjad1','$request->abjad2','','','','','','','','','','','','','','','')");


            // dd($serach_member);
            if (isset($serach_member[0]->message)) {
                return redirect('/logout_error');
            }

            if ($serach_member) {

                foreach ($serach_member as $key => $item) {
                    $thumbnail = "";
                    $thumb = "";
                    $teks = $item->namemember;
                    if ($item->photomember == "") {
                        $teks = explode(",", $teks);

                        foreach ($teks as $t) {
                            $kata = substr($t, 0, 1);
                            $thumbnail .= $kata . " ";
                        }
                        if (isset($teks[0])) {
                            $thumb = substr($thumbnail, 0, 1);
                        }
                        if (isset($teks[1])) {
                            $thumb = substr($thumbnail, 0, 1);
                        }

                        $stat = '';
                    } else {
                        $thumb = '<img src="' . $item->photomember . '" alt="">';
                    }

                    $stat = '';


                    $output .= '<li class="list-group-item">' .
                        '<a style="color: #212529" href="' . url("profile/" . $item->id_member) . '">' .
                        '<div class="row">' .
                        '<div class="col-auto">' .
                        '<div class="avatar avatar-50 shadow rounded-10 text-white" style="background-color: #E73712;">' .
                        $thumb .
                        '</div>' .
                        '</div>' .
                        '<div class="col align-self-center ps-0">' .
                        '<p class="text-color-theme mb-0">' . $item->namemember . '</p>' .
                        '<p class="text-muted size-12">' . $item->address . ' </p>' .
                        '</div>' .
                        '<div class="col-auto text-end">' .
                        '<p>' .
                        '<small class="text-muted size-12">Online <span class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>' .
                        '</p>' .
                        '</div>' .
                        '</div>' .
                        '</a>' .
                        '</li>';
                }


                return Response($output);
            }
        }
    }

    public function index()
    {
        // dd(Auth::guard('admin')->user()->id_member);
        $id_user = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        // dd($temph1,$temph2,$temph3,$temph4,$ip,$browser);
        // $serach_member = DB::select("CALL sp_chc_guest ('search_simple','$temph1','$temph2','$temph3','$temph4','$id_member','$ip','$browser','','','','','andi','','','','','','','','','','','','','','','','','','')");
        // dd($serach_member);

        $data = DB::select("CALL sp_chc_guest ('search_default_isdisplayed','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','$id_user','','','','','','','','','','','','','','','','','','','') ");
        $gender = DB::select("CALL sp_mst_gender ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','$id_user','','','','','','','','','','','','','','','','','','','')");
        $membertype = DB::select("CALL sp_mst_membertype ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $marriage = DB::select("CALL sp_mst_statusmarriage ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        $occupation = DB::select("CALL sp_mst_occupation ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')  ");
        $expertise = DB::select("CALL sp_mst_expertise ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')  ");
        $blood = DB::select("CALL sp_mst_blood ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        $level = DB::select("CALL sp_mst_level ('sel_all_dropdown_search','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        $team = DB::select("CALL sp_chc_member ('search_default_isdisplayed','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        $sel_ab = DB::select("CALL sp_chc_guest ('sel_index_ab','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        $bodymember = true;
        $organizations = DB::select("CALL sp_mst_church ('sel_all_dropdown','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");

        if (isset($data[0]->message) || isset($team[0]->message)) {
            return redirect('/logout_error');
        }
        // dd($sel_ab);

        return view('guest', compact('data', 'gender', 'membertype', 'level', 'occupation', 'expertise', 'blood', 'team', 'sel_ab', 'bodymember', 'organizations',));
    }

    public function guest($id_guest)
    {
        // dd(Auth::guard('admin')->user()->id_member);
        $id_user = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        // dd($temph1,$temph2,$temph3,$temph4,$ip,$browser);

        $sel_ab = DB::select("CALL sp_chc_guest ('sel_profile','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','$id_guest','','','','','','','','','','','','','','','','','','','')");
        $organizations = DB::select("CALL sp_mst_church ('sel_all_dropdown','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        // dd($organizations);
        // dd($sel_ab);

        return view('profile-guest', compact('sel_ab', 'organizations'));
    }

    public function guestview($id_guest)
    {
        // dd(Auth::guard('admin')->user()->id_member);


        $id_user = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        // dd($temph1, $temph2, $temph3, $temph4, $ip, $browser);

        $sel_ab = DB::select("CALL sp_chc_guest ('sel_profile','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','$id_guest','','','','','','','','','','','','','','','','','','','')");
        $organizations = DB::select("CALL sp_mst_church ('sel_all_dropdown','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','')");
        // dump($sel_ab);
        // dd($organizations);
        return view('edit-guest', compact('sel_ab', 'organizations'));
    }

    public function gueststore(Request $request)
    {
        $get_id = Crypt::decrypt($request->get_id);

        $id_member = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        // dd($id_member, $temph1, $temph2, $temph3, $temph4, $ip, $browser);
        // dump('cek param ' . $get_id);
        // dump('cek param ' . $request->nameguest);
        // dump('cek param ' . $request->phone);
        // dump('cek param ' . $request->address);
        // dd('cek param ' . $request->noteguest);

        DB::select("CALL sp_chc_guest ('upd_guest','$temph1','$temph2','$temph3','$temph4','$id_member','$ip','$browser','','','','$get_id','$request->id_church','$request->nameguest','$request->phone','$request->address','$request->noteguest','','','','','','','','','','','','','','')");


        // dd($sel_ab);
        // $data = DB::select("CALL sp_chc_guest ('upd_guest','$temph1','$temph2','$temph3','$temph4','$id_user','$ip','$browser','','','','$id_guest','','','','','','','','','','','','','','','','','','','')");
        // dd('cek param ' . $request->id_guest);
        // dd('cek param ' . $request->id_church);
        // dd('cek param ' . $request->nameguest);
        // dd('cek param ' . $request->phone);
        // dd('cek param ' . $request->address);
        // dd('cek param ' . $request->noteguest);

        // dd($request->$id_user);
        return redirect('profile-guest/' . $get_id . '#pageprofileguest')->with(['success' => 'Data berhasil diubah!']);
    }

    public function education_detail($id)
    {
        $id = Crypt::decrypt($id);
        // dd(Auth::guard('admin')->user()->id_member);
        // $slide = DB::select("CALL sp_landing ('sel_slideshow','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $aniv = DB::select("CALL sp_landing ('sel_anniversary','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $birthday = DB::select("CALL sp_landing ('sel_birthday','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $news = DB::select("CALL sp_landing ('sel_news','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $offering = DB::select("CALL sp_landing ('sel_offering','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        // $events = DB::select("CALL sp_landing ('sel_events','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')");
        $id_member = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        $listedu = DB::select("CALL sp_mst_education ('sel_all_dropdown','$temph1','$temph2','$temph3','$temph4','$id_member','$ip','$browser','','','','','','','','','','','','','','','','','','','','','','','') ");
        $data = DB::select("CALL sp_chc_guest ('sel_profile_education_one','$temph1','$temph2','$temph3','$temph4','$id_member','$ip','$browser','','','','$id','','','','','','','','','','','','','','','','','','','')  ");
        if (isset($listedu[0]->message) || isset($data[0]->message)) {
            return redirect('/logout_error');
        }
        // dd($data); 
        $data = $data[0];

        return view('profile.edit_edu', compact('listedu', 'data'));
    }

    public function guestadd(Request $request)
    {
        $id_member = Auth::guard('admin')->user()->id_member;

        $temph1 = Session::get('temph1');
        $temph2 = Session::get('temph2');
        $temph3 = Session::get('temph3');
        $temph4 = Session::get('temph4');
        $ip = Session::get('ip');
        $browser = Session::get('browser');

        $guest = DB::select("CALL sp_chc_guest ('ins_guest','$temph1','$temph2','$temph3','$temph4','$id_member','$ip','$browser','','','','$request->id_organization','$request->guestname','$request->mobile','$request->address','$request->remark','','','','','','','','','','','','','','','') ");

        return redirect('guest/#pageguest')->with(['success' => 'Data berhasil ditambah!']);
    }
}
