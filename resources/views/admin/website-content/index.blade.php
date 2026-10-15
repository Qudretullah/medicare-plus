
@extends('admin.layouts.app')

@section('title', 'Website Content Editor')

@section('page-title', 'Website Content Editor')

@section('page-description', 'Manage Medicare+ website headings, descriptions and content.')

@section('content')

<div class="cms-page-editor">

    <!-- EDITOR HEADER -->

    <div class="cms-editor-header">

        <div>
            <h2>Website Pages</h2>
            <p>Select a page and update its content.</p>
        </div>

        <a href="{{ route('home') }}"
           target="_blank"
           rel="noopener noreferrer"
           class="cms-preview-btn">
            Preview Website ↗
        </a>

    </div>

    <!-- PAGE SELECTOR -->

    <form method="GET"
          action="{{ route('admin.website-content.index') }}"
          class="cms-page-selector">

        <label for="cmsPageSelect">Choose Page</label>

        <select id="cmsPageSelect" name="page">

            @foreach($pages as $key => $label)

                <option value="{{ $key }}"
                    @selected($page === $key)>
                    {{ $label }}
                </option>

            @endforeach

        </select>

        <button type="submit" class="cms-primary-btn">
            Open Page
        </button>

    </form>

    <!-- CONTENT EDITING FORM -->

    @if($items->isNotEmpty())

        <form method="POST"
              action="{{ route('admin.website-content.update') }}"
              class="cms-content-form">

            @csrf
            @method('PUT')

            <input type="hidden"
                   name="page"
                   value="{{ $page }}">

            <div class="cms-content-heading">

                <div>
                    <h3>{{ $pages[$page] }} Content</h3>
                    <p>Edit the fields below and save your changes.</p>
                </div>

                <span class="cms-field-count">
                    {{ $items->count() }} Fields
                </span>

            </div>

            @if($errors->any())
                <div class="cms-error-message" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="cms-fields-grid">

                @foreach($items as $item)

                    <div class="cms-field">

                        <label for="cms_{{ $item->id }}">
                            {{ ucwords(str_replace('_', ' ', $item->content_key)) }}
                        </label>

                        @if($item->type === 'image')

                            <div class="cms-image-notice">
                                Image management will be available
                                in the Media Library module.
                            </div>

                            @if($item->value)
                                <p class="cms-image-path">
                                    Current image: {{ $item->value }}
                                </p>
                            @endif

                        @elseif($item->type === 'textarea')

                            <textarea
                                id="cms_{{ $item->id }}"
                                name="content[{{ $item->content_key }}]"
                                rows="5"
                                maxlength="10000"
                            >{{ old('content.'.$item->content_key, $item->value) }}</textarea>

                        @else

                            <input
                                id="cms_{{ $item->id }}"
                                type="{{ $item->type === 'url' ? 'url' : 'text' }}"
                                name="content[{{ $item->content_key }}]"
                                value="{{ old('content.'.$item->content_key, $item->value) }}"
                                maxlength="10000"
                            >

                        @endif

                        <small>
                            Content key: {{ $item->content_key }}
                        </small>

                    </div>

                @endforeach

            </div>

            <div class="cms-form-footer">

                <p>
                    Changes are saved to the website content database.
                </p>

                <button type="submit" class="cms-save-btn">
                    Save Changes
                </button>

            </div>

        </form>

    @else

        <div class="cms-empty-state">

            <div class="cms-empty-icon">✎</div>

            <h3>No Content Fields Yet</h3>

            <p>
                This page does not have editable content records yet.
                We will register the existing website content in
                the next step.
            </p>

        </div>

    @endif

</div>

@endsection
