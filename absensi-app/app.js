document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const timeDisplay = document.getElementById('current-time');
    const dateDisplay = document.getElementById('current-date');
    const locationStatus = document.getElementById('location-status');
    const latDisplay = document.getElementById('latitude');
    const lngDisplay = document.getElementById('longitude');
    const btnIn = document.getElementById('btn-in');
    const btnOut = document.getElementById('btn-out');
    const logContainer = document.getElementById('attendance-log');

    // State
    let currentUserLocation = null;

    // Initialize Clock
    function updateClock() {
        const now = new Date();

        // Format Time
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;

        // Format Date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateDisplay.textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Initialize GPS
    function initGPS() {
        if ("geolocation" in navigator) {
            // Watch position updates continuously
            navigator.geolocation.watchPosition(
                (position) => {
                    currentUserLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    latDisplay.textContent = currentUserLocation.lat.toFixed(5);
                    lngDisplay.textContent = currentUserLocation.lng.toFixed(5);
                    locationStatus.textContent = "Lokasi akurat ditemukan";
                    locationStatus.style.color = "#4ade80";

                    // Enable buttons once location is secured
                    btnIn.disabled = false;
                    btnOut.disabled = false;
                },
                (error) => {
                    console.error("Error mendapatkan lokasi:", error);
                    let errMsg = "Gagal mengambil lokasi.";
                    if (error.code === 1) errMsg = "Izin lokasi ditolak (Harap izinkan GPS).";
                    if (error.code === 2) errMsg = "Sinyal GPS tidak tersedia.";
                    if (error.code === 3) errMsg = "Waktu permintaan habis (Sensor lambat).";

                    locationStatus.textContent = errMsg;
                    locationStatus.style.color = "#f87171";

                    btnIn.disabled = true;
                    btnOut.disabled = true;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            locationStatus.textContent = "Browser perangkat Anda tidak mendukung GPS.";
            locationStatus.style.color = "#f87171";
        }
    }

    // Start fetching GPS location
    initGPS();

    // Handle Attendance Action
    function recordAttendance(type) {
        if (!currentUserLocation) {
            alert("Harap tunggu hingga sinyal GPS ditemukan.");
            return;
        }

        const now = new Date();
        const timeStr = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

        const logItem = document.createElement('li');
        if (type === 'out') {
            logItem.className = 'out';
        }

        const typeLabel = type === 'in' ? 'Masuk' : 'Pulang';

        logItem.innerHTML = `
            <div>
                <strong>${typeLabel}</strong>
                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">
                    Lat: ${currentUserLocation.lat.toFixed(4)}, Lng: ${currentUserLocation.lng.toFixed(4)}
                </div>
            </div>
            <div style="font-weight: 600; font-size: 1.1rem; color: ${type === 'in' ? '#818cf8' : '#f472b6'};">
                ${timeStr}
            </div>
        `;

        logContainer.prepend(logItem);

        // Tampilkan notifikasi pop-up native
        if (window.Notification && Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    new Notification("Absensi Digital", {
                        body: `Berhasil Absen ${typeLabel} pada jam ${timeStr}.`
                    });
                }
            });
        } else {
            alert(`Berhasil Absen ${typeLabel} pada jam ${timeStr} dengan koordinat Anda yang tersimpan.`);
        }
    }

    btnIn.addEventListener('click', () => recordAttendance('in'));
    btnOut.addEventListener('click', () => recordAttendance('out'));
});
// 1. SETTING KANTOR (Ganti dengan koordinat kantor Anda)
const KANTOR_LAT = -8.570951691307169;
const KANTOR_LON = 116.08182218746374;
const RADIUS_AMAN = 100; // Toleransi 100 meter

const btnAbsen = document.getElementById('btn-absen');
const labelStatus = document.getElementById('label-status');
const detailJarak = document.getElementById('detail-jarak');

// 2. FUNGSI HITUNG JARAK (RUMUS HAVERSINE)
function hitungJarak(lat1, lon1, lat2, lon2) {
    const R = 6371000; // Radius Bumi dalam meter
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// 3. MONITOR LOKASI USER
let userLat = 0, userLng = 0;
if ("geolocation" in navigator) {
    navigator.geolocation.watchPosition((pos) => {
        userLat = pos.coords.latitude;
        userLng = pos.coords.longitude;
        const jarak = hitungJarak(pos.coords.latitude, pos.coords.longitude, KANTOR_LAT, KANTOR_LON);

        if (jarak <= RADIUS_AMAN) {
            updateUI(true, `Lokasi Terverifikasi`, `Jarak: ${Math.round(jarak)}m dari kantor`);
        } else {
            updateUI(false, `Di Luar Area Kantor`, `Jarak Anda: ${Math.round(jarak)}m`);
        }
    }, (err) => {
        labelStatus.innerText = "GPS Error/Tidak Aktif";
    }, { enableHighAccuracy: true });
}

function updateUI(isValid, pesan, detail) {
    labelStatus.innerText = pesan;
    detailJarak.innerText = detail;
    btnAbsen.disabled = !isValid;
    document.getElementById('status-card').className = isValid ? "card status-valid" : "card status-invalid";
}

// 4. ACTION KLIK ABSEN
btnAbsen.onclick = async () => {
    try {
        btnAbsen.disabled = true;
        btnAbsen.innerText = "Mengirim...";

        const response = await fetch('/api/absen', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({
                latitude: userLat,
                longitude: userLng,
                tipe_absen: 'masuk',
                status_lokasi: 'valid'
            })
        });

        const data = await response.json();

        if (data.success) {
            const waktu = new Date().toLocaleTimeString('id-ID');
            const log = document.getElementById('log-absensi');
            log.innerHTML = `<li><b>Hadir:</b> ${waktu} (Tersimpan ke Database Laravel!)</li>` + log.innerHTML;
            alert("Berhasil! Absensi telah disimpan ke server (MySQL).");
        } else {
            alert("Gagal: " + (data.message || "Server Error"));
        }
    } catch (err) {
        alert("Terjadi kesalahan koneksi ke backend!");
        console.error(err);
    } finally {
        btnAbsen.disabled = false;
        btnAbsen.innerText = "Masuk";
    }
};