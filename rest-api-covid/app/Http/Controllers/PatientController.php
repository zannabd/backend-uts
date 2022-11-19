<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    #--------------Menampilkan Seluruh Data Pasien-----------------
    #----------------------method index----------------------------
    public function index()
    {
        # menggunakan model Patient untuk select data
        $patients = Patient::all();

        if(count($patients) > 0) {
        $data = [
            'message' => 'Get All Resource Patient',
            'data' => $patients
        ];

        return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data is empty'
            ];

            return response()->json($data, 200);
        }
    }

    #---------------Menambahkan Data Pasien Baru--------------------
    #----------------------Method store-----------------------------
    public function store(Request $request)
    {
        #validasi data
        $validateData = $request->validate([
            # kolom => rules|rules
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required'

        ]);
        # menggunakan Patient untuk insert data
        $patient = Patient::create($validateData);

        $data = [
            'message' => 'Resource is added succesfully',
            'data' => $patient
        ];

        # mengembalikan nilai json
        return response()->json($data, 201);
    }

    #-------------------Menampilkan detail data------------------------
    #------------------------Method show-------------------------------
    public function show($id)
    {
        # cari data dengan id
        $patient = Patient::find($id);

        if($patient) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patient
            ];
            # mengembalikan data json
            return response()->json($data, 200);
            } else {
                $data = [
                    'message' => 'Resource not found'
                ];

                return response()->json($data, 404);
            }
        
    }

    #----------------------Mengedit data pasien---------------------
    #-------------------------method put---------------------------
    public function update(Request $request, $id)
    {
        # mencari data dengan id
        $patient = Patient::find($id);

        if($patient) {
            # menangkap data
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at,
            ];
            # menggunakan fungsi update pada psien
            $patient->update($input);

            $data = [
                'message' => 'Resource is updated succesfully',
                'data' => $patient
            ];

            return response()->json($data, 200);
            } else {
                $data = [
                    'message' => 'Resource not found',
                ];

                return response()->json($data, 404);
            }
        
    }

    #------------------Menghapus data pasien------------------------
    #-----------------------method destroy--------------------------
    public function destroy($id)
    {
        # mencari data pasien dengan id
        $patient = Patient::find($id);

        if($patient) {
            $patient->delete($id);

            $data = [
                'message' => 'Resource is deleted succesfully',
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            return response()->json($data, 404);
        }
    }

    #----------------Menampilkan data berdasarkan nama-------------------
    #--------------------method search-----------------------------------
    public function search($name)
    {
        # mencari data dengan nama
        $patient = Patient::where('name', 'like','%'.$name.'%')->get();
        
        if(count($patient) > 0) {
            $data = [
                'message' => 'Get searched Resource',
                'data' => $patient
            ];

            return response()->json($patient, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            return response()->json($data, 404);
        }
    }

    #---------------Menampilkan data pasien yang positif------------------------
    #-----------------------Method positive-------------------------------------
    public function positive()
    {
        # mencari data dengan status
        $patient = Patient::where('status','positif')->get();

        $data = [
            'message' => 'Get positive resource',
            'jumlah' => $patient->count(),
            'data' => $patient
        ];

        return response()->json($data, 200);
    }

    #--------------Menampilkan data pasien yang sembuh-----------------------
    #-----------------------method recovered------------------------------------
    public function recovered()
    {
        # mencari data dengan status
        $patient = Patient::where('status','sembuh')->get();

        # menampilkan data
        $data = [
            'message' => 'Get positive resource',
            'jumlah' => $patient->count(),
            'data' => $patient
        ];
        # mengembalikan data json
        return response()->json($data, 200);
    }

    #-------------Menampilkan data pasien yang meninggal---------------------------
    #------------------------method dead------------------------------------------
    public function dead()
    {
        # mencari data dengan status
        $patient = Patient::where('status','meninggal')->get();

        # menampilkan data
        $data = [
            'message' => 'Get positive resource',
            'jumlah' => $patient->count(),
            'data' => $patient
        ];

        # mengembalikan data json
        return response()->json($data, 200);
    }
}