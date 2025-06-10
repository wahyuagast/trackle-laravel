{{-- resources/views/projects/_form.blade.php --}}

@csrf {{-- CSRF Token --}}

{{-- Jika ini form edit, kita perlu method PUT --}}
@if(isset($project))
    @method('PUT')
@endif

<div class="input-group">
    <label for="name">Nama Proyek:</label>
    {{-- old() untuk menjaga input jika validasi gagal, ?? '' untuk form create --}}
    <input type="text" id="name" name="name" value="{{ old('name', $project->name ?? '') }}" required>
</div>
<div class="input-group">
    <label for="description">Deskripsi:</label>
    <textarea id="description" name="description" rows="5">{{ old('description', $project->description ?? '') }}</textarea>
</div>
<div class="form-row">
    <div class="input-group">
        <label for="start_date">Tanggal Mulai:</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}" required>
    </div>
    <div class="input-group">
        <label for="deadline_date">Tanggal Deadline:</label>
        <input type="date" id="deadline_date" name="deadline_date" value="{{ old('deadline_date', $project->deadline_date ?? '') }}" required>
    </div>
</div>
<div class="form-row">
    <div class="input-group">
        <label for="pic_user_id">PIC:</label>
        <select id="pic_user_id" name="pic_user_id" required>
            <option value="">Pilih Karyawan</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ (old('pic_user_id', $project->pic_user_id ?? '') == $user->id) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <label for="priority">Prioritas:</label>
        <select id="priority" name="priority" required>
            @foreach(['Tinggi', 'Sedang', 'Rendah'] as $priority)
                <option value="{{ $priority }}" {{ (old('priority', $project->priority ?? '') == $priority) ? 'selected' : '' }}>{{ $priority }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="input-group">
    <label for="status">Status Proyek:</label>
    <select id="status" name="status" required>
         @foreach(['Belum Dimulai', 'Sedang Berjalan', 'Selesai', 'Ditunda', 'Dibatalkan'] as $status)
            <option value="{{ $status }}" {{ (old('status', $project->status ?? 'Belum Dimulai') == $status) ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>

{{-- Untuk attachment dan komentar akan ditangani terpisah di halaman detail --}}

<div class="form-actions">
    <button type="submit" class="btn primary-btn" id="saveButton">Simpan Proyek</button>
    <a href="{{ route('dashboard') }}" class="btn cancel-btn">Batalkan</a>
</div>