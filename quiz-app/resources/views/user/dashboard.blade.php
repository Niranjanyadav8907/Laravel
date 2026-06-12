@extends('layouts.user_dashboard')

@section('title', 'User Dashboard')
@section('page-title', 'User Dashboard')
@section('breadcrumb', 'User Dashboard')

@section('content')
<div class="row mt-2 m-1">

    <!-- Total Quizzes Attempted -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 class="total_attempts">0</h3>
                <p>Total Quizzes Attempted</p>
            </div>
            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">
                Refresh List <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Average Score -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3 class="average_score">0</h3>
                <p>Average Score</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">
                Refresh List <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Highest Score -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3 class="highest_score">0</h3>
                <p>Highest Score</p>
            </div>
            <div class="icon"><i class="fas fa-trophy"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">
                Refresh List <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Points Earned -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 class="total_points">0</h3>
                <p>Total Points Earned</p>
            </div>
            <div class="icon"><i class="fas fa-star"></i></div>
            <a class="small-box-footer refresh_data cursor-pointer">
                Refresh List <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<script>
$(document).ready(function () {

    $(document).on('click', '.refresh_data', function () {
        loadUserDashboard();
    });

    loadUserDashboard();

    function loadUserDashboard() {
        showLoader();
        $.ajax({
            url: "{{ route('user.dashboard.data') }}",
            type: "GET",
            success: function (response) {
                hideLoader();
                if (response.status) {
                    $('.total_attempts').text(response.total_attempts);
                    $('.average_score').text(response.average_score);
                    $('.highest_score').text(response.highest_score);
                    $('.total_points').text(response.total_points);
                }
            },
            error: function (xhr) {
                hideLoader();
                console.error('Dashboard load failed:', xhr);
            },
            complete: function () {
                hideLoader();
            }
        });
    }

});
</script>
@endsection