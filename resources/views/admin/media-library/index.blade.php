
@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('page-title', 'Media Library')

@section('page-description', 'Upload, organize and manage your website images.')

@push('styles')
<style>
.ml-page {
    --ml-card: #ffffff;
    --ml-border: #dce8f5;
    --ml-heading: #193b60;
    --ml-muted: #748ba4;
    --ml-soft: #f4f9ff;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.ml-panel {
    background: var(--ml-card);
    border: 1px solid var(--ml-border);
    border-radius: 19px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(30, 75, 130, .05);
}

.ml-panel h2 {
    margin: 0 0 8px;
    color: var(--ml-heading);
    font-size: 19px;
}

.ml-panel p {
    margin: 0 0 20px;
    color: var(--ml-muted);
    font-size: 13px;
    line-height: 1.7;
}

.ml-upload-form {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.ml-upload-form input {
    flex: 1;
    min-width: 200px;
    padding: 12px;
    background: var(--ml-soft);
    border: 1px solid var(--ml-border);
    border-radius: 11px;
    color: var(--ml-heading);
}

.ml-primary {
    padding: 13px 20px;
    background: #2867ac;
    border: none;
    border-radius: 11px;
    color: #fff;
    font: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

.ml-errors {
    padding: 15px 18px;
    border: 1px solid #e7adb9;
    border-radius: 12px;
    background: #fff0f2;
    color: #a33b51;
    font-size: 13px;
}

.ml-gallery-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.ml-gallery-header p {
    margin-bottom: 0;
}

.ml-gallery {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
}

.ml-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid var(--ml-border);
    border-radius: 17px;
    background: var(--ml-card);
}

.ml-card-image {
    display: grid;
    place-items: center;
    height: 180px;
    padding: 12px;
    background: var(--ml-soft);
}

.ml-card-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 9px;
}

.ml-card-body {
    padding: 16px;
}

.ml-file-name {
    display: block;
    overflow: hidden;
    color: var(--ml-heading);
    font-size: 12px;
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.ml-file-meta {
    display: block;
    margin: 8px 0 15px;
    color: var(--ml-muted);
    font-size: 11px;
}

.ml-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.ml-actions form {
    margin: 0;
}

.ml-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 9px 11px;
    border-radius: 9px;
    border: 1px solid var(--ml-border);
    background: var(--ml-soft);
    color: var(--ml-heading);
    font: inherit;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.ml-btn-danger {
    background: #fff0f2;
    border-color: #f1ccd4;
    color: #ac3c53;
}

.ml-empty {
    padding: 45px 20px;
    text-align: center;
    background: var(--ml-card);
    border: 1px dashed var(--ml-border);
    border-radius: 18px;
    color: var(--ml-muted);
}

.ml-pagination {
    overflow-x: auto;
}

/* DARK MODE */

html[data-admin-theme="dark"] .ml-page {
    --ml-card: #16253d;
    --ml-border: #344762;
    --ml-heading: #edf5ff;
    --ml-muted: #aabdd5;
    --ml-soft: #101d32;
}

html[data-admin-theme="dark"] .ml-btn-danger {
    background: #49303e;
    border-color: #72445a;
    color: #ffb6c7;
}

html[data-admin-theme="dark"] .ml-errors {
    background: #4b2d3a;
    border-color: #784458;
    color: #ffc0cd;
}

/* RESPONSIVE */

@media (max-width: 1300px) {
    .ml-gallery {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {
    .ml-gallery {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 520px) {
    .ml-gallery {
        grid-template-columns: 1fr;
    }

    .ml-panel {
        padding: 19px;
    }
}
</style>
@endpush

@section('content')

<div class="ml-page">

    @if($errors->any())
        <div class="ml-errors" role="alert">
            <strong>Upload failed:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- IMAGE UPLOAD --}}

    <section class="ml-panel">
        <h2>Upload New Image</h2>
        <p>
            Upload JPG, PNG or WebP images.
            Maximum file size: 3 MB.
        </p>

        <form
            class="ml-upload-form"
            action="{{ route('admin.media-library.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <input
                type="file"
                name="image"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                required
                aria-label="Choose image"
            >

            <button type="submit" class="ml-primary">
                Upload Image
            </button>
        </form>
    </section>

    {{-- GALLERY --}}

    <div class="ml-gallery-header">
        <div>
            <h2 style="color:var(--ml-heading);margin:0 0 6px;">
                Uploaded Images
            </h2>
            <p>
                {{ $mediaFiles->total() }} images in your library
            </p>
        </div>
    </div>

    @if($mediaFiles->count())

        <div class="ml-gallery">

            @foreach($mediaFiles as $media)

                @php
                    $imageUrl = asset(
                        'storage/' . $media->file_path
                    );
                @endphp

                <article class="ml-card">

                    <div class="ml-card-image">
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $media->original_name }}"
                            loading="lazy"
                        >
                    </div>

                    <div class="ml-card-body">

                        <span
                            class="ml-file-name"
                            title="{{ $media->original_name }}"
                        >
                            {{ $media->original_name }}
                        </span>

                        <span class="ml-file-meta">
                            {{ number_format($media->file_size / 1024, 1) }} KB
                            ·
                            {{ $media->created_at->format('d M Y') }}
                        </span>

                        <div class="ml-actions">

                            <a
                                href="{{ $imageUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="ml-btn"
                            >
                                View
                            </a>

                            <button
                                type="button"
                                class="ml-btn ml-copy-url"
                                data-url="{{ $imageUrl }}"
                            >
                                Copy URL
                            </button>

                            <form
                                action="{{ route('admin.media-library.destroy', $media) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this image permanently?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="ml-btn ml-btn-danger"
                                >
                                    Delete
                                </button>
                            </form>

                        </div>
                    </div>

                </article>

            @endforeach

        </div>

        @if($mediaFiles->hasPages())
            <div class="ml-pagination">
                {{ $mediaFiles->links() }}
            </div>
        @endif

    @else

        <div class="ml-empty">
            <p>No images uploaded yet.</p>
            <p>Upload your first image to get started.</p>
        </div>

    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ml-copy-url').forEach(function (button) {
        button.addEventListener('click', async function () {
            const url = button.dataset.url;

            try {
                await navigator.clipboard.writeText(url);
                button.textContent = 'Copied!';
            } catch (error) {
                button.textContent = 'Copy Failed';
            }

            window.setTimeout(function () {
                button.textContent = 'Copy URL';
            }, 1800);
        });
    });
});
</script>
@endpush

@endsection

