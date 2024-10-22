@extends('layouts.app')

@section('title', 'History Pengajuan Cuti')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
    <div class="section-header">
        <h1>History Pengajuan Cuti</h1>
        
        <div class="section-header-breadcrumb">
                </div>
            </div>
            

        <!-- Form untuk filter history berdasarkan tanggal -->
        <form action="{{ route('cuti.history') }}" method="GET" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="tanggal_selesai">Tanggal Selesai:</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                </div>
            </div>
        </form>

        @if($pengajuan_cuti->isEmpty())
            <p>Tidak ada pengajuan cuti untuk periode yang dipilih.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                       
                        <th>Nama</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan_cuti as $cuti)
                        <tr>
                          
                            <td>{{ $cuti->name }}</td>
                            <td>{{ $cuti->jenis_cuti }}</td>
                            <td>{{ $cuti->tanggal_pengajuan }}</td>
                            <td>{{ $cuti->tanggal_mulai }}</td>
                            <td>{{ $cuti->tanggal_selesai }}</td>
                            <td>{{ $cuti->alasan }}</td>
                            <td>{{ $cuti->status }}</td>
                            <td>{{ $cuti->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tampilkan pagination -->
            {{ $pengajuan_cuti->links() }}
        @endif
    </section>
</div>
@endsection
