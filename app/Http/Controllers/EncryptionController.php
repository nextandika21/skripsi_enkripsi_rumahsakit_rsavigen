<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use DateTime;
use Auth;

use App\Models\Key;

class EncryptionController extends Controller
{
    function key(){
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

        $key = Key::find(9);
        $author = $key->value;
        $tanggal_update = $key->updated_at;

        return view('encryption.key',["tanggal_update"=>$tanggal_update,"author"=>$author]);
    }

    function test(){
        return view('encryption.test');
    }

    function key_generate(){
        //Vigenere Cipher Generate Key
        $vigenkey = "";
        for($i = 0; $i < 128; $i++) {
            $vigenkey = $vigenkey . mt_rand(0, 9);
        }
        $vigenkey = Key::where('name',"vigenkey")->update(['value' => $vigenkey]);

        Key::where("name","author")->update([
            "value" => Auth::user()->name
        ]);

        Session::flash('success', "Key berhasil di generate");

        return redirect('console/encryption/key');
    }

    public function test_dekripsi(Request $request){
        $plaintext = $this->dekrip($request->ciphertext);

        return response()->json($plaintext);
    }

    public function test_enkripsi(Request $request){
        $ciphertext = $this->enkrip($request->plaintext);

        return response()->json($ciphertext);
    }

    public function enkrip($data){
        $key = Key::where("name","vigenkey")->first();
        $key = $key->value;

        //Enkripsi vigenere
        $data_length = strlen($data);
        $arr_data = [];
        $kode_length = strlen($key);
        $arr_kode = [];
        for($i=0;$i<=$kode_length-1;$i++){
            $arr_kode[$i] = substr($key,$i,1);
        }
        $flag=0;
        $result_enkrip = "";
        for($i=0;$i<=$data_length-1;$i++){
            if($flag > $kode_length-1){
                $flag=0;
            }
            $arr_data[$i] = substr($data, $i,1);
            $arr_data[$i] = ord($arr_data[$i]);
            $arr_data[$i] = $arr_data[$i] + $arr_kode[$flag];
            $result_enkrip = $result_enkrip.strlen($arr_data[$i]).$arr_data[$i];
            $flag++;
        }
        $result_enkrip = $key.strlen($data_length).$data_length.$result_enkrip;

        return $result_enkrip;
    }

    public function dekrip($data){
        $key = substr($data, 0, 128);
        $data = substr($data, 128, strlen($data)-128);

        //dekrip vigenere
        $data_length = substr($data,1,substr($data,0,1));
        $split_length = substr($data,0,1)+1;
        $data_remain = substr($data,$split_length);
        $kode_length = strlen($key);
        $arr_kode = [];
        for($i=0;$i<=$kode_length-1;$i++){
            $arr_kode[$i] = substr($key,$i,1);
        }
        $flag=0;
        $result_dekrip = "";
        $arr_data = [];
        for($i=0;$i<=$data_length-1;$i++){
            if($flag > $kode_length-1){
                $flag=0;
            }
            $arr_data[$i] = substr($data_remain,1,substr($data_remain,0,1));
            $arr_data[$i] = $arr_data[$i] - $arr_kode[$flag];
            $arr_data[$i] = chr($arr_data[$i]);
            $result_dekrip = $result_dekrip.$arr_data[$i];
            $split_length = substr($data_remain,0,1)+1;
            $data_remain = substr($data_remain,$split_length);
            $flag++;
        }
        return $result_dekrip;
    }
}
