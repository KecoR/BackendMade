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
            Data Role
        </h6>
        <a href="#" class="ml-auto d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Role Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Role Deskripsi</td>
                        <td style="width:20%">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->role_desc }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success editbutton" data-id="{{ $role->id }}">
                                    <i class="fa fa-sm fa-edit text-white"> Ubah</i>
                                </a>

                                <a href="#" class="btn btn-sm btn-danger delbutton" data-url="{{ route('roles.delete', $role->id) }}">
                                    <i class="fa fa-sm fa-trash text-white"> Hapus</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('roles.add') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    @csrf
                        <div class="form-group">
                            <label>Role Deskripsi</label>
                            <input type="text" class="form-control" name="role_desc">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('roles.edit') }}">
                    <input type="hidden" value="" id="id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perubahan Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    @csrf
                        <div class="form-group">
                            <label>Role Deskripsi</label>
                            <input type="text" class="form-control" name="role_desc" id="role_desc">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
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
        $(document).on("click",".editbutton",function(){
            let data_id = $(this).attr('data-id');
            $.get('/roles/getData/'+data_id, function(data){
                $("#id").val(data.id);
                $("#role_desc").val(data.role_desc);
                $("#editModal").modal('show');
            });
        });
        $(document).on("click",".delbutton",function(){
            let url = $(this).attr('data-url');
            let confirmation = confirm("Yakin ingin menghapus data ini ?");
            if(confirmation){
                window.location.href = url;
            }
        });
    </script>
@endsection