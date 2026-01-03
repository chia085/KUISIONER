@extends('manajemen')
@section('title', 'Mahasiswa - E-Kuesioner')
@section('page_title', 'Mahasiswa')
@section('content')
<div class="container mt-4 text-center">
    <h4 class="mb-4 fw-bold">Mahasiswa</h4>
    <button id="btnTambah" class="btn btn-primary mb-4 px-4 py-2">
        <i class="bi bi-plus-circle me-1"></i> Tambah E-Kuesioner
    </button>
    <div id="formKuesioner" class="card p-4 shadow mx-auto" style="max-width:600px;display:none;">
        <form id="kuesionerForm">
            <input type="text" id="judul" class="form-control mb-3" placeholder="Judul Kuesioner" required>
            <label class="fw-bold mb-2">Pertanyaan</label>
            <input type="text" class="form-control mb-2" placeholder="Pertanyaan 1">
            <input type="text" class="form-control mb-2" placeholder="Pertanyaan 2">
            <input type="text" class="form-control mb-2" placeholder="Pertanyaan 3">
            <input type="text" class="form-control mb-3" placeholder="Pertanyaan 4">
            <input type="text" class="form-control mb-3" placeholder="Saran dan masukan">
            <button class="btn btn-primary w-100">Simpan</button>
        </form>
    </div>
    <div id="daftarKuesioner" class="mt-4"></div>
</div>

<script>
const btnTambah=document.getElementById('btnTambah');
const formKuesioner=document.getElementById('formKuesioner');
const form=document.getElementById('kuesionerForm');
const daftar=document.getElementById('daftarKuesioner');
let editTarget=null;

btnTambah.addEventListener('click',()=>{form.reset();editTarget=null;formKuesioner.style.display=formKuesioner.style.display==='none'?'block':'none';});

form.addEventListener('submit',e=>{
 e.preventDefault();
 const judul=document.getElementById('judul').value.trim();
 if(!judul)return alert('Judul tidak boleh kosong');
 if(editTarget){editTarget.querySelector('span').textContent=judul;editTarget=null;}
 else{
   const div=document.createElement('div');
   div.classList='border rounded-pill px-4 py-2 mb-2 mx-auto d-flex justify-content-between align-items-center';
   div.style.maxWidth='600px';
   div.innerHTML=`<span>${judul}</span><div><i class="bi bi-pencil-square text-primary fs-5 me-3 btn-edit" style="cursor:pointer"></i><i class="bi bi-x-circle text-danger fs-5 btn-delete" style="cursor:pointer"></i></div>`;
   daftar.appendChild(div);
 }
 form.reset();formKuesioner.style.display='none';
});

daftar.addEventListener('click',e=>{
 if(e.target.classList.contains('btn-delete'))e.target.closest('div.border').remove();
 if(e.target.classList.contains('btn-edit')){const item=e.target.closest('div.border');document.getElementById('judul').value=item.querySelector('span').textContent;formKuesioner.style.display='block';editTarget=item;}
});
</script>
@endsection
