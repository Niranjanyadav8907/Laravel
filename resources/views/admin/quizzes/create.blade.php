@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create New Quiz
                </h3>
            </div>

            <!-- form start -->
            <form action="#" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title">Quiz Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Enter quiz title (e.g. PHP Basics for Beginners)"
                                    value="PHP Basics for Beginners" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="programming" selected>Programming</option>
                                    <option value="web-development">Web Development</option>
                                    <option value="database">Database</option>
                                    <option value="framework">Framework</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="difficulty">Difficulty Level</label>
                                <select name="difficulty" id="difficulty" class="form-control">
                                    <option value="easy" selected>Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="duration">Duration (minutes)</label>
                                <input type="number" name="duration" class="form-control" id="duration"
                                    min="5" max="120" value="15">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passing_percentage">Passing Percentage</label>
                                <input type="number" name="passing_percentage" class="form-control" 
                                    min="30" max="100" value="60">
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Write short description about this quiz...">
This is a basic PHP quiz designed for absolute beginners. 
It covers fundamental concepts like variables, data types, 
operators, conditional statements, loops and basic functions.
                        </textarea>
                    </div>

                    <!-- Status & Visibility -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="draft" value="draft">
                                        <label class="form-check-label" for="draft">Draft</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="published" value="published" checked>
                                        <label class="form-check-label" for="published">Published</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Visibility</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="visibility" id="public" value="public" checked>
                                        <label class="form-check-label" for="public">Public</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="visibility" id="private" value="private">
                                        <label class="form-check-label" for="private">Private</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info Box -->
                    <div class="alert alert-info mt-4">
                        <h5><i class="icon fas fa-info-circle"></i> Note</h5>
                        <ul class="mb-0">
                            <li>You can add questions after creating this quiz</li>
                            <li>Maximum 100 questions per quiz are allowed</li>
                            <li>Time limit will start when user clicks "Start Quiz"</li>
                        </ul>
                    </div>

                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary float-right">
                        <i class="fas fa-save mr-2"></i>
                        Create Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection