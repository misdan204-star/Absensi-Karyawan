document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const timeDisplay = document.getElementById('clock');
    const dateDisplay = document.getElementById('date');
    const latDisplay = document.getElementById('user-lat');
    const lngDisplay = document.getElementById('user-lng');
    const btnAbsen = document.getElementById('btn-absen');
    const btnPulang = document.getElementById('btn-pulang');
    const labelStatus = document.getElementById('label-status');
    const detailJarak = document.getElementById('detail-jarak');
    const logAbsensi = document.getElementById('log-absensi');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const cameraLoading = document.getElementById('camera-loading');
    const btnSnapshot = document.getElementById('btn-snapshot');
    const btnRetake = document.getElementById('btn-retake');
    const snapshotPreview = document.getElementById('snapshot-preview');
    const previewImg = document.getElementById('preview-img');
    const toastContainer = document.getElementById('toast-container');

    // Setting Kantor
    const KANTOR_LAT = -8.570951691307169;
    const KANTOR_LON = 116.08182218746374;
    const RADIUS_AMAN = 100;

    // State
    let userLat = 0;
    let userLng = 0;
    let cameraStream = null;
    let waktuMasukHariIni = null;
    let isLocationValid = false;
    let currentSelfie = null;

    // Flash Messages handled via window object or static calls now

    // 1. Inisialisasi Jam
    function updateClock() {
        const now = new Date();
        timeDisplay.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        dateDisplay.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        checkPulangStatus();
    }
    setInterval(updateClock, 1000);
    updateClock();

    function checkPulangStatus() {
        const infoPulang = document.getElementById('info-pulang');

        if (!waktuMasukHariIni) {
            btnPulang.disabled = true;
            infoPulang.style.display = 'none';
            return;
        }

        const now = new Date();
        const minPulang = new Date(waktuMasukHariIni.getTime() + (8 * 60 * 60 * 1000));
        
        if (now < minPulang) {
            btnPulang.disabled = true;
            infoPulang.style.display = 'block';
            const timeStr = minPulang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            infoPulang.innerText = `⏳ BELUM 8 JAM. BISA PULANG PUKUL ${timeStr}`;
        } else {
            btnPulang.disabled = !isLocationValid;
            infoPulang.style.display = 'block';
            infoPulang.innerText = `✅ SUDAH 8 JAM KERJA. SILAKAN PULANG.`;
            infoPulang.style.color = "#10b981";
        }
    }

    // 2. Toast Notification System
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast`;
        
        const icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
        const bgColor = type === 'success' ? 'rgba(16, 185, 129, 0.9)' : (type === 'error' ? 'rgba(239, 68, 68, 0.9)' : 'rgba(59, 130, 246, 0.9)');

        toast.style.backgroundColor = bgColor;
        toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
        toastContainer.appendChild(toast);

        // Slide in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Remove
        setTimeout(() => {
            toast.style.transform = 'translateX(120%)';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    // 3. Camera Functions
    async function initCamera() {
        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "user" }, 
                audio: false 
            });
            video.srcObject = cameraStream;
            cameraLoading.style.display = 'none';
        } catch (err) {
            console.error("Camera Error:", err);
            cameraLoading.innerHTML = `<span style="color: #ef4444; font-weight: bold; font-size: 0.7rem;">❌ KAMERA GAGAL DIAKTIFKAN</span>`;
            showToast("Gagal mengakses kamera. Pastikan izin diberikan.", "error");
        }
    }
    initCamera();

    function takeSnapshot() {
        if (!cameraStream) return null;
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        return canvas.toDataURL('image/jpeg', 0.8);
    }

    btnSnapshot.onclick = () => {
        const photo = takeSnapshot();
        if (photo) {
            currentSelfie = photo;
            previewImg.src = photo;
            snapshotPreview.style.display = 'block';
            showToast("Foto berhasil diambil!", "info");
        }
    };

    btnRetake.onclick = () => {
        currentSelfie = null;
        snapshotPreview.style.display = 'none';
    };

    // 4. GPS Functions
    function hitungJarak(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Radius bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    function getLocation() {
        if (!navigator.geolocation) {
            showToast("Browser tidak mendukung GPS.", "error");
            return;
        }

        navigator.geolocation.watchPosition((pos) => {
            userLat = pos.coords.latitude;
            userLng = pos.coords.longitude;

            const jarak = hitungJarak(userLat, userLng, KANTOR_LAT, KANTOR_LON);

            isLocationValid = (jarak <= RADIUS_AMAN);
            const pesan = isLocationValid ? `LOKASI TERVERIFIKASI` : `DI LUAR AREA KANTOR`;
            const detail = isLocationValid ? `Jarak: ${Math.round(jarak)}m dari kantor` : `Jarak Anda: ${Math.round(jarak)}m`;
            
            updateUI(isLocationValid, pesan, detail);
        }, (err) => {
            labelStatus.innerText = "GPS TIDAK AKTIF";
            showToast("Gagal mendapatkan lokasi. Aktifkan GPS Anda.", "error");
        }, { enableHighAccuracy: true });
    }
    getLocation();

    function updateUI(isValid, pesan, detail) {
        labelStatus.innerText = pesan;
        detailJarak.innerText = detail;
        btnAbsen.disabled = !isValid;
        
        checkPulangStatus();
        
        const statusCard = document.getElementById('status-card');
        if (isValid) {
            statusCard.style.borderColor = "rgba(16, 185, 129, 0.4)";
            labelStatus.style.color = "#10b981";
        } else {
            statusCard.style.borderColor = "rgba(239, 68, 68, 0.4)";
            labelStatus.style.color = "#ef4444";
        }
    }

    // 6. Submit Absen
    async function submitAbsen(type) {
        let selfie = currentSelfie;
        
        if (!selfie) {
            selfie = takeSnapshot();
        }

        if (!selfie) {
            showToast("Gagal mengambil foto selfie. Pastikan kamera aktif.", "error");
            return;
        }

        const confirmText = type === 'masuk' ? "Apakah Anda yakin ingin Absen Masuk?" : "Apakah Anda yakin ingin Absen Pulang?";
        if (!confirm(confirmText)) return;

        const originalText = type === 'masuk' ? btnAbsen.innerText : btnPulang.innerText;
        const btn = type === 'masuk' ? btnAbsen : btnPulang;
        
        btn.disabled = true;
        btn.innerText = "MEMPROSES...";

        try {
            const response = await fetch('/absensi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tipe_absen: type,
                    latitude: userLat,
                    longitude: userLng,
                    image: selfie
                })
            });

            const result = await response.json();

            if (response.ok) {
                showToast(result.message);
                currentSelfie = null;
                snapshotPreview.style.display = 'none';
                fetchHistory(); // Refresh riwayat
            } else {
                showToast(result.message || "Gagal melakukan absensi.", "error");
            }
        } catch (err) {
            showToast("Terjadi kesalahan koneksi.", "error");
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    }

    btnAbsen.onclick = () => submitAbsen('masuk');
    btnPulang.onclick = () => submitAbsen('pulang');

    // 7. Load History
    async function fetchHistory() {
        try {
            const response = await fetch('/api/history');
            const data = await response.json();
            
            if (!data) {
                logAbsensi.innerHTML = `<div class="history-item glass opacity-50 justify-center">BELUM ADA RIWAYAT</div>`;
                waktuMasukHariIni = null;
                return;
            }

            // Handle Leave Status
            if (data.leave) {
                btnAbsen.disabled = true;
                btnAbsen.innerText = data.leave.type.toUpperCase();
                btnAbsen.style.opacity = "0.7";
                btnPulang.style.display = "none";
                showToast(`Status Hari Ini: ${data.leave.type.toUpperCase()}`, "info");
            }

            const history = data.history || [];

            if (history.length === 0) {
                logAbsensi.innerHTML = `<div class="history-item glass opacity-50 justify-center">BELUM ADA DATA HARI INI</div>`;
                waktuMasukHariIni = null;
                return;
            }

            const recordMasuk = history.find(item => item.tipe_absen === 'masuk');
            if (recordMasuk) {
                waktuMasukHariIni = new Date(recordMasuk.created_at);
            }

            logAbsensi.innerHTML = history.map(item => {
                const date = new Date(item.created_at);
                const timeStr = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                const color = item.tipe_absen === 'masuk' ? '#10b981' : '#f43f5e';
                return `
                    <div class="history-item glass" style="border-left-color: ${color}">
                        <div>
                            <div class="font-bold text-sm">${item.tipe_absen === 'masuk' ? 'HADIR' : 'PULANG'}</div>
                            <div class="text-[10px] text-indigo-300/50 uppercase tracking-widest">${item.status_lokasi}</div>
                        </div>
                        <div class="text-lg font-bold text-indigo-200">${timeStr}</div>
                    </div>
                `;
            }).join('');
            
            checkPulangStatus();
        } catch (err) {
            console.error("Load History Error:", err);
        }
    }
    fetchHistory();
});