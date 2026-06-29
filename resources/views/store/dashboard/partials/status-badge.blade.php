@php
  $map = [
    'pending' => ['badge-amber', 'Menunggu'],
    'confirmed' => ['badge-blue', 'Dikonfirmasi'],
    'processing' => ['badge-blue', 'Diproses'],
    'completed' => ['badge-green', 'Selesai'],
    'cancelled' => ['badge-red', 'Dibatalkan'],
  ];
  [$cls, $label] = $map[$status] ?? ['badge-gray', ucfirst($status)];
@endphp
<span class="badge {{ $cls }}">{{ $label }}</span>
