document.addEventListener('DOMContentLoaded', () => {

    const tags = document.querySelectorAll('.tag');

    tags.forEach(tag => {

        tag.addEventListener('click', () => {

            const group = tag.dataset.group;
            const value = tag.dataset.val;

            const params = new URLSearchParams(window.location.search);

            // klik filter yang sama = hapus filter
            if (params.get(group) === value) {
                params.delete(group);
            } else {
                params.set(group, value);
            }

            window.location.search = params.toString();

        });

    });

    const resetBtn = document.getElementById('reset-btn');

    if (resetBtn) {

        resetBtn.addEventListener('click', () => {

            window.location.href =
                window.location.pathname;

        });

    }

});