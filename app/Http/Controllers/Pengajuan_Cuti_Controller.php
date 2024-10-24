<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCutiStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cuti;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CutiExport; // Pastikan ini diimpor dengan benar

class Pengajuan_Cuti_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pencarian berdasarkan nama jika ada
        $user = Auth::user();
        $pengajuan_cuti = DB::table('pengajuan_cuti')

        ->when(in_array($user->role, ['ADMIN', 'ATASAN']), function ($query) {
            return $query; // Jika admin atau atasan, ambil semua data
        }, function ($query) use ($user) {
            return $query->where('name', $user->name); // Jika bukan admin atau atasan, ambil berdasarkan nama
        })
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Return view dengan data pengajuan cuti
        return view('pages.Cuti.index', compact('pengajuan_cuti'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.Cuti.ajukan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([

            'name' => 'required|string|max:255',
            'jenis_cuti' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
            'status' => 'required|string',
            'file' => 'nullable|mimes:pdf',
        ]);
 
        // Buat data pengajuan cuti baru
        $pengajuan_cuti = Cuti::create([
            'name' => Auth::user()->name,
            'jenis_cuti' => $request->jenis_cuti,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => $request->status,
            'file' => null, // Placeholder, akan diisi setelah PDF dihasilkan
        ]);

        // Generate PDF dan simpan path ke database
        $pdfPath = $this->generatePDF($pengajuan_cuti);
        $pengajuan_cuti->update(['file' => $pdfPath]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pengajuan_cuti.index')->with('success', 'Pengajuan cuti berhasil disimpan dan PDF telah dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari data pengajuan cuti berdasarkan id
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Cari data pengajuan cuti untuk diedit
         $pengajuan_cuti = Cuti::findOrFail($id);
    
        // Return view edit dengan data pengajuan cuti
        
        return view('pages.Cuti.edit')->with('pengajuan_cuti', $pengajuan_cuti);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCutiStore $request, $id)
    {
        // Cari data pengajuan cuti berdasarkan ID
        $pengajuan_cuti = Cuti::findOrFail($id);

       
    
        // Validasi data dari request
        $validatedData = $request->validated(); 
        
        $validatedData['name'] = $pengajuan_cuti->name;// Ambil data yang sudah divalidasi
    
        // Update data pengajuan cuti dengan data yang divalidasi
        $pengajuan_cuti->update($validatedData);

        $pdfPath = $this->generatePDF($pengajuan_cuti);
        $pengajuan_cuti->update(['file' => $pdfPath]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pengajuan_cuti.index')->with('success', 'Pengajuan cuti berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari data pengajuan cuti berdasarkan id
        $pengajuan_cuti = Cuti::findOrFail($id);

        // Hapus data
        $pengajuan_cuti->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pengajuan_cuti.index')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Generate PDF for the given Cuti instance.
     */
    private function generatePDF(Cuti $cuti)
    {
        // Ambil data pengajuan cuti dari model $cuti
        $data = [
            'name' => $cuti->name,
            'jenis_cuti' => $cuti->jenis_cuti,
            'tanggal_pengajuan' => $cuti->tanggal_pengajuan,
            'tanggal_mulai' => $cuti->tanggal_mulai,
            'tanggal_selesai' => $cuti->tanggal_selesai,
            'alasan' => $cuti->alasan,
            'status' => $cuti->status,
        ];
    
        // Membuat HTML untuk PDF
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Pengajuan Cuti</title>
            <p>Pt.Jaya Makmur Selaras</p>
           
            <p> Jl. Cikunir Raya No.10, RT.002/RW.013, Jatiasih, Kec. Jatiasih, Kota Bks, Jawa Barat 17423</p>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                table, th, td { border: 1px solid black; padding: 8px; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
        .signature span {
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
 <body>

        <h1>Pengajuan Cuti</h1>
        
        <div class="content">
            <p>Kepada Yth. <strong>HRD</strong></p>
            <p>Dengan hormat,</p>
            <p>
                Saya, <strong>' . htmlspecialchars($data['name']) . '</strong>, 
                dengan ini mengajukan permohonan cuti <strong>' . htmlspecialchars($data['jenis_cuti']) . '</strong> 
                yang akan berlangsung dari tanggal <strong>' . htmlspecialchars($data['tanggal_mulai']) . '</strong> 
                sampai dengan <strong>' . htmlspecialchars($data['tanggal_selesai']) . '</strong>. 
                Tanggal pengajuan cuti ini adalah <strong>' . htmlspecialchars($data['tanggal_pengajuan']) . '</strong>.
            </p>
            <p>
                Untuk informasi, waktu pengajuan ini dilakukan pada <strong>' . now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') . ' WIB</strong>.
            </p>
            <p>
                Adapun alasan saya mengajukan cuti ini adalah sebagai berikut:<br>
                <strong>' . htmlspecialchars($data['alasan']) . '</strong>
            </p>

            <div style="margin-top: 20px;">
                <strong>Status:</strong> <span>' . htmlspecialchars($data['status']) . '</span>
            </div>
        </div>

        <p style="margin-top: 90px;">
            Terima kasih atas perhatian dan pengertian Bapak/Ibu<br>
            <br><br>
            Hormat saya,<br>
            
            <br>
            <br><br>
            <strong>' . htmlspecialchars($data['name']) . '</strong><br>
           
        </p>

       
        </div>

    </body>
</html>
        </html>';
    
        // Muat HTML ke PDF
        $pdf = PDF::loadHtml($html);
        // (Optional) Set ukuran dan orientasi kertas
        $pdf->setPaper('A4', 'potrait');
        // Render PDF
        $output = $pdf->output();
    
        // Tentukan path penyimpanan PDF
        $pdfPath = 'pdfs/pengajuan_cuti_' . $cuti->id . '.pdf';
    
        // Simpan PDF ke storage
        file_put_contents(storage_path('app/public/' . $pdfPath), $output);
    
        // Kembalikan path PDF yang disimpan
        return $pdfPath;
    }

    public function download($id)
    {
        // Cari data pengajuan cuti berdasarkan ID
        $pengajuan_cuti = Cuti::findOrFail($id);

        // Ambil path file yang akan diunduh
        $filePath = storage_path('app/public/' . $pengajuan_cuti->file);

        // Cek apakah file ada
        if (file_exists($filePath)) {
            // Lakukan proses download file
            return response()->download($filePath);
        } else {
            // Jika file tidak ditemukan, kembali dengan pesan error
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
}

public function history(Request $request)
{
    $user = Auth::user();
    $query = Cuti::query();

    // Jika user adalah ADMIN atau ATASAN, ambil semua pengajuan cuti
    if (in_array($user->role, ['ADMIN', 'ATASAN'])) {
        // Ambil semua data
    } else {
        // Jika bukan, ambil berdasarkan nama karyawan
        $query->where('name', $user->name);
    }

    // Jika ada parameter tanggal mulai dan tanggal selesai
    if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        // Filter berdasarkan rentang tanggal
        $query->whereBetween('tanggal_mulai', [$tanggal_mulai, $tanggal_selesai]);
    }

    // Ambil data dengan paginasi
    $pengajuan_cuti = $query->orderBy('id', 'desc')->paginate(10);

    return view('pages.Cuti.history', compact('pengajuan_cuti'));
}

public function export()
{
    return Excel::download(new CutiExport, 'cutis.xlsx');
}


    
}
