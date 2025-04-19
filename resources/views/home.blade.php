@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <h1 class="welcome-text">Welcome, {{ Auth::user()->name }}!</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('brands.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <h3>Brands</h3>
                    <p>Manage your brands.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <h3>Categories</h3>
                    <p>Manage your categories.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('items.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <h3>Items</h3>
                    <p>Manage your items.</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .dashboard-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #6e48aa, #9d50bb, #e94057);
        padding: 40px 20px;
        color: #fff;
    }

    .welcome-text {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 40px;
        transition: color 0.5s ease;
    }

    .welcome-text:hover {
        animation: rgb-text 3s infinite;
    }

    @keyframes rgb-text {
        0% { color: #00f; }
        33% { color: #f0f; }
        66% { color: #0ff; }
        100% { color: #00f; }
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dashboard-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .dashboard-card h3 {
        color: #fff;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    .dashboard-card p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
    }

    .dashboard-card {
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .dashboard-card h3 {
            font-size: 1.2rem;
        }

        .dashboard-card p {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
