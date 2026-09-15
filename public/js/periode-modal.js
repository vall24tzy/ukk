function bukaModalPeriode(){document.getElementById('modalPeriode').classList.add('show')}
function tutupModalPeriode(){document.getElementById('modalPeriode').classList.remove('show')}
function filterKaryawan(){const kata=document.getElementById('cariNama').value.toLowerCase().trim(),a=document.getElementById('filterAwal').value,b=document.getElementById('filterAkhir').value;document.querySelectorAll('.karyawan-item').forEach(i=>{const n=!kata||i.dataset.nama.includes(kata)||i.dataset.nik.includes(kata);let p=true;if(a&&b)p=i.dataset.awal===a&&i.dataset.akhir===b;i.style.display=n&&p?'flex':'none'})}
function resetFilterPeriode(){document.getElementById('filterAwal').value='';document.getElementById('filterAkhir').value='';filterKaryawan()}
function toggleSemua(m){document.querySelectorAll('.karyawan-item').forEach(i=>{if(i.style.display!=='none')i.querySelector('input[type=checkbox]').checked=m.checked});updateJumlahTerpilih()}
function updateJumlahTerpilih(){document.getElementById('jumlahTerpilih').textContent=document.querySelectorAll('.karyawan-item input[type=checkbox]:checked').length+' dipilih'}


function bukaModalTambahData(){
    const modal=document.getElementById('modalTambahData');
    if(!modal)return;
    const now=new Date();
    const bulan=document.getElementById('bulanTambah');
    const tahun=document.getElementById('tahunTambah');
    if(bulan && !bulan.dataset.initialized){
        bulan.value=String(now.getMonth()+1);
        tahun.value=String(now.getFullYear());
        bulan.dataset.initialized='1';
    }
    hitungPeriodeTambahData();
    modal.classList.add('show');
}
function tutupModalTambahData(){
    const modal=document.getElementById('modalTambahData');
    if(modal)modal.classList.remove('show');
}
function hitungPeriodeTambahData(){
    const bulan=parseInt(document.getElementById('bulanTambah').value,10);
    const tahun=parseInt(document.getElementById('tahunTambah').value,10);
    if(!bulan||!tahun)return;
    const awal=new Date(tahun,bulan-1,25);
    const akhir=new Date(tahun,bulan,25);
    const pad=n=>String(n).padStart(2,'0');
    const namaBulan=['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
    document.getElementById('periodeAwalTambahData').value=`${awal.getFullYear()}-${pad(awal.getMonth()+1)}-${pad(awal.getDate())}`;
    document.getElementById('periodeAkhirTambahData').value=`${akhir.getFullYear()}-${pad(akhir.getMonth()+1)}-${pad(akhir.getDate())}`;
    document.getElementById('previewPeriodeTambahData').textContent=`25 ${namaBulan[awal.getMonth()]} - 25 ${namaBulan[akhir.getMonth()]} ${akhir.getFullYear()}`;
}
