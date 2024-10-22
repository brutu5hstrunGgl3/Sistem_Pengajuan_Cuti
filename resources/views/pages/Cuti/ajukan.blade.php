@extends('layouts.app')

@section('title', 'New User')

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

                <form action="{{ route('pengajuan_cuti.store') }}" method="POST">
                    @csrf

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label> 
                        <div class="col-sm-12 col-md-7">
                            <input type="hidden" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required>
                            <p class="form-control-plaintext">{{ auth()->user()->name }}</p>

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
                                <option value="Hamil"> Cuti Hamil</option>
                                <option value="Menikah">Cuti Menikah</option>
                                <option value="Sakit">Cuti Sakit</option>
                                <option value="Sakit">Cuti Bersama</option>
                                <option value="Sakit">Cuti Lainnya</option>

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
                            <input type="datetime-local" name="tanggal_pengajuan" class="form-control" required>
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
                            <input type="datetime-local" name="tanggal_mulai" class="form-control" required>
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
                            <input type="datetime-local" name="tanggal_selesai" class="form-control" required>
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
                            <input type="text" name="alasan" class="form-control" placeholder="Masukkan alasan pengajuan cuti" required>
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
                                <option value="Pending">Pending</option>
                                @if(auth()->user()->role == 'ADMIN' || auth()->user()->role == 'ATASAN')
                                    <option value="Setujui">Setujui</option>
                                    <option value="Cuti Habis">Cuti Habis</option>
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
