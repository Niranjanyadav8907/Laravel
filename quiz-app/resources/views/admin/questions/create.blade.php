
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-12">

        <!-- Quiz Info Header -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-question-circle mr-2"></i>
                    Quiz: PHP Basics for Beginners
                </h3>
                <div class="card-tools">
                    <span class="badge badge-info">12/50 Questions Added</span>
                </div>
            </div>
        </div>

        <!-- Add New Question Form -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Question
                </h3>
            </div>

            <form action="#" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Question Text -->
                    <div class="form-group">
                        <label for="question_text">Question <span class="text-danger">*</span></label>
                        <textarea name="question_text" id="question_text" class="form-control" rows="3" 
                            placeholder="Write your question here..." required></textarea>
                    </div>

                    <!-- Question Type -->
                    <div class="form-group">
                        <label>Question Type</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="question_type" id="multiple_choice" value="multiple_choice" checked>
                                <label class="form-check-label" for="multiple_choice">Multiple Choice (Single Correct)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="question_type" id="true_false" value="true_false">
                                <label class="form-check-label" for="true_false">True / False</label>
                            </div>
                        </div>
                    </div>

                    <!-- Options (for Multiple Choice) -->
                    <div class="options-container">
                        <div class="form-group">
                            <label>Options <span class="text-danger">*</span></label>
                            <div class="row mb-2 option-row">
                                <div class="col-10">
                                    <input type="text" name="options[]" class="form-control" placeholder="Option A" required>
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="correct_option" value="0" checked>
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 option-row">
                                <div class="col-10">
                                    <input type="text" name="options[]" class="form-control" placeholder="Option B" required>
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="correct_option" value="1">
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 option-row">
                                <div class="col-10">
                                    <input type="text" name="options[]" class="form-control" placeholder="Option C">
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="correct_option" value="2">
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 option-row">
                                <div class="col-10">
                                    <input type="text" name="options[]" class="form-control" placeholder="Option D">
                                </div>
                                <div class="col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="correct_option" value="3">
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-success add-option-btn">
                            <i class="fas fa-plus"></i> Add Another Option
                        </button>
                    </div>

                    <!-- Points / Marks -->
                    <div class="form-group mt-4">
                        <label for="points">Points / Marks for this question</label>
                        <input type="number" name="points" id="points" class="form-control w-25" min="1" max="10" value="1">
                    </div>

                    <!-- Explanation (Optional) -->
                    <div class="form-group">
                        <label for="explanation">Explanation (shown after answer)</label>
                        <textarea name="explanation" id="explanation" class="form-control" rows="3" 
                            placeholder="Why this answer is correct... (optional)"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fas fa-save mr-2"></i>
                        Save Question
                    </button>
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Back to Quizzes</a>
                </div>
            </form>
        </div>

        <!-- Currently Added Questions (Preview) -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h4 class="card-title">Currently Added Questions (Preview)</h4>
            </div>
            <div class="card-body">
                <div class="timeline timeline-inverse">
                    <!-- Example Question 1 -->
                    <div>
                        <i class="fas fa-question bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> Just now</span>
                            <h3 class="timeline-header">
                                <a href="#">Q1. What does PHP stand for?</a>
                            </h3>
                            <div class="timeline-body">
                                <strong>Correct Answer:</strong> PHP: Hypertext Preprocessor
                            </div>
                        </div>
                    </div>

                    <!-- Example Question 2 -->
                    <div>
                        <i class="fas fa-question bg-success"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> 2 mins ago</span>
                            <h3 class="timeline-header">
                                <a href="#">Q2. Which symbol is used to declare variables in PHP?</a>
                            </h3>
                            <div class="timeline-body">
                                <strong>Correct Answer:</strong> $
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('js')
<script>
    // Add more options dynamically (static preview ke liye)
    document.querySelector('.add-option-btn').addEventListener('click', function() {
        const container = document.querySelector('.options-container');
        const newOptionIndex = container.querySelectorAll('.option-row').length;

        const newRow = `
            <div class="row mb-2 option-row">
                <div class="col-10">
                    <input type="text" name="options[]" class="form-control" placeholder="Option ${String.fromCharCode(65 + newOptionIndex)}">
                </div>
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_option" value="${newOptionIndex}">
                        <label class="form-check-label">Correct</label>
                    </div>
                </div>
            </div>`;

        container.insertAdjacentHTML('beforeend', newRow);
    });
</script>
@endpush