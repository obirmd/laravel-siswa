<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('cari')) {
           $data_siswa = \App\Siswa::where('nama_depan','LIKE','%'.$request->cari.'%')->get();
        }else{
             $data_siswa = \App\Siswa::all();
        }
        return view('siswa.index', ['data_siswa' => $data_siswa]);
    }

    public function create(Request $request)
    {
        // validasi data
        $this->validate($request, [
                'nama_depan' => 'required|min:3',
                'nama_belakang' => 'required',
                'email' => 'required|email|unique:users',
                'jenis_kelamin' => 'required',
                'agama' => 'required|min:4',
                'avatar' => 'mimes:jpg,png,jpeg',
        ]);
       // insert ke table user
       $user = new \App\User;
       $user->role = 'siswa';
       $user->name = $request->nama_depan;
       $user->email = $request->email;
       $user->password = bcrypt('2123');
       // $user->remember_token = str_random(60);
       $user->save();
        // insert ke table siswa
        $request->request->add(['user_id' => $user->id]);
       $siswa = \App\Siswa::create($request->all());
        if ($request->hasFile('avatar')) {
           $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
           $siswa->avatar = $request->file('avatar')->getClientOriginalName();
           $siswa->save();
       }
      return redirect('/siswa')->with('succes','Data berhasil ditambah');
    }

    public function edit($id)
    {
        $siswa = \App\Siswa::find($id);
        return view('siswa.edit', ['siswa' => $siswa]);
    }

    public function update(Request $request,$id)
    {
       $siswa = \App\Siswa::find($id);
       $siswa->update($request->all());
       if ($request->hasFile('avatar')) {
           $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
           $siswa->avatar = $request->file('avatar')->getClientOriginalName();
           $siswa->save();
       }
       return redirect('/siswa')->with('succes','Data berhasil update');
    }

    public function delete($id)
    {
        $siswa = \App\Siswa::find($id);
        $siswa->delete($siswa);
        return redirect('/siswa')->with('succes', 'Data berhasil dihapus');

    }

    public function profile($id)
    {
        $siswa = \App\Siswa::find($id);
        $matapelajaran = \App\Mapel::all();
        // menyiapkan data untuk char
        $categories = [];
        $data = [];
        foreach ($matapelajaran as $mp) {
            if($siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()){
                 $categories[] = $mp->nama;
                 $data[] = $siswa->mapel()->wherePivot('mapel_id',$mp->id)->first()->pivot->nilai;
            }
        }
        return view('siswa.profile', ['siswa' => $siswa,'matapelajaran' => $matapelajaran,'categories' => $categories, 'data' => $data]);
    }

    public function addnilai(Request $request,$idsiswa)
    {
        $siswa = \App\Siswa::find($idsiswa);
        if($siswa->mapel()->where('mapel_id',$request->mapel)->exists()){
            return redirect('siswa/'.$idsiswa.'/profile')->with('error', 'Nilai mata pelajaran telah tambah');
        }
        $siswa->mapel()->attach($request->mapel,['nilai' => $request->nilai]);
        return redirect('siswa/'.$idsiswa.'/profile')->with('succes', 'Nilai berhasil ditambah');
    }

    public function deletenilai($idsiswa,$idmapel)
    {
        $siswa = \App\Siswa::find($idsiswa);
        $siswa->mapel()->detach($idmapel);
        return redirect()->back()->with('succes', 'Data Nilai Berhasi Dihapus');
    }


}


