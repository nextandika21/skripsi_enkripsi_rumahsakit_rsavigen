<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EncryptionController;

use Illuminate\Http\Request;
use Session;

use App\Models\Patient;

class PatientController extends Controller
{
    protected $EncryptionController;

    public function __construct(EncryptionController $EncryptionController)
    {
        $this->EncryptionController = $EncryptionController;
    }

    public function messages(){
        return [
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.max' => 'NIK tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter',
            'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
        ];
    }

    public function index()
    {
        echo 
        '<html>
        <head>
        <style>
        .loader{
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("https://i.pinimg.com/originals/e9/29/1e/e9291eaddacd460280a34a151dcc5cc4.gif") 
                        50% 50% no-repeat #0e1e2f;
            background-size: 100px;
        }
        </style>
        </head>
        <body>
        <div class="loader"></div>
        </body>
        </html>';

        $patient = Patient::all();
        $length_data = count($patient);
        for($i=0;$i<=$length_data-1;$i++){
            $patient[$i]->nik = $this->EncryptionController->dekrip($patient[$i]->nik);
            $patient[$i]->nama = $this->EncryptionController->dekrip($patient[$i]->nama);
            $patient[$i]->tanggal_lahir = $this->EncryptionController->dekrip($patient[$i]->tanggal_lahir);
            $patient[$i]->jenis_kelamin = $this->EncryptionController->dekrip($patient[$i]->jenis_kelamin);
            $patient[$i]->alamat = $this->EncryptionController->dekrip($patient[$i]->alamat);
            $patient[$i]->nomor_hp = $this->EncryptionController->dekrip($patient[$i]->nomor_hp);
        }

        return view('patient.index',['patient'=>$patient]);
    }

    public function add()
    {
        echo 
        '<html>
        <head>
        <style>
        .loader{
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("https://i.pinimg.com/originals/e9/29/1e/e9291eaddacd460280a34a151dcc5cc4.gif") 
                        50% 50% no-repeat #0e1e2f;
            background-size: 100px;
        }
        </style>
        </head>
        <body>
        <div class="loader"></div>
        </body>
        </html>';

        return view('patient.add');
    }

    public function add_save(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string|max:255',
            'nomor_hp' => 'required'
        ], $this->messages());

        $checkpatient = Patient::where("nik", $this->EncryptionController->enkrip($request->nik))->first();
        if($checkpatient){
            Session::flash('error', "NIK sudah terdaftar");
            return redirect()->back();
        }

        $patient = new Patient;
        $patient->nik = $this->EncryptionController->enkrip($request->nik);
        $patient->nama = $this->EncryptionController->enkrip($request->nama);
        $patient->tanggal_lahir = $this->EncryptionController->enkrip($request->tanggal_lahir);
        $patient->jenis_kelamin = $this->EncryptionController->enkrip($request->jenis_kelamin);
        $patient->alamat = $this->EncryptionController->enkrip($request->alamat);
        $patient->nomor_hp = $this->EncryptionController->enkrip($request->nomor_hp);
        $patient->save();

        Session::flash('success', "Patient berhasil ditambahkan");
        return redirect('console/patient');
    }

    public function profile($id)
    {
        echo 
        '<html>
        <head>
        <style>
        .loader{
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("https://i.pinimg.com/originals/e9/29/1e/e9291eaddacd460280a34a151dcc5cc4.gif") 
                        50% 50% no-repeat #0e1e2f;
            background-size: 100px;
        }
        </style>
        </head>
        <body>
        <div class="loader"></div>
        </body>
        </html>';

        $patient = Patient::find($id);
        $patient->nik = $this->EncryptionController->dekrip($patient->nik);
        $patient->nama = $this->EncryptionController->dekrip($patient->nama);
        $patient->tanggal_lahir = $this->EncryptionController->dekrip($patient->tanggal_lahir);
        $patient->jenis_kelamin = $this->EncryptionController->dekrip($patient->jenis_kelamin);
        $patient->alamat = $this->EncryptionController->dekrip($patient->alamat);
        $patient->nomor_hp = $this->EncryptionController->dekrip($patient->nomor_hp);
        return view('patient.profile',['patient'=>$patient]);
    }

    public function profile_save(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string|max:255',
            'nomor_hp' => 'required'
        ], $this->messages());

        $patient = Patient::find($id);
        $patient->nama = $this->EncryptionController->enkrip($request->nama);
        $patient->tanggal_lahir = $this->EncryptionController->enkrip($request->tanggal_lahir);
        $patient->jenis_kelamin = $this->EncryptionController->enkrip($request->jenis_kelamin);
        $patient->alamat = $this->EncryptionController->enkrip($request->alamat);
        $patient->nomor_hp = $this->EncryptionController->enkrip($request->nomor_hp);
        $patient->save();

        Session::flash('success', "Data patient berhasil diubah");
        return redirect('console/patient');
    }

    public function delete($id)
    {
        $patient = Patient::find($id);
        $patient->delete();

        Session::flash('success', "Patient berhasil dihapus");
        return response()->json("berhasil");
    }
}
