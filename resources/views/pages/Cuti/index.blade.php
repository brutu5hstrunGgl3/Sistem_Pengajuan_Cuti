@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pt.Jaya Makmur Selaras</h1>
                <div class="section-header-button">
                    <a href="{{route('pages.Cuti.ajukan')}}"
                        class="btn btn-primary">Tambah Pengajuan Cuti</a>
                </div>
                <div class="section-header-breadcrumb">
                   
                </div>
            </div>
            <div class="section-body">
                
            @include('layouts.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                           

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
              
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                           
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-left">

                                </div>
                                <div class="card-body">
                                <div class="float-left">
                                <a href="{{ route('cutis.export') }}" class="btn btn-success">Export to Excel</a>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('pengajuan_cuti.index') }}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                
                                                placeholder="Search" name="name">
                                                
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Jenis Cuti</th>
                                            <th>Tanggal pengajuan</th>
                                            <th>Tanggal mulai</th>
                                            <th>Tanggal selesai</th>
                                            <th>Alasan</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                           @foreach ($pengajuan_cuti as $cuti)
                                            <tr>
                                            <td>
                                            {{ $cuti->name }}
                                            </td>
                                            <td>
                                            {{ $cuti->jenis_cuti}}
                                            </td>
                                            <td>
                                            {{ $cuti->tanggal_pengajuan }}
                                            </td>
                                            <td>
                                            {{ $cuti->tanggal_mulai}}
                                            </td>
                                            <td>
                                            {{ $cuti->tanggal_selesai }}
                                            </td>
                                            <td>
                                            {{ $cuti->alasan}}
                                            </td>
                                            <td>
                                            {{ $cuti->status }}
                                            </td>
                                            <td>
                                            @if($cuti->file)
                                            <a href="{{route('pengajuan_cuti.download', $cuti->id)}}" class="btn btn-primary">Download PDF</a>
    @else
        Tidak ada file
    @endif
                                            </td>
                                            <td>
                                                
                                            <div class="d-flex justify-content-center">
                                                         <a href="{{ route('pengajuan_cuti.edit', $cuti->id) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>
                                                        @if(auth()->user()->role == 'ADMIN' || auth()->user()->role == 'ATASAN')
                                                        <form onclick="return confirm('are you sure ? ')"  class="d-inline" action="{{route('pengajuan_cuti.destroy', $cuti->id)}}" method="POST"
                                                            class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                            @endif
                                                        </form>
                                                        <!-- Modal Konfirmasi Penghapusan -->

                                                        <!-- ====== -->
                                                    </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div class="float-right">
                                {{ $pengajuan_cuti->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
