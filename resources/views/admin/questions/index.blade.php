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
                    <i class="fas fa-list-ul mr-2"></i>
                    All Questions List
                </h3>

                <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-light">
                        <i class="fas fa-plus mr-1"></i> Add New Question
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>Question</th>
                            <th>Quiz Name</th>
                            <th>Type</th>
                            <th>Points</th>
                            <th>Correct Answer</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>What does PHP stand for?</td>
                            <td>PHP Basics for Beginners</td>
                            <td><span class="badge badge-info">Multiple Choice</span></td>
                            <td>1</td>
                            <td><strong>PHP: Hypertext Preprocessor</strong></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Which symbol is used to declare variables in PHP?</td>
                            <td>PHP Basics for Beginners</td>
                            <td><span class="badge badge-info">Multiple Choice</span></td>
                            <td>1</td>
                            <td><strong>$</strong></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>JavaScript runs on the server side. (True/False)</td>
                            <td>Advanced JavaScript Concepts</td>
                            <td><span class="badge badge-primary">True/False</span></td>
                            <td>2</td>
                            <td><strong>False</strong></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>What is the correct way to create a function in JavaScript?</td>
                            <td>Advanced JavaScript Concepts</td>
                            <td><span class="badge badge-info">Multiple Choice</span></td>
                            <td>1</td>
                            <td><strong>function myFunction() {}</strong></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>SELECT * FROM users WHERE age > 18;</td>
                            <td>MySQL for Beginners</td>
                            <td><span class="badge badge-secondary">Query</span></td>
                            <td>1</td>
                            <td><strong>All users older than 18</strong></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="float-right">
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection