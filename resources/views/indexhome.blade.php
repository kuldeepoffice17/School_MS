@extends('layouts.app')

@section('title', 'Welcome to School Management System')

@section('content')
<style>
    /* ========== COMPLETE CSS RESET & STYLES ========== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .home-container {
        width: 100%;
        overflow-x: hidden;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        height: 80vh;
        min-height: 550px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.3);
    }

    .hero-content {
        position: relative;
        z-index: 10;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        animation: fadeInUp 0.8s ease;
    }

    .hero-content h1 span {
        color: #ffc107;
    }

    .hero-content p {
        font-size: 1.3rem;
        margin-bottom: 30px;
        opacity: 0.95;
        animation: fadeInUp 1s ease;
    }

    .btn-custom {
        display: inline-block;
        background: #ffc107;
        color: #1e3c72;
        padding: 14px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        animation: fadeInUp 1.2s ease;
    }

    .btn-custom:hover {
        background: #ffcd38;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        color: #1e3c72;
        text-decoration: none;
    }

    /* Stats Section */
    .stats-section {
        padding: 80px 0;
        background: #f8f9fc;
    }

    .container-custom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .stat-card {
        text-align: center;
        padding: 35px 20px;
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .stat-icon {
        font-size: 55px;
        color: #ffc107;
        margin-bottom: 15px;
    }

    .stat-card h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 10px 0;
        color: #1e3c72;
    }

    .stat-card p {
        color: #666;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Two Columns Section */
    .two-columns-section {
        padding: 80px 0;
        background: white;
    }

    .two-columns {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 20px 25px;
        font-size: 1.3rem;
        font-weight: bold;
    }

    .card-header-custom i {
        margin-right: 12px;
        color: #ffc107;
    }

    .card-body-custom {
        padding: 25px;
    }

    .notice-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .notice-list li {
        padding: 14px 0;
        border-bottom: 1px solid #eee;
        color: #555;
        font-size: 1rem;
    }

    .notice-list li i {
        color: #ffc107;
        margin-right: 12px;
    }

    .event-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
    }

    .event-date {
        background: linear-gradient(135deg, #ffc107 0%, #ffcd38 100%);
        color: #1e3c72;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: bold;
    }

    .event-name {
        color: #555;
        font-weight: 500;
    }

    .view-all-link {
        display: inline-block;
        margin-top: 20px;
        color: #2a5298;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s;
    }

    .view-all-link:hover {
        color: #ffc107;
        text-decoration: none;
        transform: translateX(5px);
        display: inline-block;
    }

    /* Gallery Section */
    .gallery-section {
        padding: 80px 0;
        background: #f8f9fc;
    }

    .section-title {
        text-align: center;
        font-size: 2.2rem;
        color: #1e3c72;
        margin-bottom: 50px;
        font-weight: 700;
    }

    .section-title i {
        color: #ffc107;
        margin-right: 12px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .gallery-item {
        background: white;
        padding: 50px 20px;
        text-align: center;
        border-radius: 15px;
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e3c72;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .gallery-item i {
        font-size: 50px;
        display: block;
        margin-bottom: 15px;
        color: #ffc107;
    }

    .gallery-item:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }

    .gallery-item:hover i {
        color: white;
    }

    /* Principal Section */
    .principal-section {
        padding: 80px 0;
        background: white;
    }

    .principal-message {
        display: flex;
        align-items: center;
        gap: 50px;
        background: linear-gradient(135deg, #fff5e6 0%, #ffe6cc 100%);
        padding: 50px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .principal-img {
        flex: 0 0 200px;
    }

    .principal-img img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .principal-text {
        flex: 1;
    }

    .principal-text h3 {
        font-size: 2rem;
        color: #1e3c72;
        margin-bottom: 20px;
    }

    .principal-text .quote {
        font-size: 1.2rem;
        line-height: 1.7;
        color: #444;
        margin-bottom: 20px;
        font-style: italic;
    }

    .principal-text h5 {
        font-size: 1.2rem;
        color: #ffc107;
        margin-bottom: 5px;
    }

    .designation {
        color: #666;
        font-size: 0.9rem;
    }

    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        text-align: center;
    }

    .cta-section h2 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .cta-section p {
        font-size: 1.2rem;
        margin-bottom: 35px;
        opacity: 0.9;
    }

    .btn-large {
        padding: 15px 50px;
        font-size: 1.1rem;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 70vh;
            min-height: 450px;
        }
        
        .hero-content h1 {
            font-size: 2.2rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        .btn-custom {
            padding: 10px 30px;
            font-size: 0.9rem;
        }
        
        .two-columns {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .principal-message {
            flex-direction: column;
            text-align: center;
            padding: 35px;
        }
        
        .principal-img {
            flex: 0 0 auto;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .cta-section h2 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        
        .hero-content h1 {
            font-size: 1.8rem;
        }
        
        .card-header-custom {
            font-size: 1.1rem;
            padding: 15px 20px;
        }
        
        .principal-message {
            padding: 25px;
        }
        
        .principal-img img {
            width: 150px;
            height: 150px;
        }
    }
</style>

<div class="home-container">
    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to <span>Excel Public School</span></h1>
            <p>Excellence in Education Since 1995</p>
            <a href="/admission" class="btn-custom">Apply for Admission →</a>
        </div>
    </section>

    {{-- Quick Stats Cards --}}
    <section class="stats-section">
        <div class="container-custom">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <h3>1200+</h3>
                    <p>Students</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3>85+</h3>
                    <p>Teachers</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                    <h3>150+</h3>
                    <p>Awards Won</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>25+</h3>
                    <p>Years of Excellence</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Notice Board & Events --}}
    <section class="two-columns-section">
        <div class="container-custom">
            <div class="two-columns">
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-bullhorn"></i> Notice Board
                    </div>
                    <div class="card-body-custom">
                        <ul class="notice-list">
                            @foreach($notices as $notice)
                                <li><i class="fas fa-hand-point-right"></i> {{ $notice }}</li>
                            @endforeach
                        </ul>
                        <a href="/notices" class="view-all-link">View All →</a>
                    </div>
                </div>

                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-calendar-week"></i> Upcoming Events
                    </div>
                    <div class="card-body-custom">
                        @foreach($upcomingEvents as $event)
                            <div class="event-item">
                                <span class="event-date">{{ $event['date'] }}</span>
                                <span class="event-name">{{ $event['name'] }}</span>
                            </div>
                        @endforeach
                        <a href="/events" class="view-all-link">View All →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section class="gallery-section">
        <div class="container-custom">
            <h2 class="section-title"><i class="fas fa-images"></i> School Gallery</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <i class="fas fa-chalkboard"></i>
                    Smart Classrooms
                </div>
                <div class="gallery-item">
                    <i class="fas fa-book"></i>
                    Library
                </div>
                <div class="gallery-item">
                    <i class="fas fa-laptop-code"></i>
                    Computer Lab
                </div>
                <div class="gallery-item">
                    <i class="fas fa-futbol"></i>
                    Playground
                </div>
                <div class="gallery-item">
                    <i class="fas fa-music"></i>
                    Annual Function
                </div>
                <div class="gallery-item">
                    <i class="fas fa-trophy"></i>
                    Sports Day
                </div>
            </div>
        </div>
    </section>

    {{-- Principal Message --}}
    <section class="principal-section">
        <div class="container-custom">
            <div class="principal-message">
                <div class="principal-img">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Principal">
                </div>
                <div class="principal-text">
                    <h3>Principal's Message</h3>
                    <p class="quote">"Education is the most powerful weapon which you can use to change the world. At our school, we focus on holistic development of every child."</p>
                    <h5>- Mrs. Sunita Sharma</h5>
                    <p class="designation">Principal, Excel Public School</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta-section">
        <div class="container-custom">
            <h2>Enroll Your Child Today!</h2>
            <p>Limited seats available for academic year 2026-27</p>
            <a href="/admission" class="btn-custom btn-large">Get Admission Form →</a>
        </div>
    </section>
</div>
@endsection