<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $title = "Company Profile";

        $item = CompanyProfile::find(1);

        return view('company.index', [
            'title' => $title,
            'item' => $item
        ]);     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save(Request $request){
        $data = $request->all();
        $image = $request->file('image');

        if ($image){
            $data['image'] = $image->storeAs(
                'public/assets/company', 'company.jpg'
            );
        }else{
            $data['image'] = "";
        }

        $currentProfile = CompanyProfile::find(1);

        if (!$currentProfile){
            CompanyProfile::create($data);
            return redirect()->route('company.index')->with('success','Profil toko berhasil disimpan!');
        }else{
            $currentProfile->update($data);
            return redirect()->route('company.index')->with('success','Profil toko berhasil disimpan!');
        }
    }
}
