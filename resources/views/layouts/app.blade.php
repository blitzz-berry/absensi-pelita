<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'absensi guru pelita')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.png') }}">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    @yield('styles')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Layout */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: #ffffff;
            box-shadow: 3px 0 15px rgba(0,0,0,0.08);
            z-index: 99;
            padding-top: 60px;
            transition: all 0.3s ease;
            transform: translateX(0);
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        /* Sidebar Links */
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar ul li {
            margin: 0;
        }
        
        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #555;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .sidebar ul li a:hover {
            background-color: #f0f5ff;
            color: #1976D2;
        }
        
        .sidebar ul li a.active {
            background-color: #e3f2fd;
            color: #1976D2;
            border-left: 4px solid #1976D2;
        }
        
        .sidebar ul li a i {
            margin-right: 15px;
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        /* Topbar Layout */
        .topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 60px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 98;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            transition: left 0.3s ease;
        }

        /* Main Content Layout */
        .main-content {
            margin-top: 60px;
            margin-left: 260px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        /* Common Components */
        .profile-menu {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .clock-display {
            font-size: 15px;
            font-weight: 600;
            margin-right: 20px;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
            background: linear-gradient(135deg, rgba(25, 118, 210, 0.16), rgba(33, 150, 243, 0.06));
            border: 1px solid rgba(25, 118, 210, 0.25);
            color: #0f172a;
            padding: 6px 16px;
            border-radius: 999px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7), 0 8px 16px rgba(25, 118, 210, 0.12);
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 98;
            display: none;
        }

        .mobile-overlay.active {
            display: block;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            z-index: 100;
        }

        .hamburger span {
            height: 3px;
            width: 100%;
            background-color: #555;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        @media (max-width: 992px) {
            .hamburger {
                display: flex;
                margin-right: 20px;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding-left: 10px;
            }
        }

        @media (max-width: 600px) {
            .clock-display {
                font-size: 12px;
                letter-spacing: 0.08em;
                padding: 4px 10px;
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- Mobile overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- CSRF Token for AJAX requests -->
    <script>
        // Set default headers for all AJAX requests
        if (typeof jQuery !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        } else {
            // For vanilla JS - update the token regularly to prevent expiration
            setInterval(function() {
                fetch('/csrf-token-refresh', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.csrf_token) {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    }
                })
                .catch(error => console.error('Error updating CSRF token:', error));
            }, 300000); // Update every 5 minutes
        }
    </script>

    @yield('scripts')
    <script>
        function formatWibTime(date) {
            const parts = new Intl.DateTimeFormat('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            }).formatToParts(date);

            const partValue = type => {
                const part = parts.find(item => item.type === type);
                return part ? part.value : '00';
            };

            return `${partValue('hour')}:${partValue('minute')}`;
        }

        function formatWibDate(date) {
            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            }).format(date);
        }

        window.formatWibTime = formatWibTime;
        window.formatWibDate = formatWibDate;

        function startLiveClock() {
            updateClock();

            if (window.liveClockIntervalId) {
                clearInterval(window.liveClockIntervalId);
            }
            if (window.liveClockTimeoutId) {
                clearTimeout(window.liveClockTimeoutId);
            }

            const now = new Date();
            const msToNextMinute = Math.max(0, (60 - now.getSeconds()) * 1000 - now.getMilliseconds());
            window.liveClockTimeoutId = setTimeout(function() {
                updateClock();
                window.liveClockIntervalId = setInterval(updateClock, 60000);
            }, msToNextMinute);
        }

        // Update live clock safely for all pages
        function updateClock() {
            try {
                const now = new Date();
                const timeString = formatWibTime(now);
                const clockElement = document.getElementById('live-clock');
                if (clockElement) {
                    clockElement.textContent = `${timeString} WIB`;
                }
            } catch (error) {
                console.error('Error updating clock:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });

            // Initialize clock if element exists
            const clockElement = document.getElementById('live-clock');
            if (clockElement) {
                startLiveClock();
            }

            // Hamburger menu functionality
            const hamburger = document.querySelector('.hamburger');
            const sidebar = document.querySelector('.sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (hamburger && sidebar) {
                hamburger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('active');
                    mobileOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
                });

                mobileOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });

                // Close sidebar when clicking on sidebar links
                const sidebarLinks = sidebar.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        mobileOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                });
            }

            // Cleanup interval when leaving page to prevent multiple intervals running
            window.addEventListener('beforeunload', function() {
                if (window.liveClockIntervalId) {
                    clearInterval(window.liveClockIntervalId);
                    window.liveClockIntervalId = null;
                }
                if (window.liveClockTimeoutId) {
                    clearTimeout(window.liveClockTimeoutId);
                    window.liveClockTimeoutId = null;
                }
            });
        });
    </script>
</body>
</html>
