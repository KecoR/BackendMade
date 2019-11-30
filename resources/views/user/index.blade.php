@extends('layouts.main')

@section('title')
    - Kelola User
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
            Data User
        </h6>
        <a href="#" class="ml-auto d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Lengkap</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td style="width:20%">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->role_desc }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success editbutton" data-id="{{ $user->id }}">
                                    <i class="fa fa-sm fa-edit text-white"> Ubah</i>
                                </a>

                                <a href="#" class="btn btn-sm btn-danger delbutton" data-url="{{ route('users.delete', $user->id) }}">
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
                <form method="POST" action="{{ route('users.add') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role_id" class="form-control">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Umur</label>
                                    <input type="number" class="form-control" min="17" max="60" name="umur" value="17">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control" name="telp">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kel" class="form-control">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control"></textarea>
                                </div>
                            </div>
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
                <form method="POST" action="{{ route('users.edit') }}">
                    <input type="hidden" value="" id="id" name="id">
                    <input type="hidden" value="" id="old_password" name="old_password">
                    <input type="hidden" value="" id="old_tgl_lahir" name="old_tgl_lahir">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perubahan Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role_id" class="form-control" id="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Umur</label>
                                    <input type="number" class="form-control" min="17" max="60" name="umur" value="17" id="umur">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control" name="telp" id="telp">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kel" class="form-control" id="jenis_kel">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="text" id="tgl_lahir" class="form-control" disabled>
                                    <br>
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" id="alamat"></textarea>
                                </div>
                            </div>
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
            $.get('/users/getData/'+data_id, function(data){
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#role_id").val(data.role_id);
                $("#umur").val(data.umur);
                $("#telp").val(data.telp);
                $("#jenis_kel").val(data.jenis_kel);
                $("#tgl_lahir, #old_tgl_lahir").val(data.tgl_lahir);
                $("#alamat").val(data.alamat);
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