function openPesananModal()
{
    document.getElementById('modal-pesanan').style.display = 'flex';
}

function closePesananModal()
{
    document.getElementById('modal-pesanan').style.display = 'none';
}

window.onclick = function(event)
{
    const modal = document.getElementById('modal-pesanan');

    if(event.target === modal)
    {
        closePesananModal();
    }
}