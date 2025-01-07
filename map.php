<!DOCTYPE html>
<html>
<head>
    <title>Map Page</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo">
        </div>
    </div>
<a href="logout.php">Logout</a>
<div class="main-content">
<div id="map" style="height: 500px;"></div>
</div>
<script>
    // Initialize Leaflet map
    var map = L.map('map');

    // Add base map layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Get user's current location
    navigator.geolocation.getCurrentPosition(function(position) {
        var userLat = position.coords.latitude;
        var userLng = position.coords.longitude;

        // Set map view to user's location
        map.setView([userLat, userLng], 13);

        fetch('https://api.foursquare.com/v3/places/search?query=retail,grocery,supermarket', {
    method: 'GET',
    headers: {
        accept: 'application/json',
        Authorization: 'fsq3GWDOSgHO48T+blUZQQwzs1nI55bxfhrkuRBS4Ro3Sdg='
    }
})
.then(response => response.json())
.then(data => {
    // Process the response data
    data.results.forEach(function(store) {
        // Extract store information
        var name = store.name;
        var location = store.geocodes.main;
        var priceMin = ''; // Initialize price min
        var priceMax = ''; // Initialize price max

        // Check if price information is available
        if (store.categories && store.categories.length > 0) {
            priceMin = store.categories[0].price_min || '';
            priceMax = store.categories[0].price_max || '';
        }

        // Create marker content with name and price range
        var markerContent = `<b>${name}</b><br>`;
        markerContent += `Price Range: ${priceMin}-${priceMax}`;

        // Create a marker and add it to the map
        L.marker([location.latitude, location.longitude]).addTo(map)
            .bindPopup(markerContent)
            .openPopup();
    });
})
.catch(error => console.error('Error fetching data:', error));

    });
</script>
<div class="footer">
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="index.php"><i class="fas fa-map-marker-alt"></i> Index</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="tn.php"><i class="fas fa-receipt"></i>Transactions</a>
        
    </div>
</body>
</html>



