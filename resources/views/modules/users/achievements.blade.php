@extends('layouts.user_dashboard')

@section('title', 'Achievements')
@section('page-title', '')
@section('breadcrumb', 'Achievements')

@section('content')

<div class="container-fluid py-4">
    <div class="row">

        {{-- Page Title --}}
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold">🏆 Achievements & Rewards</h2>
            <p class="text-muted">Track your progress and redeem exciting rewards</p>
        </div>

        {{-- Top Stats --}}
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <i class="fas fa-medal text-warning badge-icon"></i>
                <h4 class="mt-3">12</h4>
                <p class="text-muted mb-0">Badges Earned</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <i class="fas fa-trophy text-primary badge-icon"></i>
                <h4 class="mt-3">#5</h4>
                <p class="text-muted mb-0">Leaderboard Position</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <i class="fas fa-coins text-success badge-icon"></i>
                <h4 class="mt-3">1500</h4>
                <p class="text-muted mb-0">Total Coins</p>
            </div>
        </div>

        {{-- Badges Section --}}
        <div class="col-12 mb-4">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-bold">🎖 My Badges</h5>
                <div class="row g-4 text-center">

                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-fire text-danger badge-icon"></i>
                            <h6 class="mt-2">Hot Streak</h6>
                            <span class="badge bg-success">Unlocked</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-brain text-info badge-icon"></i>
                            <h6 class="mt-2">Quiz Genius</h6>
                            <span class="badge bg-success">Unlocked</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-star text-warning badge-icon"></i>
                            <h6 class="mt-2">Rising Star</h6>
                            <span class="badge bg-secondary">Locked</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <i class="fas fa-crown text-primary badge-icon"></i>
                            <h6 class="mt-2">Champion</h6>
                            <span class="badge bg-secondary">Locked</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Redeem Rewards --}}
        <div class="col-12">
            <div class="card shadow-sm p-4">
                <h5 class="mb-4 fw-bold">🎁 Redeem Rewards</h5>
                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="card reward-card shadow-sm p-3 text-center">
                            <h6>Amazon Voucher</h6>
                            <p class="text-muted">Cost: 1000 Coins</p>
                            <button class="btn btn-success btn-sm">Redeem</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card reward-card shadow-sm p-3 text-center">
                            <h6>Premium Access (7 Days)</h6>
                            <p class="text-muted">Cost: 2000 Coins</p>
                            <button class="btn btn-primary btn-sm">Redeem</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card reward-card shadow-sm p-3 text-center">
                            <h6>Gift Hamper</h6>
                            <p class="text-muted">Cost: 3000 Coins</p>
                            <button class="btn btn-warning btn-sm">Redeem</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Leaderboard Script --}}
<script>
    $(document).ready(function () {

        getLeaderboardData();

        $(document).on('click', '.refresh_leaderboard', function () {
            getLeaderboardData();
        });

        function getLeaderboardData() {
            $.ajax({
                url: "{{ route('leaderboard.data') }}",
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (response) {
                    let tbody = $('.leaderboardTable tbody');
                    tbody.html('');

                    if (!response.status || response.data.length === 0) {
                        tbody.html(`
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No leaderboard data found
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    let currentUserId = {{ auth()->id() }};
                    let rows = '';

                    $.each(response.data, function (index, item) {
                        const rank     = item.rank ?? (index + 1);
                        const userName = item.user?.name ?? '-';
                        const attempts = item.total_attempts ?? 0;
                        const isMe     = item.user?.id == currentUserId;

                        rows += `
                            <tr ${isMe ? 'style="background:#fff8e1;"' : ''}>
                                <td>
                                    <div class="achievement-icon rank-${rank}">
                                        ${getRankIcon(rank)}
                                    </div>
                                </td>
                                <td class="text-capitalize font-weight-bold text-dark">
                                    ${userName}
                                    ${isMe ? '<span class="badge bg-warning text-dark ms-1">You</span>' : ''}
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm">Score: ${item.total_score}</h6>
                                    <p class="text-xs text-secondary mb-0">Attempts: ${attempts}</p>
                                </td>
                            </tr>
                        `;
                    });

                    tbody.html(rows);
                },
                error: function (xhr) {
                    console.error('Failed to load leaderboard:', xhr);
                }
            });
        }

    });
</script>

@endsection