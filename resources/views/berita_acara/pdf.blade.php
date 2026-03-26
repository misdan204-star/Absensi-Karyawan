<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $beritaAcara->ba_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .container { padding: 25px; }
        .header { border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .ba-title { text-align: center; margin-bottom: 20px; }
        .ba-title h1 { margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 2px; color: #111; }
        .ba-title p { margin: 5px 0 0; font-size: 11px; color: #666; font-weight: bold; }
        
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-grid td { padding: 4px 0; vertical-align: top; font-size: 12px; }
        .label { width: 130px; color: #777; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .value { color: #111; font-weight: 500; font-size: 11px;}
        
        .section-title { font-size: 10px; font-weight: bold; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; border-bottom: 1px solid #f1f1f1; padding-bottom: 3px; }
        .description-box { background: #f9fafb; padding: 12px; border-radius: 8px; font-size: 11px; color: #444; margin-bottom: 15px; min-height: 60px; border: 1px solid #e5e7eb; }
        
        .photo-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .photo-item { width: 50%; padding: 5px; text-align: center; }
        .photo-wrapper { border: 1px solid #eee; border-radius: 6px; padding: 5px; background: #fff; height: 160px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .photo-wrapper img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .photo-caption { font-size: 9px; color: #888; margin-top: 5px; text-transform: uppercase; font-weight: bold; }

        .footer-sigs { width: 100%; margin-top: 20px; page-break-inside: avoid; }
        .sig-box { width: 50%; text-align: center; vertical-align: top; }
        .sig-label { font-size: 10px; margin-bottom: 45px; color: #666; font-weight: bold; }
        .sig-name { font-size: 12px; font-weight: bold; text-decoration: underline; color: #111; }
        .sig-pos { font-size: 9px; color: #888; margin-top: 2px; }
        .signature-img { height: 45px; margin-bottom: -10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="position: relative; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px; min-height: 40px;">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" style="height: 35px; float: right; margin-top: 5px;" alt="Nustech Logo">
            @else
                <div style="float: right; font-weight: bold; color: #1e3a8a; font-size: 20px; margin-top: 5px; letter-spacing: 2px;">NUSTECH</div>
            @endif
            <div style="clear: both;"></div>
        </div>

        <div class="ba-title">
            <h1>Berita Acara Pekerjaan</h1>
            <p>NOMOR: {{ $beritaAcara->ba_number }}</p>
        </div>

        <div class="section-title">Informasi Dokumen</div>
        <table class="info-grid">
            <tr>
                <td class="label">Tanggal Dokumen</td>
                <td class="value">: {{ \Carbon\Carbon::parse($beritaAcara->date)->format('d F Y') }}</td>
                <td class="label">Klien / Perusahaan</td>
                <td class="value">: {{ $beritaAcara->client_name }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pekerjaan</td>
                <td class="value">: {{ $beritaAcara->fieldWorkReport->work_name }}</td>
                <td class="label">Lokasi</td>
                <td class="value">: {{ $beritaAcara->fieldWorkReport->location }}</td>
            </tr>
            <tr>
                <td class="label">Pelaksana</td>
                <td class="value">: {{ $beritaAcara->fieldWorkReport->user->name }}</td>
                <td class="label">Waktu Pelaksanaan</td>
                <td class="value">: {{ \Carbon\Carbon::parse($beritaAcara->fieldWorkReport->date)->format('d F Y') }}</td>
            </tr>
        </table>

        <div class="section-title">Uraian / Deskripsi Pekerjaan</div>
        <div class="description-box">
            {{ $beritaAcara->fieldWorkReport->description }}
        </div>

        <div class="section-title">Dokumentasi Foto Pekerjaan</div>
        <table class="photo-grid">
            <tr>
                <td class="photo-item">
                    <div class="photo-wrapper">
                        @if($beritaAcara->fieldWorkReport->photo_before)
                            <img src="{{ public_path('storage/' . $beritaAcara->fieldWorkReport->photo_before) }}">
                        @else
                            <p style="color: #ccc; font-size: 10px;">[ Foto Sebelum Tidak Tersedia ]</p>
                        @endif
                    </div>
                    <div class="photo-caption">FOTO SEBELUM (BEFORE)</div>
                </td>
                <td class="photo-item">
                    <div class="photo-wrapper">
                        @if($beritaAcara->fieldWorkReport->photo_after)
                            <img src="{{ public_path('storage/' . $beritaAcara->fieldWorkReport->photo_after) }}">
                        @else
                            <p style="color: #ccc; font-size: 10px;">[ Foto Sesudah Tidak Tersedia ]</p>
                        @endif
                    </div>
                    <div class="photo-caption">FOTO SESUDAH (AFTER)</div>
                </td>
            </tr>
        </table>

        <table class="footer-sigs">
            <tr>
                <td class="sig-box">
                    <div class="sig-label">Disetujui Oleh (Klien),</div>
                    <div style="height: 45px;"></div>
                    <div class="sig-name">( ______________________ )</div>
                    <div class="sig-pos">Perwakilan Klien</div>
                </td>
                <td class="sig-box">
                    <div class="sig-label">Diserahkan Oleh (Pelaksana),</div>
                    <div style="height: 45px;">
                        @if($beritaAcara->signature)
                            <img src="{{ $beritaAcara->signature }}" class="signature-img">
                        @endif
                    </div>
                    <div class="sig-name">{{ $beritaAcara->fieldWorkReport->user->name }}</div>
                    <div class="sig-pos">Teknisi Lapangan</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
