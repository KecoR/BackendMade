@extends('layouts.main')

@section('title')
    - Kelola Role
@endsection

@section('content')
<div class="card shadow mb-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if(session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
    @endif
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">
            Data Lowongan
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Lowongan</td>
                        <td>Gaji</td>
                        <td>Slot</td>
                        <td>Status</td>
                        <td style="width:20%">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vacancies as $vacancy)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vacancy->judul }}</td>
                            <td>{{ $vacancy->gaji }} / {{ $vacancy->tipe_gaji }}</td>
                            <td>{{ $vacancy->buruh }} / {{ $vacancy->slot }}</td>
                            <td>
                                @if ($vacancy->status == 0)
                                    Menunggu Persetujugan
                                @else
                                    @if ($vacancy->status == 1)
                                        Disetujui
                                    @else
                                        @if ($vacancy->status == -1)
                                            Ditolak
                                        @else
                                            Full
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($vacancy->status == 0)
                                    <a href="{{ route('vacancy.approve', $vacancy->id) }}" class="btn btn-sm btn-success">
                                        Terima
                                    </a>

                                    <a href="{{ route('vacancy.reject', $vacancy->id) }}" class="btn btn-sm btn-danger">
                                        Tolak
                                    </a>
                                @else
                                    <a href="#" class="btn btn-sm btn-success disabled">
                                        Terima
                                    </a>

                                    <a href="#" class="btn btn-sm btn-danger disabled">
                                        Tolak
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $("table").DataTable({
                "ordering" : false
            });
        });
    </script>
@endsection