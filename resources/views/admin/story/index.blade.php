@extends('admin.layouts.app')

@section('title', 'Success Stories Management - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid py-4" x-data="storyManager()">
  
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h1 class="h3 fw-bold text-gray-900 mb-0">Success Stories</h1>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1">
          <i class="bi bi-stars me-1"></i> Matchmaking Tales
        </span>
      </div>
      <p class="text-muted small mb-0">Manage inspiring success stories of happy couples who found their forever partner on Rani Matrimonial.</p>
    </div>

    <div class="d-flex items-center gap-2">
      <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2" @click="openCreateModal()">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Add New Story</span>
      </button>
    </div>
  </div>

  <!-- Metric Statistics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
        <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
          <div>
            <span class="text-muted small text-uppercase fw-semibold tracking-wider d-block mb-1">Total Stories</span>
            <h3 class="fw-bold text-gray-900 mb-0">{{ number_format($counts['total']) }}</h3>
          </div>
          <div class="w-12 h-12 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-center fs-4">
            <i class="bi bi-journal-bookmark-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
        <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
          <div>
            <span class="text-muted small text-uppercase fw-semibold tracking-wider d-block mb-1">Active / Published</span>
            <h3 class="fw-bold text-success mb-0">{{ number_format($counts['active']) }}</h3>
          </div>
          <div class="w-12 h-12 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-center fs-4">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
        <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
          <div>
            <span class="text-muted small text-uppercase fw-semibold tracking-wider d-block mb-1">Hidden / Draft</span>
            <h3 class="fw-bold text-secondary mb-0">{{ number_format($counts['inactive']) }}</h3>
          </div>
          <div class="w-12 h-12 rounded-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-center fs-4">
            <i class="bi bi-eye-slash-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
        <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
          <div>
            <span class="text-muted small text-uppercase fw-semibold tracking-wider d-block mb-1">Added This Month</span>
            <h3 class="fw-bold text-danger mb-0">{{ number_format($counts['this_month']) }}</h3>
          </div>
          <div class="w-12 h-12 rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-center fs-4">
            <i class="bi bi-heart-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Toolbar -->
  <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
    <div class="card-body p-3">
      <form action="{{ route('admin.stories.index') }}" method="GET" class="row g-2 align-items-center">
        <!-- Search Input -->
        <div class="col-12 col-md-5 col-lg-6">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" value="{{ $search }}" class="form-control bg-light border-0" placeholder="Search by title, couple names, story text...">
          </div>
        </div>

        <!-- Status Filter -->
        <div class="col-6 col-md-4 col-lg-3">
          <select name="status" class="form-select form-select-sm bg-light border-0" onchange="this.form.submit()">
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status (Active & Inactive)</option>
            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active (Published)</option>
            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
          </select>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="col-6 col-md-3 col-lg-3 d-flex gap-2">
          <button type="submit" class="btn btn-sm btn-primary flex-fill rounded-3">Filter</button>
          @if(!empty($search) || $status !== 'all')
            <a href="{{ route('admin.stories.index') }}" class="btn btn-sm btn-light rounded-3" title="Clear Filters">
              <i class="bi bi-x-circle"></i>
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  <!-- Stories Feed Grid -->
  @if($stories->count() > 0)
    <div class="row g-4 mb-4">
      @foreach($stories as $story)
        <div class="col-12 col-md-6 col-lg-4" id="story-card-{{ $story->id }}">
          <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden story-card-item transition-all bg-white position-relative">
            
            <!-- Story Cover Image -->
            <div class="position-relative" style="height: 220px; overflow: hidden; background-color: #1a0505;">
              <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-100 h-100 object-fit-cover transition-transform duration-500 hover-scale">
              
              <!-- Top Gradient Overlay -->
              <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-t pointer-events-none" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);"></div>

              <!-- Top Left Status Badge -->
              <div class="position-absolute top-3 start-3 z-2">
                <span class="badge {{ $story->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }} shadow-sm rounded-pill px-2.5 py-1 text-xs">
                  {{ $story->is_active ? '● Published' : '○ Hidden' }}
                </span>
              </div>

              <!-- Top Right Photo Count -->
              <div class="position-absolute top-3 end-3 z-2">
                <span class="badge bg-dark bg-opacity-75 text-warning border border-warning-subtle shadow-sm rounded-pill px-2.5 py-1 text-xs">
                  <i class="bi bi-images me-1"></i> {{ count($story->gallery_images) }} Photos
                </span>
              </div>

              <!-- Bottom Overlay Title & Couple -->
              <div class="position-absolute bottom-3 start-3 end-3 z-2 text-white">
                @if($story->couple_names)
                  <span class="badge bg-danger bg-opacity-90 text-white rounded-pill px-2 py-0.5 text-xs mb-1">
                    <i class="bi bi-heart-fill me-1"></i> {{ $story->couple_names }}
                  </span>
                @endif
                <h5 class="fw-bold text-white mb-0 text-truncate font-serif">{{ $story->title }}</h5>
              </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3.5 d-flex flex-column justify-content-between">
              <div>
                <!-- Wedding Date & Order -->
                <div class="d-flex align-items-center justify-content-between text-muted small mb-2.5">
                  @if($story->formatted_wedding_date)
                    <span class="d-flex align-items-center gap-1">
                      <i class="bi bi-calendar-heart text-danger"></i>
                      <span>{{ $story->formatted_wedding_date }}</span>
                    </span>
                  @else
                    <span class="text-muted">Story #{{ $story->id }}</span>
                  @endif

                  <span class="badge bg-light text-dark border">Order: {{ $story->order }}</span>
                </div>

                <!-- Description Snippet -->
                <p class="text-muted small line-clamp-3 mb-3 leading-relaxed">
                  {{ Str::limit(strip_tags($story->descriptions), 130) }}
                </p>
              </div>

              <!-- Card Action Toolbar -->
              <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                <!-- Status Toggle Switch -->
                <div class="form-check form-switch mb-0" title="Toggle active/published status">
                  <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="switch-{{ $story->id }}" {{ $story->is_active ? 'checked' : '' }} @change="toggleStatus({{ $story->id }})">
                  <label class="form-check-label text-xs fw-semibold text-muted" for="switch-{{ $story->id }}">
                    {{ $story->is_active ? 'Active' : 'Inactive' }}
                  </label>
                </div>

                <!-- Action Buttons (View, Edit, Delete) -->
                <div class="d-flex align-items-center gap-1.5">
                  <button type="button" class="btn btn-sm btn-outline-info rounded-circle p-1.5" title="View Full Story" @click="viewStory({{ $story->id }})">
                    <i class="bi bi-eye"></i>
                  </button>

                  <button type="button" class="btn btn-sm btn-outline-primary rounded-circle p-1.5" title="Edit Story" @click="openEditModal({{ $story->id }})">
                    <i class="bi bi-pencil-square"></i>
                  </button>

                  <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1.5" title="Delete Story" @click="deleteStory({{ $story->id }}, '{{ addslashes($story->title) }}')">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $stories->links('pagination::bootstrap-5') }}
    </div>
  @else
    <!-- Empty State -->
    <div class="card border-0 shadow-sm rounded-4 text-center p-5 bg-white">
      <div class="card-body">
        <div class="w-16 h-16 rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-center fs-1 mb-3">
          <i class="bi bi-stars"></i>
        </div>
        <h4 class="fw-bold text-gray-800 font-serif">No Success Stories Found</h4>
        <p class="text-muted small max-w-md mx-auto mb-4">
          @if(!empty($search) || $status !== 'all')
            No success stories match your current search criteria. Try clearing filters or creating a new story.
          @else
            No success stories have been created yet. Inspire potential brides and grooms by publishing your first success story!
          @endif
        </p>
        <button type="button" class="btn btn-primary rounded-pill px-4 py-2" @click="openCreateModal()">
          <i class="bi bi-plus-circle me-1.5"></i> Publish First Story
        </button>
      </div>
    </div>
  @endif

  <!-- ================= CREATE / ADD STORY MODAL ================= -->
  <div class="modal fade" id="createStoryModal" tabindex="-1" aria-labelledby="createStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitCreateForm($event)">
          @csrf
          <div class="modal-header bg-gradient-to-r from-danger to-dark text-white border-0 py-3">
            <h5 class="modal-title font-serif fw-bold d-flex align-items-center gap-2" id="createStoryModalLabel">
              <i class="bi bi-stars text-warning"></i> Add New Success Story
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4 bg-light">
            <div class="row g-3">
              
              <!-- Story Title -->
              <div class="col-12">
                <label class="form-label fw-semibold text-gray-700 small">Story Title <span class="text-danger">*</span></label>
                <input type="text" name="title" x-model="createData.title" class="form-control rounded-3" placeholder="e.g. Vikram & Ananya: Two Hearts United by Destiny" required>
              </div>

              <!-- Couple Names & Wedding Date -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Couple Names</label>
                <input type="text" name="couple_names" x-model="createData.couple_names" class="form-control rounded-3" placeholder="e.g. Vikram Sharma & Ananya Verma">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Wedding / Engagement Date</label>
                <input type="date" name="wedding_date" x-model="createData.wedding_date" class="form-control rounded-3">
              </div>

              <!-- Primary Couple Image -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Primary Featured Image <span class="text-danger">*</span></label>
                <input type="file" name="primary_image" class="form-control rounded-3" accept="image/*" @change="previewPrimaryImage($event, 'create')" required>
                <div class="form-text text-xs">Recommended: High quality horizontal or portrait image (JPEG, PNG, WebP up to 10MB)</div>
                
                <!-- Primary Image Preview -->
                <template x-if="createPrimaryPreview">
                  <div class="mt-2 rounded-3 overflow-hidden border position-relative" style="height: 140px; background-color: #f8f9fa;">
                    <img :src="createPrimaryPreview" class="w-100 h-100 object-fit-contain">
                  </div>
                </template>
              </div>

              <!-- Additional Gallery Images -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Additional Gallery Photos (Optional)</label>
                <input type="file" name="images[]" class="form-control rounded-3" accept="image/*" multiple @change="previewGalleryImages($event, 'create')">
                <div class="form-text text-xs">Select multiple wedding or engagement photos.</div>

                <!-- Gallery Preview Thumbnails -->
                <div class="d-flex flex-wrap gap-2 mt-2" x-show="createGalleryPreviews.length > 0">
                  <template x-for="(imgSrc, idx) in createGalleryPreviews" :key="idx">
                    <div class="rounded-2 overflow-hidden border" style="width: 50px; height: 50px;">
                      <img :src="imgSrc" class="w-100 h-100 object-fit-cover">
                    </div>
                  </template>
                </div>
              </div>

              <!-- Story Detailed Description -->
              <div class="col-12">
                <label class="form-label fw-semibold text-gray-700 small">Story Narrative / Description <span class="text-danger">*</span></label>
                <textarea name="descriptions" x-model="createData.descriptions" rows="5" class="form-control rounded-3" placeholder="Tell the romantic story of how the couple matched on Rani Matrimonial, their initial conversations, family meetings, and journey to marriage..." required></textarea>
              </div>

              <!-- Order & Active Status -->
              <div class="col-6">
                <label class="form-label fw-semibold text-gray-700 small">Display Order</label>
                <input type="number" name="order" x-model="createData.order" class="form-control rounded-3" value="0" min="0">
                <div class="form-text text-xs">Lower numbers appear first on frontend.</div>
              </div>

              <div class="col-6 d-flex align-items-center pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input cursor-pointer" type="checkbox" name="is_active" value="1" id="create_is_active" checked x-model="createData.is_active">
                  <label class="form-check-label fw-semibold text-gray-700 small" for="create_is_active">Publish on Frontend</label>
                </div>
              </div>

            </div>
          </div>

          <div class="modal-footer bg-white border-top py-3">
            <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-3 px-4 d-inline-flex align-items-center gap-2" :disabled="saving">
              <span x-show="saving" class="spinner-border spinner-border-sm"></span>
              <span x-text="saving ? 'Publishing...' : 'Publish Story'"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ================= EDIT STORY MODAL ================= -->
  <div class="modal fade" id="editStoryModal" tabindex="-1" aria-labelledby="editStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <form @submit.prevent="submitEditForm($event)">
          <div class="modal-header bg-gradient-to-r from-primary to-dark text-white border-0 py-3">
            <h5 class="modal-title font-serif fw-bold d-flex align-items-center gap-2" id="editStoryModalLabel">
              <i class="bi bi-pencil-square text-warning"></i> Edit Success Story
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4 bg-light">
            <div class="row g-3">
              
              <!-- Story Title -->
              <div class="col-12">
                <label class="form-label fw-semibold text-gray-700 small">Story Title <span class="text-danger">*</span></label>
                <input type="text" name="title" x-model="editData.title" class="form-control rounded-3" required>
              </div>

              <!-- Couple Names & Wedding Date -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Couple Names</label>
                <input type="text" name="couple_names" x-model="editData.couple_names" class="form-control rounded-3">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Wedding / Engagement Date</label>
                <input type="date" name="wedding_date" x-model="editData.wedding_date" class="form-control rounded-3">
              </div>

              <!-- Primary Couple Image -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Replace Featured Image</label>
                <input type="file" name="primary_image" class="form-control rounded-3" accept="image/*" @change="previewPrimaryImage($event, 'edit')">
                
                <!-- Primary Image Current / Preview -->
                <div class="mt-2 rounded-3 overflow-hidden border position-relative" style="height: 140px; background-color: #f8f9fa;">
                  <img :src="editPrimaryPreview || editData.image_url" class="w-100 h-100 object-fit-contain">
                </div>
              </div>

              <!-- Additional Gallery Images -->
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold text-gray-700 small">Add More Gallery Photos</label>
                <input type="file" name="images[]" class="form-control rounded-3" accept="image/*" multiple @change="previewGalleryImages($event, 'edit')">
                
                <!-- Current Gallery Thumbnails -->
                <div class="d-flex flex-wrap gap-2 mt-2">
                  <template x-for="(imgSrc, idx) in (editGalleryPreviews.length > 0 ? editGalleryPreviews : (editData.gallery_images || []))" :key="idx">
                    <div class="rounded-2 overflow-hidden border" style="width: 50px; height: 50px;">
                      <img :src="imgSrc" class="w-100 h-100 object-fit-cover">
                    </div>
                  </template>
                </div>
              </div>

              <!-- Story Detailed Description -->
              <div class="col-12">
                <label class="form-label fw-semibold text-gray-700 small">Story Narrative / Description <span class="text-danger">*</span></label>
                <textarea name="descriptions" x-model="editData.descriptions" rows="5" class="form-control rounded-3" required></textarea>
              </div>

              <!-- Order & Active Status -->
              <div class="col-6">
                <label class="form-label fw-semibold text-gray-700 small">Display Order</label>
                <input type="number" name="order" x-model="editData.order" class="form-control rounded-3" min="0">
              </div>

              <div class="col-6 d-flex align-items-center pt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input cursor-pointer" type="checkbox" id="edit_is_active" x-model="editData.is_active">
                  <label class="form-check-label fw-semibold text-gray-700 small" for="edit_is_active">Publish on Frontend</label>
                </div>
              </div>

            </div>
          </div>

          <div class="modal-footer bg-white border-top py-3">
            <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-3 px-4 d-inline-flex align-items-center gap-2" :disabled="saving">
              <span x-show="saving" class="spinner-border spinner-border-sm"></span>
              <span x-text="saving ? 'Saving...' : 'Update Story'"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ================= VIEW STORY DETAIL MODAL ================= -->
  <div class="modal fade" id="viewStoryModal" tabindex="-1" aria-labelledby="viewStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" x-show="activeStory">
        <div class="modal-header bg-dark text-white border-0 py-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-stars text-warning fs-5"></i>
            <div>
              <h5 class="modal-title font-serif fw-bold text-white mb-0" x-text="activeStory ? activeStory.title : ''"></h5>
              <span class="text-warning small text-xs font-mono" x-text="activeStory && activeStory.couple_names ? activeStory.couple_names : ''"></span>
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <!-- Main Photo Banner -->
          <div class="rounded-4 overflow-hidden mb-4 border" style="max-height: 320px; background-color: #111;">
            <img :src="activeStory ? activeStory.image_url : ''" class="w-100 h-100 object-fit-cover">
          </div>

          <!-- Metadata Badges -->
          <div class="d-flex flex-wrap items-center gap-3 mb-4 pb-3 border-bottom text-muted small">
            <div class="d-flex align-items-center gap-1.5" x-show="activeStory && activeStory.formatted_wedding_date">
              <i class="bi bi-calendar2-heart text-danger"></i>
              <span x-text="'Wedding Date: ' + (activeStory ? activeStory.formatted_wedding_date : '')"></span>
            </div>

            <div class="d-flex align-items-center gap-1.5">
              <i class="bi bi-clock-history text-primary"></i>
              <span x-text="'Published: ' + (activeStory ? activeStory.created_at : '')"></span>
            </div>

            <div>
              <span class="badge" :class="activeStory && activeStory.is_active ? 'bg-success' : 'bg-secondary'" x-text="activeStory && activeStory.is_active ? '● Published' : '○ Inactive'"></span>
            </div>
          </div>

          <!-- Full Narrative -->
          <div class="text-gray-800 leading-relaxed font-sans" style="white-space: pre-line;" x-text="activeStory ? activeStory.descriptions : ''"></div>

          <!-- Photo Gallery Strip (if multiple) -->
          <div class="mt-4 pt-3 border-top" x-show="activeStory && activeStory.gallery_images && activeStory.gallery_images.length > 1">
            <h6 class="fw-bold text-gray-700 small text-uppercase mb-2">Photo Gallery</h6>
            <div class="d-flex gap-2 overflow-x-auto py-1">
              <template x-for="(gImg, gIdx) in (activeStory ? activeStory.gallery_images : [])" :key="gIdx">
                <a :href="gImg" target="_blank" class="rounded-3 overflow-hidden border flex-shrink-0" style="width: 80px; height: 80px;">
                  <img :src="gImg" class="w-100 h-100 object-fit-cover">
                </a>
              </template>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Alpine Story Manager JS Component -->
<script>
function storyManager() {
  return {
    saving: false,
    activeStory: null,

    // Create Modal State
    createModal: null,
    createData: {
      title: '',
      couple_names: '',
      wedding_date: '',
      descriptions: '',
      order: 0,
      is_active: true
    },
    createPrimaryPreview: null,
    createGalleryPreviews: [],

    // Edit Modal State
    editModal: null,
    editStoryId: null,
    editData: {
      title: '',
      couple_names: '',
      wedding_date: '',
      descriptions: '',
      order: 0,
      is_active: true,
      image_url: '',
      gallery_images: []
    },
    editPrimaryPreview: null,
    editGalleryPreviews: [],

    // View Modal State
    viewModalInstance: null,

    init() {
      // Bootstrap Modals
      if (document.getElementById('createStoryModal')) {
        this.createModal = new bootstrap.Modal(document.getElementById('createStoryModal'));
      }
      if (document.getElementById('editStoryModal')) {
        this.editModal = new bootstrap.Modal(document.getElementById('editStoryModal'));
      }
      if (document.getElementById('viewStoryModal')) {
        this.viewModalInstance = new bootstrap.Modal(document.getElementById('viewStoryModal'));
      }
    },

    openCreateModal() {
      this.createData = {
        title: '',
        couple_names: '',
        wedding_date: '',
        descriptions: '',
        order: 0,
        is_active: true
      };
      this.createPrimaryPreview = null;
      this.createGalleryPreviews = [];
      this.createModal.show();
    },

    previewPrimaryImage(e, mode) {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (event) => {
        if (mode === 'create') {
          this.createPrimaryPreview = event.target.result;
        } else {
          this.editPrimaryPreview = event.target.result;
        }
      };
      reader.readAsDataURL(file);
    },

    previewGalleryImages(e, mode) {
      const files = Array.from(e.target.files);
      if (!files.length) return;
      const previews = [];
      let loaded = 0;
      files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (event) => {
          previews.push(event.target.result);
          loaded++;
          if (loaded === files.length) {
            if (mode === 'create') {
              this.createGalleryPreviews = previews;
            } else {
              this.editGalleryPreviews = previews;
            }
          }
        };
        reader.readAsDataURL(file);
      });
    },

    async submitCreateForm(e) {
      this.saving = true;
      const form = e.target;
      const formData = new FormData(form);

      try {
        const res = await fetch('{{ route("admin.stories.store") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        this.saving = false;

        if (data.success) {
          this.createModal.hide();
          Swal.fire({
            icon: 'success',
            title: 'Story Published!',
            text: data.message,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: data.message || 'Please check the required fields.'
          });
        }
      } catch (err) {
        this.saving = false;
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to publish story. Please try again.'
        });
      }
    },

    async openEditModal(storyId) {
      this.editStoryId = storyId;
      this.editPrimaryPreview = null;
      this.editGalleryPreviews = [];

      try {
        const res = await fetch('/admin/stories/' + storyId, {
          headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (data.success) {
          this.editData = { ...data.story };
          this.editModal.show();
        }
      } catch (err) {
        console.error(err);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Could not fetch story details.' });
      }
    },

    async submitEditForm(e) {
      this.saving = true;
      const form = e.target;
      const formData = new FormData(form);
      formData.append('_method', 'PUT');

      try {
        const res = await fetch('/admin/stories/' + this.editStoryId, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        this.saving = false;

        if (data.success) {
          this.editModal.hide();
          Swal.fire({
            icon: 'success',
            title: 'Updated Successfully!',
            text: data.message,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Failed to update story.'
          });
        }
      } catch (err) {
        this.saving = false;
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while updating story.'
        });
      }
    },

    async viewStory(storyId) {
      try {
        const res = await fetch('/admin/stories/' + storyId, {
          headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
          this.activeStory = data.story;
          this.viewModalInstance.show();
        }
      } catch (err) {
        console.error(err);
      }
    },

    async toggleStatus(storyId) {
      try {
        const res = await fetch('/admin/stories/' + storyId + '/toggle-status', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (data.success) {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
          });
          Toast.fire({
            icon: data.is_active ? 'success' : 'info',
            title: data.message
          });
        }
      } catch (err) {
        console.error(err);
      }
    },

    deleteStory(storyId, title) {
      Swal.fire({
        title: 'Delete Success Story?',
        html: `Are you sure you want to delete <strong>${title}</strong>? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete Story',
        cancelButtonText: 'Cancel'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            const res = await fetch('/admin/stories/' + storyId, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              }
            });
            const data = await res.json();
            if (data.success) {
              Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
              }).then(() => {
                const cardEl = document.getElementById('story-card-' + storyId);
                if (cardEl) {
                  cardEl.remove();
                } else {
                  window.location.reload();
                }
              });
            }
          } catch (err) {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Could not delete story.' });
          }
        }
      });
    }
  };
}
</script>

<style>
.story-card-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 28px rgba(0,0,0,0.1) !important;
}
.hover-scale:hover {
  transform: scale(1.04);
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
@endsection
