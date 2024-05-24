@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container" style="background-color: transparent;">
    <h1>Detail Proyek: {{ $project->nama_pekerjaan }}</h1>
    <p></p>
    <div class="progressbar-wrapper">
       @foreach($steps as $index => $step)
            <div class="step {{ getStatusColor($step['number'], $currentStatus) }}">
                <div class="step-circle">{{ $step['number'] }}</div>
                <div class="step-title">{{ $step['name'] }}</div>
            </div>
            @if($index < count($steps) - 1)
                <!-- Garis horizontal antara langkah -->
                <div class="step-connector {{ getConnectorColor($step['number'], $currentStatus) }}"></div>
            @endif
        @endforeach
    </div>

    <h1 style="margin-top:15px; margin-bottom: 15px;">Daftar Task</h1>

@foreach($tasksStatic as $index => $taskStatic)
    <div class="task-item">
        <button class="toggle-task" data-index="{{ $index }}" data-project-name="{{ $project->nama_pekerjaan }}">{{ $taskStatic['nama_task'] }}</button>
        <div class="task-content" id="task{{ $index }}" style="display: none;">
            <!-- Tombol Add Task di atas tabel -->
            <button class="btn btn-primary mb-3 add-task-btn" data-toggle="modal" data-target="#addTaskModal{{ $index }}">Add Task</button>
            <!-- Tabel untuk data dari database Task -->
            <table class="table-responsive" id="taskTable{{ $index }}"> 
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Program Kegiatan</th>
                        <th>Plan Date Start</th>
                        <th>Plan Date End</th>
                        <th>Actual Date Start</th>
                        <th>Actual Date End</th>
                        <th>Dokumen Output</th>
                        <th>PIC</th>
                        <th>Divisi Terkait</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop melalui $tasks berdasarkan project_id -->
                    @foreach($tasks->where('nama_task', $taskStatic['nama_task']) as $task)
                        <tr>
                            <td style="padding: 5 5; white-space:nowrap;">
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-primary edit-task-btn" data-task-id="{{ $task->id }}" data-project-name="{{ $project->nama_pekerjaan }}" data-toggle="modal" data-target="#editTaskModal{{ $index }}" onclick="editTask(this)">Edit</button>
                                <!-- Tombol Delete -->
                                <button type="button" class="btn btn-danger delete-task-btn" data-task-id="{{ $task->id }}" data-project-name="{{ $project->nama_pekerjaan }}" onclick="deleteTask(this)">Delete</button>
                            </td>
                            <td>
                                @if ($task->program_kegiatan)
                                    <?php $trimmedName = (strlen($task->program_kegiatan) > 20) ? substr($task->program_kegiatan, 0, 20) . '...' : $task->program_kegiatan; ?>
                                    <span title="{{ $task->program_kegiatan }}">
                                        {{ $trimmedName }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $task->plan_date_start }}</td>
                            <td>{{ $task->plan_date_end }}</td>
                            <td>{{ $task->actual_date_start }}</td>
                            <td>{{ $task->actual_date_end }}</td>
                            <td>
                                @if ($task->dokumen_output)
                                    <?php $trimmedName = (strlen($task->dokumen_output) > 20) ? substr($task->dokumen_output, 0, 20) . '...' : $task->dokumen_output; ?>
                                    <a href="{{ route('file.download', $task->dokumen_output) }}" title="{{ $task->dokumen_output }}">
                                        {{ $trimmedName }}
                                    </a>
                                @else
                                    No document
                                @endif
                            </td>
                            <td>{{ $task->pic }}</td>
                            <td>{{ $task->divisi_terkait }}</td>
                            <td>{{ $task->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<!-- Tambah Task Baru Modal -->
@foreach($tasksStatic as $index => $taskStatic)
    <div class="modal fade" id="addTaskModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel{{ $index }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel{{ $index }}">Tambah Task Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Formulir Tambah Task -->
                <form action="{{ route('projects.storeTask', ['nama_pekerjaan' => $project->nama_pekerjaan]) }}" method="POST" class="modal-body add-task-form" enctype="multipart/form-data">
                    @csrf
                    <!-- Isi Formulir -->
                    <div class="form-group">
                        <label for="project_id">Project ID:</label>
                        <input type="text" class="form-control" id="project_id" name="project_id" value="{{ $project->id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="program_kegiatan">Program Kegiatan:</label>
                        <input type="text" class="form-control" id="program_kegiatan" name="program_kegiatan" placeholder="Program Kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="plan_date_start">Plan Date Start:</label>
                        <input type="date" class="form-control" id="plan_date_start" name="plan_date_start" required>
                    </div>
                    <div class="form-group">
                        <label for="plan_date_end">Plan Date End:</label>
                        <input type="date" class="form-control" id="plan_date_end" name="plan_date_end" required>
                    </div>
                    <div class="form-group">
                        <label for="actual_date_start">Actual Date Start:</label>
                        <input type="date" class="form-control" id="actual_date_start" name="actual_date_start" required>
                    </div>
                    <div class="form-group">
                        <label for="actual_date_end">Actual Date End:</label>
                        <input type="date" class="form-control" id="actual_date_end" name="actual_date_end" required>
                    </div>
                    <div class="form-group">
                        <label for="dokumen_output">Dokumen Output:</label>
                        <input type="file" class="form-control" id="dokumen_output" name="dokumen_output">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC:</label>
                        <input type="text" class="form-control" id="pic" name="pic" placeholder="PIC " required>
                    </div>
                    <div class="form-group">
                        <label for="divisi_terkait">Divisi Terkait :</label>
                        <input type="text" class="form-control" id="divisi_terkait" name="divisi_terkait" placeholder="Divisi Terkait " required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan :</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan " required></textarea>
                    </div>
                    <!-- Hidden input untuk menyimpan nama_task -->
                    <input type="hidden" name="nama_task" value="{{ $taskStatic['nama_task'] }}">
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

    <!-- Modal untuk Edit Task -->
@foreach($tasks->where('project_id', $project->id) as $task)
    <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                <h5 class="modal-title" id="editTaskModalLabel{{$index}}">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('projects.updateTask', ['nama_pekerjaan' => $project->nama_pekerjaan, 'task_id' => $task->id]) }}" method="POST" id="editTaskForm{{ $index }}" class="modal-body edit-task-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="program_kegiatan">Program Kegiatan</label>
                        <input type="text" class="form-control" id="program_kegiatan" name="program_kegiatan" value="{{ $task->program_kegiatan }}" placeholder="Program Kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="plan_date_start">Tanggal Mulai Rencana</label>
                        <input type="date" class="form-control" id="plan_date_start" name="plan_date_start" value="{{ $task->plan_date_start }}" required>
                    </div>
                    <div class="form-group">
                        <label for="plan_date_end">Tanggal Selesai Rencana</label>
                        <input type="date" class="form-control" id="plan_date_end" name="plan_date_end" value="{{ $task->plan_date_end }}" required>
                    </div>
                    <div class="form-group">
                        <label for="actual_date_start">Tanggal Mulai Sebenarnya</label>
                        <input type="date" class="form-control" id="actual_date_start" name="actual_date_start" value="{{ $task->actual_date_start }}">
                    </div>
                    <div class="form-group">
                        <label for="actual_date_end">Tanggal Selesai Sebenarnya</label>
                        <input type="date" class="form-control" id="actual_date_end" name="actual_date_end" value="{{ $task->actual_date_end }}">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="pic" name="pic" value="{{ $task->pic }}" placeholder="PIC" required>
                    </div>
                    <div class="form-group">
                        <label for="divisi_terkait">Divisi Terkait</label>
                        <input type="text" class="form-control" id="divisi_terkait" name="divisi_terkait" value="{{ $task->divisi_terkait }}" placeholder="Divisi Terkait" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $task->keterangan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Fungsi untuk menampilkan atau menyembunyikan isi task
        $('.toggle-task').click(function () {
        var index = $(this).data('index');
        var nama_pekerjaan = $(this).data('project-name');
        var taskContent = $('#task' + index);
        taskContent.toggle();
        
        if (taskContent.is(':visible')) {
            // Ambil data dari database dan tambahkan ke tabel
            $.ajax({
            url: '/api/projects/' + nama_pekerjaan + '/tasks',
            type: 'GET',
            success: function(response) {
                $('#taskTable tbody').empty();

                // Tambahkan data ke dalam tabel
                response.forEach(function(task) {
                    var row = '<tr>' +
                        '<td>' + task.program_kegiatan + '</td>' +
                        '<td>' + task.plan_date_start + '</td>' +
                        '<td>' + task.plan_date_end + '</td>' +
                        '<td>' + task.actual_date_start + '</td>' +
                        '<td>' + task.actual_date_end + '</td>' +
                        '<td>' + task.dokumen_output + '</td>' +
                        '<td>' + task.pic + '</td>' +
                        '<td>' + task.divisi_terkait + '</td>' +
                        '<td>' + task.keterangan + '</td>' +
                        '</tr>';
                    $('#taskTable tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });     
        }
    });
        // Menangani pengiriman formulir
    $('.addTaskForm').submit(function (e) {
        e.preventDefault(); // Mencegah pengiriman formulir default
        var formData = new FormData(this);
        var index = $(this).attr('id').replace('addTaskForm', '');
        var nama_pekerjaan = $(this).data('project-name'); // Ambil nilai nama_pekerjaan dari atribut data

        // Kirim data formulir ke server dengan menambahkan nilai nama_pekerjaan ke URL
        $.ajax({
            url: '/api/projects/' + nama_pekerjaan + '/tasks', // Sesuaikan dengan URL yang sesuai di aplikasi Anda
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Task berhasil ditambahkan:', response);
                // Redirect ke halaman proyek yang sesuai setelah berhasil menambahkan tugas
                window.location.href = '/projects/' + response.project_id;
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
    $('.edit-task-btn').click(function() {
    var taskId = $(this).data('task-id'); // Mendapatkan ID tugas dari atribut data-task-id pada tombol edit
    var modalId = 'editTaskModal' + taskId; // Membuat ID modal editTaskModal yang sesuai dengan ID tugas

    // Menyesuaikan ID modal editTaskModal dengan ID tugas
    $('#'+modalId).modal('show');
});


    $('.editTaskForm').submit(function (e) {
    e.preventDefault(); // Mencegah pengiriman formulir default
    var formData = new FormData(this);
    var index = $(this).attr('id').replace('editTaskForm', '');
    var nama_pekerjaan = $(this).data('project-name');
    var taskId = $(this).data('task-id'); // Mengambil nilai task_id dari atribut data

    $.ajax({
        url: 'http://127.0.0.1:8000/api/projects/' + nama_pekerjaan + '/tasks/' + taskId,
        type: 'PUT',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log('Task berhasil diperbarui:', response);
            // Lakukan sesuatu setelah berhasil memperbarui data, seperti memperbarui antarmuka pengguna
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            // Tangani kesalahan yang terjadi selama permintaan
        }
    });
});
// Menggunakan kelas .delete-task-btn sebagai penanda untuk tombol hapus
$('.delete-task-btn').click(function() {
    var taskId = $(this).data('task-id'); // Mendapatkan ID tugas dari data-task-id atribut
    var nama_pekerjaan = $(this).data('project-name'); // Mendapatkan nama proyek dari data-project-name atribut

    if (confirm('Are you sure you want to delete this task?')) {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/projects/'+ nama_pekerjaan + '/tasks/' + taskId, // Sesuaikan dengan URL yang sesuai
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses jika penghapusan berhasil
                    alert(response.message);
                    // Hapus baris tugas yang dihapus dari tabel
                    $(this).closest('tr').remove();
                    location.reload(); // Memuat ulang halaman setelah tugas dihapus

                } else {
                    // Tampilkan pesan gagal jika penghapusan gagal
                    alert(response.message);
                }
            },
        });
    }
});
$('#addTaskModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var task = button.data('task'); // Mengambil data-task dari atribut data-task pada tombol

        // Update nilai input nama_task dalam modal dengan nilai task yang dipilih
        var modal = $(this);
        modal.find('#nama_task').val(task);
    });
});
</script>

<link href="{{ asset('css/showprojects.css') }}" rel="stylesheet">

@php
// Definisikan fungsi untuk mendapatkan warna status
function getStatusColor($stepNumber, $currentStatus) {
    // Mengubah status proyek menjadi angka
    switch ($currentStatus) {
        case 'Selesai':
            $currentStatusNumber = 5;
            break;
        case 'Pembayaran':
            $currentStatusNumber = 4;
            break;
        case 'Implementasi':
            $currentStatusNumber = 3;
            break;
        case 'Follow Up':
            $currentStatusNumber = 2;
            break;
        case 'Postpone':
            $currentStatusNumber = 1;
            break;
        default:
            $currentStatusNumber = 0;
            break;
    }
    
    // Memeriksa apakah langkah sudah dilakukan atau belum
    if ($currentStatusNumber >= $stepNumber) {
        return 'completed';
    } else {
        return 'incomplete';
    }
}
function getConnectorColor($stepNumber, $currentStatus) {
    // Mengubah status proyek menjadi angka
    switch ($currentStatus) {
        case 'Selesai':
            $currentStatusNumber = 5;
            break;
        case 'Pembayaran':
            $currentStatusNumber = 4;
            break;
        case 'Implementasi':
            $currentStatusNumber = 3;
            break;
        case 'Follow Up':
            $currentStatusNumber = 2;
            break;
        case 'Postpone':
            $currentStatusNumber = 1;
            break;
        default:
            $currentStatusNumber = 0;
            break;
    }
    
    // Memeriksa apakah langkah sudah dilakukan atau belum
    if ($currentStatusNumber >= $stepNumber) {
        if ($stepNumber == $currentStatusNumber) {
            return 'incompleted-connector'; // Langkah terakhir yang sedang diproses
        } else {
            return 'completed-connector'; // Langkah sebelum langkah terakhir yang sedang diproses
        }
    } else {
        return 'incompleted-connector'; // Langkah yang belum selesai
    }
}
@endphp