const f=n=>new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(Number(n||0));
function hitung(){const g=Number(document.getElementById('gaji')?.value||0),l=Number(document.getElementById('lembur')?.value||0),p=Number(document.getElementById('pinjaman')?.value||0),t=g+l;document.getElementById('total').value=f(t);document.getElementById('potongan').value=f(p);document.getElementById('bersih').value=f(t-p);}
document.querySelectorAll('.money').forEach(x=>x.addEventListener('input',hitung)); hitung();
