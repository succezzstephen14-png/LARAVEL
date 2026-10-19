@extends('layouts.site-admin')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Media Library</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal">
                            <i class="fas fa-upload"></i> Upload Files
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Folder Navigation -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary active" data-folder="general">General</button>
                                <button type="button" class="btn btn-outline-secondary" data-folder="images">Images</button>
                                <button type="button" class="btn btn-outline-secondary" data-folder="documents">Documents</button>
                                <button type="button" class="btn btn-outline-secondary" data-folder="videos">Videos</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search media...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Grid -->
                    <div id="mediaGrid" class="row">
                        @forelse($media as $item)
                        <div class="col-md-2 col-sm-3 mb-3 media-item" data-id="{{ $item->id }}">
                            <div class="card media-card">
                                <div class="media-preview">
                                    @if(str_starts_with($item->mime_type, 'image/'))
                                        <img src="{{ $item->thumbnail_url }}" alt="{{ $item->alt_text }}" class="img-fluid">
                                    @elseif(str_starts_with($item->mime_type, 'video/'))
                                        <video class="img-fluid">
                                            <source src="{{ $item->url }}" type="{{ $item->mime_type }}">
                                        </video>
                                    @else
                                        <div class="file-icon">
                                            <i class="fas fa-file"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-2">
                                    <h6 class="card-title text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                                    <small class="text-muted">{{ $item->file_size_formatted }}</small>
                                    <div class="media-actions mt-2">
                                        <button class="btn btn-sm btn-outline-primary edit-media" data-id="{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info copy-url" data-url="{{ $item->url }}">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-media" data-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">
                            <i class="fas fa-images fa-3x mb-3"></i>
                            <p>No media files found. Upload some files to get started.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($media->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $media->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Media Files</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="uploadFolder">Folder</label>
                        <select class="form-control" id="uploadFolder" name="folder">
                            <option value="general">General</option>
                            <option value="images">Images</option>
                            <option value="documents">Documents</option>
                            <option value="videos">Videos</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fileInput">Select Files</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInput" name="files[]" multiple accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.txt">
                            <label class="custom-file-label" for="fileInput">Choose files...</label>
                        </div>
                        <small class="form-text text-muted">Supported formats: Images, Videos, PDFs, Documents (max 50MB each)</small>
                    </div>

                    <!-- Drag and Drop Zone -->
                    <div class="upload-drop-zone" id="dropZone">
                        <div class="upload-drop-zone-text">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                            <p>Drag & drop files here or click to browse</p>
                        </div>
                    </div>

                    <div id="uploadProgress" class="progress mt-3" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">Upload Files</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Media Modal -->
<div class="modal fade" id="editMediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Media</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editMediaForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editAltText">Alt Text</label>
                        <input type="text" class="form-control" id="editAltText" name="alt_text">
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editFolder">Folder</label>
                        <select class="form-control" id="editFolder" name="folder">
                            <option value="general">General</option>
                            <option value="images">Images</option>
                            <option value="documents">Documents</option>
                            <option value="videos">Videos</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.media-card {
    height: 200px;
    cursor: pointer;
    transition: transform 0.2s;
}

.media-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.media-preview {
    height: 120px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.media-preview img,
.media-preview video {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.file-icon {
    color: #6c757d;
}

.media-actions {
    display: flex;
    justify-content: space-between;
}

.upload-drop-zone {
    border: 2px dashed #dee2e6;
    border-radius: 0.375rem;
    padding: 2rem;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-drop-zone:hover,
.upload-drop-zone.dragover {
    border-color: #007bff;
    background: #e3f2fd;
}

.upload-drop-zone-text {
    color: #6c757d;
}

.upload-drop-zone.dragover .upload-drop-zone-text {
    color: #007bff;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentFolder = 'general';
    let currentMediaId = null;

    // Folder navigation
    $('.btn[data-folder]').on('click', function() {
        $('.btn[data-folder]').removeClass('active');
        $(this).addClass('active');
        currentFolder = $(this).data('folder');
        loadMediaByFolder(currentFolder);
    });

    // Search functionality
    $('#searchBtn').on('click', function() {
        const query = $('#searchInput').val();
        searchMedia(query);
    });

    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            const query = $(this).val();
            searchMedia(query);
        }
    });

    // Drag and drop functionality
    const dropZone = $('#dropZone')[0];
    const fileInput = $('#fileInput')[0];

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('dragover');
    }

    function unhighlight(e) {
        dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        // Update file input with selected files
        const dt = new DataTransfer();
        for (let file of files) {
            dt.items.add(file);
        }
        fileInput.files = dt.files;

        // Update file label
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        $('.custom-file-label').text(fileNames || 'Choose files...');
    }

    // Upload form submission
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const files = fileInput.files;

        if (files.length === 0) {
            alert('Please select files to upload.');
            return;
        }

        $('#uploadProgress').show();
        $('#uploadBtn').prop('disabled', true);

        $.ajax({
            url: '{{ route("cms.upload-media") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        $('.progress-bar').css('width', percentComplete + '%');
                    }
                });
                return xhr;
            },
            success: function(response) {
                $('#uploadModal').modal('hide');
                $('#uploadProgress').hide();
                $('#uploadBtn').prop('disabled', false);
                $('.progress-bar').css('width', '0%');

                // Reset form
                $('#uploadForm')[0].reset();
                $('.custom-file-label').text('Choose files...');

                // Reload media
                loadMediaByFolder(currentFolder);

                alert(response.message);
            },
            error: function(xhr) {
                alert('Upload failed: ' + xhr.responseJSON?.message || 'Unknown error');
                $('#uploadProgress').hide();
                $('#uploadBtn').prop('disabled', false);
            }
        });
    });

    // Edit media
    $(document).on('click', '.edit-media', function() {
        currentMediaId = $(this).data('id');
        const card = $(this).closest('.media-item');
        const name = card.find('.card-title').text();

        // Load media details (you might want to make an AJAX call here)
        $('#editName').val(name);
        $('#editMediaModal').modal('show');
    });

    $('#editMediaForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("cms.update-media", ":id") }}'.replace(':id', currentMediaId),
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editMediaModal').modal('hide');
                loadMediaByFolder(currentFolder);
                alert(response.message);
            },
            error: function(xhr) {
                alert('Update failed: ' + xhr.responseJSON?.message || 'Unknown error');
            }
        });
    });

    // Copy URL
    $(document).on('click', '.copy-url', function() {
        const url = $(this).data('url');
        navigator.clipboard.writeText(url).then(function() {
            // Show success message
            const btn = $(this);
            const originalIcon = btn.find('i').attr('class');
            btn.find('i').attr('class', 'fas fa-check');
            setTimeout(() => {
                btn.find('i').attr('class', originalIcon);
            }, 1000);
        }.bind(this));
    });

    // Delete media
    $(document).on('click', '.delete-media', function() {
        if (!confirm('Are you sure you want to delete this media file?')) {
            return;
        }

        const mediaId = $(this).data('id');

        $.ajax({
            url: '{{ route("cms.delete-media", ":id") }}'.replace(':id', mediaId),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                loadMediaByFolder(currentFolder);
                alert(response.message);
            },
            error: function(xhr) {
                alert('Delete failed: ' + xhr.responseJSON?.message || 'Unknown error');
            }
        });
    });

    function loadMediaByFolder(folder) {
        $.ajax({
            url: '{{ route("cms.media-by-folder") }}',
            type: 'GET',
            data: { folder: folder },
            success: function(response) {
                // Update media grid with new data
                updateMediaGrid(response.data);
            }
        });
    }

    function searchMedia(query) {
        // Implement search functionality
        console.log('Searching for:', query);
    }

    function updateMediaGrid(media) {
        let html = '';
        if (media.length === 0) {
            html = `
                <div class="col-12 text-center text-muted">
                    <i class="fas fa-images fa-3x mb-3"></i>
                    <p>No media files found in this folder.</p>
                </div>
            `;
        } else {
            media.forEach(function(item) {
                let previewHtml = '';
                if (item.mime_type.startsWith('image/')) {
                    previewHtml = `<img src="${item.thumbnail_url}" alt="${item.alt_text || ''}" class="img-fluid">`;
                } else if (item.mime_type.startsWith('video/')) {
                    previewHtml = `<video class="img-fluid"><source src="${item.url}" type="${item.mime_type}"></video>`;
                } else {
                    previewHtml = `<div class="file-icon"><i class="fas fa-file"></i></div>`;
                }

                html += `
                    <div class="col-md-2 col-sm-3 mb-3 media-item" data-id="${item.id}">
                        <div class="card media-card">
                            <div class="media-preview">
                                ${previewHtml}
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title text-truncate" title="${item.name}">${item.name}</h6>
                                <small class="text-muted">${item.file_size_formatted}</small>
                                <div class="media-actions mt-2">
                                    <button class="btn btn-sm btn-outline-primary edit-media" data-id="${item.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info copy-url" data-url="${item.url}">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-media" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
        $('#mediaGrid').html(html);
    }
});
</script>
@endpush