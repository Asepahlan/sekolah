@extends('layouts.dashboard')

@section('title', 'Kalender Akademik')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Kalender Akademik</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                    Tambah Event
                </button>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" name="id" id="event_id">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="holiday">Libur</option>
                            <option value="exam">Ujian</option>
                            <option value="event">Event</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <input type="color" class="form-control" name="color" id="color" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveEvent">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: @json($events),
        editable: true,
        eventClick: function(info) {
            // Tampilkan event di modal untuk edit
            $('#event_id').val(info.event.id);
            $('#title').val(info.event.title);
            $('#description').val(info.event.extendedProps.description);
            $('#start_date').val(info.event.start.toISOString().split('T')[0]);
            $('#end_date').val(info.event.end.toISOString().split('T')[0]);
            $('#type').val(info.event.extendedProps.type);
            $('#color').val(info.event.backgroundColor);
            $('#eventModal').modal('show');
        }
    });
    calendar.render();

    // Handle save event
    $('#saveEvent').click(function() {
        var formData = $('#eventForm').serialize();
        var url = $('#event_id').val()
            ? '/admin/calendar/' + $('#event_id').val()
            : '/admin/calendar';

        $.ajax({
            url: url,
            method: $('#event_id').val() ? 'PUT' : 'POST',
            data: formData,
            success: function(response) {
                $('#eventModal').modal('hide');
                calendar.refetchEvents();
                alert(response.message);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan!');
            }
        });
    });
});
</script>
@endsection 
