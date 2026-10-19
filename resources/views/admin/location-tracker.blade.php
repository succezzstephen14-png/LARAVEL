@extends('layouts.admin')

@section('title', 'Location Tracker - Live GPS Monitoring')

@section('page-title', 'Location Tracker')
@section('page-description', 'Monitor real-time locations of drivers and vehicles')

@section('styles')
<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .tracker-controls {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .tracker-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .legend {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .driver-dot { background: #10b981; }
    .vehicle-dot { background: #f59e0b; }

    .location-info {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        max-height: 300px;
        overflow-y: auto;
    }

    .location-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .location-item:last-child {
        border-bottom: none;
    }

    .location-name {
        font-weight: 600;
    }

    .location-status {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        color: white;
    }

    .status-available { background: #10b981; }
    .status-on_duty { background: #f59e0b; }
    .status-unavailable { background: #6b7280; }
    .status-maintenance { background: #ef4444; }

    .refresh-btn {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .refresh-btn:hover {
        background: #1d4ed8;
    }

    .filter-checkboxes {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .filter-checkboxes label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="tracker-stats">
    <div class="stat-card">
        <div class="stat-value" id="drivers-count">0</div>
        <div class="stat-label">Active Drivers</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" id="vehicles-count">0</div>
        <div class="stat-label">Active Vehicles</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" id="total-count">0</div>
        <div class="stat-label">Total Tracked</div>
    </div>
</div>

<div class="tracker-controls">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h4 style="margin: 0;">Live Location Monitoring</h4>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <div class="filter-checkboxes">
                <label>
                    <input type="checkbox" id="show-drivers" checked>
                    Show Drivers
                </label>
                <label>
                    <input type="checkbox" id="show-vehicles" checked>
                    Show Vehicles
                </label>
            </div>
            <button class="refresh-btn" onclick="refreshLocations()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <div class="legend">
        <div class="legend-item">
            <div class="legend-dot driver-dot"></div>
            <span>Drivers</span>
        </div>
        <div class="legend-item">
            <div class="legend-dot vehicle-dot"></div>
            <span>Vehicles</span>
        </div>
    </div>
</div>

<div id="map"></div>

<div class="location-info">
    <h5>Tracked Locations</h5>
    <div id="location-list">
        <p class="text-muted">Loading location data...</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
let map;
let markers = [];
let driversData = @json($drivers ?? []);
let vehiclesData = @json($vehicles ?? []);

document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    updateMap();
    updateStats();
    updateLocationList();
    setInterval(loadLocationData, 30000); // Refresh every 30 seconds
});

function initializeMap() {
    // Initialize map centered on Ghana
    map = L.map('map').setView([5.6037, -0.1870], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
}

function loadLocationData() {
    // For now, just reload the page to get fresh data
    // In production, this would fetch from the API
    location.reload();
}

function updateMap() {
    // Clear existing markers
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];

    const showDrivers = document.getElementById('show-drivers').checked;
    const showVehicles = document.getElementById('show-vehicles').checked;

    if (showDrivers) {
        driversData.forEach(driver => {
            const marker = L.marker([driver.latitude, driver.longitude], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background: #10b981; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            });

            marker.bindPopup(`
                <strong>Driver: ${driver.name}</strong><br>
                Status: ${driver.status}<br>
                Tracking: ${driver.tracking_status || 'N/A'}<br>
                Location: ${driver.location || 'N/A'}<br>
                Last Update: ${driver.last_update || 'N/A'}
            `);

            marker.addTo(map);
            markers.push(marker);
        });
    }

    if (showVehicles) {
        vehiclesData.forEach(vehicle => {
            const marker = L.marker([vehicle.latitude, vehicle.longitude], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background: #f59e0b; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            });

            marker.bindPopup(`
                <strong>Vehicle: ${vehicle.name}</strong><br>
                Status: ${vehicle.status}<br>
                Tracking: ${vehicle.tracking_status || 'N/A'}<br>
                Location: ${vehicle.location || 'N/A'}<br>
                Last Update: ${vehicle.last_update || 'N/A'}
            `);

            marker.addTo(map);
            markers.push(marker);
        });
    }

    // Fit map to show all markers
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

function updateStats() {
    const showDrivers = document.getElementById('show-drivers').checked;
    const showVehicles = document.getElementById('show-vehicles').checked;

    let driversCount = showDrivers ? driversData.length : 0;
    let vehiclesCount = showVehicles ? vehiclesData.length : 0;

    document.getElementById('drivers-count').textContent = driversCount;
    document.getElementById('vehicles-count').textContent = vehiclesCount;
    document.getElementById('total-count').textContent = driversCount + vehiclesCount;
}

function updateLocationList() {
    const showDrivers = document.getElementById('show-drivers').checked;
    const showVehicles = document.getElementById('show-vehicles').checked;

    let html = '';

    if (showDrivers && driversData.length > 0) {
        html += '<h6 style="color: #10b981; margin-top: 1rem;">Drivers</h6>';
        driversData.forEach(driver => {
            html += `
                <div class="location-item">
                    <div>
                        <div class="location-name">${driver.name}</div>
                        <small class="text-muted">${driver.location || 'Location not set'}</small>
                    </div>
                    <div class="location-status status-${driver.status}">${driver.status}</div>
                </div>
            `;
        });
    }

    if (showVehicles && vehiclesData.length > 0) {
        html += '<h6 style="color: #f59e0b; margin-top: 1rem;">Vehicles</h6>';
        vehiclesData.forEach(vehicle => {
            html += `
                <div class="location-item">
                    <div>
                        <div class="location-name">${vehicle.name}</div>
                        <small class="text-muted">${vehicle.location || 'Location not set'}</small>
                    </div>
                    <div class="location-status status-${vehicle.status}">${vehicle.status}</div>
                </div>
            `;
        });
    }

    if (!html) {
        html = '<p class="text-muted">No locations to display</p>';
    }

    document.getElementById('location-list').innerHTML = html;
}

function refreshLocations() {
    loadLocationData();
}

// Update map when filters change
document.getElementById('show-drivers').addEventListener('change', function() {
    updateMap();
    updateStats();
    updateLocationList();
});

document.getElementById('show-vehicles').addEventListener('change', function() {
    updateMap();
    updateStats();
    updateLocationList();
});
</script>
@endsection