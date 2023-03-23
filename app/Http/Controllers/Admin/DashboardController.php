<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $petugas = Petugas::count();
        $detail = Petugas::get();
        $masyarakat = Masyarakat::count();

        $pending = Pengaduan::where('status', '0')->count();
        $proses = Pengaduan::where('status', 'proses')->count();

        $selesai = Pengaduan::where('status', 'selesai')->count();

        $selesaiData = Pengaduan::where('status', 'selesai')->orderBy('tgl_pengaduan', 'desc')->get();
        $prosesData = Pengaduan::where('status', 'proses')->orderBy('tgl_pengaduan', 'desc')->get();
        $pendingData = Pengaduan::where('status', '0')->orderBy('tgl_pengaduan', 'desc')->get();
    
        return view('Admin.Dashboard.index', ['petugas' => $petugas, 'masyarakat' => $masyarakat,'pending' => $pending, 'proses' => $proses, 'selesai' => $selesai,'detail'=> $detail, 'data_selesai' => $selesaiData, 'data_proses' => $prosesData, 'data_pending' => $pendingData]);
    }
    public function proses()
    {
        $Proses = Pengaduan::where('status', 'Proses')->count();
        $Selesai = Pengaduan::where('status', 'Selesai')->count();

        $pengaduan = Pengaduan::where('status', '0')->with('getDataMasyarakat')->paginate(5);
        $cetak = 'pending';

        return view('Admin.Dashboard.index', compact('pengaduan', 'Proses', 'Selesai'));
    }

    public function selesai()
    {
        $aduanProses = Pengaduan::where('status', 'Proses')->count();
        $aduanSelesai = Pengaduan::where('status', 'Selesai')->count();

        $pengaduan = Pengaduan::where('status' ,'Selesai')->with('getDataMasyarakat')->paginate(5);
        $cetak = 'selesai';

        return view('Admin.Dashboard.index', compact('pengaduan', 'Proses', 'Selesai'));
    }
}

