const UI = (() => {

    function showToast(msg, duration = 3000) {

        const toast = document.getElementById('toast');

        if (!toast) {
            console.warn('Element #toast tidak ditemukan');
            return;
        }

        toast.textContent = msg;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, duration);
    }

    return {
        showToast
    };

})();