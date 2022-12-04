<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horoscopes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function upload_file(Request $request)
    {
        $filename = $request->file('file');
        //Controllo se il file è selezionato
        if ($filename == null) {
            Session::flash('message', 'Nessun file selezionato!');
            return redirect()->back();
        }
        //ottengo l'estensione del file
        $extension = $filename->getClientOriginalExtension();

        //Verifico l'estensione del file
        if ($extension !== 'csv') {
            Session::flash('message', 'Caricare solo file .csv!');
            return redirect()->back();
        }

        $header = [null];
        $data = array();    
        //Apriamo il file e leggegiamolo per poi convertirlo in un array
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 20000, '|')) !== false) {
                //Sostituisco le chiavi con i nomi delle colonne sul db
                $row = [
                    'description' => $row[1],
                    'date' => $row[2],
                    'zodiac_sign' => $row[3],
                ];
                
                if (!$header){
                    $header = $row;
                }else{
                    $data[] =  $row;
                }
            }
            fclose($handle);
        }

        //Qui elimino tutti i record se tento di ricaricare lo stesso file
        $existing_obj = Horoscopes::get();
        if (count($existing_obj) > 0) {
            DB::table('Horoscopes')->delete();
        }
       
        for ($i = 0; $i < count($data); $i++) {
            
            $model = new Horoscopes();
            $model->id = $i;
            $model->description = $data[$i]['description'];
            $model->date = \Carbon\Carbon::createFromFormat('m-d-Y', $data[$i]['date'])->format('Y-m-d');
            $model->zodiac_sign = $data[$i]['zodiac_sign'];
            $model->save(); 
        }

        Session::flash('message_success', 'Caricamento riuscito con successo!');
        return redirect()->back();
        
    }

    public function get_horoscopes(Request $request){

        $date = $request->input('date');
        $query = Horoscopes::where('date', $date)->get();
        
        return view('welcome', ['data' => $query]);
    }
}
