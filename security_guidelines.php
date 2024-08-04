<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Cyber Attack Threat Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
        }
        #map {
            height: 80%;
            width: 100%;
        }
        #stats {
            height: 20%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px;
        }
        .stat-box {
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="stats">
        <div class="stat-box">
            <div>Total Reports</div>
            <div id="totalReports" class="stat-value">0</div>
        </div>
        <div class="stat-box">
            <div>Top Attacker Country</div>
            <div id="topAttackerCountry" class="stat-value">-</div>
        </div>
        <div class="stat-box">
            <div>Most Common Category</div>
            <div id="topCategory" class="stat-value">-</div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const API_KEY = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Cyber Attack Threat Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
        }
        #map {
            height: 80%;
            width: 100%;
        }
        #stats {
            height: 20%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px;
        }
        .stat-box {
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="stats">
        <div class="stat-box">
            <div>Total Reports</div>
            <div id="totalReports" class="stat-value">0</div>
        </div>
        <div class="stat-box">
            <div>Top Attacker Country</div>
            <div id="topAttackerCountry" class="stat-value">-</div>
        </div>
        <div class="stat-box">
            <div>Most Common Category</div>
            <div id="topCategory" class="stat-value">-</div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const API_KEY = 'YOUR_API_KEY_HERE'; // Replace with your actual API key
        let totalReports = 0;
        let countryCount = {};
        let categoryCount = {};

        async function fetchRecentReports() {
            const url = 'https://api.abuseipdb.com/api/v2/reports?page=1&perPage=100';
            
            try {
                const response = await fetch(url, {
                    headers: {
                        'Key': API_KEY,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                data.data.forEach(report => {
                    addReport(report);
                });

                updateStats();
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function addReport(report) {
            const lat = report.latitude;
            const lon = report.longitude;
            const country = report.countryCode;
            const category = report.categories[0]; // Using the first category for simplicity

            L.circle([lat, lon], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50000
            }).addTo(map).bindPopup(`
                IP: ${report.ipAddress}<br>
                Country: ${country}<br>
                Category: ${category}<br>
                Reported At: ${report.reportedAt}
            `);

            totalReports++;
            countryCount[country] = (countryCount[country] || 0) + 1;
            categoryCount[category] = (categoryCount[category] || 0) + 1;
        }

        function updateStats() {
            document.getElementById('totalReports').textContent = totalReports;
            document.getElementById('topAttackerCountry').textContent = getTopItem(countryCount);
            document.getElementById('topCategory').textContent = getTopItem(categoryCount);
        }

        function getTopItem(countObj) {
            return Object.entries(countObj).sort((a, b) => b[1] - a[1])[0]?.[0] || '-';
        }

        // Fetch reports every 5 minutes
        fetchRecentReports();
        setInterval(fetchRecentReports, 300000);
    </script>
</body>
</html>'; // Replace with your actual API key
        let totalReports = 0;
        let countryCount = {};
        let categoryCount = {};

        async function fetchRecentReports() {
            const url = 'https://api.abuseipdb.com/api/v2/reports?page=1&perPage=100';
            
            try {
                const response = await fetch(url, {
                    headers: {
                        'Key': API_KEY,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                data.data.forEach(report => {
                    addReport(report);
                });

                updateStats();
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function addReport(report) {
            const lat = report.latitude;
            const lon = report.longitude;
            const country = report.countryCode;
            const category = report.categories[0]; // Using the first category for simplicity

            L.circle([lat, lon], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50000
            }).addTo(map).bindPopup(`
                IP: ${report.ipAddress}<br>
                Country: ${country}<br>
                Category: ${category}<br>
                Reported At: ${report.reportedAt}
            `);

            totalReports++;
            countryCount[country] = (countryCount[country] || 0) + 1;
            categoryCount[category] = (categoryCount[category] || 0) + 1;
        }

        function updateStats() {
            document.getElementById('totalReports').textContent = totalReports;
            document.getElementById('topAttackerCountry').textContent = getTopItem(countryCount);
            document.getElementById('topCategory').textContent = getTopItem(categoryCount);
        }

        function getTopItem(countObj) {
            return Object.entries(countObj).sort((a, b) => b[1] - a[1])[0]?.[0] || '-';
        }

        // Fetch reports every 5 minutes
        fetchRecentReports();
        setInterval(fetchRecentReports, 300000);
    </script>
</body>
</html>