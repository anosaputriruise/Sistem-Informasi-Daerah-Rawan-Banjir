@extends('layouts.layout')
@section('title', 'Data Tahun')
@section('login_as', 'Administrator')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->name }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->name }}
    @endif
@endsection
@section('sidebar-menu')
    @include('admin/sidebar')
@endsection
@push('styles')
    <style>
        #detail:hover{
            text-decoration: underline !important;
            cursor: pointer !important;
            color:teal;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Data Tahun
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <form action="" method="POST">

                <div class="row" style="margin-right:-15px; margin-left:-15px;">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block" id="berhasil">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Berhasil: </strong> {{ $message }}
                            </div>
                            @else
                            <div class="alert alert-success alert-block" id="keterangan">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua data tahun yang tersedia !!
                            </div>
                        @endif
                    </div>
                    {{ csrf_field() }} {{ method_field('PATCH') }}
                    <div class="col-md-12">
                        <a onclick="tambahTahun()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-plus"></i>&nbsp; Tambah Tahun</a>
                        <table class="table table-striped table-bordered" id="table" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no=1;
                                @endphp
                                @foreach ($tahuns as $tahun)
                                    <tr>
                                        <td> {{ $no++ }} </td>
                                        <td> {{ $tahun->tahun }} </td>
                                        <td>
                                            <a onclick="ubahTahun({{ $tahun->id }})" class="btn btn-info btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-edit"></i></a>
                                            <a onclick="hapusTahun({{ $tahun->id }})" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!-- Modal hapus -->
                            <div class="modal modal-default fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tahun.delete') }} " method="POST">
                                        <div class="modal-header modal-header-danger">
                                            <p style="font-size:15px;" class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i>&nbsp;Form Konfirmasi Hapus Data Tahun</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }} {{ method_field("DELETE") }}
                                            <input type="hidden" name="tahun_id" id="tahun_id" >
                                            Apakah anda yakin akan menghapus data?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm"  style="color:white;" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                            <button type="submit" class="btn btn-primary btn-sm" style="color:white"><i class="fa fa-check-circle"></i>&nbsp; Ya, Hapus</button>
                                        </div>
                                    </form>

                                </div>
                                </div>
                            </div>
                        </table>
                        <!-- Modal tambah -->
                        <div class="modal modal-default fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header modal-header-danger">
                                    <p style="font-size:15px;" class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i>&nbsp;Form Tambah Data Tahun</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.tahun.post') }} " method="POST">
                                        {{ csrf_field() }} {{ method_field("POST") }}
                                        <input type="hidden" name="id" >
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tahun</label>
                                            <input type="text" class="form-control" name="tahun" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm"  style="color:white;" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                    <button type="submit" class="btn btn-primary btn-sm" style="color:white"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal ubah -->
                    <div class="modal modal-default fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                                <p style="font-size:15px;" class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i>&nbsp;Form Ubah Data Tahun</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.tahun.update') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field("PATCH") }}
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tahun</label>
                                        <input type="text" class="form-control" name="tahun" id="tahun" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm"  style="color:white;" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                <button type="submit" class="btn btn-primary btn-sm" style="color:white"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
                "ordering": false,
            });
        } );

        function tambahTahun(){
            $('#modaltambah').modal('show');
        }

        function ubahTahun(id){
            $.ajax({
                url: "{{ url('admin/tahun') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id').val(data.id);
                    $('#tahun').val(data.tahun);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusTahun(id){
            $('#modalhapus').modal('show');
            $('#tahun_id').val(id);
        }

    </script>
@endpush
