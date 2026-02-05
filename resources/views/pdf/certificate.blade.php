<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat Seminar</title>
    <style>
        @page {
            margin: 0px;
            size: 297mm 210mm;
        }

        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            width: 100%;
            height: 100%;
        }

        /* FIXED BACKGROUND FRAME */
        .frame-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -10;
        }

        /* BORDER CONTAINER */
        .border {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 2px solid #1e3a8a;
            background: #fff;
            box-shadow: inset 0 0 0 4px #fff, inset 0 0 0 6px #1e3a8a; /* Triple Border Effect */
        }

        /* CENTRAL WATERMARK SEAL */
        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: 400px;
            opacity: 0.04;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%231e3a8a' d='M98.6 15.6c-1.3-.8-3-.8-4.3 0C84.4 20.8 74 27 63.8 33.4c-1.5.9-3.3.6-4.4-.8-6.9-8.3-15.1-15.4-24.8-20.9-1.4-.8-3.1-.4-4.1.9-5.9 8-10.7 16.7-14.2 25.9-.6 1.5.1 3.2 1.5 3.9 9.3 4.9 18 10.9 25.7 18 1.2 1.1 1.4 3 .4 4.3 -6.6 8.7-12 18.2-16.1 28.3 -.6 1.5 .1 3.2 1.6 3.8 9.9 4 20.2 6.5 30.8 7.3 1.6.1 2.9-1.1 3-2.7 .9-10.8 3.2-21.3 6.9-31.4 .5-1.5 2.3-2.1 3.7-1.4 10 5.4 20.7 9.1 31.9 10.9 1.6.3 3.1-.8 3.3-2.4 1.5-10.7 4.5-21 8.8-30.8 .6-1.5 2.4-2.1 3.8-1.3 9.4 5.3 18.2 11.9 26 19.6 1.2 1.1 3.1 1.1 4.2-.1 7.7-7.9 16.5-14.5 26.1-19.6 1.4-.7 3.2-.1 3.7 1.4 4.2 10.1 7.1 20.7 8.5 31.6 .2 1.6 1.7 2.7 3.3 2.4 11-1.9 21.6-5.5 31.4-10.6 1.4-.7 3.2-.1 3.7 1.4 3.7 10.2 6 21 6.8 32 .1 1.6-1.1 3-2.7 3.2-10.7 1.1-21.1 3.7-31.1 7.6-1.5.6-2.2 2.3-1.6 3.8 4 10.1 9.4 19.6 16 28.2 1 1.3 .7 3.2-.5 4.3 -7.6 7-16.1 13-25.3 17.8-1.4.7-2.1 2.4-1.5 3.9 3.4 9.2 8.1 17.8 13.9 25.7 1 1.3 .7 3.2-.6 4.2 -9.6 5.4-17.7 12.4-24.5 20.6-1.1 1.3-2.9 1.6-4.3 .7-10.1-6.1-20.4-12.1-30.2-17.2-1.4-.7-3.1-.7-4.5 0 -9.3 4.8-19.1 10.6-28.8 16.5-1.3.8-3.1.6-4.2-.7 -6.8-8.1-14.8-15-24.3-20.3-1.3-.7-1.7-2.6-.7-3.9 5.8-7.8 10.5-16.3 13.9-25.4 .6-1.5-.1-3.2-1.5-3.9 -9.2-4.7-17.7-10.6-25.2-17.5-1.2-1.1-1.5-3-.5-4.3 6.5-8.6 11.9-18 15.8-28 .6-1.5-.1-3.2-1.6-3.8 -9.9-3.9-20.2-6.4-30.8-7.3-1.6-.1-2.9 1.1-3 2.7 -.8 10.8-3.1 21.3-6.8 31.4 -.5 1.5-2.3 2.1-3.7 1.4 -9.9-5.3-20.5-8.8-31.6-10.6-1.6-.3-3.1 .8-3.3 2.4 -1.4 10.8-4.3 21.3-8.6 31.2 -.6 1.5-2.4 2.1-3.8 1.3 -9.4-5.2-18.1-11.8-26-19.5-1.2-1.1-3.1-1.1-4.2 .1 -7.7 7.9-16.4 14.5-25.9 19.5-1.4 .7-3.2 .1-3.7-1.4 -4.2-10.1-7.1-20.7-8.5-31.6-.2-1.6-1.7-2.7-3.3-2.4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        /* DECORATIONS */
        .corner-tl {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 100px;
            height: 100px;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L40 0 L0 40 Z' fill='%231e3a8a'/%3E%3Cpath d='M5 5 L45 5 L5 45 Z' fill='none' stroke='%23cbd5e1' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
        }

        .corner-br {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 100px;
            height: 100px;
            transform: rotate(180deg);
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L40 0 L0 40 Z' fill='%231e3a8a'/%3E%3Cpath d='M5 5 L45 5 L5 45 Z' fill='none' stroke='%23cbd5e1' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
        }

        /* HEADER DECORATION */
        .header-bar {
            width: 100%;
            height: 12px;
            background-color: #1e3a8a;
            margin-bottom: 2px;
        }
        
        .header-bar-thin {
            width: 100%;
            height: 2px;
            background-color: #fbbf24; /* Goldish */
            margin-bottom: 20px;
        }

        /* CONTENT WRAPPER - USE TABLE FOR VERTICAL ALIGNMENT */
        .content-table {
            position: absolute;
            top: 25mm;
            left: 25mm;
            width: 247mm; /* 297 - 25 - 25 */
            height: 160mm; /* 210 - 25 - 25 */
            border-collapse: collapse;
            text-align: center;
            z-index: 10;
        }

        .row-header {
            height: 20%;
            vertical-align: top;
        }

        .row-body {
            height: 55%;
            vertical-align: middle;
        }

        .row-footer {
            height: 25%;
            vertical-align: bottom;
        }

        /* TYPOGRAPHY */
        .header-text {
            color: #64748b;
            font-size: 14px;
            letter-spacing: 6px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .title-text {
            font-family: serif;
            font-size: 48px;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-top: 5px;
            margin-bottom: 0;
            line-height: 1;
            letter-spacing: 2px;
            text-shadow: 1px 1px 0px rgba(0,0,0,0.1);
        }

        /* ORNAMENTAL DIVIDER */
        .divider {
            margin: 15px auto;
            width: 400px;
            height: 20px;
            background-image: url("data:image/svg+xml,%3Csvg width='400' height='20' viewBox='0 0 400 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 10 L180 10 L190 2 L200 18 L210 2 L220 10 L400 10' stroke='%23fbbf24' stroke-width='2' fill='none'/%3E%3Ccircle cx='200' cy='10' r='3' fill='%231e3a8a'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
        }

        .label-text {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .name-text {
            font-family: serif;
            font-size: 40px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2px solid #fbbf24; /* Gold Underline */
            display: inline-block;
            padding: 0 40px 10px 40px;
            margin-bottom: 10px;
        }

        .nim-text {
            font-size: 12px;
            color: #64748b;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .desc-text {
            font-size: 15px;
            color: #334155;
            line-height: 1.8;
            margin-top: 15px;
            width: 85%;
            margin-left: auto;
            margin-right: auto;
        }

        .seminar-name {
            font-weight: bold;
            font-size: 20px;
            color: #1e3a8a;
            display: block;
            margin: 10px 0;
            text-decoration: underline;
            text-decoration-color: #cbd5e1;
            text-underline-offset: 4px;
        }

        /* FIX BADGE RENDERING */
        .badge-container {
            margin-top: 20px;
        }
        
        .badge {
            background-color: #fff;
            border: 1px solid #1e3a8a;
            color: #1e3a8a;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline;
        }

        /* SIGNATURES */
        .sig-table {
            width: 80%;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .sig-cell {
            text-align: center;
            width: 50%;
            vertical-align: bottom;
        }

        .sig-line {
            width: 200px;
            border-bottom: 1px solid #0f172a;
            margin: 0 auto 8px auto;
            height: 50px; /* Space for signature */
        }

        .footer-left { position: absolute; left: 15mm; bottom: 12mm; font-size: 9px; color: #94a3b8; font-family: monospace; }
        .footer-right { position: absolute; right: 15mm; bottom: 12mm; font-size: 9px; color: #94a3b8; font-family: monospace;}

    </style>
</head>
<body>
    <!-- FIXED GEOMETRIC BACKGROUND PATTERN -->
    <div class="frame-bg">
        <div class="border">
            <div class="corner-tl"></div>
            <div class="corner-br"></div>
            <!-- Central Seal Watermark -->
            <div class="watermark-seal"></div>
        </div>
    </div>

    <!-- MAIN CONTENT TABLE -->
    <table class="content-table">
        <!-- HEADER ROW -->
        <tr>
            <td class="row-header">
                <div class="header-text">SeminarKu Indonesia Award</div>
                <div class="title-text">Sertifikat</div>
                <div class="title-text" style="font-size: 24px; letter-spacing: 5px; margin-top: 5px;">Apresiasi</div>
                
                <!-- ORNAMENTAL DIVIDER LINE -->
                <div class="divider"></div>
            </td>
        </tr>
        
        <!-- BODY ROW -->
        <tr>
            <td class="row-body">
                <div class="label-text">Diberikan Kepada</div>
                <div class="name-text">{{ $peserta->nama_peserta }}</div>
                <div class="nim-text">NIM: {{ $peserta->nim_peserta }}</div>

                <div class="desc-text">
                    Atas partisipasi & dedikasinya sebagai <strong style="color: #1e3a8a;">PESERTA</strong> dalam kegiatan seminar interaktif:
                    
                    <span class="seminar-name">"{{ $seminar->nama_seminar }}"</span>
                    
                    Diselenggarakan oleh <strong>{{ $seminar->penyelenggara }}</strong><br>
                    pada tanggal {{ \Carbon\Carbon::parse($seminar->tgl_seminar)->isoFormat('D MMMM Y') }}.
                </div>

                <div class="badge-container">
                    <span class="badge">Performance Score: +{{ $seminar->poin_seminar }} Poin</span>
                </div>
            </td>
        </tr>

        <!-- FOOTER ROW (SIGNATURES) -->
        <tr>
            <td class="row-footer">
                <table class="sig-table">
                    <tr>
                        <td class="sig-cell">
                            <div class="sig-line"></div>
                            <div style="font-weight: bold; font-size: 13px;">Dr. Administrator, M.Kom</div>
                            <div style="font-size: 11px; color: #64748b; font-style: italic;">Ketua Pelaksana</div>
                        </td>
                        <td class="sig-cell">
                            <div class="sig-line"></div>
                            <div style="font-weight: bold; font-size: 13px;">{{ $seminar->penyelenggara }}</div>
                            <div style="font-size: 11px; color: #64748b; font-style: italic;">Penyelenggara Utama</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- FOOTER METADATA -->
    <div class="footer-left">NO. SERTIFIKAT: {{ $pendaftaran->kode_pendaftaran }}</div>
    <div class="footer-right">Generasi Digital: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
</body>
</html>