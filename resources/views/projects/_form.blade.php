@csrf {{-- CSRF Token --}}

@if(isset($project))
    @method('PUT')
@endif

<div class="input-group">
    <label for="name">Nama Proyek:</label>
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
        <label>PIC (bisa pilih lebih dari satu):</label>
        @php
            $selectedPics = old('pic_user_id', isset($project) ? $project->pics->pluck('id')->toArray() : []);
        @endphp
        @if(isset($users) && count($users))
            <div class="pic-checkbox-list">
                @foreach($users as $user)
                    <label class="pic-checkbox-item">
                        <input type="checkbox" name="pic_user_id[]" value="{{ $user->id }}"
                            {{ in_array($user->id, $selectedPics) ? 'checked' : '' }}>
                        <span>{{ $user->name }}</span>
                    </label>
                @endforeach
            </div>
            <small>Pilih satu atau lebih PIC. Gunakan pencarian (Ctrl+F) jika user sangat banyak.</small>
        @else
            <span style="color:red;">Tidak ada user yang bisa dipilih sebagai PIC.</span>
        @endif
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
    <label for="progress">Progress (%):</label>
    <input type="number" id="progress" name="progress" min="0" max="100" value="{{ old('progress', $project->progress ?? 0) }}" required>
</div>

<div class="form-actions">
    <button type="submit" class="btn primary-btn" id="saveButton">Simpan Proyek</button>
    <a href="{{ route('dashboard') }}" class="btn cancel-btn">Batalkan</a>
</div>