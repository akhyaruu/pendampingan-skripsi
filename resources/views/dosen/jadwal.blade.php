@extends('layouts.admin')
@section('page','Manajemen Jadwal')
@section('breadcrumb')
<li><a href="#" class="fw-normal">Jadwal Bimbingan {{ $proposal->mahasiswa }}</a></li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row justify-content-center">

      @if (!isset($jadwal))
      <div class="card align-middle">
         <div class="card-body">
            Mahasiswa belum ada jadwal bimbingan
            <button class="btn btn-primary bBuatJadwal" style="float: right;" data-bs-toggle="modal"
               data-bs-target="#mainModal"><i class="fas fa-calendar-alt"></i>&nbsp; Buat Jadwal</button>
         </div>
      </div>
      @endif


      <script>
      let bimbinganId = '';
      </script>
      @if (isset($jadwal))

      @foreach ($jadwal as $item)
      <script>
      bimbinganId = "{{ $item->bimbingan_id }}";
      </script>
      @endforeach

      <div class="row">
         <div class="mb-3">
            <h4>Jadwal Bimbingan</h4>
            <button class="btn btn-primary bJadwalBaru" data-bs-toggle="modal" data-bs-target="#mainModal"><i
                  class=" fas fa-calendar-plus"></i> &nbsp; Jadwal Baru</button>
         </div>

         <div>
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </div>
            @elseif (session('success'))
            <div class="alert alert-success" role="alert">
               {{ session('success') }}
            </div>
            @endif
         </div>

         <div class="col-lg-4 col-md-4 overflow-auto" style="max-height: 400px;">
            <div class="list-group">
               <script>
               var jadwal = [];
               </script>
               @foreach ($jadwal as $item)
               <script>
               var jadwalObject = {};
               jadwalObject.id = '{{ $item->id }}';
               jadwal.push(jadwalObject);
               </script>
               @if ($loop->first)
               <a href="#" class="list-group-item list-group-item-action active bJadwal" idJadwal="{{ $item->id }}"
                  aria-current="true" data-bs-toggle="modal" data-bs-target="#modalJadwal">
                  <div class="d-flex w-100 justify-content-between">
                     <h5 class="mb-1">Bimbingan baru <small>(ke-{{ $jumlahBimbingan }})</small></h5>
                     <small>{{ date("d-m-Y", strtotime($item->tgl_bimbingan)) }}</small>
                  </div>
                  <p class="mb-1">{{ $item->judul }}</p>
               </a>
               <hr>
               @else
               <a href="#" class="list-group-item list-group-item-action bJadwal" idJadwal="{{ $item->id }}"
                  aria-current="true" data-bs-toggle="modal" data-bs-target="#modalJadwal">
                  <div class="d-flex w-100 justify-content-between">
                     <h5 class="mb-1">Bimbingan sebelumnya </h5>
                     <small>{{ date("d-m-Y", strtotime($item->tgl_bimbingan)) }}</small>
                  </div>
                  <p class="mb-1">{{ $item->judul }}</p>
               </a>
               @endif
               @endforeach

            </div>

         </div>

         <div class="col-lg-8 col-md-8">

            <div class="card">
               <div class="card-body">

                  <h4 class="mb-3">Detail Proposal</h4>
                  <div>
                     <h5 class="fw-bold d-inline">Topik</h5>
                     <p>{{ $proposal->topik }}</p>
                  </div>
                  <div>
                     <h5 class="fw-bold d-inline">Judul</h5>
                     <p>{{$proposal->judul  }}</p>
                  </div>
                  <div>
                     <h5 class="fw-bold d-inline">Abstrak</h5>
                     @if (!isset($proposal->abstrak))
                     <p class="text-danger">abstrak belum ditambahkan</p>
                     @else
                     <p>{{ $proposal->abstrak }}</p>
                     @endif

                  </div>

               </div>
            </div>

         </div>
      </div>
      @endif


   </div>



   <!-- Main Modal -->
   <div class="modal fade" id="mainModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <form id="formBimbingan" action="" method="POST">
               @csrf
               <input type="text" name="mahasiswa_id" value="{{ $proposal->mahasiswa_id }}" hidden>
               <input type="text" name="proposal_id" value="{{ $proposal->id }}" hidden>
               <input id="input-bimbingan-id" type="text" name="bimbingan_id" value="" hidden>
               <div class="modal-header">
                  <h5 class="modal-title fw-bold">Atur Jadwal Bimbingan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="mb-3">
                     <label for="input-date" class="form-label">Tanggal Bimbingan</label>
                     <input type="date" name="tgl_bimbingan" class="form-control" id="input-date"
                        aria-describedby="emailHelp" required>
                  </div>
                  <div class="mb-3">
                     <label for="input-judul" class="form-label">Judul</label>
                     <input type="text" name="judul" class="form-control" id="input-judul" required>
                  </div>
                  <div class="mb-3">
                     <label for="input-catatan" class="form-label">Catatan</label>
                     <textarea name="catatan" class="form-control"
                        placeholder="Catatan tambahan seperti link zoom atau lainnya" id="abstrakForm"
                        style="height: 120px" required></textarea>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger text-light bClear"><i class="fas fa-eraser"></i>
                     Clear</button>
                  <button type="submit" class="btn btn-primary bSubmit"><i class="fas fa-upload"></i>&nbsp;
                     Submit</button>
               </div>
            </form>

         </div>
      </div>
   </div>

   <!-- Modal Detail Jadwal -->
   <div class="modal fade" id="modalJadwal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Bimbingan</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
               <div class="modal-body">
                  <div class="mb-3">
                     <label for="input-date" class="form-label">Tanggal Bimbingan</label>
                     <input type="date" name="tgl_bimbingan" class="form-control" id="input-date"
                        aria-describedby="emailHelp" required>
                  </div>
                  <div class="mb-3">
                     <label for="input-judul" class="form-label">Judul</label>
                     <input type="text" name="judul" class="form-control" id="input-judul" required>
                  </div>
                  <div class="mb-3">
                     <label for="input-catatan" class="form-label">Catatan</label>
                     <textarea name="catatan" class="form-control"
                        placeholder="Catatan tambahan seperti link zoom atau lainnya" id="abstrakForm"
                        style="height: 120px" required></textarea>
                  </div>
                  <div class="mb-3">
                     <label for="input-judul" class="form-label">Judul</label>
                     <textarea name="catatan" class="form-control"
                        placeholder="Catatan tambahan seperti link zoom atau lainnya" id="abstrakForm"
                        style="height: 120px" required></textarea>
                  </div>
               </div>
               <div class="m-3">
                  <button type="submit" class="btn btn-warning"><i class="fas fa-upload"></i>&nbsp;
                     Submit</button>
                  <div style="float: right;">
                     <button type="button" class="btn btn-info text-white bRevisi"><i
                           class="fas fa-clipboard-list"></i>&nbsp; Tambah Revisi</button>
                     <form id="formJadwalSelesai" action="{{ route('m-bimbingan.jadwal.update') }}" class="pull-left"
                        method="POST">
                        @csrf
                        <input id="input-id-jadwal" type="hidden" name="id" value="">
                        <button type="button" onclick="return confirm('tandai jadwal bimbingan sudah selesai?')"
                           class="btn btn-primary bSelesai"><i class="fas fa-check text-white"></i>&nbsp;
                           Selesai</button>
                     </form>
                  </div>


               </div>
            </form>
         </div>
      </div>
   </div>


</div>
@endsection

@section('script')
<script>
$(document).ready(function() {

   let idJadwal = '';

   $(".bClear").click(function() {
      $('#formBimbingan :input').val('');
   });

   $(".bJadwalBaru").click(function() {
      $("#formBimbingan").attr("action", "{{ route('m-bimbingan.jadwal.create.new') }}");
      $('#input-bimbingan-id').val(bimbinganId);
   });

   $(".bBuatJadwal").click(function() {
      $("#formBimbingan").attr("action", "{{ route('m-bimbingan.jadwal.create') }}");
   });

   $(".bJadwal").click(function() {
      $("#formBimbingan").attr("action", "{{ route('m-bimbingan.jadwal.create') }}");


      idJadwal = $(this).attr('idJadwal');
      jadwal.forEach(element => {
         if (element.id == idJadwal) {
            $("#input-id-jadwal").val(element.id);
         }
      });

   });

   $(".bSelesai").click(function() {
      $('#formJadwalSelesai').submit();
   });

   $(".bRevisi").click(function() {});


});
</script>
@endsection