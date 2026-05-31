@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome to your analytics and management overview. Use the menu to navigate through your application.</p>
        </div>
        <x-profile-chip />
    </div>

    <div class="row g-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card p-4 h-100 border rounded-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted">Total Users</div>
                        <h2 class="mt-2 mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <span class="badge bg-primary">Users</span>
                </div>
                <p class="text-muted mb-0">All registered system users.</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card p-4 h-100 border rounded-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted">Total Customers</div>
                        <h2 class="mt-2 mb-0">{{ $totalCustomers }}</h2>
                    </div>
                    <span class="badge bg-info text-dark">Customers</span>
                </div>
                <p class="text-muted mb-0">Customers tracked in the app.</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card p-4 h-100 border rounded-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted">Your Records</div>
                        <h2 class="mt-2 mb-0">{{ $userRecords }}</h2>
                    </div>
                    <span class="badge bg-warning text-dark">Records</span>
                </div>
                <p class="text-muted mb-0">Your personal records count.</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card p-4 h-100 border rounded-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted">Profile</div>
                        <h2 class="mt-2 mb-0">{{ auth()->user()->name }}</h2>
                    </div>
                    <span class="badge bg-secondary">Profile</span>
                </div>
                <p class="text-muted mb-0">Update your account anytime.</p>
            </div>
        </div>
    </div>

    <div class="dashboard-chart-card mt-5 p-4 border rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1">Application Activity</h5>
                <p class="text-muted mb-0">A quick snapshot of your dashboard data.</p>
            </div>
        </div>
        <canvas id="dashboardChart" height="160"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('dashboardChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(['Users', 'Customers', 'Records']),
                datasets: [{
                    label: 'Counts',
                    data: @json([$totalUsers, $totalCustomers, $userRecords]),
                    backgroundColor: ['#4f46e5', '#0ea5e9', '#f59e0b'],
                    borderRadius: 12,
                    barPercentage: 0.55,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e2e8f0' },
                        ticks: { color: '#64748b' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
</script>
@endpush
