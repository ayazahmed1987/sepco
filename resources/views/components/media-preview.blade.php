@if ($file)
    @php
        $type = $mediaType();
        $path = $mediaPath();
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    @endphp

    <div class="card mb-3 mt-3 shadow-sm" style="max-width: 400px;">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <strong>Submitted {{ ucfirst($type) }}</strong>

            @if ($removeRoute)
                <a href="{{ route($removeRoute, [$id, $columnName]) }}" class="btn btn-sm btn-outline-danger"
                    onclick="submitMediaRemoveForm('{{ $id }}', $columnName)">
                    <i class="fas fa-trash-alt"></i> Remove
                </a>
            @endif
        </div>

        <div class="card-body text-center">
            @if ($type === 'image')
                <img src="{{ $path }}" alt="Submitted Image" class="img-fluid rounded" style="max-height: 250px;">
            @elseif ($type === 'video')
                <video controls class="w-100 rounded" style="max-height: 250px;">
                    <source src="{{ $path }}" type="video/{{ $ext }}">
                </video>
            @elseif ($type === 'pdf')
                <iframe src="{{ $path }}" class="w-100 rounded" style="height: 250px;" frameborder="0"></iframe>
            @else
                <a href="{{ $path }}" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-file-alt"></i> Download {{ strtoupper($ext) }}
                </a>
            @endif
        </div>
    </div>
@endif
