@error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="size">Size</label>
                                <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                       id="size" name="size" value="{{ old('size', $component->size) }}" 
                                       placeholder="e.g., Small, Medium, Large, or specific measurements">
                                @error('size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="material">Material</label>
                                <input type="text" class="form-control @error('material') is-invalid @enderror" 
                                       id="material" name="material" value="{{ old('material', $component->material) }}" 
                                       placeholder="e.g., Carbon Fiber, Titanium, Aluminum">
                                @error('material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="compatibility">Compatibility</label>
                                <input type="text" class="form-control @error('compatibility') is-invalid @enderror" 
                                       id="compatibility" name="compatibility" value="{{ old('compatibility', $component->compatibility) }}" 
                                       placeholder="e.g., Below Knee, Above Knee, Below Elbow, Above Elbow">
                                <small class="form-text text-muted">Specify amputation levels this component is compatible with</small>
                                @error('compatibility')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" required
                                          placeholder="Detailed description of the prosthetic component, its features, and benefits">{{ old('description', $component->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Weight Specifications Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-weight-hanging"></i> Weight Specifications
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="weight_min">Minimum Weight (grams)</label>
                                <input type="number" class="form-control @error('weight_min') is-invalid @enderror" 
                                       id="weight_min" name="weight_min" value="{{ old('weight_min', $component->weight_min) }}" 
                                       placeholder="e.g., 200" min="0">
                                <small class="form-text text-muted">Minimum weight requirement in grams</small>
                                @error('weight_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="weight_max">Maximum Weight (grams)</label>
                                <input type="number" class="form-control @error('weight_max') is-invalid @enderror" 
                                       id="weight_max" name="weight_max" value="{{ old('weight_max', $component->weight_max) }}" 
                                       placeholder="e.g., 800" min="0">
                                <small class="form-text text-muted">Maximum weight requirement in grams</small>
                                @error('weight_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Patient Matching Criteria Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-check"></i> Patient Matching Criteria
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="age_min">Minimum Age (years)</label>
                                <input type="number" class="form-control @error('age_min') is-invalid @enderror" 
                                       id="age_min" name="age_min" value="{{ old('age_min', $component->age_min) }}" 
                                       placeholder="e.g., 18" min="0" max="120">
                                <small class="form-text text-muted">Minimum recommended age</small>
                                @error('age_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="age_max">Maximum Age (years)</label>
                                <input type="number" class="form-control @error('age_max') is-invalid @enderror" 
                                       id="age_max" name="age_max" value="{{ old('age_max', $component->age_max) }}" 
                                       placeholder="e.g., 75" min="0" max="120">
                                <small class="form-text text-muted">Maximum recommended age</small>
                                @error('age_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="klevel_range">K-Level Range</label>
                                <input type="text" class="form-control @error('klevel_range') is-invalid @enderror" 
                                       id="klevel_range" name="klevel_range" value="{{ old('klevel_range', $component->klevel_range) }}" 
                                       placeholder="e.g., K1-K3, K2-K4, K0">
                                <small class="form-text text-muted">K-level mobility range (K0, K1, K2, K3, K4)</small>
                                @error('klevel_range')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bscore_min">Minimum BLARt Score</label>
                                <input type="number" class="form-control @error('bscore_min') is-invalid @enderror" 
                                       id="bscore_min" name="bscore_min" value="{{ old('bscore_min', $component->bscore_min) }}" 
                                       placeholder="e.g., 10" min="0" max="30">
                                <small class="form-text text-muted">Minimum BLARt score</small>
                                @error('bscore_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bscore_max">Maximum BLARt Score</label>
                                <input type="number" class="form-control @error('bscore_max') is-invalid @enderror" 
                                       id="bscore_max" name="bscore_max" value="{{ old('bscore_max', $component->bscore_max) }}" 
                                       placeholder="e.g., 25" min="0" max="30">
                                <small class="form-text text-muted">Maximum BLARt score</small>
                                @error('bscore_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status & Metadata Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-clock"></i> Status & Information
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Current Status</label>
                                <div class="status-display">
                                    <span class="status-badge badge badge-warning">
                                        <i class="fas fa-clock"></i> Pending Approval
                                    </span>
                                    <small class="form-text text-muted">This component will remain pending until approved by an administrator</small>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Component Information</label>
                                <div class="component-metadata">
                                    <p><strong>Created:</strong> {{ $component->created_at->format('M d, Y \a\t H:i') }}</p>
                                    <p><strong>Last Updated:</strong> {{ $component->updated_at->format('M d, Y \a\t H:i') }}</p>
                                    <p><strong>Component ID:</strong> #{{ $component->compID }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Component
                        </button>
                        <a href="{{ route('staff.component.show', $component->compID) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Component
                        </a>
                        <a href="{{ route('staff.component.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Back to List
                        </a>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i> Reset Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar functionality
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const dashboardLayout = document.querySelector('.dashboard-layout');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            dashboardLayout.classList.toggle('sidebar-collapsed');
        });
    }

    // ScrollReveal animation
    ScrollReveal().reveal('.content-container', {
        origin: 'top',
        distance: '20px',
        duration: 1000,
        delay: 200,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    // Form validation
    const componentForm = document.getElementById('componentForm');
    
    componentForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Check required fields
        const requiredFields = ['name', 'type', 'description'];
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate age range
        const ageMin = document.getElementById('age_min');
        const ageMax = document.getElementById('age_max');
        
        if (ageMin.value && ageMax.value) {
            const minValue = parseInt(ageMin.value);
            const maxValue = parseInt(ageMax.value);
            
            if (minValue >= maxValue) {
                ageMin.classList.add('is-invalid');
                ageMax.classList.add('is-invalid');
                isValid = false;
                showCustomError(ageMin, 'Minimum age must be less than maximum age');
            } else {
                ageMin.classList.remove('is-invalid');
                ageMax.classList.remove('is-invalid');
            }
        }

        // Validate weight range
        const weightMin = document.getElementById('weight_min');
        const weightMax = document.getElementById('weight_max');
        
        if (weightMin.value && weightMax.value) {
            const minValue = parseInt(weightMin.value);
            const maxValue = parseInt(weightMax.value);
            
            if (minValue >= maxValue) {
                weightMin.classList.add('is-invalid');
                weightMax.classList.add('is-invalid');
                isValid = false;
                showCustomError(weightMin, 'Minimum weight must be less than maximum weight');
            } else {
                weightMin.classList.remove('is-invalid');
                weightMax.classList.remove('is-invalid');
            }
        }

        // Validate BScore range
        const bscoreMin = document.getElementById('bscore_min');
        const bscoreMax = document.getElementById('bscore_max');
        
        if (bscoreMin.value && bscoreMax.value) {
            const minValue = parseInt(bscoreMin.value);
            const maxValue = parseInt(bscoreMax.value);
            
            if (minValue >= maxValue) {
                bscoreMin.classList.add('is-invalid');
                bscoreMax.classList.add('is-invalid');
                isValid = false;
                showCustomError(bscoreMin, 'Minimum BScore must be less than maximum BScore');
            } else {
                bscoreMin.classList.remove('is-invalid');
                bscoreMax.classList.remove('is-invalid');
            }
        }

        if (!isValid) {
            event.preventDefault();
            
            // Scroll to first invalid field
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                firstInvalid.focus();
            }
        }
    });

    // Helper function to show custom errors
    function showCustomError(field, message) {
        const existingError = field.parentNode.querySelector('.invalid-feedback');
        if (!existingError || !existingError.textContent.includes('must be less than')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);
        }
    }

    // Auto-hide success/error messages
    const messages = document.querySelectorAll('.success-message, .error-message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 1s ease';
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 1000);
        }, 5000);
    });

    // Form reset functionality
    const resetButton = document.querySelector('button[type="reset"]');
    resetButton.addEventListener('click', function() {
        // Remove validation classes
        document.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Remove custom error messages
        document.querySelectorAll('.invalid-feedback').forEach(errorMsg => {
            if (errorMsg.textContent.includes('must be less than')) {
                errorMsg.remove();
            }
        });
    });

    // Real-time validation for range fields
    const rangeFields = [
        {min: 'age_min', max: 'age_max', name: 'age'},
        {min: 'weight_min', max: 'weight_max', name: 'weight'},
        {min: 'bscore_min', max: 'bscore_max', name: 'BScore'}
    ];

    rangeFields.forEach(range => {
        const minField = document.getElementById(range.min);
        const maxField = document.getElementById(range.max);
        
        [minField, maxField].forEach(field => {
            field.addEventListener('blur', function() {
                if (minField.value && maxField.value) {
                    const minValue = parseInt(minField.value);
                    const maxValue = parseInt(maxField.value);
                    
                    if (minValue >= maxValue) {
                        minField.classList.add('is-invalid');
                        maxField.classList.add('is-invalid');
                    } else {
                        minField.classList.remove('is-invalid');
                        maxField.classList.remove('is-invalid');
                        
                        // Remove custom error messages
                        const errorMsgs = minField.parentNode.querySelectorAll('.invalid-feedback');
                        errorMsgs.forEach(msg => {
                            if (msg.textContent.includes('must be less than')) {
                                msg.remove();
                            }
                        });
                    }
                }
            });
        });
    });

    // Change detection for unsaved changes warning
    let formChanged = false;
    const formElements = componentForm.querySelectorAll('input, select, textarea');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            formChanged = true;
        });
    });

    // Warn user about unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            const confirmationMessage = 'You have unsaved changes. Are you sure you want to leave?';
            e.returnValue = confirmationMessage;
            return confirmationMessage;
        }
    });

    // Don't warn if form is being submitted
    componentForm.addEventListener('submit', function() {
        formChanged = false;
    });
});
</script>

<style>
/* Staff Component Update Specific Styles */
:root{
    --blue: #7d7deb;
    --black: #333;
    --white: #fff;
    --light-color: #666;
    --light-bg: #eee;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --border: .2rem solid rgba(0,0,0,.1);
    --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
}

* {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    outline: none;
    border: none;
    text-decoration: none !important;
}

html {
    font-size: 62.5%;
    overflow-x: hidden;
    overflow-y: auto;
    scroll-behavior: smooth;
    scroll-padding-top: 6.5rem;
}

/* Dashboard Layout */
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
    position: relative;
    background-color: #f7f7fa;
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: 280px;
    background: var(--white);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 100;
    transition: all 0.3s ease;
    overflow-y: auto;
}

.sidebar-header {
    padding: 2rem 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.logo-container {
    margin-bottom: 1.5rem;
}

.logo-container img {
    height: 60px;
    width: auto;
}

.staff-info {
    width: 100%;
    text-align: center;
    margin-bottom: 1rem;
}

.staff-info h3 {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.staff-info p {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
}

.staff-info span {
    color: var(--blue);
    font-weight: 600;
}

.sidebar-toggle {
    display: none;
    background: none;
    color: var(--black);
    font-size: 2.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-menu {
    padding: 2rem 0;
}

.sidebar-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    margin-bottom: 0.5rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 1.2rem 2rem;
    color: var(--light-color);
    font-size: 1.6rem;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-menu a:hover {
    color: var(--blue);
    background-color: rgba(125, 125, 235, 0.1);
}

.sidebar-menu li.active a {
    color: var(--blue);
    background-color: rgba(125, 125, 235, 0.1);
    font-weight: 500;
}

.sidebar-menu li.active a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background-color: var(--blue);
}

.sidebar-menu a i {
    margin-right: 1.5rem;
    font-size: 1.8rem;
    width: 2rem;
    text-align: center;
}

/* Main Content */
.dashboard-main {
    flex: 1;
    padding: 2rem;
    margin-left: 280px;
    transition: all 0.3s ease;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 3rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-left h2 {
    font-size: 2.4rem;
    color: var(--black);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.component-info {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.component-id {
    color: var(--blue);
    font-weight: 600;
}

.component-name {
    color: var(--black);
    font-weight: 500;
}

.status-notice {
    color: var(--warning-color);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Permissions Notice */
.permissions-notice {
    margin-bottom: 2rem;
}

.permission-card {
    background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    border: 1px solid var(--warning-color);
    border-radius: 1rem;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 2rem;
}

.permission-icon {
    background-color: var(--warning-color);
    color: var(--white);
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.permission-content h4 {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.permission-content p {
    font-size: 1.3rem;
    color: var(--light-color);
    margin: 0;
    line-height: 1.5;
}

/* Component Form Specific Styles */
.component-form {
    padding: 0;
}

.form-section {
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--blue);
}

.section-title {
    font-size: 2rem;
    color: var(--blue);
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--light-bg);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-title i {
    font-size: 2.2rem;
}

.form-group label {
    font-size: 1.5rem;
    color: var(--black);
    font-weight: 500;
    margin-bottom: 0.8rem;
}

.form-control {
    font-size: 1.4rem;
    padding: 1rem 1.5rem;
    border: 2px solid #e0e0e0;
    border-radius: 0.5rem;
    color: var(--black);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 0.2rem rgba(125, 125, 235, 0.25);
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 1.3rem;
    color: #dc3545;
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    margin-top: 0.25rem;
    font-size: 1.2rem;
    color: var(--light-color);
}

/* Status Display */
.status-display {
    margin-top: 0.8rem;
}

.status-badge {
    font-size: 1.3rem;
    padding: 0.6rem 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: inline-block;
}

/* Component Metadata */
.component-metadata {
    background-color: var(--light-bg);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-top: 0.8rem;
}

.component-metadata p {
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
    color: var(--light-color);
}

.component-metadata p:last-child {
    margin-bottom: 0;
}

.component-metadata strong {
    color: var(--black);
}

.form-actions {
    margin-top: 3rem;
    padding: 2rem;
    background-color: var(--light-bg);
    border-radius: 1rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.form-actions .btn {
    padding: 1.2rem 2.5rem;
    font-size: 1.6rem;
    font-weight: 500;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: var(--blue);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #6c6ce9;
    color: var(--white);
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-info {
    background-color: var(--info-color);
    color: var(--white);
}

.btn-info:hover {
    background-color: #138496;
    color: var(--white);
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--light-color);
    color: var(--white);
}

.btn-secondary:hover {
    background-color: #555;
    color: var(--white);
    text-decoration: none;
}

.btn-outline-secondary {
    background-color: transparent;
    color: var(--light-color);
    border: 2px solid var(--light-color);
}

.btn-outline-secondary:hover {
    background-color: var(--light-color);
    color: var(--white);
    text-decoration: none;
}

/* Success and Error Messages */
.success-message, .error-message {
    background-color: #D4EDDA;
    color: #155724;
    padding: 1.5rem 2rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.6rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Update Prosthetic Component</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="dashboard-layout">
    <!-- Sidebar Start -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('images/progait.png') }}" alt="ProGait Logo">
            </div>
            <div class="staff-info">
                <h3>Staff Dashboard</h3>
                <p>Welcome, <span>Staff</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.patient.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.doctor.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.doctor.doctorliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.assessment.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.appointment.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointments List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.reminder.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.component.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.component.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Component Devices</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Sidebar End -->

    <!-- Main Content Start --> 
    <main class="dashboard-main">
        <div class="dashboard-header">
            <div class="header-left">
                <h2>Update Prosthetic Component</h2>
                <p class="component-info">
                    <span class="component-id">#{{ $component->compID }}</span> - 
                    <span class="component-name">{{ $component->name }}</span>
                    <span class="status-notice">
                        <i class="fas fa-clock"></i> Pending Approval - Can be edited
                    </span>
                </p>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="{{ route('staff.component.show', $component->compID) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Component
                    </a>
                    <a href="{{ route('staff.component.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-container">
                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="error-message">
                        <i class="fas fa-times-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Please fix the following errors:</strong>
                            <ul class="error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Edit Permissions Notice -->
                <div class="permissions-notice">
                    <div class="permission-card">
                        <div class="permission-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="permission-content">
                            <h4>Editing Pending Component</h4>
                            <p>This component is currently pending approval. As a staff member, you can edit all details. Once approved by an administrator, only administrators can make changes.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('staff.component.update', $component->compID) }}" method="POST" class="component-form" id="componentForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i> Basic Information
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Component Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $component->name) }}" 
                                       placeholder="e.g., Advanced Knee Joint Pro" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Component Type <span class="text-danger">*</span></label>
                                <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">Select Component Type</option>
                                    <option value="Foot" {{ old('type', $component->type) == 'Foot' ? 'selected' : '' }}>Foot</option>
                                    <option value="Knee Joint" {{ old('type', $component->type) == 'Knee Joint' ? 'selected' : '' }}>Knee Joint</option>
                                    <option value="Tube" {{ old('type', $component->type) == 'Tube' ? 'selected' : '' }}>Tube</option>
                                    <option value="Socket Adapter" {{ old('type', $component->type) == 'Socket Adapter' ? 'selected' : '' }}>Socket Adapter</option>
                                    <option value="Elbow Unit" {{ old('type', $component->type) == 'Elbow Unit' ? 'selected' : '' }}>Elbow Unit</option>
                                    <option value="Terminal Device" {{ old('type', $component->type) == 'Terminal Device' ? 'selected' : '' }}>Terminal Device</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>