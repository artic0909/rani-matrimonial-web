@extends('admin.layouts.app')

@section('title', 'Success Stories Management - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid p-0">
  
  <!-- START: Page Header Banner -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-heart-pulse-fill fs-4" style="color: var(--brand-forest-medium);"></i>
        <h1 class="page-title mb-0">Success Stories</h1>
        <span class="badge-table success ms-2">
          {{ number_format($counts['total']) }} Stories
        </span>
      </div>
      <p class="page-subtitle mb-0">Manage inspiring success stories of happy couples who found their life partner on Rani Matrimonial.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-arrow-left"></i>
        <span>Dashboard</span>
      </a>
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createStoryModal">
        <i class="bi bi-plus-lg"></i>
        <span>Add New Story</span>
      </button>
    </div>
  </div>
  <!-- END: Page Header Banner -->

  <!-- START: Metric Statistics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Stories</span>
            <h2 class="fw-bold mb-0" style="font-size: 1.75rem; color: var(--text-main); line-height: 1.2;">{{ number_format($counts['total']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(7, 47, 31, 0.08); color: var(--brand-forest-medium); font-size: 1.35rem;">
            <i class="bi bi-journal-bookmark-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Published (Live)</span>
            <h2 class="fw-bold mb-0 text-success" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['active']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(34, 197, 94, 0.12); color: var(--sys-green); font-size: 1.35rem;">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Drafts / Hidden</span>
            <h2 class="fw-bold mb-0 text-secondary" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['inactive']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(108, 117, 125, 0.12); color: #6c757d; font-size: 1.35rem;">
            <i class="bi bi-eye-slash-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Added This Month</span>
            <h2 class="fw-bold mb-0 text-danger" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['this_month']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(239, 68, 68, 0.12); color: var(--sys-red); font-size: 1.35rem;">
            <i class="bi bi-heart-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Metric Statistics Cards -->

  <!-- START: Main Stories Container (Table Card Custom) -->
  <div class="table-card-custom mb-4">
    
    <!-- Header Controls & Filters -->
    <div class="table-header-control">
      <!-- Status Tabs -->
      <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
        <a href="{{ route('admin.stories.index', ['search' => $search, 'status' => 'all']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          All Stories ({{ $counts['total'] }})
        </a>
        <a href="{{ route('admin.stories.index', ['search' => $search, 'status' => 'active']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'active' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-check2-circle"></i> Published ({{ $counts['active'] }})
        </a>
        <a href="{{ route('admin.stories.index', ['search' => $search, 'status' => 'inactive']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'inactive' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-eye-slash"></i> Hidden ({{ $counts['inactive'] }})
        </a>
      </div>

      <div class="d-flex align-items-center gap-2 ms-auto">
        <!-- Search Box Form -->
        <form method="GET" action="{{ route('admin.stories.index') }}" class="table-search-box m-0" style="min-width: 250px;">
          @if(($status ?? 'all') !== 'all')
            <input type="hidden" name="status" value="{{ $status }}">
          @endif
          <i class="bi bi-search table-search-icon"></i>
          <input type="text" 
                 name="search" 
                 class="table-search-input" 
                 placeholder="Search story, couple name..." 
                 value="{{ $search }}">
        </form>

        @if(!empty($search))
          <a href="{{ route('admin.stories.index', ['status' => $status]) }}" class="btn-custom btn-custom-light btn-custom-sm" title="Clear search">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif

        <!-- View Mode Switcher Buttons -->
        <div class="btn-group btn-group-sm rounded-3 shadow-2xs" role="group">
          <button type="button" class="btn btn-light btn-sm px-2.5 active" id="view-mode-table" title="Table View" onclick="switchViewMode('table')">
            <i class="bi bi-list-ul"></i>
          </button>
          <button type="button" class="btn btn-light btn-sm px-2.5" id="view-mode-grid" title="Cards View" onclick="switchViewMode('grid')">
            <i class="bi bi-grid-fill"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- 1. TABLE VIEW -->
    <div id="stories-table-view" class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th class="ps-4" style="width: 50px;">#</th>
            <th>Story & Couple</th>
            <th>Gallery Photos</th>
            <th>Wedding / Event Date</th>
            <th>Display Order</th>
            <th>Status</th>
            <th>Created Date</th>
            <th class="text-center pe-4" style="width: 140px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($stories as $story)
            <tr id="story-row-{{ $story->id }}">
              <td class="ps-4 text-muted fw-bold font-monospace">
                {{ (($stories->currentPage() - 1) * $stories->perPage()) + $loop->iteration }}
              </td>
              <td>
                <div class="table-user-cell">
                  <div class="position-relative flex-shrink-0" style="width: 52px; height: 52px;">
                    <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-100 h-100 rounded-3 object-fit-cover border shadow-2xs" onerror="this.src='{{ asset('img/bg-default.jpg') }}'">
                  </div>
                  <div>
                    <a href="javascript:void(0)" class="table-user-name text-decoration-none d-block view-story-btn" data-id="{{ $story->id }}">
                      {{ $story->title }}
                    </a>
                    <div class="table-user-sub">
                      @if($story->couple_names)
                        <span class="text-danger fw-semibold"><i class="bi bi-heart-fill me-1"></i>{{ $story->couple_names }}</span>
                      @else
                        <span class="text-muted">Story #{{ $story->id }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-1.5">
                  <span class="badge bg-light text-dark border fw-bold rounded-pill px-2.5 py-1">
                    <i class="bi bi-images text-warning me-1"></i> {{ count($story->gallery_images) }} Photos
                  </span>
                </div>
              </td>
              <td>
                @if($story->formatted_wedding_date)
                  <span class="fw-semibold" style="color: var(--text-main);">
                    <i class="bi bi-calendar-heart text-danger me-1"></i> {{ $story->formatted_wedding_date }}
                  </span>
                @else
                  <span class="text-muted small italic">Not specified</span>
                @endif
              </td>
              <td>
                <span class="badge bg-light text-secondary border font-monospace px-2 py-1">
                  {{ $story->order }}
                </span>
              </td>
              <td>
                <div class="form-check form-switch mb-0 d-inline-block align-middle">
                  <input class="form-check-input cursor-pointer toggle-status-btn" type="checkbox" role="switch" id="switch-table-{{ $story->id }}" data-id="{{ $story->id }}" {{ $story->is_active ? 'checked' : '' }}>
                </div>
                <span class="badge-table {{ $story->is_active ? 'success' : 'failed' }} ms-1" id="status-pill-{{ $story->id }}">
                  {{ $story->is_active ? 'Published' : 'Hidden' }}
                </span>
              </td>
              <td>
                <div class="table-user-sub">{{ $story->created_at->format('M d, Y') }}</div>
              </td>
              <td class="text-center pe-4">
                <div class="d-flex align-items-center justify-content-center gap-1.5">
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 view-story-btn" title="View Story" data-id="{{ $story->id }}">
                    <i class="bi bi-eye text-info"></i>
                  </button>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 edit-story-btn" title="Edit Story" data-id="{{ $story->id }}">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </button>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 delete-story-btn" title="Delete Story" data-id="{{ $story->id }}" data-title="{{ htmlspecialchars($story->title, ENT_QUOTES) }}">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-center fs-2 mb-2">
                  <i class="bi bi-heartbreak"></i>
                </div>
                <div class="fw-semibold fs-6">No Success Stories Found</div>
                <p class="small text-muted mb-3">Try adjusting your search criteria or add a new success story.</p>
                <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createStoryModal">
                  <i class="bi bi-plus-lg"></i> Add New Story
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- 2. CARDS GRID VIEW (Alternative View Mode) -->
    <div id="stories-grid-view" class="p-4 d-none">
      <div class="row g-4">
        @forelse($stories as $story)
          <div class="col-12 col-md-6 col-lg-4" id="story-card-{{ $story->id }}">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden story-card-item transition-all bg-white position-relative">
              
              <!-- Story Cover Image -->
              <div class="position-relative" style="height: 200px; overflow: hidden; background-color: #072F1F;">
                <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-100 h-100 object-fit-cover transition-transform duration-500 hover-scale" onerror="this.src='{{ asset('img/bg-default.jpg') }}'">
                
                <!-- Overlay Gradient -->
                <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="background: linear-gradient(to top, rgba(7, 47, 31, 0.9) 0%, rgba(7, 47, 31, 0.1) 60%, transparent 100%);"></div>

                <!-- Top Badges -->
                <div class="position-absolute top-3 start-3 z-2">
                  <span class="badge-table {{ $story->is_active ? 'success' : 'failed' }} shadow-sm bg-white" id="grid-status-badge-{{ $story->id }}">
                    {{ $story->is_active ? 'Published' : 'Hidden' }}
                  </span>
                </div>

                <div class="position-absolute top-3 end-3 z-2">
                  <span class="badge bg-dark bg-opacity-75 text-white border border-white border-opacity-25 rounded-pill px-2.5 py-1 text-xs">
                    <i class="bi bi-images text-warning me-1"></i> {{ count($story->gallery_images) }}
                  </span>
                </div>

                <!-- Bottom Title in Cover -->
                <div class="position-absolute bottom-3 start-3 end-3 z-2 text-white">
                  @if($story->couple_names)
                    <span class="badge bg-danger bg-opacity-90 text-white rounded-pill px-2 py-0.5 text-xs mb-1">
                      <i class="bi bi-heart-fill me-1"></i> {{ $story->couple_names }}
                    </span>
                  @endif
                  <h6 class="fw-bold text-white mb-0 text-truncate font-serif">{{ $story->title }}</h6>
                </div>
              </div>

              <!-- Card Body -->
              <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex align-items-center justify-content-between text-muted small mb-2">
                    @if($story->formatted_wedding_date)
                      <span class="text-danger fw-semibold"><i class="bi bi-calendar-heart me-1"></i>{{ $story->formatted_wedding_date }}</span>
                    @else
                      <span class="text-muted">Story #{{ $story->id }}</span>
                    @endif
                    <span class="badge bg-light text-muted border">Order: {{ $story->order }}</span>
                  </div>
                  <p class="text-muted small line-clamp-2 mb-3 leading-relaxed">
                    {{ Str::limit(strip_tags($story->descriptions), 110) }}
                  </p>
                </div>

                <!-- Card Footer Actions -->
                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input cursor-pointer toggle-status-btn" type="checkbox" role="switch" id="switch-grid-{{ $story->id }}" data-id="{{ $story->id }}" {{ $story->is_active ? 'checked' : '' }}>
                    <label class="form-check-label text-xs fw-semibold text-muted" for="switch-grid-{{ $story->id }}">
                      {{ $story->is_active ? 'Live' : 'Draft' }}
                    </label>
                  </div>

                  <div class="d-flex align-items-center gap-1.5">
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 view-story-btn" title="View Story" data-id="{{ $story->id }}">
                      <i class="bi bi-eye text-info"></i>
                    </button>
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 edit-story-btn" title="Edit Story" data-id="{{ $story->id }}">
                      <i class="bi bi-pencil-square text-primary"></i>
                    </button>
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 delete-story-btn" title="Delete Story" data-id="{{ $story->id }}" data-title="{{ htmlspecialchars($story->title, ENT_QUOTES) }}">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </div>
                </div>
              </div>

            </div>
          </div>
        @empty
          <div class="col-12 text-center py-5 text-muted">
            <div class="fw-semibold">No stories available.</div>
          </div>
        @endforelse
      </div>
    </div>

    <!-- Pagination Footer -->
    <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 table-footer-control">
      <div class="table-user-sub">
        Showing {{ $stories->firstItem() ?? 0 }} to {{ $stories->lastItem() ?? 0 }} of {{ $stories->total() }} records
      </div>
      <div>
        {{ $stories->links('pagination::bootstrap-5') }}
      </div>
    </div>

  </div>
  <!-- END: Main Stories Container -->

  <!-- ==========================================
       CREATE / ADD STORY MODAL
       ========================================== -->
  <div class="modal fade" id="createStoryModal" tabindex="-1" aria-labelledby="createStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <form id="createStoryForm" action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-header border-bottom py-3.5 px-4" style="background-color: #F8FAF9;">
            <div class="d-flex align-items-center gap-2.5">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: var(--brand-forest-medium);">
                <i class="bi bi-plus-lg fs-6"></i>
              </div>
              <div>
                <h5 class="modal-title fw-bold text-gray-900 mb-0" id="createStoryModalLabel">Add New Success Story</h5>
                <p class="text-muted small mb-0">Publish a verified real matchmaking story to the website frontend.</p>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4 bg-white">
            <div class="row g-3">
              
              <!-- Story Title -->
              <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Story Headline / Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control rounded-3 py-2 px-3" placeholder="e.g. Aditya & Neha: A Modern Fairytale of Shared Values" required>
              </div>

              <!-- Couple Names & Wedding Date -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Couple Names</label>
                <input type="text" name="couple_names" class="form-control rounded-3 py-2 px-3" placeholder="e.g. Aditya Singhania & Neha Kapoor">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Wedding / Engagement Date</label>
                <input type="date" name="wedding_date" class="form-control rounded-3 py-2 px-3">
              </div>

              <!-- Primary Couple Image -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Primary Featured Photo <span class="text-danger">*</span></label>
                <div class="p-3 border-2 border-dashed rounded-3 bg-light text-center cursor-pointer hover-scale" onclick="$('#create_primary_image').click()" style="border-style: dashed !important; border-color: #CBD5E1;">
                  <i class="bi bi-cloud-arrow-up fs-2" style="color: var(--brand-forest-medium);"></i>
                  <div class="fw-semibold small text-gray-800 mt-1">Click to select primary cover photo</div>
                  <div class="text-muted small" style="font-size: 11px;">JPEG, PNG, WebP (Max 20MB)</div>
                </div>
                <input type="file" name="primary_image" id="create_primary_image" class="d-none" accept="image/*" required>
                
                <!-- Primary Image Preview Container -->
                <div id="create_primary_preview_wrap" class="mt-2.5 rounded-3 overflow-hidden border d-none position-relative" style="height: 140px; background-color: #f8f9fa;">
                  <img id="create_primary_preview_img" src="" class="w-100 h-100 object-fit-contain">
                </div>
              </div>

              <!-- Additional Gallery Images -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Additional Gallery Photos (Optional)</label>
                <div class="p-3 border-2 border-dashed rounded-3 bg-light text-center cursor-pointer hover-scale" onclick="$('#create_gallery_images').click()" style="border-style: dashed !important; border-color: #CBD5E1;">
                  <i class="bi bi-images fs-2" style="color: var(--brand-forest-medium);"></i>
                  <div class="fw-semibold small text-gray-800 mt-1">Click to select multiple gallery photos</div>
                  <div class="text-muted small" style="font-size: 11px;">Select multiple wedding photos</div>
                </div>
                <input type="file" name="images[]" id="create_gallery_images" class="d-none" accept="image/*" multiple>

                <!-- Gallery Preview Thumbnails -->
                <div id="create_gallery_preview_wrap" class="d-flex flex-wrap gap-2 mt-2.5"></div>
              </div>

              <!-- Story Detailed Description -->
              <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Story Narrative / Description <span class="text-danger">*</span></label>
                <textarea name="descriptions" rows="5" class="form-control rounded-3 p-3" placeholder="Share how the couple met, their conversations on Rani Matrimonial, family meetings, and wedding memories..." required></textarea>
              </div>

              <!-- Order & Active Status -->
              <div class="col-6">
                <label class="form-label fw-bold text-dark small mb-1">Display Order</label>
                <input type="number" name="order" class="form-control rounded-3 py-2 px-3" value="0" min="0">
                <div class="form-text text-muted" style="font-size: 11px;">Lower order numbers appear first on frontend.</div>
              </div>

              <div class="col-6 d-flex align-items-center pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input cursor-pointer" type="checkbox" name="is_active" value="1" id="create_is_active" checked>
                  <label class="form-check-label fw-bold text-dark small ms-1" for="create_is_active">Publish immediately on frontend</label>
                </div>
              </div>

            </div>
          </div>

          <div class="modal-footer bg-light border-top py-3 px-4">
            <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="createSubmitBtn" class="btn-custom btn-custom-primary btn-custom-sm d-inline-flex align-items-center gap-2">
              <span class="spinner-border spinner-border-sm d-none" id="createSpinner"></span>
              <span id="createText">Publish Story</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ==========================================
       EDIT STORY MODAL
       ========================================== -->
  <div class="modal fade" id="editStoryModal" tabindex="-1" aria-labelledby="editStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <form id="editStoryForm" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" id="edit_story_id" name="story_id">

          <div class="modal-header border-bottom py-3.5 px-4" style="background-color: #F8FAF9;">
            <div class="d-flex align-items-center gap-2.5">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: var(--brand-forest-medium);">
                <i class="bi bi-pencil-square fs-6"></i>
              </div>
              <div>
                <h5 class="modal-title fw-bold text-gray-900 mb-0" id="editStoryModalLabel">Edit Success Story</h5>
                <p class="text-muted small mb-0">Modify story headline, couple details, photos, or published visibility.</p>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4 bg-white">
            <div class="row g-3">
              
              <!-- Story Title -->
              <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Story Headline / Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="edit_title" class="form-control rounded-3 py-2 px-3" required>
              </div>

              <!-- Couple Names & Wedding Date -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Couple Names</label>
                <input type="text" name="couple_names" id="edit_couple_names" class="form-control rounded-3 py-2 px-3">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Wedding / Engagement Date</label>
                <input type="date" name="wedding_date" id="edit_wedding_date" class="form-control rounded-3 py-2 px-3">
              </div>

              <!-- Primary Couple Image -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Replace Primary Photo (Optional)</label>
                <div class="p-3 border-2 border-dashed rounded-3 bg-light text-center cursor-pointer hover-scale" onclick="$('#edit_primary_image').click()" style="border-style: dashed !important; border-color: #CBD5E1;">
                  <i class="bi bi-cloud-arrow-up fs-2" style="color: var(--brand-forest-medium);"></i>
                  <div class="fw-semibold small text-gray-800 mt-1">Click to replace primary cover photo</div>
                  <div class="text-muted small" style="font-size: 11px;">Leave blank to keep existing photo</div>
                </div>
                <input type="file" name="primary_image" id="edit_primary_image" class="d-none" accept="image/*">
                
                <!-- Primary Image Current / Preview Container -->
                <div class="mt-2.5 rounded-3 overflow-hidden border" style="height: 140px; background-color: #f8f9fa;">
                  <img id="edit_primary_preview_img" src="" class="w-100 h-100 object-fit-contain">
                </div>
              </div>

              <!-- Additional Gallery Images -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold text-dark small mb-1">Add More Gallery Photos (Optional)</label>
                <div class="p-3 border-2 border-dashed rounded-3 bg-light text-center cursor-pointer hover-scale" onclick="$('#edit_gallery_images').click()" style="border-style: dashed !important; border-color: #CBD5E1;">
                  <i class="bi bi-images fs-2" style="color: var(--brand-forest-medium);"></i>
                  <div class="fw-semibold small text-gray-800 mt-1">Click to upload more photos</div>
                  <div class="text-muted small" style="font-size: 11px;">Appends new photos to current gallery</div>
                </div>
                <input type="file" name="images[]" id="edit_gallery_images" class="d-none" accept="image/*" multiple>

                <!-- Existing & New Gallery Photos Wrap -->
                <div id="edit_gallery_preview_wrap" class="d-flex flex-wrap gap-2 mt-2.5"></div>
              </div>

              <!-- Story Detailed Description -->
              <div class="col-12">
                <label class="form-label fw-bold text-dark small mb-1">Story Narrative / Description <span class="text-danger">*</span></label>
                <textarea name="descriptions" id="edit_descriptions" rows="5" class="form-control rounded-3 p-3" required></textarea>
              </div>

              <!-- Order & Active Status -->
              <div class="col-6">
                <label class="form-label fw-bold text-dark small mb-1">Display Order</label>
                <input type="number" name="order" id="edit_order" class="form-control rounded-3 py-2 px-3" min="0">
              </div>

              <div class="col-6 d-flex align-items-center pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input cursor-pointer" type="checkbox" name="is_active" value="1" id="edit_is_active">
                  <label class="form-check-label fw-bold text-dark small ms-1" for="edit_is_active">Publish on Frontend</label>
                </div>
              </div>

            </div>
          </div>

          <div class="modal-footer bg-light border-top py-3 px-4">
            <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="editSubmitBtn" class="btn-custom btn-custom-primary btn-custom-sm d-inline-flex align-items-center gap-2">
              <span class="spinner-border spinner-border-sm d-none" id="editSpinner"></span>
              <span id="editText">Update Story</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ==========================================
       VIEW STORY MODAL
       ========================================== -->
  <div class="modal fade" id="viewStoryModal" tabindex="-1" aria-labelledby="viewStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        
        <div class="modal-header border-bottom py-3.5 px-4" style="background-color: #F8FAF9;">
          <div class="d-flex align-items-center gap-2.5">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: var(--brand-forest-medium);">
              <i class="bi bi-eye fs-6"></i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-gray-900 mb-0" id="viewStoryModalLabel">Story Details</h5>
              <p class="text-muted small mb-0">Preview how this story appears and read full matchmaking narrative.</p>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4 sm:p-4.5 bg-white">
          <!-- Featured Image -->
          <div class="rounded-4 overflow-hidden border mb-3 position-relative shadow-sm" style="height: 300px; background-color: #072F1F;">
            <img id="view_primary_img" src="" class="w-100 h-100 object-fit-cover">
            <div class="position-absolute bottom-3 start-3">
              <span id="view_couple_badge" class="badge bg-danger bg-opacity-95 rounded-pill px-3 py-1.5 shadow-sm" style="font-size: 0.825rem;"></span>
            </div>
          </div>

          <!-- Gallery Strip -->
          <div id="view_gallery_strip" class="d-flex gap-2.5 overflow-x-auto pb-1 mb-3.5"></div>

          <!-- Title & Meta -->
          <div class="mb-3">
            <h3 id="view_title" class="fw-bold text-gray-900 font-serif mb-2" style="font-size: 1.35rem; line-height: 1.35;"></h3>
            <div class="d-flex flex-wrap align-items-center gap-3 text-muted small py-2.5 border-top border-bottom">
              <span id="view_wedding_date" class="d-inline-flex align-items-center gap-1.5 text-danger fw-semibold">
                <i class="bi bi-calendar-heart"></i>
                <span class="val"></span>
              </span>
              <span id="view_status_pill"></span>
              <span id="view_created_at" class="text-muted ms-auto"></span>
            </div>
          </div>

          <!-- Full Narrative -->
          <div class="p-3.5 sm:p-4 rounded-4 border" style="background-color: #F8FAF9;">
            <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom border-light">
              <i class="bi bi-quote fs-5" style="color: var(--brand-forest-medium);"></i>
              <h6 class="fw-bold mb-0" style="color: var(--brand-forest-medium); font-size: 0.95rem;">Matchmaking Narrative</h6>
            </div>
            <p id="view_descriptions" class="text-secondary mb-0 leading-relaxed" style="font-size: 0.925rem; line-height: 1.75; white-space: pre-line;"></p>
          </div>
        </div>

        <div class="modal-footer bg-light border-top py-3 px-4 d-flex justify-content-end">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm px-4" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
// Switch between Table View and Cards Grid View
function switchViewMode(mode) {
  if (mode === 'grid') {
    $('#stories-table-view').addClass('d-none');
    $('#stories-grid-view').removeClass('d-none');
    $('#view-mode-grid').addClass('active btn-primary text-white').removeClass('btn-light');
    $('#view-mode-table').removeClass('active btn-primary text-white').addClass('btn-light');
    localStorage.setItem('admin_stories_view_mode', 'grid');
  } else {
    $('#stories-grid-view').addClass('d-none');
    $('#stories-table-view').removeClass('d-none');
    $('#view-mode-table').addClass('active btn-primary text-white').removeClass('btn-light');
    $('#view-mode-grid').removeClass('active btn-primary text-white').addClass('btn-light');
    localStorage.setItem('admin_stories_view_mode', 'table');
  }
}

$(document).ready(function() {

  // Restore saved view mode preference
  const savedViewMode = localStorage.getItem('admin_stories_view_mode');
  if (savedViewMode === 'grid') {
    switchViewMode('grid');
  }

  // CSRF Token setup for all AJAX requests
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  });

  // -------------------------------------------------------------
  // 1. Create Modal - Photo Previews
  // -------------------------------------------------------------
  $('#create_primary_image').on('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        $('#create_primary_preview_img').attr('src', event.target.result);
        $('#create_primary_preview_wrap').removeClass('d-none');
      };
      reader.readAsDataURL(file);
    } else {
      $('#create_primary_preview_wrap').addClass('d-none');
    }
  });

  $('#create_gallery_images').on('change', function(e) {
    const files = Array.from(e.target.files);
    const $wrap = $('#create_gallery_preview_wrap');
    $wrap.empty();

    files.forEach(function(file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        $wrap.append(`
          <div class="rounded-2 overflow-hidden border shadow-2xs" style="width: 54px; height: 54px;">
            <img src="${event.target.result}" class="w-100 h-100 object-fit-cover">
          </div>
        `);
      };
      reader.readAsDataURL(file);
    });
  });

  // -------------------------------------------------------------
  // 2. Submit Create Story Form (AJAX)
  // -------------------------------------------------------------
  $('#createStoryForm').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const $btn = $('#createSubmitBtn');
    const $spinner = $('#createSpinner');
    const $text = $('#createText');

    $btn.prop('disabled', true);
    $spinner.removeClass('d-none');
    $text.text('Publishing...');

    $.ajax({
      url: "{{ route('admin.stories.store') }}",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        $btn.prop('disabled', false);
        $spinner.addClass('d-none');
        $text.text('Publish Story');

        if (res.success) {
          bootstrap.Modal.getInstance(document.getElementById('createStoryModal')).hide();
          Swal.fire({
            icon: 'success',
            title: 'Story Published!',
            text: res.message,
            timer: 1500,
            showConfirmButton: false
          }).then(function() {
            window.location.reload();
          });
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false);
        $spinner.addClass('d-none');
        $text.text('Publish Story');

        let msg = 'Failed to publish story.';
        if (xhr.responseJSON) {
          if (xhr.responseJSON.errors) {
            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
          } else if (xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }
        }
        Swal.fire({
          icon: 'error',
          title: 'Validation Error',
          html: msg
        });
      }
    });
  });

  // -------------------------------------------------------------
  // 3. Open Edit Modal & Populate Data
  // -------------------------------------------------------------
  $(document).on('click', '.edit-story-btn', function() {
    const storyId = $(this).data('id');
    const editModalEl = document.getElementById('editStoryModal');
    const editModal = new bootstrap.Modal(editModalEl);

    $.ajax({
      url: '/admin/stories/' + storyId,
      type: 'GET',
      success: function(res) {
        if (res.success && res.story) {
          const s = res.story;
          $('#edit_story_id').val(s.id);
          $('#edit_title').val(s.title);
          $('#edit_couple_names').val(s.couple_names || '');
          $('#edit_wedding_date').val(s.wedding_date || '');
          $('#edit_descriptions').val(s.descriptions);
          $('#edit_order').val(s.order || 0);
          $('#edit_is_active').prop('checked', !!s.is_active);

          // Primary image preview
          $('#edit_primary_preview_img').attr('src', s.image_url);
          $('#edit_primary_image').val('');

          // Gallery previews
          const $gWrap = $('#edit_gallery_preview_wrap');
          $gWrap.empty();
          if (s.gallery_images && s.gallery_images.length > 0) {
            s.gallery_images.forEach(function(imgSrc) {
              $gWrap.append(`
                <div class="rounded-2 overflow-hidden border shadow-2xs" style="width: 54px; height: 54px;">
                  <img src="${imgSrc}" class="w-100 h-100 object-fit-cover">
                </div>
              `);
            });
          }

          editModal.show();
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Could not fetch story details.'
        });
      }
    });
  });

  $('#edit_primary_image').on('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        $('#edit_primary_preview_img').attr('src', event.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // -------------------------------------------------------------
  // 4. Submit Edit Story Form (AJAX)
  // -------------------------------------------------------------
  $('#editStoryForm').on('submit', function(e) {
    e.preventDefault();
    const storyId = $('#edit_story_id').val();
    const formData = new FormData(this);
    const $btn = $('#editSubmitBtn');
    const $spinner = $('#editSpinner');
    const $text = $('#editText');

    $btn.prop('disabled', true);
    $spinner.removeClass('d-none');
    $text.text('Updating...');

    $.ajax({
      url: '/admin/stories/' + storyId,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        $btn.prop('disabled', false);
        $spinner.addClass('d-none');
        $text.text('Update Story');

        if (res.success) {
          bootstrap.Modal.getInstance(document.getElementById('editStoryModal')).hide();
          Swal.fire({
            icon: 'success',
            title: 'Story Updated!',
            text: res.message,
            timer: 1500,
            showConfirmButton: false
          }).then(function() {
            window.location.reload();
          });
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false);
        $spinner.addClass('d-none');
        $text.text('Update Story');

        let msg = 'Failed to update story.';
        if (xhr.responseJSON) {
          if (xhr.responseJSON.errors) {
            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
          } else if (xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }
        }
        Swal.fire({
          icon: 'error',
          title: 'Update Error',
          html: msg
        });
      }
    });
  });

  // -------------------------------------------------------------
  // 5. View Full Story Modal
  // -------------------------------------------------------------
  $(document).on('click', '.view-story-btn', function() {
    const storyId = $(this).data('id');
    const viewModalEl = document.getElementById('viewStoryModal');
    const viewModal = new bootstrap.Modal(viewModalEl);

    $.ajax({
      url: '/admin/stories/' + storyId,
      type: 'GET',
      success: function(res) {
        if (res.success && res.story) {
          const s = res.story;
          $('#view_primary_img').attr('src', s.image_url);
          $('#view_title').text(s.title);

          if (s.couple_names) {
            $('#view_couple_badge').text(s.couple_names).show();
          } else {
            $('#view_couple_badge').hide();
          }

          if (s.formatted_wedding_date) {
            $('#view_wedding_date .val').text(s.formatted_wedding_date);
            $('#view_wedding_date').show();
          } else {
            $('#view_wedding_date').hide();
          }

          if (s.is_active) {
            $('#view_status_pill').html('<span class="badge-table success">Published</span>');
          } else {
            $('#view_status_pill').html('<span class="badge-table failed">Hidden</span>');
          }

          $('#view_created_at').text('Created: ' + s.created_at);
          $('#view_descriptions').text(s.descriptions);

          // Gallery strip
          const $gStrip = $('#view_gallery_strip');
          $gStrip.empty();
          if (s.gallery_images && s.gallery_images.length > 1) {
            s.gallery_images.forEach(function(img) {
              $gStrip.append(`
                <button type="button" class="btn p-0 rounded-3 overflow-hidden border-2 cursor-pointer shrink-0 shadow-2xs hover-scale" onclick="$('#view_primary_img').attr('src', '${img}')" style="width: 62px; height: 62px; border-color: #E2E8F0;">
                  <img src="${img}" class="w-100 h-100 object-fit-cover">
                </button>
              `);
            });
            $gStrip.show();
          } else {
            $gStrip.hide();
          }

          viewModal.show();
        }
      }
    });
  });

  // -------------------------------------------------------------
  // 6. Delete Story with SweetAlert2 Confirmation
  // -------------------------------------------------------------
  $(document).on('click', '.delete-story-btn', function() {
    const storyId = $(this).data('id');
    const title = $(this).data('title') || 'this story';

    Swal.fire({
      title: 'Delete Success Story?',
      html: `Are you sure you want to delete <strong>${title}</strong>? This action cannot be undone.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, Delete Story',
      cancelButtonText: 'Cancel'
    }).then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: '/admin/stories/' + storyId,
          type: 'DELETE',
          success: function(res) {
            if (res.success) {
              Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
              }).then(function() {
                $('#story-row-' + storyId).fadeOut(400, function() { $(this).remove(); });
                $('#story-card-' + storyId).fadeOut(400, function() { $(this).remove(); });
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Could not delete story.'
            });
          }
        });
      }
    });
  });

  // -------------------------------------------------------------
  // 7. Toggle Active Status Live (Switch)
  // -------------------------------------------------------------
  $(document).on('change', '.toggle-status-btn', function() {
    const storyId = $(this).data('id');
    const isChecked = $(this).is(':checked');
    const $statusPill = $('#status-pill-' + storyId);
    const $gridStatusBadge = $('#grid-status-badge-' + storyId);

    $.ajax({
      url: '/admin/stories/' + storyId + '/toggle-status',
      type: 'POST',
      success: function(res) {
        if (res.success) {
          if (res.is_active) {
            $statusPill.removeClass('failed').addClass('success').text('Published');
            $gridStatusBadge.removeClass('failed').addClass('success').text('Published');
          } else {
            $statusPill.removeClass('success').addClass('failed').text('Hidden');
            $gridStatusBadge.removeClass('success').addClass('failed').text('Hidden');
          }

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
          });
          Toast.fire({
            icon: res.is_active ? 'success' : 'info',
            title: res.message
          });
        }
      },
      error: function() {
        $('#switch-table-' + storyId).prop('checked', !isChecked);
        $('#switch-grid-' + storyId).prop('checked', !isChecked);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to update story status.'
        });
      }
    });
  });

});
</script>

<style>
.story-card-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 28px rgba(11, 19, 15, 0.08) !important;
}
.hover-scale {
  transition: transform 0.2s ease-in-out;
}
.hover-scale:hover {
  transform: scale(1.03);
}
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.shadow-2xs {
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
</style>
@endpush
