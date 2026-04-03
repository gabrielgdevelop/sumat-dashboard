"use strict";

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalHistorial');
    const btnOpen = document.getElementById('btnAbrirHistorial');
    const btnClose = document.getElementById('btnCerrarHistorial');
    const overlay = document.getElementById('modalOverlay');

    const toggleModal = () => {
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
        // Bloquear scroll del cuerpo cuando el modal está abierto
        document.body.classList.toggle('overflow-hidden');
    };

    if (btnOpen) btnOpen.addEventListener('click', toggleModal);
    if (btnClose) btnClose.addEventListener('click', toggleModal);
    if (overlay) overlay.addEventListener('click', toggleModal);

    // Cerrar con la tecla Esc
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            toggleModal();
        }
    });
});