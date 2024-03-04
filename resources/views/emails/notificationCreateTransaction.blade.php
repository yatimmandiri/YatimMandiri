<p>Sahabat <b>{{$name}}</b>, selangkah lagi untuk menyelesaikan pembayaran donasi ✨</p>
<p>
    <span>Invoice: <b>{{$invoice}}</b></span> <br />
    <span>Nama program: <b>{{$campaigns}}</b></span> <br />
    <span>Jumlah Transfer: <b>Rp {{ number_format($nominal, 0, ",", ".") }}</b></span>
</p>
<p>
    <span>Melalui: {{$payments}} <b>({{$virtualaccount}})</b></span> <br />
    <span>A.n. Yayasan Yatim Mandiri (Donasi Yatim Mandiri)</span>
</p>
<p>
    <span>
        ⌛️ Selanjutnya silahkan melakukan pembayaran Donasi. Pastikan transfer dengan nominal yang tertera diatas agar bisa terkonfirmasi otomatis dengan tepat.
    </span>
    <span>Salam.</span>
</p>