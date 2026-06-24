<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;background:#eef3fe;font-family:Segoe UI,Helvetica,Arial,sans-serif;color:#1c2a4a">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef3fe;padding:32px 12px">
    <tr><td align="center">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 12px 32px rgba(13,30,70,.08)">
        <tr><td style="background:linear-gradient(135deg,#2563eb,#1d4ed8);padding:30px 36px">
          <span style="color:#fff;font-size:22px;font-weight:800;letter-spacing:-.02em">ConWeb<span style="opacity:.7"> ID</span></span>
        </td></tr>
        <tr><td style="padding:36px">
          <h1 style="margin:0 0 12px;font-size:22px;color:#0a1633">Verifikasi email kamu</h1>
          <p style="margin:0 0 24px;font-size:15px;line-height:1.7;color:#4b5a78">Halo <strong>{{ $name }}</strong>, terima kasih sudah mendaftar. Masukkan kode di bawah ini untuk mengaktifkan akunmu:</p>
          <div style="background:#f5f8ff;border:1px solid #e6ecf7;border-radius:14px;padding:22px;text-align:center;margin-bottom:24px">
            <div style="font-size:38px;font-weight:800;letter-spacing:12px;color:#1d4ed8;font-family:'Courier New',monospace">{{ $code }}</div>
          </div>
          <p style="margin:0 0 8px;font-size:13.5px;color:#8190ab">Kode berlaku selama <strong>10 menit</strong>. Abaikan email ini jika kamu tidak merasa mendaftar.</p>
        </td></tr>
        <tr><td style="padding:22px 36px;border-top:1px solid #e6ecf7;background:#f5f8ff">
          <p style="margin:0;font-size:12px;color:#8190ab">Email ini dikirim otomatis oleh ConWeb ID · mail@conweb.id</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
