<?php
// Set session timeout to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Optional: You can log access or perform other security checks here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday & Festival Calendar</title>
    <link rel="icon" href="1200.jpeg" />

    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .calendar-container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #4285f4, #34a853);
            color: white;
            position: relative;
        }

        .calendar-header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .calendar-header button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .calendar-header button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .country-selector {
            margin-left: 15px;
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: bold;
        }

        .country-selector option {
            color: #333;
            background: white;
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #e0e0e0;
        }

        .days div {
            min-height: 100px;
            padding: 8px;
            background-color: white;
            position: relative;
            transition: all 0.2s;
        }

        .days div:hover {
            background-color: #f9f9f9;
            transform: scale(1.02);
            z-index: 1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .days div.today {
            background-color: #e8f4fe;
            border: 2px solid #4285f4;
        }

        .days div.other-month {
            color: #aaa;
            background-color: #fafafa;
        }

        /* Holiday indicator */
        .days div.has-holiday::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background-color: #e91e63;
            border-radius: 50%;
        }

        /* Birthday indicator */
        .days div.has-birthday {
            background-color: #f8fbf8;
        }

        .days div.has-birthday::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            width: 8px;
            height: 8px;
            background-color: #34a853;
            border-radius: 50%;
        }

        .birthday-badge {
            position: absolute;
            bottom: 8px;
            left: 0;
            right: 0;
            background-color: #34a853;
            color: white;
            padding: 2px 5px;
            font-size: 10px;
            text-align: center;
            border-radius: 3px;
            margin: 0 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .holiday-info {
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .holiday-info h3 {
            margin-top: 0;
            color: #4285f4;
            display: flex;
            align-items: center;
        }

        .holiday-info h3::before {
            content: '📅';
            margin-right: 10px;
        }

        .event-list {
            margin-top: 15px;
        }

        .event-item {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .event-date {
            font-weight: bold;
            min-width: 90px;
            color: #555;
        }

        .event-details {
            flex-grow: 1;
            margin-left: 15px;
        }

        .event-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .event-type {
            font-size: 12px;
            color: #666;
        }

        .holiday .event-title {
            color: #e91e63;
        }

        .birthday .event-title {
            color: #34a853;
        }

        .event-icon {
            margin-right: 10px;
            font-size: 20px;
        }

        .holiday .event-icon {
            color: #e91e63;
        }

        .birthday .event-icon {
            color: #34a853;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .legend {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 12px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .holiday-legend {
            background-color: #e91e63;
        }

        .birthday-legend {
            background-color: #34a853;
        }

        .today-legend {
            background-color: #4285f4;
        }
        
        .dashboard-link {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 8px 12px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        
        .dashboard-link:hover {
            background: rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }
        
        .logout-link {
            color: #333;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            padding: 5px 10px;
            border-radius: 3px;
            background: #f1f1f1;
            transition: all 0.3s;
        }
        
        .logout-link:hover {
            background: #e1e1e1;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prev-month">&lt;</button>
            <h1 id="month-year">Month Year</h1>
            <button id="next-month">&gt;</button>
            <a href="dashboard.php" class="dashboard-link">Dashboard</a>

            <select id="country-selector" class="country-selector">
                <option value="IN" selected>India</option>
            </select>
        </div>
        <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>
        <div class="days" id="calendar-days">
            <!-- Days will be populated by JavaScript -->
        </div>
        <div class="holiday-info">
            <h3>Events this Month</h3>
            <div id="loading" class="loading">Loading events...</div>
            <div id="event-list" class="event-list">
                <!-- Events will be populated by JavaScript -->
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color holiday-legend"></div>
                    <span>Holiday</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color birthday-legend"></div>
                    <span>Birthday</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color today-legend"></div>
                    <span>Today</span>
                </div>
            </div>
            <div><a href="logout.php" class="logout-link">Logout</a></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calendarific API configuration
            const API_KEY = 'xnUPYBRadKGzg51hreRYjzjcFMFQlCvG';
            const API_BASE_URL = 'https://calendarific.com/api/v2/holidays';
            
            
            
            // Birthdays data (name: MM/DD)
            const birthdays = {
                'Rajvardhan': '09/09',
                'Akashat': '03/18',
                'Shubham': '07/18',
                'Harsh': '02/08',
                'Vinay': '01/02',
                'Kirsh Banejlal': '06/22',
                'Madhav Banejlal': '07/02',

            };
            
            
            

            // Current date
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            let currentCountry = 'IN'; // Default to India
            
            // DOM elements
            const monthYearElement = document.getElementById('month-year');
            const calendarDays = document.getElementById('calendar-days');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            const eventList = document.getElementById('event-list');
            const loadingElement = document.getElementById('loading');
            const countrySelector = document.getElementById('country-selector');
            
            // Initialize calendar
            renderCalendar(currentMonth, currentYear);
            fetchHolidays(currentYear, currentMonth + 1, currentCountry);
            
            // Event listeners
            prevMonthBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
                fetchHolidays(currentYear, currentMonth + 1, currentCountry);
            });
            
            nextMonthBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
                fetchHolidays(currentYear, currentMonth + 1, currentCountry);
            });
            
            countrySelector.addEventListener('change', function() {
                currentCountry = this.value;
                fetchHolidays(currentYear, currentMonth + 1, currentCountry);
            });
            
            // Prevent default behavior for day clicks
            calendarDays.addEventListener('click', function(e) {
                if (e.target.closest('.days div')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
            
            // Functions
            function renderCalendar(month, year) {
                // Update month/year display
                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                monthYearElement.textContent = `${monthNames[month]} ${year}`;
                
                // Clear previous days
                calendarDays.innerHTML = '';
                
                // Get first day of month and total days in month
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                // Get days from previous month
                const prevMonthDays = new Date(year, month, 0).getDate();
                
                // Create days from previous month
                for (let i = 0; i < firstDay; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('other-month');
                    dayElement.textContent = prevMonthDays - firstDay + i + 1;
                    calendarDays.appendChild(dayElement);
                }
                
                // Create days for current month
                const today = new Date();
                for (let i = 1; i <= daysInMonth; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.textContent = i;
                    
                    // Highlight today
                    if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        dayElement.classList.add('today');
                    }
                    
                    calendarDays.appendChild(dayElement);
                }
                
                // Calculate total cells so far
                const totalCells = firstDay + daysInMonth;
                const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
                
                // Create days from next month
                for (let i = 1; i <= remainingCells; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('other-month');
                    dayElement.textContent = i;
                    calendarDays.appendChild(dayElement);
                }
                
                // Mark birthdays on the calendar
                markBirthdaysOnCalendar(month + 1, year);
            }
            
            async function fetchHolidays(year, month, country) {
                loadingElement.style.display = 'block';
                eventList.innerHTML = '';
                
                try {
                    const response = await fetch(
                        `${API_BASE_URL}?api_key=${API_KEY}&country=${country}&year=${year}&month=${month}`
                    );
                    
                    if (!response.ok) {
                        throw new Error(`API request failed with status ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.meta.code !== 200) {
                        throw new Error(data.meta.error_detail || 'Unknown API error');
                    }
                    
                    displayEvents(data.response.holidays, month, year);
                } catch (error) {
                    console.error('Error fetching holidays:', error);
                    eventList.innerHTML = `<div class="event-item">Error loading holidays: ${error.message}</div>`;
                    // Still show birthdays even if holidays fail to load
                    displayBirthdaysList(month);
                } finally {
                    loadingElement.style.display = 'none';
                }
            }
            
            function displayEvents(holidays, month, year) {
                // Clear previous events
                eventList.innerHTML = '';
                
                // Filter holidays for the specific month
                const monthHolidays = holidays ? holidays.filter(holiday => {
                    const holidayDate = new Date(holiday.date.iso);
                    return holidayDate.getMonth() + 1 === month;
                }) : [];
                
                // Sort holidays by date
                monthHolidays.sort((a, b) => {
                    return new Date(a.date.iso) - new Date(b.date.iso);
                });
                
                // Get birthdays for this month
                const monthBirthdays = getBirthdaysForMonth(month);
                
                // Display message if no events
                if (monthHolidays.length === 0 && monthBirthdays.length === 0) {
                    eventList.innerHTML = '<div class="event-item">No events this month</div>';
                    return;
                }
                
                // Combine and sort all events by date
                const allEvents = [...monthHolidays.map(h => ({
                    type: 'holiday',
                    date: new Date(h.date.iso),
                    name: h.name,
                    details: h.type.join(', ')
                })), ...monthBirthdays.map(b => ({
                    type: 'birthday',
                    date: new Date(year, month - 1, b.day),
                    name: `${b.name}'s Birthday`,
                    details: 'Birthday'
                }))];
                
                allEvents.sort((a, b) => a.date - b.date);
                
                // Display all events
                allEvents.forEach(event => {
                    const dateStr = event.date.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const eventItem = document.createElement('div');
                    eventItem.className = `event-item ${event.type}`;
                    
                    eventItem.innerHTML = `
                        <div class="event-icon">${event.type === 'birthday' ? '🎂' : '🎉'}</div>
                        <div class="event-date">${dateStr}</div>
                        <div class="event-details">
                            <div class="event-title">${event.name}</div>
                            <div class="event-type">${event.details}</div>
                        </div>
                    `;
                    
                    eventList.appendChild(eventItem);
                });
                
                // Mark holidays on calendar
                markHolidaysOnCalendar(monthHolidays);
            }
            
            function markHolidaysOnCalendar(holidays) {
                const dayElements = document.querySelectorAll('.days div:not(.other-month)');
                
                holidays.forEach(holiday => {
                    const holidayDate = new Date(holiday.date.iso);
                    const dayOfMonth = holidayDate.getDate();
                    
                    if (dayOfMonth <= dayElements.length) {
                        const dayElement = dayElements[dayOfMonth - 1];
                        dayElement.classList.add('has-holiday');
                        
                        // Add holiday name as tooltip
                        dayElement.setAttribute('title', holiday.name);
                        
                        // Add click event to show holiday details
                        dayElement.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            alert(`${holiday.name}\nDate: ${holiday.date.iso}\nType: ${holiday.type.join(', ')}`);
                        });
                    }
                });
            }
            
            function getBirthdaysForMonth(month) {
                const monthBirthdays = [];
                
                for (const [name, dateStr] of Object.entries(birthdays)) {
                    const [birthMonth, birthDay] = dateStr.split('/').map(Number);
                    
                    if (birthMonth === month) {
                        monthBirthdays.push({
                            name: name,
                            day: birthDay
                        });
                    }
                }
                
                return monthBirthdays;
            }
            
            function markBirthdaysOnCalendar(month, year) {
                const dayElements = document.querySelectorAll('.days div:not(.other-month)');
                const monthBirthdays = getBirthdaysForMonth(month);
                
                monthBirthdays.forEach(birthday => {
                    const dayOfMonth = birthday.day;
                    
                    if (dayOfMonth <= dayElements.length) {
                        const dayElement = dayElements[dayOfMonth - 1];
                        dayElement.classList.add('has-birthday');
                        
                        // Add birthday badge to the calendar day
                        const birthdayBadge = document.createElement('div');
                        birthdayBadge.className = 'birthday-badge';
                        birthdayBadge.textContent = `${birthday.name}'s Birthday`;
                        dayElement.appendChild(birthdayBadge);
                        
                        // Add click event to show birthday details
                        dayElement.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            alert(`${birthday.name}'s Birthday\nDate: ${month}/${dayOfMonth}/${year}`);
                        });
                    }
                });
            }
            
            function displayBirthdaysList(month) {
                const monthBirthdays = getBirthdaysForMonth(month);
                
                if (monthBirthdays.length === 0) {
                    eventList.innerHTML = '<div class="event-item">No birthdays this month</div>';
                    return;
                }
                
                monthBirthdays.forEach(birthday => {
                    const date = new Date(currentYear, month - 1, birthday.day);
                    const dateStr = date.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const eventItem = document.createElement('div');
                    eventItem.className = 'event-item birthday';
                    
                    eventItem.innerHTML = `
                        <div class="event-icon">🎂</div>
                        <div class="event-date">${dateStr}</div>
                        <div class="event-details">
                            <div class="event-title">${birthday.name}'s Birthday</div>
                            <div class="event-type">Birthday</div>
                        </div>
                    `;
                    
                    eventList.appendChild(eventItem);
                });
            }
        });
    </script>
</body>
</html>