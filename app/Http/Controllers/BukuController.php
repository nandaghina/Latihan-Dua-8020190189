<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index (Request $request)
    {
        $data['objek'] = \App\Buku::latest()->paginate(10);
        return view('buku_index', $data);
    }
    public function tambah()

    {   

    $data['objek'] = new \App\Buku();

    $data['action'] = 'BukuController@simpan';

$data['method'] = 'POST';

$data['nama_tombol'] = 'SIMPAN';

return view('buku_form', $data);

}

public function simpan(Request $request)

{

$request->validate([

'name' => 'required|min:2',

'email' => 'required|email|unique:users,email',

'password' => 'same:password_confirmation'

]);

$objek = new \App\Buku();

$objek->name = $request->name;

$objek->email = $request->email;

$objek->password = bcrypt($request->password);

$objek->save();

//\App\Buku::create($request->except('password_confirmation'));

return back()->with('pesan', 'data sudah disimpan');

}
public function edit($id)

{

$data['objek'] = \App\Buku::findOrFail($id);

$data['action'] = ['BukuController@update', $id];

$data['method'] = 'PUT';

$data['nama_tombol'] = 'UPDATE';

return view('buku_form', $data);

}

public function update(Request $request, $id)

{

$request->validate([

'name' => 'required|min:2',

'email' => 'required|email|unique:users,email,' . $id,

'password' => 'same:password_confirmation'

]);

$objek = \App\Buku::findOrFail($id);

$objek->name = $request->name;

$objek->email = $request->email;

if ($request->password != "") {

$objek->password = bcrypt($request->password);

}

$objek->save();

return redirect('admin/buku/index')->with('pesan', 'data sudah diupdate');

}
public function hapus($id)

{

$objek = \App\Buku::findOrFail($id);

$objek->delete();

return back()->with('pesan', 'Data berhasil dihapus');

}
}
