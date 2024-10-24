@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sistem Pengajuan Cuti</h1>
                <div class="section-header-breadcrumb">
                </div>
            </div>

            <div class="section-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengajuan_cuti.update', $pengajuan_cuti) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label> 
                        <div class="col-sm-12 col-md-7">
                       
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $pengajuan_cuti->name }}" readonly>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Cuti</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="jenis_cuti" class="form-control selectric" required>
                                <option value="Tahunan" {{ $pengajuan_cuti->jenis_cuti == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                <option value="Harian" {{ $pengajuan_cuti->jenis_cuti == 'Harian' ? 'selected' : '' }}>Harian</option>
                                <option value="Bulanan" {{ $pengajuan_cuti->jenis_cuti == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                            @error('jenis_cuti')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Pengajuan</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="datetime-local" name="tanggal_pengajuan" class="form-control" value ="{{ $pengajuan_cuti->tanggal_pengajuan }}" required>

                 
                            @error('tanggal_pengajuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Mulai</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ $pengajuan_cuti->tanggal_mulai }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Selesai</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ $pengajuan_cuti->tanggal_selesai }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alasan</label>
                        <div class="col-sm-12 col-md-7">
                        <input type="text" name="alasan" class="form-control" value="{{ $pengajuan_cuti->alasan }}" required>
                            @error('alasan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="status" class="form-control selectric" required>
                                <option value="Pending" {{ $pengajuan_cuti->status == 'Pending' ? 'selected' : '' }} readonly>Pending</option>
                                @if(auth()->user()->role == 'ADMIN' || auth()->user()->role == 'ATASAN')
                                    <option value="Setujui" {{ $pengajuan_cuti->status == 'Setujui' ? 'selected' : '' }}>Setujui</option>
                                    <option value="Cuti Habis" {{ $pengajuan_cuti->status == 'Cuti Habis' ? 'selected' : '' }}>Cuti Habis</option>
                                @endif
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="path/to/jquery.selectric.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectric').selectric();
        });
    </script>

    <!-- Page Specific JS File -->
@endpush
