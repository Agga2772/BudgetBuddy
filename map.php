<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Map Page</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo" class="logo-image">
        </div>
        <div class="greeting">
            <p><?php echo $user_data['username']?>!</p>
        </div>
        <div class="logout">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>
    <div class="main-content">
    <h1>Map Page</h1>
    <br>
    <div class="map-info">
        <h2>Find Nearby Stores</h2>
        <p>Welcome to the Map Page! Here, you can explore nearby retail, grocery, and supermarket stores.</p>
        <p>The map below shows your current location and displays markers for nearby stores based on the categories you've specified.</p>
    </div>
    <br>
    <div id="map" style="height: 500px;"></div>
</div>
<script>
    
    var map = L.map('map');

    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

 
    navigator.geolocation.getCurrentPosition(function(position) {
        var userLat = position.coords.latitude;
        var userLng = position.coords.longitude;

        
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
 
    data.results.forEach(function(store) {
        
        var name = store.name;
        var location = store.geocodes.main;
        var priceMin = ''; 
        var priceMax = ''; 

      
        if (store.categories && store.categories.length > 0) {
            priceMin = store.categories[0].price_min || '';
            priceMax = store.categories[0].price_max || '';
        }

     
        var markerContent = `<b>${name}</b><br>`;
        markerContent += `Price Range: ${priceMin}-${priceMax}`;

       
        L.marker([location.latitude, location.longitude]).addTo(map)
            .bindPopup(markerContent)
            .openPopup();
    });
})
.catch(error => console.error('Error fetching data:', error));

    });
</script>
<footer class="footer">
        <a href="index.php"><i class="fas fa-house"></i> Home</a>
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="tn.php"><i class="fas fa-arrows-alt-v"></i> Tips</a>
    </footer>
</body>
</html>



