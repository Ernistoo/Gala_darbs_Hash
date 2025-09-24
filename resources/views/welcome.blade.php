<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hash') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        purple: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        },
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-in-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-hidden {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .section-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .sticky-header {
            transition: all 0.3s ease;
        }

        .sticky-header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .dark .sticky-header.scrolled {
            background: rgba(0, 0, 0, 0.8);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="min-h-screen font-sans antialiased bg-gradient-to-b from-gray-100 to-purple-300 dark:from-black dark:to-purple-900 relative overflow-x-hidden">

    <!-- Background Image -->
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/chat.png') }}"
            class="w-full h-full object-cover opacity-10 dark:opacity-5">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-white/30 dark:to-black/50"></div>
    </div>

    <!-- Sticky Header -->
    <header class="sticky-header fixed top-0 w-full z-50 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/chat.png') }}"
                        class="w-8 h-8 object-cover">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name', 'Hash') }}</span>
                </div>

                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Features</a>
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">About</a>
                    <a href="#community" class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition">Community</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-medium shadow-lg hover:shadow-xl transition">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center relative pt-20">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-4xl mx-auto animate-fade-in">
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 dark:text-white mb-6">
                    Connect. Share. <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Inspire.</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Join a vibrant community where creativity meets connection. Share your stories, discover amazing content, and build meaningful relationships.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                    <a href="{{ route('register') }}"
                        class="px-8 py-3.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Start Your Journey
                    </a>
                    <a href="#features"
                        class="px-8 py-3.5 glass-effect text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-white/20 dark:hover:bg-black/20 transition">
                        Explore Features
                    </a>
                </div>



                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                    <a href="#features" class="text-gray-400 dark:text-gray-600 hover:text-purple-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </a>
                </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 section-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Amazing Features</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Discover what makes our platform unique and engaging for creators and communities alike.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-effect rounded-xl p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Engaging Discussions</h3>
                    <p class="text-gray-600 dark:text-gray-400">Join meaningful conversations with like-minded individuals across various topics and interests.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-effect rounded-xl p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Visual Storytelling</h3>
                    <p class="text-gray-600 dark:text-gray-400">Share your experiences through stunning images and videos that captivate your audience.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-effect rounded-xl p-6 hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Vibrant Communities</h3>
                    <p class="text-gray-600 dark:text-gray-400">Find your tribe among hundreds of communities dedicated to specific interests and passions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white/50 dark:bg-black/20 section-hidden">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">About Hash</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Hash is more than just a social platform - it's a space where creativity flourishes and connections deepen.
                    We believe in the power of sharing stories, ideas, and experiences to build a more connected world.
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                    Our mission is to provide a safe, inclusive environment where everyone can express themselves freely,
                    discover new perspectives, and grow together as a community about their interests.
                </p>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="py-20 section-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Join Our Community</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">Be part of something bigger. Share, learn, and grow with us.</p>
            </div>

            <div class="max-w-2xl mx-auto glass-effect rounded-2xl p-8 text-center">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Ready to Get Started?</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Create your account today and start your journey with our vibrant community.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition">
                        Sign Up Free
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold rounded-lg border border-purple-600 dark:border-purple-400 hover:border-purple-700 dark:hover:border-purple-300 transition">
                        Existing User? Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 border-t border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                &copy; 2025 {{ config('app.name', 'Hash') }}. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Theme toggle logic
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Sticky header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.sticky-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('section-visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.section-hidden').forEach((section) => {
            observer.observe(section);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>