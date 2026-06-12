@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">
                    <i class="fas fa-list mr-2"></i>
                    All Available Quizzes
                </h3>

                <div class="card-tools">
                    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus mr-1"></i> Add New Quiz
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    <!-- Quiz Card 1 -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">PHP Basics for Beginners</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">
                                    Basic concepts of PHP for absolute beginners
                                </p>

                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-question-circle"></i> 12 Questions</span>
                                    <span><i class="fas fa-clock"></i> 15 min</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span><strong>Difficulty:</strong> Easy</span>
                                    <span><strong>Passing:</strong> 60%</span>
                                </div>

                                <div class="mb-3">
                                    <span class="badge badge-success">Published</span>
                                    <span class="badge badge-secondary ml-2">Public</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye-slash"></i> Unpublish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Card 2 -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Laravel Intermediate Level</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">
                                    Routing, Middleware, Eloquent, Blade & more
                                </p>

                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-question-circle"></i> 25 Questions</span>
                                    <span><i class="fas fa-clock"></i> 30 min</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span><strong>Difficulty:</strong> Medium</span>
                                    <span><strong>Passing:</strong> 70%</span>
                                </div>

                                <div class="mb-3">
                                    <span class="badge badge-secondary">Draft</span>
                                    <span class="badge badge-info ml-2">Private</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-check-circle"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Card 3 -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Advanced JavaScript Concepts</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">
                                    Promises, Async/Await, Closures, ES6+ features
                                </p>

                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-question-circle"></i> 35 Questions</span>
                                    <span><i class="fas fa-clock"></i> 45 min</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span><strong>Difficulty:</strong> Hard</span>
                                    <span><strong>Passing:</strong> 75%</span>
                                </div>

                                <div class="mb-3">
                                    <span class="badge badge-success">Published</span>
                                    <span class="badge badge-secondary ml-2">Public</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye-slash"></i> Unpublish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Card 4 (example extra) -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-warning">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">MySQL for Beginners</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">
                                    Basic queries, joins, indexes & optimization
                                </p>

                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-question-circle"></i> 18 Questions</span>
                                    <span><i class="fas fa-clock"></i> 20 min</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span><strong>Difficulty:</strong> Easy</span>
                                    <span><strong>Passing:</strong> 65%</span>
                                </div>

                                <div class="mb-3">
                                    <span class="badge badge-secondary">Draft</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-check-circle"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Pagination (static example) -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection