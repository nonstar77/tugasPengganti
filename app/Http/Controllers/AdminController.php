<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //menampilkan form untuk menambahkan data admin
    public function create()
    {
        return view('admin.add');
    }
    
    // menyimpan data admin ke dalam tabel
    public function store(Request $request)
    {
        //validasi input dari form
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        //menyimpan data admin ke dalam tabel menggunakan DB::insert
        DB::insert(
            'INSERT INTO admin(id_admin,nama_admin, alamat, username, password) VALUES (:id_admin, :nama_admin, :alamat, :username, :password)',
            [
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );

        //redirect ke halaman index dengan pesan "success"
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    //menampilkan semua data admin dari tabel
    public function index()
    {
        $datas = DB::select('select * from admin');
        return view('admin.index')->with('datas', $datas);
    }

    //menampilkan form untuk mengedit data admin
    public function edit($id)
    {
        //mengambil data admin berdasarkan ID
        $data = DB::table('admin')->where('id_admin', $id)->first();
        return view('admin.edit')->with('data', $data);
    }

    //update data admin dalam tabel
    public function update($id, Request $request)
    {
        //validasi input dari form
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        //update data admin dalam tabel menggunakan DB::update
        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama_admin = :nama_admin, alamat = :alamat, username = :username, password = :password WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );

        //redirect ke halaman index dengan pesan "success"
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }

    //menghapus data admin dari tabel
    public function delete($id)
    {
        //menghapus data admin berdasarkan ID
        DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);
        //redirect ke halaman index dengan pesan "success"
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }


}
